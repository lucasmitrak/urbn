#!/usr/bin/env python

import MySQLdb
from datetime import datetime
import time
import os

list = ['01','02','03','04','05','06','07','08','09']
f = '%Y-%m-%dT%H:%M:%S.%f%z'
res3 = [0] * len(list)
db = MySQLdb.connect(host='127.0.0.1',user='root',passwd='1503vzw35',port=3306,db='xnet_node_root_info_xnet')
if not db:
	print "Error db"
else:
	while True:
		os.system('clear')
		print str(datetime.now())
		print "================================================="
		sum = 0
		sum2 = 0
		flag = 0
		flag2 = 0
		index = 0
		for node in list:
			table = 'fb%s_timeline' % (node)
			com = "SELECT postTime FROM "+table+" ORDER BY id DESC LIMIT 1;"
			cur = db.cursor()
			cur.execute(com)
			res = cur.fetchall()
			com = "SELECT COUNT(*) FROM "+table+";"
			cur = db.cursor()
			cur.execute(com)
			res2 = cur.fetchall()
			sum += res2[0][0]
			tim = datetime.now() - res[0][0]
			if int(tim.seconds/60) > 30:
				timz = "\033[41m\033[1m"+str(tim)+"\033[0m"
				flag = 3
			elif int(tim.seconds/60) > 10:
				timz = "\033[43m\033[30m"+str(tim)+"\033[0m"
				flag = 2
			else:
				timz = "\033[42m\033[30m"+str(tim)+"\033[0m"
				flag = 1
			diff = res2[0][0]-res3[index]
			sum2 += diff
			if diff == 0:
				dr = "\033[41m\033[1m"+str(diff)+"\033[0m"
				flag2 = 3
			elif diff < 10:
				dr = "\033[43m\033[30m"+str(diff)+"\033[0m"
				flag2 = 2
			else:
				dr = "\033[42m\033[30m"+str(diff)+"\033[0m"
				flag2 = 1
			if flag == 1 and flag2 == 1:
				msg = "\033[42m\033[30mRunning\033[0m"
			elif flag == 3 and flag2 == 3:
				msg = "\033[41m\033[1mStopped\033[0m"
			elif flag == 2 or flag2 == 2:
				msg = "\033[43m\033[30mRunning Slow\033[0m"
			elif flag == 1 and flag2 == 3:
				msg = "\033[41m\033[1mLOOPED\033[0m"
			else:
				msg = ''
			print node+"\t"+timz+"\t"+str(res2[0][0])+"\t"+dr+"\t"+msg
			res3[index] = res2[0][0]
			index += 1
		print "-------------------------------------------------"
		print "sums:\t\t\t"+str(sum)+"\t"+str(sum2)
		print "================================================="
		
		db.commit()
		time.sleep(60)
		
