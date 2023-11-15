#!/bin/bash

name="sawbones"
./MEMORY_FIX.sh
echo "START - $name"
a=$(tr -s ' ' '_' <<< "$(date)")
mkdir $a
./$name.py 2>&1 | tee $a/$name.txt
tar -zcf $a.tar.gz $a/ && scp -P 22000 /root/$a.tar.gz root@192.168.1.106:/root/data/$hostname && rm $a/* && rmdir $a 
echo "DONE - $name"
exit
