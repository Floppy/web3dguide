---
title: "VRML97 Tutorial 4.5: ECMAScript Objects"
keywords: Browser, getName, getVersion, getWorldURL, getCurrentFrameRate, getCurrentSpeed, setDescription, loadURL, replaceWorld, createVrmlFromURL, createVrmlFromString, addRoute, deleteRoute,
---

# As If By Magic

So far in this part of the tutorial, we've covered the basics of ECMAScript programming and how it
ties into a VRML world. We've also taken a look at the built-in VRML objects that come as standard
in most browsers. Now, we're going to delve further into one particular object, and see how we can
wield its power to full effect. This is the **Browser** object.

## The Browser object

 The Browser object is an ECMAScript object that is provided within the ECMAScript 
  interpreter by your VRML browser. All the browsers should provide this, but 
  then this is only a *should*. Unfortunately, script support is the area 
  in VRML that is very inconsistent, and generally badly supported. This is a 
  real pity, as it's the most powerful part. Anyway, the Browser object is built- 
  in to your browser's ECMAScript interpreter, as I mentioned. It is a *static* 
  object, meaning that you don't have to create a variable of that type before 
  you can use its methods. To use a method within the Browser object, 
  just use the syntax *Browser.functionName()*. This will run the static 
  method in the Browser object. The Browser object has many uses. It is a source 
  of information, and also provides a number of ways to change the world that 
  you are viewing. First off, we're going to look at getting various pieces of 
  information back from the browser. 

Before we do, though, just a bit of a recap on a couple of things. You remember the **Script**
node has two fields called *directOutput* and *mustEvaluate*. These can be quite important
when using the Browser interface, so I'll just remind you what they do.

* *mustEvaluate* - If set to true, the script is evaluated as soon as possible. Browsers are
allowed to hold back processing scripts if something more important is going on. This forces them
not to do that and execute the script immediately.
* *directOutput* - if this is true, the script can write directly to *eventIn*s and read
directly from *eventOut*s of nodes that it has access to. Normally, a script can only do this
be either sending or receiving events in the normal event-cascade fashion.

Right, on we go then...


## Information Technology

OK. The first set of methods we're going to look at in the Browser object are the information-
gathering methods. I'll list these, along with a short description of each...

<DL>
<DT>**Browser.getName()**
<DD>This method just returns a string containing the name of the browser, e.g. "Cosmo Player". It
returns an empty string if the information is not available.
<DT>**Browser.getVersion()**
<DD>This returns a string containing version information, e.g. "2.1". It also returns an empty
string if the information is not available.
<DT>**Browser.getWorldURL()**
  <DD>This, not surprisingly, returns the URL of the currently loaded world as a 
    string. 
  <DT>**Browser.getCurrentFrameRate()**
<DD>This returns a numeric value equal to the current frame rate (the number of images the browser
is displaying per second).
<DT>**Browser.getCurrentSpeed()**
<DD>This method returns another numeric value, this time equal to the movement speed of the
user in metres per second, relative to the current Viewpoint's coordinate system.
</DL>

These are all pretty simple, really. I've knocked up a quick <A HREF="../worlds/tut45a.wrl"
TARGET="_new">example</A>, where you can see all of these in action, along with its <A
HREF="../source/tut45a.html">source code</A>. There's nothing there that you shouldn't understand, it
should all be quite familiar by now. The **TimeSensor** is only there to provide regular updates
of the displayed text.

You may wonder what use all those really are, but you could tailor worlds for particular browsers,
or you could even provide a dynamic level-of-detail arrangement, where your world becomes less
detailed if the frame rate drops too much.

## Out of thin air...

No we get to the more complex stuff, which is of course also much more useful. This mainly involves
making changes to the current world, in one way or another. Again, we'll cover these methods one
by one.

<DL>
<DT>**Browser.setDescription(string *description*)** - needs *mustEvaluate TRUE*
<DD>This method changes the current description of the world (set in the **WorldInfo** node)
to the string passed as a parameter. Nice and simple.
<DT>**Browser.loadURL(MFString *url*, MFString *parameter*)** - needs *mustEvaluate TRUE*
<DD>This loads up a new world from a new file. The first argument to the method is a MFString list
of URLs to try. In standard VRML fashion, these will be tried in order until one of them is
successful. The *parameter* argument supplies extra parameters, such as a TARGET window for the
world, and so on. These parameters are exactly the same as you would use for a normal **Anchor**
node. In fact, the whole lot works in the same way as an **Anchor** node. If the new world is
loaded up in the same window, it will be closed down and completely replaced with the new one.
<DT>**Browser.replaceWorld(MFNode *nodes*)** - needs *mustEvaluate TRUE*
  <DD>This replaces the whole of the currently loaded world with the nodes in the 
    passed MFNode object. This method will never return, as the script running 
    it will be replaced. 
</DL>

As you can see, these methods are also fairly basic stuff, not doing anything really amazing. Now,
though, we come to the good stuff, which allows us to dynamically create VRML from nothing!

## createVrmlFromX()

There are two methods that allow you to create new bits of VRML from nowhere, collectively known
as the createVrmlFromX methods. They are:


* **Browser.createVrmlFromString(String *string*)**
* **Browser.createVrmlFromURL(MFString *url*, SFNode *node*, String *eventIn*)**


As their names suggest, these methods let you create new pieces of VRML from either a string or a
file. Both methods create a new MFNode object, that you can then use to add to a grouping node via
its *addChildren* eventIn. All of the grouping nodes have this eventIn, so you can add child
nodes anywhere you like.

 The two methods work in a subtly different way, as you can see from the 
  method definition. Why this is the case, I don't know. You would have thought 
  they would both work in the same way, but they don't. **createVrmlFromString** 
  takes a string as a parameter and returns an MFNode object containing the VRML 
  from the string. The string must be valid VRML, and be completely self-contained. 
  This means it cannot USE things DEFed outside the string, and likewise for PROTO 
  definitions. You can, however, include ROUTEs in the string. Essentially, the 
  string is like a complete VRML file in its own right, and follows the same 
  rules that a file would, apart from the magic header. So, a quick example of 
  this; if we assume we are inside a script that has an MFNode eventOut called 
  *newChildren*, which is going to the *addChildren* event of some grouping 
  node, we can do something like this: 
```
newVRML =  'Shape {';
newVRML += '   appearance Appearance {';
newVRML += '      material Material {';
newVRML += '         diffuseColor 1 0 0';
newVRML += '      }';
newVRML += '   }';
newVRML += '   geometry Box {';
newVRML += '   }';
newVRML += '}';
newChildren = Browser.createVrmlFromString(newVRML);
```
 This puts together the string we want (you don't have to separate out the 
  lines like I have, I've just find it easier to read like that - it could all 
  be on one very long line if you like), and then creates a new MFNode from it. 
  This MFNode is immediately assigned to the eventOut *newChildren*, and 
  is sent to the grouping node. The current children of the group are not replaced, 
  the new one is just added to them. 
 That's not too complex, really, is it? The other creation method is a little 
  more complex, though. createVrmlFromString() works in a very simple and flexible 
  way. For some reason, createVrmlFromURL() is more complex and less flexible. 
  With this method, you provide an MFString containing a list of URLs to try 
  as the first parameter. These files must be perfectly valid VRML, obeying all 
  the normal rules. The nodes within the file will be read and converted into 
  new nodes for you to use. That bit's OK, the awkwardness comes when you try 
  and send the new MFNode to a grouping node outside. createVrmlFromString gave 
  you a simple MFNode object that you could manipulate further and do what you 
  want with. createVrmlFromURL does not return anything. Instead, it sends the 
  MFNode out by itself, from inside the method. This is what the two other parameters 
  are for. The first is a reference to the node you want to add the new bits to, 
  and the second is the name of an MFNode eventIn that will receive the new nodes. 
  I think an example is the best way here. 
```
DEF GROUP Group {
}

Script {
   field SFNode group USE GROUP
   url "javascript:
      function initialize() {
         urlString = new MFString('cone.wrl');
         Browser.createVrmlFromURL(urlString,group,'addChildren');
      }
   "
}
```
As you can see, the parameters are the name of the file to use (in an MFString), the SFNode
reference, and the name of the eventIn. The method then handles everything else for you, posting
the new nodes into the *addChildren* eventIn of *group*. I'm not quite sure why it's been
done this way, but I'm sure the people in the know have their reasons. I'll let you know if I find
out! As an alternative, you can ignore createVrmlFromURL() and use createVrmlFromString() with an
**Inline** node containing the filename you want instead, like this:

```
newVRML = 'Inline { url "cone.wrl" }';
newChildren = Browser.createVrmlFromString(newVRML);
```
 This gives the functionality of createVrmlFromURL() with the usage style of
createVrmlFromString(). Thanks to Eyal Teler for that suggestion.
 Back to work, take a look at this <A HREF="../worlds/tut45b.wrl" TARGET="_new">example</A>, 
  along with its <A HREF="../source/tut45b.html">code</A>. As you can see, we have 
  a little toy that you can play with and make pretty pictures. Click the buttons 
  at the bottom to create a new object. You can then slide that object around 
  inside the grey area, building up patterns. This is done by creating a new **PlaneSensor** 
  along with each new **Shape**, and providing all the appropriate Routes and 
  so on inside the string or file. The cube and sphere are created from strings, 
  while the cone is created directly from a VRML file. Take a look at the source 
  for <A
HREF="../source/cone.html">cone.wrl</A>. That should all explain how these very useful 
  methods are used, I think. 

## From A to B

 There are two more methods in the Browser object to do with dynamic creation 
  of worlds; these are the *addRoute()* and *deleteRoute()* methods. 
  Not surprisingly, these add or delete Routes between nodes. They look like this... 

* **Browser.addRoute(SFNode *fromNode*, String *fromEventOut*, SFNode *toNode*,
String *toEventIn*)** - needs *directOutput TRUE*
* **Browser.deleteRoute(SFNode *fromNode*, String *fromEventOut*, SFNode
*toNode*, String *toEventIn*)** - needs *directOutput TRUE*


 These methods use their parameters in a similar way to the createVrmlFromUrl() 
  method, in that the first and third parameters are SFNode references, which 
  you have to find somehow, and the second and fourth are strings that identify 
  the events to link together. These are pretty simple in concept, the difficulty 
  comes when you actually try to obtain the SFNode references. This could involve 
  quite a lot of navigating through MFNode objects trying to find the correct 
  SFNode that you're trying to get to. They can, however, be vital if you want 
  to add new user-interface elements, or anything else that needs to communicate 
  with other nodes. You can create the nodes with createVrmlFromX(), and then 
  link them in to the rest of your world with the addRoute() method. 

## Vapourised

Well, we're all done here, at least I am. If you want more information on the Browser script
interface, I suggest you look at section <A
HREF="http://www.web3d.org/technicalinfo/specifications/vrml97/part1/concepts.html#4.12.10">4.12.10</A>
in the specification. This explains all the concepts behind the Browser object. Section <A
HREF="http://www.web3d.org/technicalinfo/specifications/vrml97/part1/javascript.html#BrowserClass">C.6.3</A> explains the binding of this
object in ECMAScript. Also on the <A HREF="http://web3d.vapourtech.com/info/index.html">specs</A> page are the ECMAScript
cheat sheets, which you may find useful as a quick reference to the methods of the Browser object,
and their parameters 

Well, I think that that is about all I can teach you about ECMAScript scripting, really, and as such
is the end of this part of the tutorial. In the next part, I'm going to quickly go over some Java,
which you can use for more complex and structured scripting tasks, However, it's another whole new
language. I think you lot are ready for it, though. See you there!

