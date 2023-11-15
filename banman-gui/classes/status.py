#!/usr/bin/python3
from tkinter import *

#create status class
class Status(Frame):
    def __init__(self, parent):
        Frame.__init__(self, parent);

        #views

        #add to frame

    def show(self):
        self.grid(column=1, row=0, rowspan=1, columnspan=1, padx=4, pady=4, stick=(N, E, W, S))

    def hide(self):
        self.grid_forget()
