#!/usr/bin/python

#10101010101010101010101010101010101010101010101010101010101010101010101010101010
#0		1								1
#1 @@@@@@@$$$$	0	************************************************	0
#0    @  $	1	*					       *	1
#1    @   $$	0	*   URBN SCRIPTS MOTHERFUCKER	v4.0.0	       *	0
#0    @     $$	1	*		Created by Tallywackereb       *	1
#1    @       $	0	*					       *	0
#0    @   $$$$	1	************************************************	1
#1		0								0
#01010101010101010101010101010101010101010101010101010101010101010101010101010101



#================================================================================
#--------------------------------------------------------------------------------
#	Libraries and Shit
#--------------------------------------------------------------------------------
#================================================================================

import socket
import ssl
import pprint
from datetime import datetime

import bamman_config as cfg



#================================================================================
#--------------------------------------------------------------------------------
#	GLOBAL (THERMAL NUCLEAR WAR) [How about a nice game of chess?] 
#--------------------------------------------------------------------------------
#================================================================================





#================================================================================
#--------------------------------------------------------------------------------
#	Classy ass functions!
#--------------------------------------------------------------------------------
#================================================================================

class bcolors:
	HEADER = '\033[95m'
	OKBLUE = '\033[94m'
	OKGREEN = '\033[92m'
	WARNING = '\033[93m'
	FAIL = '\033[91m'
	ENDC = '\033[0m'



#================================================================================
#--------------------------------------------------------------------------------
#	Fuckin Functions
#--------------------------------------------------------------------------------
#================================================================================





#================================================================================
#--------------------------------------------------------------------------------
#	Main Bulllllllshit
#--------------------------------------------------------------------------------
#================================================================================

start = datetime.now()

s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

# Require a certificate from the server. We used a self-signed certificate
# so here ca_certs must be the server certificate itself.
ssl_sock = ssl.wrap_socket(s,
                           ca_certs=cfg.cert,
                           cert_reqs=ssl.CERT_REQUIRED)

ssl_sock.connect((cfg.host, int(cfg.port)))

print repr(ssl_sock.getpeername())
print ssl_sock.cipher()
print pprint.pformat(ssl_sock.getpeercert())

ssl_sock.write("boo!")

if False: # from the Python 2.7.3 docs
    # Set a simple HTTP request -- use httplib in actual code.
    ssl_sock.write("""GET / HTTP/1.0\r
    Host: www.verisign.com\n\n""")

    # Read a chunk of data.  Will not necessarily
    # read all the data returned by the server.
    data = ssl_sock.read()

    # note that closing the SSLSocket will also close the underlying socket
    ssl_sock.close()
	
	

#================================================================================
#--------------------------------------------------------------------------------
#	We're closed man. Dave isnt here man.
#--------------------------------------------------------------------------------
#================================================================================

