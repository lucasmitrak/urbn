#!/usr/bin/python3
from tkinter import *
from tkinter import ttk

#create search class
class Search(Frame):
    def __init__(self, parent):
        Frame.__init__(self, parent);

        #views
        
        tree=ttk.Treeview(self)
        #ck_fb=Checkbutton(self, text='Facebook')
        #ck_fb.pack(side=LEFT)
        #ck_yt=Checkbutton(self, text='Youtube')
        #ck_yt.pack(side=LEFT)
        #ck_tw=Checkbutton(self, text='Twitter')
        #ck_tw.pack(side=LEFT)
        #id=tree.insert(ck_fb, 'end')
        #id=tree.insert(ck_fb, 'end')
        txt_input=Entry(self)
        txt_input.pack()
        btn_input=Button(self, text='Search')
        btn_input.pack(side=RIGHT)
        tree["columns"]=("one","two")
        tree.column("one", width=100 )
        tree.column("two", width=100)
        tree.heading("one", text="Facebook")
        tree.heading("two", text="Youtube")
         
        tree.insert("" , 0,    text="usernme", values=("some facebook","some youtube"))
          
        id2 = tree.insert("", 1, "dir2", text="Info")
        tree.insert(id2, "end", "dir 2", text="Extra Info", values=("2A","2B"))
        tree.pack()

        #add to frame

    def show(self):
        self.grid(column=1, row=0, rowspan=1, columnspan=1, padx=4, pady=4, stick=(N, E, W, S))

    def hide(self):
        self.grid_forget()
