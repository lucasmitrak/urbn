#!/bin/bash

#mysql -u root -p"" "RESET QUERY CACHE;"
#mysql -u root -p"" "FLUSH QUERY CACHE;"
mysqlcheck -v xnet_node_root_info_xnet -u root -p"1503vzw35"
mysqlanalyze -v xnet_node_root_info_xnet -u root -p"1503vzw35"
mysqloptimize -v xnet_node_root_info_xnet -u root -p"1503vzw35"
mysqlrepair -v xnet_node_root_info_xnet -u root -p"1503vzw35"
./mysqltuner.pl
