#!/usr/bin/env python

import socket
import sys
import ssl
import pickle

class Client:
	def __init__(self):
		self.host = 'localhost'
		self.port = 40000
		self.size = 1024
		self.server = None
		self.ssl_server = None
		self.ca_certs = 'security/server.crt'
	
	def open_socket(self):
		try:
			self.server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
			self.ssl_server = ssl.wrap_socket(self.server,
												ca_certs=self.ca_certs,
												cert_reqs=ssl.CERT_REQUIRED)
			self.ssl_server.connect((self.host,self.port))
			self.send_data(["Connected"])
			data = self.recieve_data()
			sys.stdout.write('# %s@%s:%u %s\n' % ('server',self.host,self.port,str(data)))
		except socket.error, (value,message):
			if self.server:
				self.server.close()
				sys.stdout.write('Could not open socket: ' + message + '\n')
			sys.exit(1)
			
	def send_data(self,data):
		pickled_data = pickle.dumps(data)
		self.ssl_server.write(pickled_data)
		
	def recieve_data(self):
		pickled_data = self.ssl_server.read()
		data = pickle.loads(pickled_data)
		return data
	
	def run(self):
		self.open_socket()
		input = [self.server,sys.stdin]
		reciever = 1
		running = 1
		while running:
			# read from keyboard
			sys.stdout.write('%')
			line = sys.stdin.readline()
			if line == 'quit\n':
				self.send_data(['quit'])
				reciever = 0
				running = 0
			
			#test
			elif line == 'list\n':
				self.send_data(['list',1,2,3,'abc',"cunt"])
				reciever = 1
			elif line == 'login nik\n':
				self.send_data(['login','nik','upton'])
				reciever = 1
			elif line == 'login tim\n':
				self.send_data(['login','tim','tom'])
				reciever = 1
			elif line == 'ls nodes\n':
				self.send_data(['get_ldb_nodes'])
				reciever = 1
			elif line == 'wc fb catfish\n':
				self.send_data(['get_rdball_fb_profile_pop'])
				reciever = 1
			#test end
			
			elif line == 'search':
				'''
				1  searcg
				2  downlood,email,ivh
				3  csv,txt
				4  regex
				5  regex
				6  regex
				'''
				self.send_data(['search','email','csv','nikolas','',''])
				reciever = 1
			else:
				sys.stdout.write("Not an assigned command.\n")
				reciever =0
			if reciever == 1:
				data = self.recieve_data()
				sys.stdout.write('# %s@%s:%u %s\n' % ('server',self.host,self.port,str(data)))
		self.ssl_server.close()

if __name__ == "__main__":
	c = Client()
	c.run()