---
title: "VRML97 Tutorial 3.1: VRML Animation, ROUTEs, eventIns, eventOuts"
keywords: VRML animation, ROUTE, TO, eventIn, eventOut, animation,
---

# More Power, Igor!

Well, then. That's Parts 1 and 2 over. Part 1 covered the basics of VRML, and creating your own simple worlds.
Part 2 taught you techniques for making your worlds more realistic, such as advanced objects and textures. However, our worlds are still a bit static.
This is going to be fixed from now on, where we're going to cover the techniques of animation and user interaction. If you thought that what you'd created so far was good, hold on!
It's about to get a lot more exciting!

This tutorial is just going to recap and add a little detail to the basic layout of the VRML interaction and animation system. This stuff was explained earlier on, but now we're going to
put it in context, and give you an idea of how the VRML internal execution model works.

## Wiring It Up

VRML is no longer a static language. It is a moving, living thing, which can take inputs and give different outputs.
This requires some sort of internal model of execution, to govern how things change and in what order they do it.
This is done by wiring together the nodes in the world, to provide paths along which messages can travel between them.
These wires aren't visible, they have no representation in your world, but they glue the underlying model together, allowing
fantastic effects.

Most nodes have <STRONG>eventIn</STRONG>s and <STRONG>eventOut</STRONG>s, and many have <STRONG>exposedField</STRONG>s. These are how the nodes talk to the outside. <STRONG>eventIn</STRONG>s are like receivers, which
listen for messages called <STRONG>events</STRONG> from the outside and take them in to be processed. <STRONG>eventOut</STRONG>s are transmitters, which send events from the node to the outside.
<STRONG>exposedField</STRONG>s are a combination of both. They behave as a normal field <EM>fieldname</EM>, an <STRONG>eventIn</STRONG> called <EM>set_fieldname</EM> and an <STRONG>eventOut</STRONG> called
<EM>fieldname_changed</EM>. In general, the <EM>set_</EM> and <EM>_changed</EM> parts of the name are not necessary, you can just use the <EM>fieldname</EM> of the <STRONG>exposedField</STRONG> 
and the execution model will work out what you mean.

Now, all this is useless if your <STRONG>eventOut</STRONG>s are just spewing events into empty space. They're not going to go anywhere. You need to connect your nodes together using <STRONG>ROUTE</STRONG>s. These
are like pipes that channel events from an <STRONG>eventOut</STRONG> into an <STRONG>eventIn</STRONG>. You can connect many <STRONG>eventIn</STRONG>s to one <STRONG>eventOut</STRONG> to make one event cause many things to happen. This is called
<EM>fan-out</EM>. <EM>Fan-in</EM> is also allowed, where two or more <STRONG>eventOut</STRONG>s feed into one <STRONG>eventIn</STRONG>. However, this is slightly dangerous. If two events arrive at an <STRONG>eventIn</STRONG> with the same 
time stamp (which I'll explain in a minute), the results are undefined, so if you must use fan-in, take care to avoid this situation.

So, for example, if you have two nodes, one <STRONG>TouchSensor</STRONG> (covered later) and one <STRONG>Sound</STRONG> node, DEFed to be called SENSOR and SOUND respectively, 
To route the <EM>touchTime</EM> <STRONG>eventOut</STRONG> from the <STRONG>TouchSensor</STRONG> node to the <EM>startTime</EM> <STRONG>eventOut</STRONG>
in the <STRONG>Sound</STRONG> node. (for instance to play a sound on a mouse click), we would use the following line of code:

<PRE>
ROUTE SENSOR.touchTime TO SOUND.startTime
</PRE>
<IMG SRC="../pics/route.gif" WIDTH=320 HEIGHT=200 ALT="Route">

When the TouchSensor is clicked, the sound will play. There! Interaction! As standard practice, all ROUTE statements are grouped together at the end of the file in one big group. They do not go inside any 
nodes, and are completely separate from the things they are routing. Also, ROUTEs can only connect events of the same type, so you cannot connect an SFTime to an SFBool for instance. If you need to, you 
need to write a script to convert from one type to the other.

## Generating Events

So, now that we can route events around the scene, we need to know a little more about the events themselves. Events are the messages that bind the world together. Everything that moves or interacts in VRML does
so because of events. They are the key to the whole thing. An event consists of two parts: the message itself, which is a value of a certain type, and a time stamp. The message value 
can be any type, for instance SFTime, SFString, MFNode, anything at all. If the nodes can handle it, you can send it. The time stamp is a special value which you have no control over. This is a value corresponding 
to the precise time at which the real-world event actually occurred, not when the <STRONG>event</STRONG> happened to be generated by the node. The actual values are not important, only how they relate to other values. An event with a 
later time stamp is defined as happening after one with an earlier time stamp. In general, events are processed in order of increasing time stamp. The time stamp is not available to you as a content creator, and is 
used only internally by the browser.

If one event is generated, and this causes another event in another node, and so on and so on, this is called an <EM>event cascade</EM>. All the events in the cascade will have the <EM>same</EM> timestamp. That is, as far as the browser 
is concerned, all the events happened at the same time. With fan-in to an <STRONG>eventIn</STRONG>, if two events are received with the same timestamp, the results are undefined. Whether they will both be ignored, both run, or one run, there is 
no way of knowing, and it will vary between browsers. Fortunately though, almost the only way to do this is to have fan-in within a single event cascade, so with careful design these situations can be avoided. Loops can also occur in event 
cascades, where one event causes another, which in turn causes the first. This should also be avoided in most cases. However, if it is necessary, it can be used. The execution model will only allow 1 event with a particular timestamp to
be sent from each <STRONG>eventOut</STRONG>, so if loops are present, they will not loop forever, only once. This is because the a loop must be part of an event cascade, and so the second event generated by a node will have the same time stamp as 
the first, so will not be sent. So, loops are allowed, but will probably not function as you expect.

Initial events (events not caused by another in a cascade) can only be generated by sensor nodes and <STRONG>Script</STRONG> nodes. Other nodes can only generate events if they receive one. This means that
sensors and <STRONG>Script</STRONG>s are the key to driving VRML animation and interaction. The nodes charged with doing the actual animation are the interpolator nodes and <STRONG>Switch</STRONG> nodes, as well as the 
<EM>exposedField</EM>s in other nodes. These perform the actual animation function. In between these can lie other sensors, <STRONG>Script</STRONG>s, anything at all to provide complex animation engine functions.
The VRML animation model is very powerful indeed, and the possibilities are practically unlimited.

## It's Alive!

So, in this fairly complex model below, A <STRONG>TouchSensor</STRONG> sends a single <EM>touchTime</EM> event (SFTime) to a <STRONG>Script</STRONG> node whenever it is activated. The <STRONG>Script</STRONG> node converts the SFTime into an SFBool 
and uses this to toggle the <EM>enabled</EM> field of the <STRONG>TimeSensor</STRONG>, which will then start (or stop) running. While the <STRONG>TimeSensor</STRONG> is enabled, it generates events continuously to drive a <STRONG>ColorInterpolator</STRONG> 
which cycles the <EM>diffuseColor</EM> of an object. These events from the <STRONG>TimeSensor</STRONG> also drive a <STRONG>PositionInterpolator</STRONG> which changes the <EM>translation</EM> field of a <STRONG>Transform</STRONG> node.
You see? Simple. Sort of...

<IMG SRC="../pics/eventcascade.gif" WIDTH=640 HEIGHT=267 ALT="Event Cascade">

You'll learn more about the nodes involved, later, but just concentrate on the connections and flow of data for now.
That's it for the basics. Now you know how to connect your nodes together to make complex behaviours, and how and why these behaviours arise. Now, we're going to start on the practical bits of it all, starting with some info on 
environmental sensors.