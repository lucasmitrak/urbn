#!/usr/bin/env python

import select
import socket
import sys
import threading
import ssl
from datetime import datetime
import MySQLdb
import commands
import pickle

class Server:
	def __init__(self):
		self.host = ''
		self.port = 40000
		self.backlog = 5
		self.size = 1024
		self.server = None
		self.threads = []

	def open_socket(self):
		try:
			self.server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
			self.server.bind((self.host,self.port))
			self.server.listen(5)
		except socket.error, (value,message):
			if self.server:
				self.server.close()
				sys.stdout.write('Could not open socket: ' + message)
			sys.exit(1)

	def run(self):
		self.open_socket()
		input = [self.server,sys.stdin]
		running = 1
		while running:
			inputready,outputready,exceptready = select.select(input,[],[])
			for s in inputready:
				if s == self.server:
					# handle the server socket
					c = Client(self.server.accept())
					c.start()
					self.threads.append(c)
				elif s == sys.stdin:
					# handle standard input
					sys.stdout.write('%')
					junk = sys.stdin.readline()
					if junk == 'quit\n':
						if threading.active_count() == 1:
							running = 0
						else:
							sys.stdout.write('Cannot close, %u Client(s) are still active.\n' % (threading.active_count()-1))
					elif junk == 'clients\n':
						sys.stdout.write('Client Count: %u\n' % (threading.active_count()-1))
					elif junk == 'threads\n':
						sys.stdout.write('Thread Count: %u\n' % (len(self.threads)))
					else:
						sys.stdout.write("Not an assigned command.\n")
        # close all threads
		self.server.close()
		for c in self.threads:
			c.join()

class Client(threading.Thread):
	def __init__(self,(client,address)):
		threading.Thread.__init__(self)
		self.client = client
		self.ssl_client = ssl.wrap_socket(client,
										server_side=True,
										certfile='security/server.crt',
										keyfile='security/server.key')
		self.address = address
		self.size = 1024
		self.user = ''
		self.auth = 0
	
	def send_data(self,data):
		pickled_data = pickle.dumps(data)
		self.ssl_client.write(pickled_data)
		
	def recieve_data(self):
		pickled_data = self.ssl_client.read()
		data = pickle.loads(pickled_data)
		return data
	
	def run(self):
		running = 1
		while running:
			data = self.recieve_data()				
			if data:
				sys.stdout.write('# %s@%s:%u %s\n' % (self.user,self.address[0],self.address[1],str(data[0])))
				if str(data[0]) == 'quit':
					self.ssl_client.close()
					running = 0
				
				else:
					self.send_data(data)
			else:
				self.ssl_client.close()
				running = 0

if __name__ == "__main__":
	start = datetime.now()
	print 'Start:    ' + str(start)

	s = Server()
	s.run()
	
	print 'Complete: ' + str(datetime.now() - start)