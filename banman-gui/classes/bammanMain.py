#!/usr/bin/python3
import tkinter as tk
from tkinter import *
import classes.sidemenu as sidemenu
import classes.topmenu as topmenu
import classes.login as login
import classes.status as status
import classes.search as search
import classes.export as export

#create root class
class Main(tk.Tk):
    def __init__(self):
        tk.Tk.__init__(self)

        #define topmenu
        mnu_top_menu=topmenu.TopMenu(self)

        #define views
        frm_status=status.Status(self)
        frm_search=search.Search(self)
        frm_export=export.Export(self)

        #define sidemenu
        #frm_side_menu=sidemenu.SideMenu(self, frm_status, frm_search, frm_export)

        #default page
        frm_login=login.Login(self)

        #intialize view
        mnu_top_menu.show()
        frm_login.show()

        #configure self
        self.resizable(FALSE, FALSE)
        self.option_add('*tearOff', FALSE)
        self.title('Social Media Spider')
        self.geometry('800x600')
