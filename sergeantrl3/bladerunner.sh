#!/bin/bash

name="sergeantrl3"
#free && sync && echo 3 > /proc/sys/vm/drop_caches && free
echo "START - $name at $(date)"
a=$(tr -s ' ' '_' <<< "$(date)")
#mkdir $a
#./$name.py 2>&1 | tee $a/$name.txt
./$name.py
#tar -zcf $a.tar.gz $a/ && scp -P 22000 /root/$a.tar.gz root@192.168.1.106:/root/data/$hostname && rm $a/* && rmdir $a 
echo "DONE - $name at $(date)"
exit
