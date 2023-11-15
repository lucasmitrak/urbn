#!/usr/bin/python3
from tkinter import *

#create SideMenu class
class SideMenu(Frame):
    def __init__(self, parent, frm_status, frm_search, frm_export):
        Frame.__init__(self, parent);

        #views
        self['borderwidth']=5
        self['relief']='raised'
        lbl_status=Label(self, text='Status', height=5)
        lbl_search=Label(self, text='Search', height=5)
        lbl_export=Label(self, text='Export', height=5)

        lbl_status.grid(column=0, row=1, stick=(N, E, S, W))
        lbl_search.grid(column=0, row=2, stick=(N, E, S, W))
        lbl_export.grid(column=0, row=3, stick=(N, E, S, W))

        #define events
        lbl_status.bind('<Button-1>', lambda e:self.showStatus(frm_status, frm_search, frm_export))
        lbl_search.bind('<Button-1>', lambda e:self.showSearch(frm_search, frm_search, frm_export))
        lbl_export.bind('<Button-1>', lambda e:self.showExport(frm_export, frm_search, frm_export))

    def showStatus(event, frm_status, frm_search, frm_export):
        frm_search.hide()
        frm_export.hide()
        frm_status.show()

    def showSearch(event, frm_status, frm_search, frm_export):
        frm_status.hide()
        frm_export.hide()
        frm_search.show()

    def showExport(event, frm_status, frm_search, frm_export):
        frm_status.hide()
        frm_search.hide()
        frm_export.show()

    def show(self):
        self.grid(column=0, row=0, rowspan=4, columnspan=1, padx=4, pady=4, stick=(N, W, E, S))

    def hide(self):
        self.grid_forget()

    #define frmbtn here
