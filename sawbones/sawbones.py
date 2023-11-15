#!/usr/bin/python

import MySQLdb
import urllib
import os.path
import collections
import mechanize
import re
import unicodedata
import requests
from lxml import html
from lxml import etree
from bs4 import BeautifulSoup as BS
from urllib2 import urlopen
from datetime import datetime

class Images:
	def __init__(self):
		self.db = None
		self.db_host = "localhost"
		self.db_port = 3306
		self.db_user = "root"
		self.db_pass = "1503vzw35"
		self.db_name = "xnet_node_root_info_xnet"
		self.target = None
		self.save_path = "/root/sawbones/var/"
		self.midc_res = None
		self.try_count_max = 1000
		self.filesize_trash = 512
		
	def db_connect(self):
		self.db = MySQLdb.connect(host=self.db_host,user=self.db_user,passwd=self.db_pass,port=self.db_port,db=self.db_name)
		if self.db:
			print 'Database Connection [1]'
			return True
		else:
			print 'Database Connection [-1]'
			return False
		
	def db_get(self,command):
		cur = self.db.cursor()
		cur.execute(command)
		return cur.fetchall()
		
	def db_get_midc_main(self):
		return self.db_get("SELECT mdm_id, mdoc_number, image_url FROM midc_main;")
	
	def db_disconnect(self):
		if self.db:
			self.db.close()
			print 'Database Connection [2]'
		else:
			print 'Database Connection [-2]'
	
	def run(self):
		print "[" + str(datetime.now()) +"] - Getting images."
		if self.db_connect():
			self.midc_res = db_get_midc_main()
			for row in self.midc_res:
				print "[" + str(datetime.now()) +"] - Requesting."
				savepath = self.save_path + "%s-%s.jpg" % (row[0],row[1])
				if os.path.isfile(savepath):
					print "[" + str(datetime.now()) +"] - File Exists."
				else:
					try_count = 0
					while try_count < self.try_count_max:
						try:
							urllib.urlretrieve(row[2], savepath)
							try_count = self.try_count_max
						except:
							print "[" + str(datetime.now()) +"] - Server is fighting back."
							try_count += 1
					if os.path.isfile(savepath):
						print "[" + str(datetime.now()) +"] - File saved."
						if os.path.getsize(savepath) <= self.filesize_trash:
							os.remove(savepath)
							if os.path.isfile(savepath):
								print "[" + str(datetime.now()) +"] - File is shit, but cannot be trashed."
							else:
								print "[" + str(datetime.now()) +"] - File is shit and has been trashed."
					else:
						print "[" + str(datetime.now()) +"] - File failed to save."
		self.db_disconnect()

class MiDOC:
	def __init__(self):
		self.db = None
		self.db_host = "localhost"
		self.db_port = 3306
		self.db_user = "root"
		self.db_pass = "1503vzw35"
		self.db_name = "xnet_node_root_info_xnet"
		self.target = 'http://mdocweb.state.mi.us/otis2/otis2profile.aspx?mdocNumber='
		self.save_path = "/root/sawbones/var/"
		self.doc_start = 100000
		self.doc_stop = 1100000
		self.try_count_max = 10000
		self.res_main = None
		self.res_alaises = None
		self.res_marks = None
		self.res_sentences = None
		self.re_name = re.compile('\w{1,}')
		self.re_feet = re.compile(r"\d{1,2}[']")
		self.re_inches = re.compile('\d{1,2}["]')
		self.re_weight = re.compile('\d{1,}')
		self.re_date = re.compile('(\d{1,2}[/]){2}\d{4}')
		self.re_alias = re.compile('[^#]{3,}')
		self.re_slash = re.compile(' / ')
		self.re_year = re.compile('\d{1,2} year')
		self.re_month = re.compile('\d{1,2} month')
		self.re_day = re.compile('\d{1,2} day')
		
	def clean_data(self,rawdata):
		counter = 0
		cleandata = []
		for item in rawdata:
			cleandata.append(str("".join(rawdata[counter]).encode('ascii','ignore')))
			counter += 1
		return cleandata
	
	def clean_data_space(self,rawdata):
		cleandata = []
		counter = 0
		for item in rawdata:
			rawdata[counter] = str("###".join(rawdata[counter]).encode('ascii','ignore'))
			counter += 1
		matches = self.re_alias.findall(rawdata[0])
		if matches:
			counter = 0
			for elem in matches:
				cleandata.append(matches[counter])
				counter += 1
		return cleandata
	
	def clean_date(self,rawdata):
		matches = self.re_date.search(rawdata)
		if matches:
			cleandate = datetime.strptime(matches.group(), "%m/%d/%Y").date()
		else:
			cleandate = datetime.strptime("01/01/2999", "%m/%d/%Y").date()
		return cleandate
	
	def clean_date_long(self,rawdata):
		total = 0
		match = self.re_year.search(rawdata)
		if match:
			total += (int(self.re_weight.search(match.group()).group())*365)
		match = self.re_month.search(rawdata)
		if match:
			total += (int(self.re_weight.search(match.group()).group())*30)
		match = self.re_day.search(rawdata)
		if match:
			total += int(self.re_weight.search(match.group()).group())
		return total

	def clean_BULLSHIT(self,rawdata):
		cleandata = []
		for item in rawdata:
			if item != "":
				cleandata.append(item)
		return cleandata
	
	def assemble_data(self,rawdata,mnum):
		fulldata = []
		fulldata.append(rawdata[0])				#mdoc
		fulldata.append(rawdata[1])				#sid
		fulldata.append(rawdata[2])				#full name
		
		matches = self.re_name.findall(rawdata[2])
		if matches:
			if len(matches) > 2:
				fulldata.append(matches[2])	#last name
				fulldata.append(matches[0])	#first name
				fulldata.append(matches[1])	#middle name
			elif len(matches) == 2:
				fulldata.append(matches[1])	#last name
				fulldata.append(matches[0])	#first name
				fulldata.append("")		#middle name
			else:
				fulldata.append("")		#last name
				fulldata.append(matches[0])	#first name
				fulldata.append("")		#middle name
		else:
			fulldata.append("")				#last name
			fulldata.append("")				#first name
			fulldata.append("")				#middle name
			
		fulldata.append(rawdata[3])				#race
		fulldata.append(rawdata[4])				#sex
		fulldata.append(rawdata[5])				#hair
		fulldata.append(rawdata[6])				#eyes
		
		matches = self.re_feet.search(rawdata[7])
		if matches:
			feet = int(self.re_weight.search(matches.group()).group())
			matches = self.re_inches.search(rawdata[7])
			inches = int(self.re_weight.search(matches.group()).group())
			fulldata.append( ( inches + (feet*12) ) )	#height
		else:
			fulldata.append(0)				#height
		
		matches = self.re_weight.search(rawdata[8])
		if matches:
			fulldata.append( int(matches.group()) )	#weight
		else:
			fulldata.append(0)				#weight
			
		fulldata.append(self.clean_date(rawdata[9]))			#dob
		fulldata.append(self.clean_date(rawdata[10]))		#image date
		fulldata.append(self.target + "%u" % (mnum))
		fulldata.append(rawdata[11])				#status
		fulldata.append(rawdata[12])				#location
		fulldata.append(rawdata[13])				#security lvl
		fulldata.append(self.clean_date(rawdata[14]))		#min release
		fulldata.append(self.clean_date(rawdata[15]))		#max release
		fulldata.append(self.target + "%u" % (mnum))	
		return fulldata
	
	def assemble_sentences(self,part1, part2, part3, type, cleansent, mdmid):
		sent = []
		n = 0
		a = 0
		b = 0
		c = 0
		d = len(part1)
		e = len(part2)
		f = len(part3)
		while len(part1) > a and len(part2) > b and len(part3) > c:
			if n==1:
				match = self.re_slash.search(part1[a+1])
				if match:
					n = 0
					sent.append(mdmid)
					sent.append(type)
					sent.append(part1[a])
					if e <= b+1:
						sent.append("")
					else:
						sent.append( part2[b]+" / "+part2[b+1] )
					if d <= a+2:
						sent.append("")
					else:
						sent.append(part1[a+2])
					if d <= a+3:
						sent.append("")
					else:
						sent.append(part1[a+3])
					if d <= a+4:
						sent.append("")
					else:
						sent.append(part1[a+4])
					if f <= c:
						sent.append("")
					else:
						sent.append(self.clean_date_long(part3[c]))
					if f <= c+1:
						sent.append("")
					else:
						sent.append(self.clean_date_long(part3[c+1]))
					if f <= c+2:
						sent.append("")
					else:
						sent.append(self.clean_date(part3[c+2]))
					if f <= c+3:
						sent.append("")
					else:
						sent.append(self.clean_date(part3[c+3]))
					a += 5
					b += 2
					if type == 2 or type == 4:
						if f <= c+4:
							sent.append("")
						else:
							sent.append(self.clean_date(part3[c+4]))
						if f <= c+5:
							sent.append("")
						else:
							sent.append(part3[c+5])
						a += 1
						c += 6
					else:
						sent.append("")
						sent.append("")
						c += 4
				else:
					sent.append(mdmid)
					sent.append(type)
					sent.append(part1[a])
					sent.append(part2[b])
					if d <= a+1:
						sent.append("")
					else:
						sent.append(part1[a+1])
					if d <= a+2:
						sent.append("")
					else:
						sent.append(part1[a+2])
					if d <= a+3:
						sent.append("")
					else:
						sent.append(part1[a+3])
					if f <= c:
						sent.append("")
					else:
						sent.append(self.clean_date_long(part3[c]))
					if f <= c+1:
						sent.append("")
					else:
						sent.append(self.clean_date_long(part3[c+1]))
					if f <= c+2:
						sent.append("")
					else:
						sent.append(self.clean_date(part3[c+2]))
					if f <= c+3:
						sent.append("")
					else:
						sent.append(self.clean_date(part3[c+3]))
					a += 4
					b += 1
					if type == 2 or type == 4:
						if f <= c+4:
							sent.append("")
						else:
							sent.append(self.clean_date(part3[c+4]))
						if f <= c+5:
							sent.append("")
						else:
							sent.append(part3[c+5])
						a += 1
						c += 6
					else:
						sent.append("")
						sent.append("")
						c += 4
				cleansent.append(sent)
				sent = []
			n += 1
			if n == 4:
				n = 0
		return cleansent
	
	def db_connect(self):
		self.db = MySQLdb.connect(host=self.db_host,user=self.db_user,passwd=self.db_pass,port=self.db_port,db=self.db_name)
		if self.db:
			print 'Database Connection [1]'
			return True
		else:
			print 'Database Connection [-1]'
			return False
		
	def db_get(self,command):
		cur = self.db.cursor()
		cur.execute(command)
		return cur.fetchall()
		
	def db_get_midc_main(self):
		return self.db_get("SELECT * FROM midc_main;")
		
	def db_get_midc_aliases(self):
		return self.db_get("SELECT * FROM midc_aliases;")
		
	def db_get_midc_marks(self):
		return self.db_get("SELECT * FROM midc_marks;")
		
	def db_get_midc_sentences(self):
		return self.db_get("SELECT * FROM midc_sentences;")
	
	def db_insert_main(self,fulldata):
		com = "INSERT INTO midc_main (mdoc_number, sid_number, full_name, last_name, first_name, middle_name, race, sex, hair, eyes, height, weight, date_of_birth, image_date, image_url, current_status, assigned_location, security_level, date_intake, date_discharge, profile_url) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)".format('midc_main')
		cur.execute(com, (fulldata[0],fulldata[1],fulldata[2],fulldata[3],fulldata[4],fulldata[5],fulldata[6],fulldata[7],fulldata[8],fulldata[9],fulldata[10],fulldata[11],fulldata[12],fulldata[13],fulldata[14],fulldata[15],fulldata[16],fulldata[17],fulldata[18],fulldata[19],fulldata[20]))
		self.db.commit()
		com = "SELECT mdm_id FROM midc_main ORDER BY mdm_id DESC LIMIT 1;"
		cur.execute(com)
		counter = 0
		resss = cur.fetchall()
		for row in resss:
			if counter == 0:
				linenum = row[0]
				counter = 1
		return linenum

	def db_insert_aliases(self,alias, mdmid):
		com = "INSERT INTO midc_aliases (alias, mdm_id) VALUES (%s,%s)".format('midc_aliases')
		cur.execute(com, (alias, mdmid))
		self.db.commit()
		
	def db_insert_marks(self,alias, mdmid):
		com = "INSERT INTO midc_marks (mark, mdm_id) VALUES (%s,%s)".format('midc_marks')
		cur.execute(com, (alias, mdmid))
		self.db.commit()
		
	def db_insert_sentences(self,sent):
		com = "INSERT INTO midc_sentences (mdm_id,type,offense,mcl_number,court_file_number,county,conviction_type,min_sentence,max_sentence,date_of_offense,date_of_sentence,discharge_date,discharge_reason) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)".format('midc_sentences')
		cur.execute(com, (sent[0],sent[1],sent[2],sent[3],sent[4],sent[5],sent[6],sent[7],sent[8],sent[9],sent[10],sent[11],sent[12]))
		self.db.commit()

	def db_update_main(self,fulldata, mdmid):
		com = "UPDATE midc_main SET sid_number=%s, full_name=%s, last_name=%s, middle_name=%s, race=%s, sex=%s, hair=%s, eyes=%s, height=%s, weight=%s, image_date=%s, image_url=%s, current_status=%s, assigned_location=%s, security_level=%s, date_intake=%s, date_discharge=%s, profile_url=%s WHERE mdm_id=%s".format('midc_main')
		cur.execute(com, (fulldata[1],fulldata[2],fulldata[3],fulldata[4],fulldata[6],fulldata[7],fulldata[8],fulldata[9],fulldata[10],fulldata[11],fulldata[12],fulldata[14],fulldata[15],fulldata[16],fulldata[17],fulldata[18],fulldata[19],fulldata[20],mdmid))
		self.db.commit()
		
	def db_update_sentences(self,sent, mdsid):
		com = "UPDATE midc_sentences SET conviction_type=%s, min_sentence=%s, max_sentence=%s, date_of_sentence=%s, discharge_date=%s, discharge_reason=%s WHERE mds_id=%s".format('midc_sentences')
		cur.execute(com, (sent[6],sent[7],sent[8],sent[10],sent[11],sent[12],mdsid))
		self.db.commit()
	
	def db_push_main(self,fulldata):
		duplicate = 0
		linenum = 0
		for row in self.res_main:
			if str(fulldata[0]) == str(row[2]) and str(fulldata[12]) == str(row[14]) and str(fulldata[4]) == str(row[6]):
				duplicate = 1
				linenum = row[0]
		if duplicate == 1:
			self.db_update_main(fulldata, linenum)
		else:
			linenum = self.db_insert_main(fulldata)
		return linenum
		
	def db_push_aliases(self,rawalias, mdmid):
		for elem in rawalias:
			duplicate = 0
			for row in self.res_alaises:
				if str(mdmid) == str(row[1]) and str(elem) == str(row[3]):
					duplicate = 1
			if duplicate != 1:
				self.db_insert_aliases(elem, mdmid)

	def db_push_marks(self,rawalias, mdmid):
		for elem in rawalias:
			duplicate = 0
			for row in self.res_marks:
				if str(mdmid) == str(row[1]) and str(elem) == str(row[3]):
					duplicate = 1
			if duplicate != 1:
				self.db_insert_marks(elem, mdmid)
				
	def db_push_sentences(self,rawalias, mdmid):
		for elem in rawalias:
			duplicate = 0
			for row in self.res_sentences:
				if str(mdmid) == str(row[1]) and str(elem[1]) == str(row[3]) and str(elem[2]) == str(row[4]) and str(elem[3]) == str(row[5]) and str(elem[4]) == str(row[6]) and str(elem[5]) == str(row[7]) and str(elem[9]) == str(row[11]):
					duplicate = 1
					linenum = row[0]
			if duplicate == 1:
				self.db_update_sentences(elem, linenum)
			else:
				self.db_insert_sentences(elem)
	
	def db_disconnect(self):
		if self.db:
			self.db.close()
			print 'Database Connection [2]'
		else:
			print 'Database Connection [-2]'
	
	def run(self):
		print "[" + str(datetime.now()) +"] - Getting Data."
		if not self.db_connect():
			print "[" + str(datetime.now()) +"] - Error, db connect."
			break
		self.res_main = self.db_get_midc_main()
		if not self.res_main:
			print "[" + str(datetime.now()) +"] - Error, db get main."
			break
		self.res_alaises = self.db_get_midc_aliases()
		if not self.res_aliases:
			print "[" + str(datetime.now()) +"] - Error, db get aliases."
			break
		self.res_marks = self.db_get_midc_marks()
		if not self.res_marks:
			print "[" + str(datetime.now()) +"] - Error, db get marks."
			break
		self.res_sentences = self.db_get_midc_sentences()
		if not self.res_sentences:
			print "[" + str(datetime.now()) +"] - Error, db get sentences."
			break
		index = self.doc_start
		while index <= self.doc_stop:
			print "[" + str(datetime.now()) +"] - [?] DOC = %u." % (index)
			url = self.target + "%u" % (index)
			try_count = 0
			while try_count < self.try_count_max:
				try:
					request = requests.get(url)
					try_count = self.try_count_max
				except:
					print "[" + str(datetime.now()) +"] - Remote is fighting back."
					try_count += 1
			resultTree = html.fromstring(request.text)
			
			rawdata = []
			rawalias = []
			rawmarks = []
			rawsent = []
			
			rawdata.append(resultTree.xpath(r'//*[@id="valOffenderNumber"]/text()'))
			rawdata.append(resultTree.xpath(r'//*[@id="valSID"]/text()'))
			rawdata.append(resultTree.xpath(r'//*[@id="valFullName"]/text()'))
			rawdata.append(resultTree.xpath(r'//*[@id="valRace"]/text()'))
			rawdata.append(resultTree.xpath(r'//*[@id="valGender"]/text()'))
			rawdata.append(resultTree.xpath(r'//*[@id="valHairColor"]/text()'))
			rawdata.append(resultTree.xpath(r'//*[@id="valEyeColor"]/text()'))
			rawdata.append(resultTree.xpath(r'//*[@id="valHeight"]/text()'))
			rawdata.append(resultTree.xpath(r'//*[@id="valWeight"]/text()'))
			rawdata.append(resultTree.xpath(r'//*[@id="valBirthDate"]/text()'))
			rawdata.append(resultTree.xpath(r'//*[@id="valImageDate"]/text()'))
			rawdata.append(resultTree.xpath(r'//*[@id="valCurrentStatus"]/text()'))
			rawdata.append(resultTree.xpath(r'//*[@id="valLocation"]/text()'))
			rawdata.append(resultTree.xpath(r'//*[@id="valSecurityLevel"]/text()'))
			rawdata.append(resultTree.xpath(r'//*[@id="valEarliestReleaseDate"]/text()'))
			rawdata.append(resultTree.xpath(r'//*[@id="valDischargeDate"]/text()'))
			
			rawalias.append(resultTree.xpath(r'//*[@id="valAlias"]/text()'))
			rawmarks.append(resultTree.xpath(r'//*[@id="valMST"]/text()'))
			
			rawdata[0] = str("".join(rawdata[0]).encode('ascii','ignore'))
			if rawdata[0]:
				rawdata = self.clean_data(rawdata)
				rawalias = self.clean_data_space(rawalias)
				rawmarks = self.clean_data_space(rawmarks)
				fulldata = self.assemble_data(rawdata, index)
				linenum = self.db_push_main(fulldata)
				
				if linenum == 0:
					linenum = str(self.db_get("SELECT mdm_id FROM midc_main ORDER BY mdm_id DESC LIMIT 1;"))
				self.db_push_aliases(rawalias, linenum)
				self.db_push_marks(rawmarks, linenum)
				
				part1 = self.clean_data(resultTree.xpath(r'//*[@id="pnlPASentences"]/div[@class="row-fluid rowWapper"]/div[2]/text()'))
				part2 = self.clean_data(resultTree.xpath(r'//*[@id="pnlPASentences"]/div[@class="row-fluid rowWapper"]/div[2]/a/text()'))
				part3 = self.clean_data(resultTree.xpath(r'//*[@id="pnlPASentences"]/div[@class="row-fluid rowWapper"]/div[4]/text()'))
				rawsent = self.assemble_sentences(part1, part2, part3, 1, rawsent, linenum)
				part1 = self.clean_data(clean_data(resultTree.xpath(r'//*[@id="pnlPISentences"]/div[@class="row-fluid rowWapper"]/div[2]/text()')))
				part2 = self.clean_data(resultTree.xpath(r'//*[@id="pnlPISentences"]/div[@class="row-fluid rowWapper"]/div[2]/a/text()'))
				part3 = self.clean_data(resultTree.xpath(r'//*[@id="pnlPISentences"]/div[@class="row-fluid rowWapper"]/div[4]/text()'))
				rawsent = self.assemble_sentences(part1, part2, part3, 2, rawsent, linenum)
				part1 = self.clean_data(resultTree.xpath(r'//*[@id="pnlRASentences"]/div[@class="row-fluid rowWapper"]/div[2]/text()'))
				part2 = self.clean_data(resultTree.xpath(r'//*[@id="pnlRASentences"]/div[@class="row-fluid rowWapper"]/div[2]/a/text()'))
				part3 = self.clean_data(resultTree.xpath(r'//*[@id="pnlRASentences"]/div[@class="row-fluid rowWapper"]/div[4]/text()'))
				rawsent = self.assemble_sentences(part1, part2, part3, 3, rawsent, linenum)
				part1 = self.clean_data(clean_data(resultTree.xpath(r'//*[@id="pnlRISentences"]/div[@class="row-fluid rowWapper"]/div[2]/text()')))
				part2 = self.clean_data(resultTree.xpath(r'//*[@id="pnlRISentences"]/div[@class="row-fluid rowWapper"]/div[2]/a/text()'))
				part3 = self.clean_data(resultTree.xpath(r'//*[@id="pnlRISentences"]/div[@class="row-fluid rowWapper"]/div[4]/text()'))
				rawsent = self.assemble_sentences(part1, part2, part3, 4, rawsent, linenum)
				self.db_push_sentences(rawsent, linenum)
				print "[" + str(datetime.now()) +"] - [++] DOC = %u." % (index)
			else:
				print "[" + str(datetime.now()) +"] - [--] DOC = %u." % (index)
			index += 1
		self.db_disconnect()
		
if __name__ == "__main__":
	start = datetime.now()
	print 'Start:    ' + str(start)
	
	midc = MiDOC()
	midc.run()
	mijp = Images()
	mijp.run()
	
	print 'Complete: ' + str(datetime.now() - start)
