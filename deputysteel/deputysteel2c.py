node = "00"
catfish = 0 #node.profile
subject = 0 #node.profile.friend
extended = 0 #30 day, y2d, last year, last year --
etc = 0 #0 for just the pull, 1 for the pull and all datasets after
db_host = '127.0.0.1'
db_port = 7777
db_user = 'root'
db_pass = '1503vzw35'
db_name = 'xnet_node_root_info_xnet'
db_table_catfish = 'fb00_catfish'
db_table_friends = 'fb%s_friends' % (node)
db_table_timeline = 'fb%s_timeline' % (node)
db_table_comments = 'fb%s_comments' % (node)
