#!/usr/bin/env python
from splinter import Browser
import MySQLdb
from Base import PersonInfo
from Follower import CatFollowers
import sergeantrl3c as config
import sys

class Twitter():
    def __init__(self):
        self.b=Browser()
        self.cats=[]
        self.db=None
        self.cur=None

    def dbConnect(self):
        self.db=MySQLdb.connect(host=config.db_host,user=config.db_user,passwd=config.db_pass,db=config.db_name,port=config.db_port)
        self.cur=self.db.cursor()

    def dbUpdateConfig(self):
        sql='SELECT startCatId,endCatId,startCatSeen,endCatSeen,startTwSet,endTwSet,startTwSeen,endTwSeen,deep,id FROM %s ORDER BY `priority` DESC LIMIT 1' % config.db_table_searches
        self.cur.execute(sql)
        results=self.cur.fetchall()
        config.startCatId=results[0]
        config.endCatId=results[1]
        config.startCatSeen=results[2]
        config.endCatSeen=results[3]
        config.startTwSet=results[4]
        config.endTwSet=results[5]
        config.startTwSeen=results[6]
        config.endTwSeen=results[7]
        config.deep=results[8]
        config.searchId=results[9]

    def getCats(self):
        for entry in self.dbGetCats():
            self.cats.append(Cat(entry[0], entry[1], entry[2]))

    def dbGetCats(self):
        sql='SELECT email,password,id FROM {0} WHERE email IS NOT NULL AND node BETWEEN {1} AND {2}'.format(config.db_table_catfish,config.startCatId,endCatId)
        self.cur.execute(sql)
        return self.cur.fetchall()
        #return [['nellywi77001513', 'twitter911TWITTER(!!']]

    def scrape(self):
        for cat in self.cats:
            cat.scrape(self.b, self.cur, self.db)
        sql='DELETE FROM {0} WHERE id = {1}'.format(config.db_table_searches,config.searchId)
        self.cur.execute(sql)
        sekf,db.commit()

class Cat(PersonInfo):
    def __init__(self, handle, password, cId):
        PersonInfo.__init__(self)
        self.handle=handle
        self.password=password
        self.cId=cId
        self.followers=CatFollowers(cId)

    def scrape(self, b, cur, db):
        self.login(b)
        self.viewMeSection(b)
        self.viewFollowers(b)
        self.loadAllFollowers(b)
        self.followers.scrape(b, cur, db)
        self.logout(b)

    def login(self, b):
        link_login='https://mobile.twitter.com/login'
        b.visit(link_login)
        #login form ids
        l_id='session[username_or_email]'
        p_id='session[password]'
        b_id='signupbutton'
        #fill in texts
        b.fill(l_id, self.handle)
        b.fill(p_id, self.password)
        b.find_by_id(b_id).click()

    def logout(self, b):
        link_home='https://mobile.twitter.com/account'
        b.visit(link_home)
        b.find_by_xpath('//button[@data-action]').click()
        b.find_by_text('Log out').click()

if __name__=="__main__":
    t=Twitter()
    t.dbConnect()
    t.dbUpdateConfig()
    t.getCats()
    t.scrape()
    t.db.close()
    t.b.quit()
