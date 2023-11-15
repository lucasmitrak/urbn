#!/bin/bash

apt-get update
apt-get upgrade -y
apt-get dist-upgrade -y
apt-get install python-mysqldb -y
apt-get install python-urllib3 -y
apt-get install python-mechanize -y
apt-get install python-regex -y
apt-get install python-requests -y
apt-get install python-lxml -y
apt-get install python-bs4 -y

chmod +x sawbones.py

# install mysql
#apt-get install mysql-server
#mysqladmin -u root password "1503vzw35"
#update-rc.d mysql enable
#apt-get install phpmyadmin -y

# install ssh
#apt-get install openssh
#service ssh start
#update-rc.d ssh enable
#ssh-keygen
#ssh-copy-key

# install openvpn

#mkdir -p log
#touch log/sawbones_0.txt
#touch log/sawbones_1.txt
#touch log/sawbones_2.txt
#touch log/sawbones_3.txt
#touch log/sawbones_4.txt
#touch log/sawbones_5.txt
#touch log/sawbones_6.txt
