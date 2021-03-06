---
title: "VRML97 Tutorial 1.1: Browsers, Editors, Compression, Headers, Comments, Group"
keywords: introduction, browsers, editors, GZIP, compression, wrl, wrz, wrl.gz, headers, comments, Group
---

# Getting Started


VRML - the Virtual Reality Modeling Language. It sounds quite cool really, and it is. A lot of
people say it's dead, but it's just that people don't use it a lot. However, as 3D graphics takes
off, 3D on the internet will become more popular, and VRML is best candidate for Web 3D at the
moment. 

In this tutorial, I'm going to teach you how to create your own virtual worlds. However, I can't
teach you absolutely everything, so I'm going to assume some basic knowledge on your part. You will
find this tutorial pretty easy if you have a basic knowledge of the following things:

* The Internet - how to use it, how it's organised, how to put up a web page, stuff like that.
* HTML - Not a lot, but occasionally I'll compare some VRML concepts to how it's done in HTML. Not
often though, and it's never vital.
* 3D Geometry - Vectors, axes, coordinates, things like that. Nothing more complex that a normal
school matsh course should teach you. You will need to have good spatial reasoning to design 3D
worlds, but if you don't already have it, I'm sure you'll develop it as we go along.


If you don't know about those things, don't worry, but you may need to ask someone what something
means evey now and again. Shouldn't be too often though... and like I say, this would take forever
if I tried to teach you *everything*. OK, enough of this, let's get down to it.

## VRML 1.0, 2.0, 97, AAAAAAAGH!

So. You want to write VRML, do you? Well, it's not so hard really. What *is* confusing at
first is which sort of VRML do you write? There are really two versions of VRML, but one of these
has two names. Simple. Let's have a short 'history of VRML' lesson. Originally, there was VRML
(Virtual Reality Modeling Language) 1.0. This was a first attempt at an Internet 3D language, and
after a while was revised into VRML 2.0, which changed the file structure and added a lot of new
features, such as animation. VRML 1.0 was good, but has been superseded now, so I'm not going to
bother with it. VRML 2.0 was then submitted to the ISO/IEC for approval and standardisation. VRML97
is the outcome of that process, and is an ISO/IEC standard. VRML97 is practically identical to VRML
2.0, with a couple of minor changes in very small details. I'm going to teach you VRML97 in this
tutorial, because that's what the reference material I have covers. This is to all intents and
purposes identical to VRML 2.0, so you can assume they are the same thing. Right, now we know what
we're talking about, lets get on with it.

## Browsers

The very first thing you need is a VRML browser, to view your worlds, as well as other peoples. I
personally use Cosmo Player from <A HREF="http://www.cai.com/cosmo/" target="_blank">Cosmo
Software</A> *(Win95/NT)*. There are others available, though. Check out the <A
HREF="http://web3d.vapourtech.com/links.php" target="_blank">links</A> page for more info.
Most well-known VRML browsers will operate as plugins for Netscape or Internet Explorer. There are
also browsers available for most other operating systems. Take a look around the software companies
or the <A HREF="http://www.web3d.org/vrml/vrml.htm" target="_blank">VRML Repository</A> for more
information. Once you have your browser installed and set up, you can simply load VRML worlds as you
would with any web page and look at them.

## Editing

The next thing you need to do is create your own worlds. There are two ways of doing this. First,
you could use one of the many VRML authoring tools, which are like 3D modelers in which you can
build your world. For more info, see the <A HREF="http://www.web3d.org/vrml/vrml.htm"
target="_blank">The VRML Repository</A> again. The way I do my VRML, which I prefer, is to code it by
hand. This is taught in the tutorial, and is the method I concentrate on in this site. All you need
for this is a text editor, such as notepad or wordpad. I personally would recommend <A
HREF="http://www.parallelgraphics.com/products/vrmlpad/" target="_blank">VrmlPad</A>, which is a very
nice VRML-specific editor with syntax highlighting and so on. Simply type in the code as shown, and
save it as *filename.wrl*. You can then load this into your browser and take a look! One
quick point: if you do use a more complex editor, like Wordpad, make sure to save the file as
**plain text**, nothing else, or otherwise it won't work.


Working with raw VRML is all very well, but it can be difficult to create complex objects. To do
this, you need to use either a higher-level VRML authoring tool, or a 3D modeling program. If you go
for the latter option, you will probably need some kind of file translation program to convert
between the modelers format and VRML. One very good free translator is <A
HREF="http://home.europa.com/~keithr/" target="_blank">Crossroads</A>. Higher level VRML tools are
available from many companies. Take a look on the <A
HREF="http://web3d.vapourtech.com/links.php">links</A> page for some of them.

## Compression, MIME, and Publishing

The normal extension for VRML files is *.wrl*, though occasionally *.wrz* is used for
compressed VRML. Browsers can read VRML files that are compressed with GZIP. These compressed files
can use either the *.wrz*, *.wrl.gz*, or the standard *.wrl* extension. GZIP is
fairly standard on UNIX systems, but you can get a PC or Mac version if you look around. A good way
to compress your files is to use <A HREF="http://www.trapezium.com/chisel.html"
target="_blank">Chisel</A>, which is a VRML validator and optimiser which can save GZIPped VRML. This
is a good tool to have anyway for debugging your code, because nobody writes perfect VRML first time.


All internet documents have a MIME type. This tells the receiving end what it is going to get before
it gets it. You probably won't need to worry about this, but just for information, the VRML MIME
type is *model/vrml*. Alternatively, it can be *x-world/x-vrml*, but this is out of
date now.


Once you've created your world, you need to publish it on the web so other people can look at it.
For this you need some kind of ISP (Internet Service Provider). You can then use the space they give
you to put your files on the web, just as you would a normal HTML file.

## VRML Proper

Right, now we can get down to some proper VRML. This tutorial is going to cover the text-based
method of creating VRML worlds. If you want to create VRML with higher-level tools, like some kind
of 3D program, you don't need a VRML tutorial. You just need a tutorial on how to use the tool
you're using. That is NOT what this tutorial is for. This is for those of you who want to get
straight to grips with the real thing, to get your hands dirty on real code. So, if you're ready,
here we go!

## Headers & Comments

The first thing to know is that all VRML files start with a header line, which is:

```#VRML V2.0 utf8```

This tells the browser that it's looking at a VRML file, and the version it's using. In this case,
it's version 2.0. VRML is case-sensitive, so make sure that the capitalisation and so on is exactly
the same as you see here. The **utf8** part tells the browser which text string
standard to use. VRML 1.0 had either **ascii** or **utf8**, but version 2
has only **utf8**, so best use that.


Any line that starts with a # character is a comment, and ignored by the VRML parser, so you can add
comments to your files using it. The first line is an exception, and *is* read by the
browser, but still has a # at the start. So, the following is valid VRML:

```
#VRML V2.0 utf8
#Floppy's VRML97 Tutorial Example File
```

The next thing you should remember is that VRML is case-sensitive, so you have to have the capitals
in the right place all the time, which can be confusing until you get used to it.

## Nodes, Fields and the Scene Graph

Now we move on the the actual structure of a VRML file. A VRML world is made up of
**nodes**, which are types of object. Inside these nodes, you find
**fields**, which are properties of the object. Fields can be anything, from a size of
a box, to another node inside the first. Nodes are written as follows:

```
Group {
	children [
	]
}
```

This shows the **Group** node. This is the simplest node, and simply groups together
other nodes. The node is written in the file by writing the node name (Group), and then a pair of
curly braces. Inside these braces, we have the fields. In this case, we have the *children*
field, which can contain other nodes. So, nodes can be nested inside one another in this way, giving
a kind of hierarchy of nodes, sometimes referred to as the **Scene Graph**. A simple
examples of nested nodes is shown below, using two group nodes, one inside the other.

```
Group {
   children [
      Group {
      }
   ]
}
```

Now this is a fairly pointless piece of VRML, but it shows how to group nodes together and how the
nesting works. Now, this is all OK, but then it gets more complex. You see, not every node can go
anywhere in the file. Some can only be placed in certain fields, and only a few can be used at the
top level, like **Group**. However, we'll see this later on. For now, just get used to
the idea of the scene graph, and nodes and fields.

## Next!

One thing you must remember is that VRML is case-sensitive. Nodes tend to have capital letters at
the beginning of their names (Group, Transform, IndexedFaceSet), while fields have lower-case
letters at the start. They can still have capital letters in the middle of them though (children,
translation, coordIndex).


Now you know how it all works, we can start looking at the different node types. Next time, we'll
cover WorldInfo, and how to get a shape into your world.
