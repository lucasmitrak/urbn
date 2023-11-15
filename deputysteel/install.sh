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
apt-get install python-argparse -y
apt-get install pip -y
pip install splinter


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

#chmod +x deputysteel.py
chmod +x deputysteel2.py
chmod +x bladerunner.sh

mkdir -p var
mkdir -p log

touch log/deputysteel_0.txt
touch log/deputysteel_1.txt
touch log/deputysteel_2.txt
touch log/deputysteel_3.txt
touch log/deputysteel_4.txt
touch log/deputysteel_5.txt
touch log/deputysteel_6.txt

#
# UPLOAD BLANK DATABASE
#
