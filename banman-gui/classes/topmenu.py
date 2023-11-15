#!/usr/bin/python3
from tkinter import *

#create content menu
class TopMenu(Menu):
    def __init__(self, parent):
        Menu.__init__(self, parent)

        filemenu=Menu(self)
        filemenu.add_command(label='New', command=self.do_nothing)
        filemenu.add_command(label='Open', command=self.do_nothing)
        filemenu.add_command(label='Save', command=self.do_nothing)
        filemenu.add_command(label='Save As', command=self.do_nothing)
        filemenu.add_command(label='Close', command=self.do_nothing)
        filemenu.add_separator()
        filemenu.add_command(label='Exit', command=self.do_nothing)
        self.add_cascade(label='File', menu=filemenu)

        editmenu=Menu(self)
        editmenu.add_command(label='Undo', command=self.do_nothing)
        editmenu.add_separator()
        editmenu.add_command(label='Cut', command=self.do_nothing)
        editmenu.add_command(label='Copy', command=self.do_nothing)
        editmenu.add_command(label='Paste', command=self.do_nothing)
        editmenu.add_command(label='Delete', command=self.do_nothing)
        editmenu.add_command(label='Select All', command=self.do_nothing)
        self.add_cascade(label='Edit', menu=editmenu)

        helpmenu=Menu(self, name='help')
        helpmenu.add_command(label='Help Index', command=self.do_nothing)
        helpmenu.add_command(label='About...', command=self.do_nothing)
        self.add_cascade(label='Help', menu=helpmenu)

        sysmenu=Menu(self, name='system')
        self.add_cascade(menu=sysmenu)

    def show(self):
        self.master['menu']=self

    def do_nothing(self):
        print('doing nothing')
