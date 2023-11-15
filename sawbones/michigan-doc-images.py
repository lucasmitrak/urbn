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
import urllib
import os.path

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
BASE_URL = "/root/spoderman/var/midc/"

db = MySQLdb.connect(host="localhost",
                     user="root",
                      passwd="1503vzw35",
                      db="xnet_node_root_info_xnet")
cur = db.cursor()
com = "SELECT mdm_id, mdoc_number, image_url FROM midc_main;"
cur.execute(com)
resdb = cur.fetchall()
#================================================================================



#================================================================================
#--------------------------------------------------------------------------------
#   Fuckin Functions
#--------------------------------------------------------------------------------
#================================================================================

#================================================================================



#================================================================================
#--------------------------------------------------------------------------------
#   Main Bullshit
#--------------------------------------------------------------------------------
#================================================================================
print bcolors.HEADER + ">> Scraping OTIS Database, (MDOC), for images:" + bcolors.ENDC
print bcolors.HEADER + ">> Saving images to: %s" % (BASE_URL) + bcolors.ENDC

print bcolors.OKBLUE + ">> Search worker has started." + bcolors.ENDC

for row in resdb:
	print bcolors.WARNING + ">>> Worker is submitting DOC number: %s..." % (row[1]) + bcolors.ENDC
	savepath = "/root/spoderman/var/midc/%s-%s.jpg" % (row[0],row[1])
	if os.path.isfile(savepath):
		print bcolors.OKBLUE + ">> File already exists." + bcolors.ENDC
	else:
		try_count = 0
		while try_count < 10000:
			try:
				urllib.urlretrieve(row[2], savepath)
				try_count = 40000
			except:
				print "Server is fighting back"
				try_count += 1
		
		if os.path.isfile(savepath):
			print bcolors.OKGREEN + ">> File saved correctly." + bcolors.ENDC
			if os.path.getsize(savepath) <= 512:
				os.remove(savepath)
				if os.path.isfile(savepath):
					print bcolors.FAIL + "\n>> File is shit, but can not be trashed.\n" + bcolors.ENDC
					break
				else:
					print bcolors.OKBLUE + ">> File is shit and has been trashed." + bcolors.ENDC
		else:
			print bcolors.FAIL + "\n>> File failed to save.\n" + bcolors.ENDC
			break

print bcolors.OKGREEN + ">> Search worker has finished." + bcolors.ENDC

if db:
	db.close()
	print bcolors.OKGREEN + "\n>> Closed database connection." + bcolors.ENDC
else:
	print bcolors.FAIL + "\n>> No database connection to close." + bcolors.ENDC

print bcolors.OKGREEN + ">> Done getting images." + bcolors.ENDC
#================================================================================


