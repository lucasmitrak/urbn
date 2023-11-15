#!/usr/bin/env python

from datetime import datetime
import MySQLdb
import commands
import subprocess

class Terminator:
	def __init__(self):
		import terminatorc as config
		
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
	
	def run_command(self,comm):
		command = comm.rstrip()
		
		try:
			output = subprocess.check_output(command,stderr=subprocess.STDOUT,shell=True)
		except:
			output = "Failed to execute command.\r\n"
			
		return output
		
load the text log
find the start time
find the end time 
	if found then write as successful
	if not found then find the last date time and return that line plus the rest of the file
	
to update
	schedule.the next run time
	schedule.run_count_total
	schedule.run_count_success || schedule.run_count_error
	schedule.date_last_run
	schedule.date_last_success || schedule.date_last_error
	script_history.node_list_name
	script_history.time_Started
	script_history.time_ended
	script_history.successful
	script_history.command
	script_history.error
	
to notify
	if error
	if finished after it was originally supposed to run again (run on tuesday, end friday but it ends saturday)
	