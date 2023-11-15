node=''

#follower config
startCatId=None
endCatId=None
startCatSeen=None
endCatSeen=None

#tweet config
startTwSet=None
endTwSet=None
startTwSeen=None
endTwSeen=None
deep=None
searchId=None

db_host='127.0.0.1'
db_port=3306 
db_user='root'
db_pass='1503vzw35'
db_name='xnet_node_root_info_xnet'
db_table_searches='tw%s_searches' % (node)
db_table_catfish='tw%s_catfish' % (node)
db_table_cat_followers='tw%s_cat_followers' % (node)
db_table_timeline='tw%s_timeline' % (node)
db_table_subscribed_to_list='tw%s_subscribed_to_list' % (node)
db_table_member_of_list='tw%s_member_of_list' % (node)
db_table_retweeters='tw%s_retweeters' % (node)
db_table_favoriters='tw%s_favoriters' % (node)
db_table_followers='tw%s_followers' % (node)
db_table_followings='tw%s_followings' % (node)
db_table_tweets='tw%s_tweets' % (node)
db_table_comments='tw%s_comments' % (node)
db_table_tweet_favorites='tw%s_tweet_favorites' % (node)
