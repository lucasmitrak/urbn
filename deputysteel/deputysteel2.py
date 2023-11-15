#!/usr/bin/env python

import MySQLdb
import re
import bs4
#from lxml import html
import shutil
import os
from datetime import datetime
import urllib3
import sys
from splinter import Browser as webdriver
import time
import urllib
import gc

class Facebook:
	def __init__(self):
		import deputysteel2c as config
		self.start = datetime.now()
		self.target = 'https://m.facebook.com'
		self.target_node = int(config.node)
		self.target_catfish = config.catfish
		self.target_subject = config.subject
		self.extended = config.extended
		self.target_continue = config.etc
		self.db = None
		self.db_host = config.db_host
		self.db_port = config.db_port
		self.db_user = config.db_user
		self.db_pass = config.db_pass
		self.db_name = config.db_name
		self.db_table_catfish = config.db_table_catfish
		self.db_table_friends = config.db_table_friends
		self.db_table_timeline = config.db_table_timeline
		self.db_table_comments = config.db_table_comments
		self.profiles = None
		self.browser = webdriver()
		self.browser2 = webdriver()
		self.save_path = "/root/deputysteel/var/"
		self.try_count_max = 1000
		self.filesize_trash = 512
		self.last_message = ''
		self.last_fbdate = ''
		self.last_links = None
		self.repeat = 0
	
	def clean_up():
		self.browser.quit()
		self.browser2.quit()
		gc.collect()
	
	def clean_data(self,rawdata):
		counter = 0
		cleandata = []
		for item in rawdata:
			cleandata.append(str("".join(rawdata[counter]).encode('ascii','ignore')))
			counter += 1
		return cleandata
	
	def assemble_strings(self,rawdata):
		rawdata = self.clean_data(rawdata)
		msg = ""
		for item in rawdata:
			msg = msg + " " + item
		return msg
	
	def assemble_story(self,post):
		slist = [None] * 12
		
		if post[0]:
			slist[0] = str("".join(post[0][0]).encode('ascii','ignore'))
		else:
			slist[0] = -1
		
		if post[1]:
			slist[1] = str("".join(post[1][0]).encode('ascii','ignore'))
		else:
			slist[1] = -1
		
		if post[2]:
			slist[2] = str("".join(post[2]).encode('ascii','ignore'))
			if slist[2] == '':
				slist[2] = "posted"
		else:
			slist[2] = "posted"
		
		if post[3]:
			slist[3] = self.assemble_strings(post[3])
		else:
			slist[3] = "no message"
		
		if post[4]:
			slist[4] = post[4][0]
		else:
			slist[4] = "error"
		
		if post[5]:
			#slist[5] = convert_time(post[4][0])
			slist[5] = post[5]
		else:
			slist[5] = "No time stamp?"
		
		if post[6]:
			slist[6] = str("".join(post[6][0]).encode('ascii','ignore'))
		else:
			slist[6] = "no privacy stated"
		
		if post[7] or post[7] == 0:
			slist[7] = post[7]
		else:
			slist[7] = -1
			
		if post[8]:
			slist[8] = post[8][0]
		else:
			slist[8] = "No attachment or video"
		
		if post[9] or post[9] == 0:
			slist[9] = post[9]
		else:
			slist[9] = "-1"
			
		if post[10]:
			slist[10] = post[10]
		else:
			slist[10] = "http://www.google.com/"
			
		if post[11] or post[11] == 0:
			slist[11] = post[11]
		else:
			slist[11] = -1
			
		return slist
	
	def assemble_story_picture(self,post):
		slist = [None] * 13
	
		if post[0]:
			slist[0] = str("".join(post[0][0]).encode('ascii','ignore'))
		else:
			slist[0] = -1
		
		if post[1]:
			slist[1] = str("".join(post[1][0]).encode('ascii','ignore'))
		else:
			slist[1] = -1
		
		if post[2]:
			slist[2] = str("".join(post[2]).encode('ascii','ignore'))
			if slist[2] == '':
				slist[2] = "posted"
		else:
			slist[2] = "posted"
		
		if post[3]:
			slist[3] = self.assemble_strings(post[3])
		else:
			slist[3] = "no message"
		
		if post[4]:
			slist[4] = post[4][0]
		else:
			slist[4] = "error"
		
		if post[5]:
			#slist[5] = convert_time(post[4][0])
			slist[5] = post[5]
		else:
			slist[5] = "No time stamp?"
		
		if post[6]:
			slist[6] = str("".join(post[6][0]).encode('ascii','ignore'))
		else:
			slist[6] = "no privacy stated"
		
		if post[7] or post[7] == 0:
			slist[7] = post[7]
		else:
			slist[7] = -1
			
		if post[8]:
			slist[8] = post[8][0]
			try:
				loc = self.br_get_story_picture(post[8][0], str(datetime.now()))
				slist[12] = open(loc, 'rb').read()
			except:
				slist[12] = open('/root/deputysteel/oops.jpg', 'rb').read()
		else:
			slist[8] = "No PICTURE"
		
		if post[9] or post[9] == 0:
			slist[9] = post[9]
		else:
			slist[9] = "-1"
			
		if post[10]:
			slist[10] = post[10]
		else:
			slist[10] = "http://www.google.com/"
			
		if post[11] or post[11] == 0:
			slist[11] = post[11]
		else:
			slist[11] = -1
		
		return slist
	
	def assemble_story_video(self):
		return 0
	
	def assemble_comments(self,post):
		clist = []
		comm = []
		counter = 0
		for item in post[12]:
			if item:
				comm.append(str("".join(item).encode('ascii','ignore')))
			else:
				comm.append("No data?")
			counter = counter + 1
			if counter == 4:
				counter = 0
				clist.append(comm)
				comm = []
		return clist
	
	def convert_timestamp(self, ftime):
		return 0
	
	
	def br_open(self):
		self.browser.visit(self.target)
		
	def br_login(self, profile):
		print "[" + str(datetime.now()) +"] - Entering " + str(profile[2])
		self.browser.visit(self.target)
		self.browser.find_by_name('email').fill(str(profile[3]))
		self.browser.find_by_name('pass').fill(str(profile[4]))
		self.browser.find_by_name('login').click()
		if self.br_followlink('Skip'):
			print "[" + str(datetime.now()) +"] - FB asked for verification [skip]"
		if not self.br_checklink("Logout"):
			return False
		self.browser2.visit(self.target)
		self.browser2.find_by_name('email').fill(str(profile[3]))
		self.browser2.find_by_name('pass').fill(str(profile[4]))
		self.browser2.find_by_name('login').click()
		if self.br2_followlink('Skip'):
			print "[" + str(datetime.now()) +"] - FB asked for verification [skip]"
		if not self.br2_checklink("Logout"):
			return False
		return True
	
	def br_logout(self):
		print "[" + str(datetime.now()) +"] - Logging out"
		if self.br_followlink("Logout"):
			if not self.br_checklink("Logout"):
				print "[" + str(datetime.now()) +"] - Successfull Log out"
				print "[" + str(datetime.now()) +"] - Logging out"
				self.browser2.visit(self.target)
				if self.br2_followlink("Logout"):
					if not self.br2_checklink("Logout"):
						print "[" + str(datetime.now()) +"] - Successfull Log out"
						return True
		print "[" + str(datetime.now()) +"] - Failed Log out"
		return False
	
	def br_checklink(self,textInLink):
		if self.browser.find_link_by_partial_text(textInLink):
			return True
		return False
	
	def br2_checklink(self,textInLink):
		if self.browser2.find_link_by_partial_text(textInLink):
			return True
		return False
	
	def br_checklink_exact(self,textInLink):
		if self.browser.find_link_by_text(textInLink):
			return True
		return False
		
	def br_followlink(self,textInLink):
		if self.br_checklink(textInLink):
			try_count = 0
			while try_count < 4:
				try:
					self.browser.click_link_by_partial_text(textInLink)
					return True
				except:
					try_count += 1
					print 'Recieved a apache 500 error, retrying (' + str(try_count) + ')'
					self.browser.back()
		return False
		
	def br2_followlink(self,textInLink):
		if self.br2_checklink(textInLink):
			try_count = 0
			while try_count < 4:
				try:
					self.browser2.click_link_by_partial_text(textInLink)
					return True
				except:
					try_count += 1
					print 'Recieved a apache 500 error, retrying (' + str(try_count) + ')'
					self.browser2.back()
		return False
	
	def br_followlink_exact(self,textInLink):
		if self.br_checklink_exact(textInLink):
			try_count = 0
			while try_count < 4:
				try:
					self.browser.click_link_by_text(textInLink)
					return True
				except:
					try_count += 1
					print 'Recieved a apache 500 error, retrying (' + str(try_count) + ')'
					self.browser.back()
		return False
	
	def br_goto_friendslist(self):
		self.browser.visit(self.target)
		if self.br_followlink_exact('Profile'):
			if self.br_followlink_exact('Friends'):
				return True
		return False
	
	def br_get_friendslist(self,profile):
		if not self.br_goto_friendslist():
			return False
		soup = bs4.BeautifulSoup(self.browser.html)

		fnames = []
		flinks = []
		listDone = False
		
		while not listDone:
			friends = soup.select("div div div div div div div table tbody tr td a")
			for friend in friends:
				if fnames:
					if fnames[0] == friend.contents[0]:
						break
				fnames.append(friend.contents[0])
				flinks.append(self.target + friend['href'])
			if self.br_followlink('See More Friends'):
				soup = bs4.BeautifulSoup(self.browser.html)
			else:
				listDone = True
		fnames = self.clean_data(fnames)
		flinks = self.clean_data(flinks)
		
		if self.db_push_friendslist(fnames, flinks, profile):
			return True
		print "[" + str(datetime.now()) +"] - Failed to get friends list from " + str(profile[2])
		return False
	
	def browser_get_likes(self):
		return 0
	
	def browser_get_likers(self):
		return 0
	
	def br_get_comments(self,xpath):
		list = []
		"""
		xpathUnit = xpath + '/div'
		elements = html.xpath(xpathUnit)
		index = 1
		for item in elements:
			xpathUnit = xpath + '/div[%u]' % (index)
			list.append(html.xpath(xpathUnit + r'/h3/a/text()')) #name
			list.append(html.xpath(xpathUnit + r'/h3/a/@href')) #link
			list.append(html.xpath(xpathUnit + r'/div[1]/text()')) #comment
			list.append(html.xpath(xpathUnit + r'/div[2]/abbr/text()')) #date
			index = index + 1
		"""
		sxpath = xpath + '/div'
		if self.browser2.is_element_not_present_by_xpath(sxpath):
			print "[" + str(datetime.now()) +"] - Error, No comments found"
		else:
			index = 1
			elements = self.browser2.find_by_xpath(sxpath)
			for item in elements:
				sxpath = xpath + '/div[%u]' % (index)
				list.append(self.browser2.find_by_xpath(sxpath + '/h3/a').text)
				list.append(self.browser2.find_by_xpath(sxpath + '/h3/a')['href'])
				list.append(self.browser2.find_by_xpath(sxpath + '/div[1]').text)
				list.append(self.browser2.find_by_xpath(sxpath + '/div[2]/abbr').text)
		return list
	
	def br_get_comments_count(self,xpath):
		"""
		num = 0
		xpathUnit = xpath + '/div'
		elements = html.xpath(xpathUnit)
		for item in elements:
			num = num + 1
		return num
		"""
		index = 0
		sxpath = xpath + '/div'
		if self.browser2.is_element_not_present_by_xpath(sxpath):
			print "[" + str(datetime.now()) +"] - Error, No Comments found to count"
		else:
			elements = self.browser2.find_by_xpath(sxpath)
			for item in elements:
				index = index + 1
		return index
	
	def br_get_timeline(self,profile,friend):
		print "[" + str(datetime.now()) +"] - Getting timeline of " + friend[2] + " who is linked to "+ profile[2]
		self.browser.visit(friend[3])
		listDone = 0
		flip = 0
		while listDone == 0:
			links = []
			index = 0
			while index >= 0:
				if flip == 0:
					links.append(self.browser.find_by_xpath(r'/html/body/div/div/div[2]/div/div/div[%u]/div[2]/div/div[1]/div/div/div[%u]/div[2]/div[2]/a[1]/@href' % (2,index+1)).first['href'])
				elif flip == 1:
					links.append(self.browser.find_by_xpath(r'/html/body/div/div/div[2]/div/div/div/div[1]/div[2]/div/div[%u]/div[2]/div[2]/a[1]' % (index+1)).first['href'])
				if not links[index]:
					links.pop()
					break
				index += 1
			if len(links) == 0:
				self.repeat = 1
			elif self.last_links == links:
				print "[" + str(datetime.now()) +"] - Repeater story!!!"
				self.repeat = 1
			else:
				self.br_get_story(profile,links,friend)
			self.last_links = links
			
			if self.br_followlink('Show more') and self.repeat == 0:
				print "[" + str(datetime.now()) +"] - Clicking 'Show more'"
			elif self.br_checklink_exact('2015') and flip == 0 and self.extended == 1:
				flip = 1
				self.repeat = 0
				if self.br_followlink('2015'):
					print "[" + str(datetime.now()) +"] - Clicking '2015'"
				else:
					listDone = 1
					self.repeat = 0
			else:
				listDone = 1
				self.repeat = 0
			
			print "[" + str(datetime.now()) +"] - Successfully found and saved " + str(len(links)) + " stories from timeline."
	
	def br_get_story(self,profile,links,friend):
		for link in links:
			post = [None] * 13
			link = self.target + link[0]
			self.browser2.visit(link)
			page = self.browser2.html
			soup = bs4.BeautifulSoup(self.browser2.html)
			root = html.fromstring(page)
			index = 0
			
			post[8] = root.xpath(r'/html/body/div/div/div[2]/div/div/div/div[1]/div[1]/div/img/@src')
			if post[8]: #If photo post
				post[0] = root.xpath(r'/html/body/div/div/div[2]/div/div/div/div[3]/div[1]/div[1]/a/strong/text()') #poster
				post[1] = root.xpath(r'/html/body/div/div/div[2]/div/div/div/div[3]/div[1]/div[1]/a/@href') #posterlink
				post[2] = "posted a photo" #action
				post[3] = root.xpath(r'/html/body/div/div/div[2]/div/div/div/div[3]/div[1]/div[1]/div/text()') #message
				post[4] = root.xpath(r'/html/body/div/div/div[2]/div/div/div/div[3]/div[1]/div[2]/span/div/div/abbr/text()') #postTime
				post[5] = datetime.now() #posttime datetime
				post[6] = root.xpath(r'/html/body/div/div/div[2]/div/div/div/div[3]/div[1]/div[2]/span/div/div/span[2]/text()') #privacy
				linkl = root.xpath(r'/html/body/div/div/div[2]/div/div/div/div[3]/div[2]/div/div/div[1]/a[2]/@href')
				if linkl:
					url = self.target + linkl[0]
					post[7] = 0 #get_likes(browser, target, url_login, profile, db, url) #likes
					post[9] = 0 #get_likers(browser, target, url_login, profile, db, url) #likers
				else:
					linkl = root.xpath(r'/html/body/div/div/div[2]/div/div/div/div[3]/div[2]/div/div/div[1]/a[1]/@href')
					if linkl:
						url = self.target + linkl[0]
						post[7] = 0 #get_likes(browser, target, url_login, profile, db, url) #likes
						post[9] = 0 #get_likers(browser, target, url_login, profile, db, url) #likers
					else:
						post[7] = 0
						post[8] = 0
				post[10] = link #link
				xpathComments = r'/html/body/div/div/div[2]/div/div/div/div[3]/div[2]/div/div/div[2]'
				post[11] = self.br_get_comments_count(xpathComments) #comments num
				post[12] = self.br_get_comments(xpathComments) #comments
				repeat = str("".join(post[3]).encode('ascii','ignore'))
				repeatd = str("".join(post[4]).encode('ascii','ignore'))
				
				"""if 1 == 2 and repeat != '' or repeatd == self.last_fbdate:
					if self.last_message == repeat:
						self.repeat = 1
						print "[" + str(datetime.now()) +"] - Repeater story!!!"
					else:
						self.db_push_story_picture(post,profile,friend)
				else:
					self.db_push_story_picture(post,profile,friend)
				"""
				self.db_push_story_picture(post,profile,friend)
				
				self.last_message = repeat
				self.last_fbdate = repeatd
				print "[" + str(datetime.now()) +"] - Successfully scraped and saved the Picture Story"
			else:
				post[0] = root.xpath(r'/html/body/div/div/div[2]/div/div/div[1]/div/div[1]/div[1]/h3/strong/a/text()') #poster
				post[1] = root.xpath(r'/html/body/div/div/div[2]/div/div/div[1]/div/div[1]/div[1]/h3/strong/a/@href') #posterLink
				post[2] = root.xpath(r'/html/body/div/div/div[2]/div/div/div[1]/div/div[1]/div[1]/h3/text()') #action
				post[3] = root.xpath(r'/html/body/div/div/div[2]/div/div/div[1]/div/div[1]/div[2]/p/text()') #message
				post[8] = root.xpath(r'/html/body/div/div/div[2]/div/div/div[1]/div/div[1]/div[3]/a/@href') #attachment
				post[4] = root.xpath(r'/html/body/div/div/div[2]/div/div/div[1]/div/div[2]/div[1]/abbr/text()') #postTime
				post[5] = datetime.now() #postTime datetime
				post[6] = root.xpath(r'/html/body/div/div/div[2]/div/div/div[1]/div/div[2]/div[1]/span[2]/span/span/text()') #privacy
				linkl = root.xpath(r'/html/body/div/div/div[2]/div/div/div[2]/div/div[2]/a[2]/@href')
				if linkl:
					post[7] = 0 #get_likes(browser, target, url_login, profile, db, linkl) #likes
					post[9] = 0 #get_likers(browser, target, url_login, profile, db, root.xpath(r'/html/body/div/div/div[2]/div/div/div[2]/div/div[2]/a[2]/@href')) #likers
				else:
					linkl = root.xpath(r'/html/body/div/div/div[2]/div/div/div[2]/div/div[2]/a[1]/@href')
					if linkl:
						url = self.target + linkl[0]
						post[7] = 0 #get_likes(browser, target, url_login, profile, db, url) #likes
						post[9] = 0 #get_likers(browser, target, url_login, profile, db, url) #likers
					else:
						post[7] = 0
						post[8] = 0
				post[10] = link #link
				xpathComments = r'/html/body/div/div/div[2]/div/div/div[2]/div/div[3]'
				post[11] = self.br_get_comments_count(xpathComments) #comments num
				post[12] = self.br_get_comments(xpathComments) #comments
				repeat = str("".join(post[3]).encode('ascii','ignore'))
				repeatd = str("".join(post[4]).encode('ascii','ignore'))
				
				"""if and repeat != '' or repeatd == self.last_fbdate:
					if self.last_message == repeat:
						self.repeat = 1
						print "[" + str(datetime.now()) +"] - Repeater story!!!"
					else:
						self.db_push_story(post,profile,friend)
				else:
					self.db_push_story(post,profile,friend)
				"""
				self.db_push_story(post,profile,friend)
				
				self.last_message = repeat
				self.last_fbdate = repeatd
				"[" + str(datetime.now()) +"] - Successfully scraped and saved the Non-Picture Story"
		
	def br_get_story_picture(self,link,filename):
		savepath = self.save_path + "%s.jpg" % (str(filename))
		if os.path.isfile(savepath):
			print "[" + str(datetime.now()) +"] - File Exists."
		else:
			try_count = 0
			while try_count < self.try_count_max:
				try:
					urllib.urlretrieve(link, savepath)
					try_count = self.try_count_max
				except:
					print "[" + str(datetime.now()) +"] - Server is fighting back."
					time.sleep(1)
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
		return savepath
		
	def browser_get_story_video(self):
		return 0
	
	
	def db_connect(self):
		self.db = MySQLdb.connect(host=self.db_host,user=self.db_user,passwd=self.db_pass,port=self.db_port,db=self.db_name)
		if self.db:
			print "[" + str(datetime.now()) +"] - Database Connection [++]"
			return True
		else:
			print "[" + str(datetime.now()) +"] - Database Connection [--]"
			return False
		
	def db_get(self,command):
		cur = self.db.cursor()
		cur.execute(command)
		return cur.fetchall()
		
	def db_get_friends(self,id):
		res = self.db_get("SELECT * FROM "+self.db_table_friends+" WHERE postingProfile LIKE '%s'" % (id))
		if self.target_subject != 0:
			for friend in res:
				if int(friend[0]) == self.target_subject:
					if self.target_continue == 1:
						newres = []
						flipper = 0
						for ares in res:
							if int(ares[0]) == self.target_subject:
								flipper = 1
							if flipper == 1:
								newres.append(ares)
						print "[" + str(datetime.now()) +"] - TARGETED SEARCH with CONTINUE"
						return newres
					print "[" + str(datetime.now()) +"] - TARGETED SEARCH"
					return [friend,friend]
		return res
		
	def db_get_timeline(self,id):
		return self.db_get("SELECT * FROM "+self.db_table_timeline+" WHERE postingProfile LIKE '%s'" % (id))
	
	def db_get_comments(self,id):
		return self.db_get("SELECT * FROM "+self.db_table_comments+" WHERE timelineID LIKE '%s'" % (id))
	
	def db_push_friendslist(self,fnames,flinks,profile):
		res = self.db_get_friends(profile[0])
		cur = self.db.cursor()
		index = 0
		for link in flinks:
			duce = 0
			for row in res:
				if link == row[3] and duce == 0:
					com = "UPDATE "+self.db_table_friends+" SET name=%s, lastSeen=%s WHERE link=%s".format(self.db_table_friends)
					cur.execute(com, (str(fnames[index]), str(datetime.now()), str(link)))
					try:
						self.db.commit()
					except:
						return False
					duce = 1
					break
			if duce == 0:
				com = "INSERT INTO "+self.db_table_friends+" (postingProfile,name,link) VALUES (%s,%s,%s)".format(self.db_table_friends)
				cur.execute(com, (str(profile[0]),str(fnames[index]),link))
				try:
					self.db.commit()
				except:
					return False
			index = index + 1
		return True
	
	def db_push_comments(self,post,profile,timeline_id):
		if post[11] != 0:
			cur = self.db.cursor()
			if timeline_id == 0:
				duce = 0
				res_timeline = self.db_get_timeline(profile[0])
				for row in res_timeline:
					if post[10] == row[12] and duce == 0:
						timeline_id = row[0]
						duce = 1
						break
				if duce == 0:
					print "[" + str(datetime.now()) +"] - Error: finding timeline_id for comment submission failed to locate parent timeline_id"
			clist = self.assemble_comments(post)
			res_comments = self.db_get_comments(timeline_id)
			duce = 0
			for comm in clist:
				for row in res_comments:
					if row[3] == comm[0] and row[4] == comm[1] and row[5] == comm[2]:
						com = "UPDATE "+self.db_table_comments+" SET postTime_fb=%s, lastSeen=%s WHERE id=%s".format(self.db_table_comments)
						cur.execute(com, (comm[3], str(datetime.now()), row[0]))
						self.db.commit()
						duce = 1
						break
				if duce == 0:
					com = "INSERT INTO "+self.db_table_comments+" (postingProfile, timelineID, name, link, message, postTime_fb, postTime) VALUES (%s,%s,%s,%s,%s,%s,%s)".format(self.db_table_comments)
					cur.execute(com, (profile[0], timeline_id, comm[0], comm[1], comm[2], comm[3], str(datetime.now())))
					self.db.commit()
	
	def db_push_story(self,post,profile,friend):
		cur = self.db.cursor()
		duce = 0
		slist = self.assemble_story(post)
		res_timeline = self.db_get_timeline(profile[0])
		for row in res_timeline:
			if post[10] == row[12] and duce == 0:
				com = "UPDATE "+self.db_table_timeline+" SET message=%s, postTime_fb=%s, comments=%s, pictureLink=%s, lastSeen=%s WHERE postLink=%s".format(self.db_table_timeline)
				cur.execute(com, (slist[3], slist[4], slist[11], slist[8], str(datetime.now()), slist[10]))
				self.db.commit()
				self.db_push_comments(post,profile,row[0])
				duce = 1
				break
		if duce == 0:
			com = "INSERT INTO "+self.db_table_timeline+" (postingProfile, friend, poster, posterLink, action, message, postTime_fb, postTime, privacy, likes, likers, postLink, comments, pictureLink) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)".format(self.db_table_timeline)
			cur.execute(com, (profile[0], friend[0], slist[0], slist[1], slist[2], slist[3], slist[4], slist[5], slist[6], slist[7], slist[9], slist[10], slist[11], slist[8]))
			self.db.commit()
			self.db_push_comments(post,profile, 0)
		
	def db_push_story_picture(self,post,profile,friend):
		cur = self.db.cursor()
		duce = 0
		slist = self.assemble_story_picture(post)
		res_timeline = self.db_get_timeline(profile[0])
		for row in res_timeline:
			if post[10] == row[12] and duce == 0:
				com = "UPDATE "+self.db_table_timeline+" SET message=%s, postTime_fb=%s, comments=%s, pictureLink=%s, picture=%s, lastSeen=%s WHERE postLink=%s".format(self.db_table_timeline)
				cur.execute(com, (slist[3], slist[4], slist[11], slist[8], slist[12], str(datetime.now()), slist[10]))
				self.db.commit()
				self.db_push_comments(post, profile, row[0])
				duce = 1
				break
		if duce == 0:
			com = "INSERT INTO "+self.db_table_timeline+" (postingProfile, friend, poster, posterLink, action, message, postTime_fb, postTime, privacy, likes, likers, postLink, comments, pictureLink, picture) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)".format(self.db_table_timeline)
			cur.execute(com, (profile[0], friend[0], slist[0], slist[1], slist[2], slist[3], slist[4], slist[5], slist[6], slist[7], slist[9], slist[10], slist[11], slist[8], slist[12]))
			self.db.commit()
			self.db_push_comments(post, profile, 0)
		
	def db_push_story_video(self):
		return 0
	
	def db_disconnect(self):
		if self.db:
			self.db.close()
			if self.db:
				print "[" + str(datetime.now()) +"] - Database Connection [++]"
			else:
				print "[" + str(datetime.now()) +"] - Database Connection [--]"
		else:
			print "[" + str(datetime.now()) +"] - Database Connection [--]"
	
	
	def run(self):
		if self.db_connect():
			if self.target_catfish != 0:
				self.profiles = self.db_get("SELECT * FROM "+self.db_table_catfish+" WHERE id=%s;" % (str(self.target_catfish)))
			else:
				self.profiles = self.db_get("SELECT * FROM "+self.db_table_catfish+" WHERE node=%s;" % (str(self.target_node)))
			
			for profile in self.profiles:
				if self.br_login(profile):
					if self.br_get_friendslist(profile):
						friends = self.db_get_friends(profile[0])
						for friend in friends:
							#get about
							#get degree 2 friends
							self.br_get_timeline(profile,friend)
							#get photos
							#get videos
							#get likes
							#get following
					if not self.br_logout():
						break
			self.db_disconnect()
		self.clean_up()
		
if __name__ == "__main__":
	start = datetime.now()
	print 'Start:    ' + str(start)
	
	fb = Facebook()
	fb.run()
	
	print 'Complete: ' + str(datetime.now() - start)
