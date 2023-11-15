#!/usr/bin/python3
from tkinter import *

#create Login class
class Login(Frame):
    def __init__(self, parent):
        Frame.__init__(self, parent);

        #notification label text
        n=StringVar()

        #views
        lbl_login=Label(self, text='Login')
        entr_login=Entry(self)
        lbl_pass=Label(self, text='Password')
        entr_pass=Entry(self, show='*')
        lbl_search=Label(self, text='Search')
        txt_search=Entry(self)
        lbl_email=Label(self, text='Email')
        txt_email=Entry(self)
        btn_enter=Button(self, text='Enter')
        lbl_not=Label(self, textvariable=n)

        #add to frame
        lbl_login.grid(column=1, row=1)
        entr_login.grid(column=2, row=1)

        lbl_pass.grid(column=3, row=1)
        entr_pass.grid(column=4, row=1)

        lbl_search.grid(column=1, row=2)
        txt_search.grid(column=2, row=2)

        lbl_email.grid(column=1, row=3)
        txt_email.grid(column=2, row=3)

        btn_enter.grid(column=1, row=4)

        lbl_not.grid(column=2, row=4)

        #define events
        btn_enter.bind('<Button-1>', lambda e:self.enterCreds(entr_login.get(), entr_pass.get(), txt_email.get(), n))
        btn_enter.bind('<Return>', lambda e:self.enterCreds(entr_login.get(), entr_pass.get(), txt_email.get(), n))

    def enterCreds(event, username, password, email, n):
        print('entered credentials')
        print('username:'+username)
        print('password:'+password)
        print('email:'+email)
        #check credentials
        if(1):
            print('logged in')
            n.set('Check your email')

    def show(self):
        self.grid(column=1, row=0, rowspan=5, columnspan=2, padx=4, pady=4, stick=(N, E, W, S))

    def hide(self):
        self.grid_forget()
