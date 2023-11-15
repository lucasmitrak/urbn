#!/usr/bin/env python
from datetime import datetime
import sergeantrl3c as config

class PersonInfo:
    def __init__(self):
        pass

    def viewMeSection(self, b):
        b.find_by_text('Me').click()

    def viewFollowers(self, b):
        b.find_by_css('.followers-count').click()

    def visitSubscribed(self, b, handle):
        b.visit('https://mobile.twitter.com'+handle+'/lists')

    def visitMembership(self, b, handle):
        b.visit('https://mobile.twitter.com'+handle+'/lists/membership')

    def visitFavorites(self, b, handle):
        b.visit('https://mobile.twitter.com'+handle+'/favorites')
        
    def visitTweets(self, b, handle):
        b.visit('https://mobile.twitter.com'+handle+'/tweets')
        #b.find_by_css('.tweet-count').click()
        #clicking on tweets from another page section doesnt go there, it just goes to home
        #if not b.url.endswith('/tweets'):
        #    b.find_by_css('.tweet-count').click()

    def visitFollowers(self, b, handle):
        b.visit('https://mobile.twitter.com'+handle+'/followers')

    def visitFollowings(self, b, handle):
        b.visit('https://mobile.twitter.com'+handle+'/followings')

    def loadAllFavorites(self, b):
        t_css='.stream-end-text'
        t=b.is_element_present_by_css(t_css, 5000)
        while t:
            t.click()
            t=b.is_element_present_by_css(t_css, 5000)

    def loadAllTweets(self, b):
        t_css='.stream-end-text'
        t=b.is_element_present_by_css(t_css, 5000)
        while t:
            t.click()
            t=b.is_element_present_by_css(t_css, 5000)

    def loadAllFollowers(self, b):
        pass
        #t_css='.stream-end-text'
        #t_tap='Tap to load more people'
        #t_loading='Loading...'
        #t=b.find_by_css(t_css)
        #if(b.is_element_present_by_css(t_css)):
        #load_more=t.text!=''
        #while(t.text==t_tap or t.text==t_loading):
        #while(t.text!=''):
        #while(load_more):
            #if(b.is_element_present_by_css(t_css)):
        #    t.click()
        #    t=b.find_by_css(t_css)
        #    load_more=t.text!=''

    def loadAllFollowings(self, b):
        pass

class Lists:
    def __init__(self, cId):
        self.cId=cId

    def scrape(self, b, cur, db):
        lis=b.find_by_css('li.lists-item')
        lId=0
        for li in lis:
            avatar=li.find_by_css('img.avatar')['src']
            title=li.find_by_css('div.list-title').text
            owner=li.find_by_css('div.list-owner').text
            description=li.find_by_css('div.list-description').text
            count=self.clean(li.find_by_css('div.list-count').text)
            handle=li['href']
            self.add(cur, db, self.cId, lId, avatar, title, owner, description, count, handle)
            lId+=1

    def clean(self, c):
        return int(c.replace(' members',''))

class TweetList():
    def __init__(self, cId):
        self.cId=cId

    def scrape(self, b, cur, db):
        lis=b.find_by_xpath('//li[@data_id]')
        tId=0
        for li in lis:
            messageFound=li.find_by_css('.tweet-text-inner')
            message=messageFound.text

            atsFound=messageFound.find_by_xpath('.//a[@data-screenname]')
            hasAt=bool(atsFound)
            ats=[]
            if hasAt:
                for at in atsFound:
                    atData=at['data-screenname']
                    ats.append(atData)

            hashtagsFound=messageFound.find_by_css('a.twitter-hashtag')
            hasHashtag=bool(hashtagsFound)
            hashtags=[]
            if hasHashtag:
                for hashtag in hashtagsFound:
                    hashtagData=hashtag.text
                    hashtags.append(hashtagData)

            hasMedia=bool(li['media'])

            pics=[]
            articles=[]
            if hasMedia:
                picsFound=messageFound.find_by_xpath('.//a[@data-entity-id]')
                hasPic=bool(picsFound)
                if hasPic:
                    for pic in picsFound:
                        picData=pic['data-url']
                        pics.append(picData)

                articlesFound=messageFound.find_by_css('a.activeLink')
                hasArticle=bool(articlesFound)
                if hasArticle:
                    for article in articlesFound:
                        articleData=article['data-url']
                        articles.append(articleData)

            stampFound=li.find_by_xpath('.//div[@timestamp]')
            timestamp=stampFound['timestamp']
            twTimeStamp=stampFound.text
            tweetHandle=li['data_id']
            isRetweet=li['reweeted_by']
            retweetName=li['screen_name']
            retweetHandle=li['uhref']
            self.add(cur, db, self.cId, tId, message, hasMedia, tweetHandle, isRetweet, retweetName, retweetHandle, timestamp, twTimeStamp, ats, hashtags, pics, articles)
            tId+=1

class FollowerList():
    def __init__(self, cId):
        self.cId=cId

    def scrape(self, b, cur, db): 
        lis=b.find_by_xpath('//li[@userid]')
        fId=0
        for li in lis:
            name=li.find_by_css('.full-name').text
            handle=li['href']
            avatar=li.find_by_css('img.avatar')['src']
            self.add(cur, db, self.cId, fId, name, handle, avatar)
            fId+=1
