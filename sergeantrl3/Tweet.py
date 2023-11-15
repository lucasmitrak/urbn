#!/usr/bin/env Python
from Base import TweetList
from Base import FollowerList
import sergeantrl3c as config
from datetime import datetime

class Retweeters(FollowerList):
    def __init__(self, tId):
        FollowerList.__init__(self, tId)

    def scrape(self, b, cur, db):
        FollowerList.scrape(self, b, cur, db)

    def add(self, cur, db, tId, rId, name, handle, avatar):
        #check
        sql='INSERT INTO '+config.db_table_retweeters+' (lastSeen,conId,curId,name,handle,avatar) VALUES (%s,%s,%s,%s,%s,%s)'
        cur.execute(sql, (str(datetime.now()), tId, rId, name.encode('utf8'), handle.encode('utf8'), avatar.encode('utf8')))
        db.commit()

class Favoriters(FollowerList):
    def __init__(self, tId):
        FollowerList.__init__(self, tId)

    def scrape(self, b, cur, db):
        FollowerList.scrape(self, b, cur, db)

    def add(self, cur, db, tId, rId, name, handle, avatar):
        #check
        sql='INSERT INTO '+config.db_table_favoriters+' (lastSeen,conId,curId,name,handle,avatar) VALUES (%s,%s,%s,%s,%s,%s)'
        cur.execute(sql, (str(datetime.now()), tId, rId, name.encode('utf8'), handle.encode('utf8'), avatar.encode('utf8')))
        db.commit()

class Comments(TweetList):
    def __init__(self, tId):
        TweetList.__init__(self, tId)

    def scrape(self, b, cur, db):
        TweetList.scrape(self, b, cur, db)

    def add(self, cur, db, tId, cId, message, hasMedia, tweetHandle, isRetweet, retweetName, retweetHandle, timestamp, twTimeStamp, ats, hashtags, pics, articles):
        #check
        sql='INSERT INTO '+config.db_table_comments+' (lastSeen,tweetId,commentId,message,hasMedia,tweetHandle,isRetweet,retweetName,retweetHandle,timestamp,twTimeStamp) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)'
        cur.execute(sql, (str(datetime.now()), tId, cId, message.encode('utf8'), hasMedia, tweetHandle.encode('utf8'), isRetweet, retweetName.encode('utf8'), retweetHandle.encode('utf8'), timestamp, twTimeStamp.encode('utf8')))
        db.commit()

class Tweets(TweetList):
    def __init__(self, cFId):
        self.tweetsArray=[]
        TweetList.__init__(self, cFId)

    def add(self, cur, db, cFId, tId, message, hasMedia, tweetHandle, isRetweet, retweetName, retweetHandle, timestamp, twTimeStamp, ats, hashtags, pics, articles):
        #check
        sql='INSERT INTO '+config.db_table_tweets+' (lastSeen,catFollowerId,tweetId,message,hasMedia,tweetHandle,isRetweet,retweetName,retweetHandle,timestamp,twTimeStamp) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)'
        cur.execute(sql, (str(datetime.now()), cFId, tId, message.encode('utf8'), hasMedia, tweetHandle.encode('utf8'), isRetweet, retweetName.encode('utf8'), retweetHandle.encode('utf8'), timestamp, twTimeStamp.encode('utf8')))
        db.commit()
        self.tweetsArray.append(self.Tweet(cFId, tId, message, hasMedia, tweetHandle, isRetweet, retweetName, retweetHandle, timestamp, twTimeStamp, ats, hashtags, pics, articles))

    def scrape(self, b, handle, cur, db):
        TweetList.scrape(self, b, cur, db)
        #for tweet in self.tweetsArray:
        #    b.visit(self.mobile_tweet(handle, tweet.tweetHandle))
        #    tweet.scrape(b, handle, cur, db)

    def mobile_tweet(self, handle, tweetHandle):
        return 'https://mobile.twitter.com'+handle+'/status/'+tweetHandle

    class Tweet():
        def __init__(self, cFId, tId, message, hasMedia, tweetHandle, isRetweet, retweetName, retweetHandle, timestamp, twTimeStamp, ats, hashtags, pics, articles):
            self.retweeters=Retweeters(tId)
            self.favoriters=Favoriters(tId)
            self.comments=Comments(tId)

            self.cFId=cFId
            self.tId=tId
            self.message=message
            self.hasMedia=hasMedia
            self.tweetHandle=tweetHandle
            self.isRetweet=isRetweet
            self.retweetName=retweetName
            self.retweetHandle=retweetHandle
            self.timestamp=timestamp
            self.twTimeStamp=twTimeStamp
            self.ats=ats
            self.hashtags=hashtags
            self.pics=pics
            self.articles=articles

        def scrape(self, b, handle, cur, db):
            #scrape save images
            originalTweet=b.find_by_xpath('//div[@data_id]')
            twTimeStampTweet=originalTweet.find_by_xpath('.//a[@timestamp]').text
            self.comments.scrape(b, cur, db)
            self.reveal_div(b)
            retweetAmount=None
            retweetDiv='div.retweets'
            if b.is_element_present_by_css(retweetDiv):
                retweet=originalTweet.find_by_css(retweetDiv)
                retweetAmount=retweet.find_by_css('span.retweets-count').text
                if retweetAmount != '':
                    retweet.click()
                    self.retweeters.scrape(b, cur, db)
                    b.back()
                    self.reveal_div(b)
                    originalTweet=b.find_by_xpath('//div[@data_id]')
                else:
                    retweetAmount=0
            else:
                retweetAmount=0
            retweetAmount=int(str(retweetAmount).replace(',',''))
            favoriteAmount=None
            favoriterDiv='div.faves'
            if b.is_element_present_by_css(favoriterDiv):
                favorite=originalTweet.find_by_css(favoriterDiv)
                favoriteAmount=favorite.find_by_css('span.faves-count').text
                if favoriteAmount != '':
                    favorite.click()
                    self.favoriters.scrape(b, cur, db)
                else:
                    favoriteAmount=0
            else:
                favoriteAmount=0
            favoriteAmount=int(str(favoriteAmount).replace(',',''))
            sql='UPDATE '+config.db_table_tweets+' SET lastSeen=%s,twTimeStampTweet=%s,retweetAmount=%s,favoriteAmount=%s WHERE catFollowerId=%s AND tweetId=%s'
            cur.execute(sql, (str(datetime.now()), twTimeStampTweet, retweetAmount, favoriteAmount, self.cFId, self.tId))
            db.commit()

        def reveal_div(self, b):
            script='document.getElementsByClassName("tweet-stats")[0].style.display="inline-block"' 
            b.execute_script(script)

class FavoriteTweets(TweetList):
    def __init__(self, cFId):
        self.tweetsArray=[]
        TweetList.__init__(self, cFId)

    def add(self, cur, db, cFId, tId, message, hasMedia, tweetHandle, isRetweet, retweetName, retweetHandle, timestamp, twTimeStamp, ats, hashtags, pics, articles):
        #check
        sql='INSERT INTO '+config.db_table_tweet_favorites+' (lastSeen,catFollowerId,tweetId,message,hasMedia,tweetHandle,isRetweet,retweetName,retweetHandle,timestamp,twTimeStamp) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)'
        cur.execute(sql, (str(datetime.now()), cFId, tId, message.encode('utf8'), hasMedia, tweetHandle.encode('utf8'), isRetweet, retweetName.encode('utf8'), retweetHandle.encode('utf8'), timestamp, twTimeStamp.encode('utf8')))
        db.commit()
        self.tweetsArray.append(self.FavoriteTweet(cFId, tId, message, hasMedia, tweetHandle, isRetweet, retweetName, retweetHandle, timestamp, twTimeStamp, ats, hashtags, pics, articles))

    def scrape(self, b, handle, cur, db):
        TweetList.scrape(self, b, cur, db)
        #for tweet in self.tweetsArray:
        #    b.visit(self.mobile_tweet(handle, tweet.tweetHandle))
        #    tweet.scrape(b, handle, cur, db)

    def mobile_tweet(self, handle, tweetHandle):
        return 'https://mobile.twitter.com'+handle+'/status/'+tweetHandle

    class FavoriteTweet():
        def __init__(self, cFId, tId, message, hasMedia, tweetHandle, isRetweet, retweetName, retweetHandle, timestamp, twTimeStamp, ats, hashtags, pics, articles):
            self.retweeters=Retweeters(tId)
            self.favoriters=Favoriters(tId)
            self.comments=Comments(tId)

            self.cFId=cFId
            self.tId=tId
            self.message=message
            self.hasMedia=hasMedia
            self.tweetHandle=tweetHandle
            self.isRetweet=isRetweet
            self.retweetName=retweetName
            self.retweetHandle=retweetHandle
            self.timestamp=timestamp
            self.twTimeStamp=twTimeStamp
            self.ats=ats
            self.hashtags=hashtags
            self.pics=pics
            self.articles=articles

        def scrape(self, b, handle, cur, db):
            #scrape save images
            originalTweet=b.find_by_xpath('//div[@data_id]')
            twTimeStampTweet=originalTweet.find_by_xpath('.//a[@timestamp]').text
            self.comments.scrape(b, cur, db)
            self.reveal_div(b)
            retweetAmount=None
            retweetDiv='div.retweets'
            if b.is_element_present_by_css(retweetDiv):
                retweet=originalTweet.find_by_css(retweetDiv)
                retweetAmount=retweet.find_by_css('span.retweets-count').text
                if retweetAmount != '':
                    retweet.click()
                    self.retweeters.scrape(b, cur, db)
                    b.back()
                    self.reveal_div(b)
                    originalTweet=b.find_by_xpath('//div[@data_id]')
                else:
                    retweetAmount=0
            else:
                retweetAmount=0
            retweetAmount=int(str(retweetAmount).replace(',',''))
            favoriteAmount=None
            favoriterDiv='div.faves'
            if b.is_element_present_by_css(favoriterDiv):
                favorite=originalTweet.find_by_css(favoriterDiv)
                favoriteAmount=favorite.find_by_css('span.faves-count').text
                if favoriteAmount != '':
                    favorite.click()
                    self.favoriters.scrape(b, cur, db)
                else:
                    favoriteAmount=0
            else:
                favoriteAmount=0
            favoriteAmount=int(str(favoriteAmount).replace(',',''))
            sql='UPDATE '+config.db_table_tweet_favorites+' SET lastSeen=%s,twTimeStampTweet=%s,retweetAmount=%s,favoriteAmount=%s WHERE catFollowerId=%s AND tweetId=%s'
            cur.execute(sql, (str(datetime.now()), twTimeStampTweet, retweetAmount, favoriteAmount, self.cFId, self.tId))
            db.commit()

        def reveal_div(self, b):
            script='document.getElementsByClassName("tweet-stats")[0].style.display="inline-block"' 
            b.execute_script(script)
