#!/usr/bin/env python
from Base import PersonInfo
from Base import FollowerList
from Base import Lists
from Tweet import Tweets
from Tweet import FavoriteTweets
import sergeantrl3c as config
from datetime import datetime

class SubscribedToList(Lists):
    def __init__(self, cFId):
        Lists.__init__(self, cFId)

    def scrape(self, b, cur, db):
        Lists.scrape(self, b, cur, db)

    def add(self, cur, db, cFId, lId, avatar, title, owner, description, count, handle):
        #check
        sql='INSERT INTO '+config.db_table_subscribed_to_list+' (lastSeen,catFollowerId,listId,avatar,title,owner,description,count,handle) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)'
        cur.execute(sql, (str(datetime.now()), cFId, lId, avatar.encode('utf8'), title.encode('utf8'), owner.encode('utf8'), description.encode('utf8'), count, handle.encode('utf8')))
        db.commit()

class MemberOfList(Lists):
    def __init__(self, cFId):
        Lists.__init__(self, cFId)

    def scrape(self, b, cur, db):
        Lists.scrape(self, b, cur, db)

    def add(self, cur, db, cFId, lId, avatar, title, owner, description, count, handle):
        #check
        sql='INSERT INTO '+config.db_table_member_of_list+' (lastSeen,catFollowerId,listId,avatar,title,owner,description,count,handle) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)'
        cur.execute(sql, (str(datetime.now()), cFId, lId, avatar.encode('utf8'), title.encode('utf8'), owner.encode('utf8'), description.encode('utf8'), count, handle.encode('utf8')))
        db.commit()

class Following(FollowerList):
    def __init__(self, cFId):
        FollowerList.__init__(self, cFId)

    def scrape(self, b, cur, db):
        FollowerList.scrape(self, b, cur, db)

    def add(self, cur, db, cFId, fId, name, handle, avatar):
        #check
        sql='INSERT INTO '+config.db_table_followings+' (lastSeen,conId,curId,name,handle,avatar) VALUES (%s,%s,%s,%s,%s,%s)'
        cur.execute(sql, (str(datetime.now()), cFId, fId, name.encode('utf8'), handle.encode('utf8'), avatar.encode('utf8')))
        db.commit()

class Followers(FollowerList):
    def __init__(self, cFId):
        FollowerList.__init__(self, cFId)

    def scrape(self, b, cur, db):
        FollowerList.scrape(self, b, cur, db)

    def add(self, cur, db, cFId, fId, name, handle, avatar):
        #check
        sql='INSERT INTO '+config.db_table_followers+' (lastSeen,conId,curId,name,handle,avatar) VALUES (%s,%s,%s,%s,%s,%s)'
        cur.execute(sql, (str(datetime.now()), cFId, fId, name.encode('utf8'), handle.encode('utf8'), avatar.encode('utf8')))
        db.commit()

class CatFollowers(FollowerList):
    def __init__(self, cId):
        self.followersArray=[]
        FollowerList.__init__(self, cId)

    def add(self, cur, db, cId, cFId, name, handle, avatar):
        #check
        sql='INSERT INTO '+config.db_table_cat_followers+' (lastSeen,catId,catFollowerId,name,handle,avatar) VALUES (%s,%s,%s,%s,%s,%s)'
        cur.execute(sql, (str(datetime.now()),cId,cFId,name.encode('utf8'),handle.encode('utf8'),avatar.encode('utf8')))
        db.commit()
        self.followersArray.append(self.CatFollower(cId, cFId, name, handle, avatar))

    def scrape(self, b, cur, db):
        FollowerList.scrape(self, b, cur, db)
        for follower in self.followersArray:
            b.visit('https://mobile.twitter.com'+follower.handle)
            follower.scrape(b, cur, db)

    class CatFollower(PersonInfo):
        def __init__(self, cId, cFId, name, handle, avatar):
            PersonInfo.__init__(self)
            self.following=Following(cFId)
            self.followers=Followers(cFId)
            self.favorites=FavoriteTweets(cFId)
            self.tweets=Tweets(cFId)
            self.subscribedToList=SubscribedToList(cFId)
            self.memberOfList=MemberOfList(cFId)

            self.cId=cId
            self.cFId=cFId
            self.name=name
            self.handle=handle
            self.avatar=avatar

        def scrape(self, b, cur, db):
            tweetBox=b.find_by_css('div.tweet-count')
            tweetsAmount=self.clean(tweetBox.find_by_css('div.stats-count').text)
            followeringBox=b.find_by_css('div.followings-count')
            followeringAmount=self.clean(followeringBox.find_by_css('div.stats-count').text)
            followersBox=b.find_by_css('div.followers-count')
            followersAmount=self.clean(followersBox.find_by_css('div.stats-count').text)
            script='document.getElementsByClassName("bio")[0].style.display="inline-block"'
            b.execute_script(script)
            description=b.find_by_css('div.description').text
            location=b.find_by_css('div.location').text
            url=b.find_by_css('div.url').text

            sql='UPDATE '+config.db_table_cat_followers+' SET lastSeen=%s,tweetsAmount=%s,followeringAmount=%s,followersAmount=%s,description=%s,location=%s,url=%s WHERE catId=%s AND catFollowerId=%s'
            cur.execute(sql, (str(datetime.now()),tweetsAmount,followeringAmount,followersAmount,description.encode('utf8'),location.encode('utf8'),url.encode('utf8'),self.cId,self.cFId))
            db.commit()
            
            #visit subscribedToList
            self.visitSubscribed(b, self.handle)
            self.subscribedToList.scrape(b, cur, db)
            #visit memberOfList
            self.visitMembership(b, self.handle)
            self.memberOfList.scrape(b, cur, db)
            #visit tweets
            self.visitTweets(b, self.handle)
            self.loadAllTweets(b)
            self.tweets.scrape(b, self.handle, cur, db)
            #visit favorites
            self.visitFavorites(b, self.handle)
            self.loadAllFavorites(b)
            self.favorites.scrape(b, self.handle, cur, db)
            #visit followers
            self.visitFollowers(b, self.handle)
            self.loadAllFollowers(b)
            self.followers.scrape(b, cur, db)
            #visit followings
            self.visitFollowings(b, self.handle)
            self.loadAllFollowings(b)
            self.following.scrape(b, cur, db)

        def clean(self, c):
            c=c.replace(',','').replace('.','')
            #contains K
            if 'K' in c:
                c=int(c.replace('K',''))*100
            else:
                c=int(c)
            return c
