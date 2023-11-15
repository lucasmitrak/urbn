#!/usr/bin/python

#10101010101010101010101010101010101010101010101010101010101010101010101010101010
#0              1                                                               1
#1 @@@@@@@$$$$  0        ************************************************       0
#0    @  $      1        *                                              *       1
#1    @   $$    0        *  Welcome to TallySix.com's Databases&Scripts *       0
#0    @     $$  1        *                     Created by Tallywackereb *       1
#1    @       $ 0        *  v3.0                                        *       0
#0    @   $$$$  1        ************************************************       1
#1              0                                                               0
#01010101010101010101010101010101010101010101010101010101010101010101010101010101


#================================================================================
#--------------------------------------------------------------------------------
#   Libraries
#--------------------------------------------------------------------------------
#================================================================================
import MySQLdb
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

class bcolors:
	HEADER = '\033[95m'
    	OKBLUE = '\033[94m'
    	OKGREEN = '\033[92m'
    	WARNING = '\033[93m'
    	FAIL = '\033[91m'
    	ENDC = '\033[0m'

	def disable(self):
		self.HEADER = ''
		self.OKBLUE = ''
		self.OKGREEN = ''
		self.WARNING = ''
		self.FAIL = ''
		self.ENDC = ''
#================================================================================



#================================================================================
#--------------------------------------------------------------------------------
#   Global Shit
#--------------------------------------------------------------------------------
#================================================================================
#DOC_LOWER=100000
DOC_UPPER=1100000
DOC_LOWER=157317
#DOC_UPPER=758080
#DOC_LOWER=716869			#132578,174571,178846,195141,199194
#DOC_UPPER=200004
connect_timeout = 0.0001

BASE_URL = "http://mdocweb.state.mi.us/otis2/otis2.aspx"
BASE_URL2 = "http://mdocweb.state.mi.us/otis2/"
BASE_URL3 = "http://mdocweb.state.mi.us/otis2/otis2profile.aspx?mdocNumber=%u" % (DOC_LOWER)
BASE_URL4 = "http://mdocweb.state.mi.us/otis2/ProfileImage.aspx?mdocNumber=%u" % (DOC_LOWER)
BASE_URL5 = "/var/www_download/dcc-security/mdoc/"

re_name = re.compile('\w{1,}')
re_feet = re.compile(r"\d{1,2}[']")
re_inches = re.compile('\d{1,2}["]')
re_weight = re.compile('\d{1,}')
re_date = re.compile('(\d{1,2}[/]){2}\d{4}')
re_alias = re.compile('[^#]{3,}')
re_slash = re.compile(' / ')
re_year = re.compile('\d{1,2} year')
re_month = re.compile('\d{1,2} month')
re_day = re.compile('\d{1,2} day')

db = MySQLdb.connect(host="localhost",
                     user="root",
                      passwd="1503vzw35",
                      db="xnet_node_root_info_xnet")
cur = db.cursor()
com = "SELECT * FROM midc_main;"
cur.execute(com)
resdb = cur.fetchall()
com = "SELECT * FROM midc_aliases;"
cur.execute(com)
resdb_a = cur.fetchall()
com = "SELECT * FROM midc_marks;"
cur.execute(com)
resdb_m = cur.fetchall()
com = "SELECT * FROM midc_sentences;"
cur.execute(com)
resdb_s = cur.fetchall()
#================================================================================



#================================================================================
#--------------------------------------------------------------------------------
#   Fuckin Functions
#--------------------------------------------------------------------------------
#================================================================================
def clean_data(rawdata):
	counter = 0
	rawSpoople = []
	for item in rawdata:
		rawSpoople.append(str("".join(rawdata[counter]).encode('ascii','ignore')))
		counter += 1
	return rawSpoople
	
def clean_date(rawdata):
	matches = re_date.search(rawdata)
	if matches:
		cleandate = datetime.strptime(matches.group(), "%m/%d/%Y").date()
	else:
		cleandate = datetime.strptime("01/01/2999", "%m/%d/%Y").date()
	return cleandate
	
def clean_date_long(rawdata):
	total = 0
	match = re_year.search(rawdata)
	if match:
		total += (int(re_weight.search(match.group()).group())*365)
	match = re_month.search(rawdata)
	if match:
		total += (int(re_weight.search(match.group()).group())*30)
	match = re_day.search(rawdata)
	if match:
		total += int(re_weight.search(match.group()).group())
	return total

def clean_data_space(rawdata):
	cleandata = []
	counter = 0
	for item in rawdata:
		rawdata[counter] = str("###".join(rawdata[counter]).encode('ascii','ignore'))
		counter += 1
	matches = re_alias.findall(rawdata[0])
	if matches:
		counter = 0
		for elem in matches:
			cleandata.append(matches[counter])
			counter += 1
	return cleandata
	
def clean_BULLSHIT(rawdata):
	cleandata = []
	for item in rawdata:
		if item != "":
			cleandata.append(item)
	return cleandata

def construct_data(rawdata, mnum):
	fulldata = []
	fulldata.append(rawdata[0])				#mdoc
	fulldata.append(rawdata[1])				#sid
	fulldata.append(rawdata[2])				#full name
	
	matches = re_name.findall(rawdata[2])
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
	
	matches = re_feet.search(rawdata[7])
	if matches:
		feet = int(re_weight.search(matches.group()).group())
		matches = re_inches.search(rawdata[7])
		inches = int(re_weight.search(matches.group()).group())
		fulldata.append( ( inches + (feet*12) ) )	#height
	else:
		fulldata.append(0)				#height
	
	matches = re_weight.search(rawdata[8])
	if matches:
		fulldata.append( int(matches.group()) )	#weight
	else:
		fulldata.append(0)				#weight
		
	fulldata.append(clean_date(rawdata[9]))			#dob
	fulldata.append(clean_date(rawdata[10]))		#image date
	fulldata.append("http://mdocweb.state.mi.us/otis2/ProfileImage.aspx?mdocNumber=%u" % (mnum))
	fulldata.append(rawdata[11])				#status
	fulldata.append(rawdata[12])				#location
	fulldata.append(rawdata[13])				#security lvl
	fulldata.append(clean_date(rawdata[14]))		#min release
	fulldata.append(clean_date(rawdata[15]))		#max release
	fulldata.append("http://mdocweb.state.mi.us/otis2/otis2profile.aspx?mdocNumber=%u" % (mnum))	
	return fulldata
	
def construct_sent(part1, part2, part3, type, cleansent, mdmid):
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
			match = re_slash.search(part1[a+1])
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
					sent.append(clean_date_long(part3[c]))
				if f <= c+1:
					sent.append("")
				else:
					sent.append(clean_date_long(part3[c+1]))
				if f <= c+2:
					sent.append("")
				else:
					sent.append(clean_date(part3[c+2]))
				if f <= c+3:
					sent.append("")
				else:
					sent.append(clean_date(part3[c+3]))
				a += 5
				b += 2
				if type == 2 or type == 4:
					if f <= c+4:
						sent.append("")
					else:
						sent.append(clean_date(part3[c+4]))
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
					sent.append(clean_date_long(part3[c]))
				if f <= c+1:
					sent.append("")
				else:
					sent.append(clean_date_long(part3[c+1]))
				if f <= c+2:
					sent.append("")
				else:
					sent.append(clean_date(part3[c+2]))
				if f <= c+3:
					sent.append("")
				else:
					sent.append(clean_date(part3[c+3]))
				a += 4
				b += 1
				if type == 2 or type == 4:
					if f <= c+4:
						sent.append("")
					else:
						sent.append(clean_date(part3[c+4]))
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

def insert_data(fulldata):
	com = "INSERT INTO midc_main (mdoc_number, sid_number, full_name, last_name, first_name, middle_name, race, sex, hair, eyes, height, weight, date_of_birth, image_date, image_url, current_status, assigned_location, security_level, date_intake, date_discharge, profile_url) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)".format('midc_main')
	cur.execute(com, (fulldata[0],fulldata[1],fulldata[2],fulldata[3],fulldata[4],fulldata[5],fulldata[6],fulldata[7],fulldata[8],fulldata[9],fulldata[10],fulldata[11],fulldata[12],fulldata[13],fulldata[14],fulldata[15],fulldata[16],fulldata[17],fulldata[18],fulldata[19],fulldata[20]))
	db.commit()
	com = "SELECT mdm_id FROM midc_main ORDER BY mdm_id DESC LIMIT 1;"
	cur.execute(com)
	counter = 0
	resss = cur.fetchall()
	for row in resss:
		if counter == 0:
			linenum = row[0]
			counter = 1
	return linenum

def insert_data_alias(alias, mdmid):
	com = "INSERT INTO midc_aliases (alias, mdm_id) VALUES (%s,%s)".format('midc_aliases')
	cur.execute(com, (alias, mdmid))
	db.commit()
	
def insert_data_marks(alias, mdmid):
	com = "INSERT INTO midc_marks (mark, mdm_id) VALUES (%s,%s)".format('midc_marks')
	cur.execute(com, (alias, mdmid))
	db.commit()
	
def insert_data_sent(sent):
	com = "INSERT INTO midc_sentences (mdm_id,type,offense,mcl_number,court_file_number,county,conviction_type,min_sentence,max_sentence,date_of_offense,date_of_sentence,discharge_date,discharge_reason) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)".format('midc_sentences')
	cur.execute(com, (sent[0],sent[1],sent[2],sent[3],sent[4],sent[5],sent[6],sent[7],sent[8],sent[9],sent[10],sent[11],sent[12]))
	db.commit()

def update_data(fulldata, mdmid):
	com = "UPDATE midc_main SET sid_number=%s, full_name=%s, last_name=%s, middle_name=%s, race=%s, sex=%s, hair=%s, eyes=%s, height=%s, weight=%s, image_date=%s, image_url=%s, current_status=%s, assigned_location=%s, security_level=%s, date_intake=%s, date_discharge=%s, profile_url=%s WHERE mdm_id=%s".format('midc_main')
	cur.execute(com, (fulldata[1],fulldata[2],fulldata[3],fulldata[4],fulldata[6],fulldata[7],fulldata[8],fulldata[9],fulldata[10],fulldata[11],fulldata[12],fulldata[14],fulldata[15],fulldata[16],fulldata[17],fulldata[18],fulldata[19],fulldata[20],mdmid))
	db.commit()
	
def update_data_sent(sent, mdsid):
	com = "UPDATE midc_sentences SET conviction_type=%s, min_sentence=%s, max_sentence=%s, date_of_sentence=%s, discharge_date=%s, discharge_reason=%s WHERE mds_id=%s".format('midc_sentences')
	cur.execute(com, (sent[6],sent[7],sent[8],sent[10],sent[11],sent[12],mdsid))
	db.commit()

def publish_data(fulldata):
	duplicate = 0
	linenum = 0
	for row in resdb:
		if str(fulldata[0]) == str(row[2]) and str(fulldata[12]) == str(row[14]) and str(fulldata[4]) == str(row[6]):
			duplicate = 1
			linenum = row[0]
	if duplicate == 1:
		update_data(fulldata, linenum)
	else:
		linenum = insert_data(fulldata)
	return linenum
	
def publish_data_alias(rawalias, mdmid):
	for elem in rawalias:
		duplicate = 0
		for row in resdb_a:
			if str(mdmid) == str(row[1]) and str(elem) == str(row[3]):
				duplicate = 1
		if duplicate != 1:
			insert_data_alias(elem, mdmid)

def publish_data_marks(rawalias, mdmid):
	for elem in rawalias:
		duplicate = 0
		for row in resdb_m:
			if str(mdmid) == str(row[1]) and str(elem) == str(row[3]):
				duplicate = 1
		if duplicate != 1:
			insert_data_marks(elem, mdmid)
			
def publish_data_sent(rawalias, mdmid):
	for elem in rawalias:
		duplicate = 0
		for row in resdb_s:
			if str(mdmid) == str(row[1]) and str(elem[1]) == str(row[3]) and str(elem[2]) == str(row[4]) and str(elem[3]) == str(row[5]) and str(elem[4]) == str(row[6]) and str(elem[5]) == str(row[7]) and str(elem[9]) == str(row[11]):
				duplicate = 1
				linenum = row[0]
		if duplicate == 1:
			update_data_sent(elem, linenum)
		else:
			insert_data_sent(elem)
				
def print_data(rawdata):
	count = 0
	for item in rawdata:
		print "List item " + str(count) + " contains " + str(item)
		count += 1
#================================================================================



#================================================================================
#--------------------------------------------------------------------------------
#   Main Bullshit
#--------------------------------------------------------------------------------
#================================================================================
print bcolors.HEADER + ">> Scraping OTIS Database, (MDOC):" + bcolors.ENDC
print bcolors.HEADER + ">> %s" % (BASE_URL) + bcolors.ENDC

print bcolors.OKBLUE + ">> Search worker has started." + bcolors.ENDC
index = DOC_LOWER
while index <= DOC_UPPER and db:
	print bcolors.WARNING + ">>> Worker is submitting DOC number: %u..." % (index) + bcolors.ENDC
	
	url = 'http://mdocweb.state.mi.us/otis2/otis2profile.aspx?mdocNumber=%u' % (index)
	
	trying = 1
	while trying == 1:
		try:
			request = requests.get(url)
			trying = 0
		except requests.exceptions.RequestException as e:
			print bcolors.FAIL + ">>> [Error] MDOC: %u" % (index) + bcolors.ENDC
		
		
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
		rawdata = clean_data(rawdata)
		rawalias = clean_data_space(rawalias)
		rawmarks = clean_data_space(rawmarks)
		fulldata = construct_data(rawdata, index)
		linenum = publish_data(fulldata)
		if linenum == 0:
			com = "SELECT mdm_id FROM midc_main ORDER BY mdm_id DESC LIMIT 1;"
			cur.execute(com)
			linenum = str(cur.fetchall())
		publish_data_alias(rawalias, linenum)
		publish_data_marks(rawmarks, linenum)
		
		part1 = clean_data(resultTree.xpath(r'//*[@id="pnlPASentences"]/div[@class="row-fluid rowWapper"]/div[2]/text()'))
		part2 = clean_data(resultTree.xpath(r'//*[@id="pnlPASentences"]/div[@class="row-fluid rowWapper"]/div[2]/a/text()'))
		part3 = clean_data(resultTree.xpath(r'//*[@id="pnlPASentences"]/div[@class="row-fluid rowWapper"]/div[4]/text()'))
		rawsent = construct_sent(part1, part2, part3, 1, rawsent, linenum)
		part1 = clean_data(clean_data(resultTree.xpath(r'//*[@id="pnlPISentences"]/div[@class="row-fluid rowWapper"]/div[2]/text()')))
		part2 = clean_data(resultTree.xpath(r'//*[@id="pnlPISentences"]/div[@class="row-fluid rowWapper"]/div[2]/a/text()'))
		part3 = clean_data(resultTree.xpath(r'//*[@id="pnlPISentences"]/div[@class="row-fluid rowWapper"]/div[4]/text()'))
		rawsent = construct_sent(part1, part2, part3, 2, rawsent, linenum)
		part1 = clean_data(resultTree.xpath(r'//*[@id="pnlRASentences"]/div[@class="row-fluid rowWapper"]/div[2]/text()'))
		part2 = clean_data(resultTree.xpath(r'//*[@id="pnlRASentences"]/div[@class="row-fluid rowWapper"]/div[2]/a/text()'))
		part3 = clean_data(resultTree.xpath(r'//*[@id="pnlRASentences"]/div[@class="row-fluid rowWapper"]/div[4]/text()'))
		rawsent = construct_sent(part1, part2, part3, 3, rawsent, linenum)
		part1 = clean_data(clean_data(resultTree.xpath(r'//*[@id="pnlRISentences"]/div[@class="row-fluid rowWapper"]/div[2]/text()')))
		part2 = clean_data(resultTree.xpath(r'//*[@id="pnlRISentences"]/div[@class="row-fluid rowWapper"]/div[2]/a/text()'))
		part3 = clean_data(resultTree.xpath(r'//*[@id="pnlRISentences"]/div[@class="row-fluid rowWapper"]/div[4]/text()'))
		rawsent = construct_sent(part1, part2, part3, 4, rawsent, linenum)
		publish_data_sent(rawsent, linenum)
	else:
		print bcolors.FAIL + ">>> No record for MDOC: %u" % (index) + bcolors.ENDC
	index += 1
print bcolors.OKGREEN + ">> Search worker has finished." + bcolors.ENDC

if db:
	db.close()
	print bcolors.OKGREEN + "\n>> Closed database connection." + bcolors.ENDC
else:
	print bcolors.FAIL + "\n>> No database connection to close." + bcolors.ENDC

print bcolors.OKGREEN + ">> Done getting data." + bcolors.ENDC
#================================================================================


