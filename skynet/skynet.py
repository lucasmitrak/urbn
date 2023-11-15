#!/usr/bin/env python

from datetime import datetime
import MySQLdb
import commands
import subprocess

class Skynet:
	def __init__(self):
		import skynetc as config
		
		self.node_list = None
		self.node_schedule = None
		
		self.db = None
		self.db_host = config.db_host
		self.db_port = config.db_port
		self.db_user = config.db_user
		self.db_pass = config.db_pass
		self.db_name = config.db_name
		self.db_table_list = config.db_table_list
		self.db_table_schedule = config.db_table_schedule
		self.db_table_messages = config.db_table_messages
		self.db_table_heartbeat = config.db_table_heartbeat		
		self.res_list = None
		self.res_schedule = None
	
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
	
	def db_get_list(self):
		self.res_list = self.db_get("SELECT * FROM "+self.db_table_list+";")
		
	def db_get_schedule(self):
		self.res_schedule = self.db_get("SELECT * FROM "+self.db_table_schedule+";")
	
	def db_disconnect(self):
		if self.db:
			self.db.close()
			if self.db:
				print "[" + str(datetime.now()) +"] - Database Connection [++]"
			else:
				print "[" + str(datetime.now()) +"] - Database Connection [--]"
		else:
			print "[" + str(datetime.now()) +"] - Database Connection [--]"
	
	def flag_running(self,id):
		try:
			cur = self.db.cursor()
			com = "UPDATE "+self.db_table_schedule+" SET running_flag=%s WHERE id=%s".format(self.db_table_schedule)
			cur.execute(com, ("1", str(id)))
			self.db.commit()
		except:
			return False
		return True
	
	def run_command(self,comm):
		command = comm.rstrip()
		
		try:
			output = subprocess.check_output(command,stderr=subprocess.STDOUT,shell=True)
		except:
			output = "Failed to execute command.\r\n"
			
		return output
	
	def check_schedule(self):
		now = datetime.now()
		for event in self.res_schedule:
			if event[6] < now and event[19] == 0:
				name = "69"
				for row in self.res_list:
					if event[1] == row[0]:
						name = str(row[1])
						user = str(row[6])
						host = str(row[7])
						port = str(row[8])	
				if name != "69":
					print "[" + str(datetime.now()) +"] - Running "+str(event[4])+" on node "+name+" as per the schedule item "+str(event[0])
					command = "ssh %s@%s -p %s \"cd %s && DISPLAY=:0.0 screen -d -m %s\"" % (user,host,port,event[4],event[5])
					if self.flag_running(event[0]):
						print command
						self.run_command(command)
	
	
	def run(self):
		self.db_connect()
		self.db_get_schedule()
		self.db_get_list()
		self.check_schedule()
		self.db_disconnect()

if __name__ == "__main__":
	start = datetime.now()
	print 'Start:    ' + str(start)
	
	sn = Skynet()
	sn.run()
	
	print 'Complete: ' + str(datetime.now() - start)