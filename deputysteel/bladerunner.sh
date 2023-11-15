#!/bin/bash

echo "START - DEPUTYSTEEL"
echo "CLEARING RAM BUFFER"
rm var/*
./MEMORY_FIX.sh
#service mysql restart
#service ssh restart
cp log/deputysteel_5.txt log/deputysteel_6.txt
cp log/deputysteel_4.txt log/deputysteel_5.txt
cp log/deputysteel_3.txt log/deputysteel_4.txt
cp log/deputysteel_2.txt log/deputysteel_3.txt
cp log/deputysteel_1.txt log/deputysteel_2.txt
cp log/deputysteel_0.txt log/deputysteel_1.txt
./deputysteel2.py 2>&1 | tee log/deputysteel_0.txt
#mysqldump -u root -p"1503vzw35" xnet_node_0000_data_xnet > xnet_node_0000_data_xnet.sql
#scp -P 22000 /root/xnet_node_0000_data_xnet.sql root@192.168.1.106:/root/data/xnet_node_0000_data_xnet.sql
#ssh commands to load the tables
echo "CLEARING RAM BUFFER"
rm var/*
./MEMORY_FIX.sh 
echo "DONE - DEPUTYSTEEL"
exit
