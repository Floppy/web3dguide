---
title: "VRML97 Tutorial 3.4: ColorInterpolator, CoordinateInterpolator, NormalInterpolator, OrientationInterpolator, PositionInterpolator, ScalarInterpolator"
keywords: ColorInterpolator, CoordinateInterpolator, NormalInterpolator, OrientationInterpolator, PositionInterpolator, ScalarInterpolator, Interpolators, animation, 
---

# Inbetweener

## Interpolators and Animation

Right then, this time out we're going to learn about Interpolator nodes. These nodes are very important for animation, but really are very simple.
The general concept is that they are used to change a certain value over time. Depending on what sort of value you want to change, there are six different
interpolator nodes. They are very similar in behaviour however, so we'll cover them all at once and give a big demo at the end.


You would use an interpolator where you want to change a value over time. They take timing signals from a <STRONG>TimeSensor</STRONG> or similar, and perform a linear interpolation between
sets of values called <EM>keyValue</EM>s. For each keyValue there is a <EM>key</EM>, which is a fraction from 0 to 1. Now, as you remember, a <STRONG>TimeSensor</STRONG> outputs <EM>fraction_changed</EM> events as regularly
as it can. This can be routed to the <EM>set_fraction</EM> eventIn of an interpolator to set the correct point in the interpolation cycle. So, if you route a <STRONG>TimeSensor</STRONG> with a <EM>cycleInterval</EM> of 10 to an
interpolator, the interpolator will cycle through its keys every 10 seconds.


Now, every time an interpolator receives an eventIn, it generates an eventOut with the appropriate interpolated value. This can be routed to anything of the appropriate type to change its value. So, the overall animation chain
for an interpolator looks like the diagram below. Note, this diagram uses the OrientationInterpolator and a Transform node to demonstrate the ROUTEing.

<IMG SRC="../pics/interpolator.gif" WIDTH=320 HEIGHT=103 ALT="Interpolator">

## Interpolator Types</FONT>

OK, let's take a look at the actual nodes themselves. You can use these in any of the normal places, so at the root of the file, in transform nodes, wherever. As they are nodes purely concerned with the animation engine,
they can go anywhere in the scene hierarchy, it doesn't matter.


All the nodes have the same fields, but with different types for the <EM>keyValue</EM> field and the <EM>value_changed</EM> eventOut. So, first we have a <EM>set_fraction</EM> eventIn, which receives events from <STRONG>TimeSensors</STRONG> or otherwise. This sets the current stage in the animation cycle, 
and sets how far through the interpolation we are. The next field is the <EM>key</EM> field. This is a sequence of numbers from 0 to 1 corresponding to the key points in the animation. So, if at fraction 0 you want a position to be a certain value, and likewise at fractions 0.5 and 1.0, you would have 
a <EM>key</EM> field of [0, 0.5, 1], each number representing the fraction of each keyframe. Each key has a corresponding entry in the <EM>keyValue</EM> field, so if we follow the above example (using the <STRONG>ScalarInterpolator</STRONG> which interpolates SFFloat values), we could have a <EM>keyValue</EM> field of 
[0.0, 10.0, 0.0]. At fraction 0, the output would be 0.0, and fraction 0.5 it would be 10.0, and at 1 it would be 0.0 again. Between these times the value is linearly interpolated, so at fraction 0.25, the value will be 5.0. This value is output along the <EM>value_changed</EM> eventOut whenever a <EM>set_fraction</EM>
event is received.


The interpolator nodes allow you to specify key frames in an animation and let the browser work the rest of the animation out. This allows concise, simple definition of animation information. One important thing to remember is that if you want an animation to cycle smoothly, it will have to have the same value at fraction 1 as at fraction 0. If not,
you will get a jump as the value at 1 changes instantly to the value at 0. Now, let's take a look at the types of value we can interpolate with the different nodes.

<PRE>
ColorInterpolator {
   eventIn        SFFloat  set_fraction
   exposedField   MFFloat  key                  []
   exposedField   MFColor  keyValue             []
   eventOut       SFColor  value_changed
}
</PRE>

The first one is the <STRONG>ColorInterpolator</STRONG>. This, understandably, interpolates an rgb colour triple. The colours are declared in the <EM>keyValue</EM> field in the same way you would specify any MFColor field. To have a colour go from green to blue to red, you would use the following (note this <EM>will</EM> jump at fraction=1) :

<PRE>
key [0, 0.5, 1]
keyValue [0 0 1, 0 1 0, 1 0 0]
</PRE>

So, that's all there is to it. Really, the rest of the nodes are just the same, but with different types in the <EM>keyValue</EM> field. Let's have a look at them anyway...

<PRE>
CoordinateInterpolator {
   eventIn        SFFloat  set_fraction
   exposedField   MFFloat  key                  []
   exposedField   MFVec3f  keyValue             []
   eventOut       MFVec3f  value_changed
}
</PRE>

Actually, having said that, this one is a bit different. This one, rather than sending a single value, sends lots at a time. This is so that you can 
interpolate many coordinates (i.e. entire <STRONG>IndexedFaceSet</STRONG>s) at once. To do this, the number of coordinates in the <EM>keyValue</EM> field has to be an exact multiple of the
number of <EM>key</EM>s. This multiple is the number of coordinates that will be sent at a time. Bear in mind that you need to keep the coordinates in the same order in each set, or your object will look very strange.

<PRE>
NormalInterpolator {
   eventIn        SFFloat  set_fraction
   exposedField   MFFloat  key                  []
   exposedField   MFVec3f  keyValue             []
   eventOut       MFVec3f  value_changed
}
</PRE>

As above, this node sends numerous normals at once, for much the same reasons. The node outputs a number of normals, so you can manipulate all the normals for an object at a time.

<PRE>
OrientationInterpolator {
   eventIn        SFFloat     set_fraction
   exposedField   MFFloat     key               []
   exposedField   MFRotation  keyValue          []
   eventOut       SFRotation  value_changed
}
</PRE>

This interpolates between rotation values, and is suitable for routing into a <STRONG>Transform</STRONG> node's <EM>set_rotation</EM> field.

<PRE>
PositionInterpolator {
   eventIn        SFFloat  set_fraction
   exposedField   MFFloat  key                  []
   exposedField   MFVec3f  keyValue             []
   eventOut       SFVec3f  value_changed
}
</PRE>

Again, this interpolates 3D position values, and can be routed into a <EM>set_translation</EM> event of a <STRONG>Transform</STRONG>. However, you could also route it into any SFVec3f value.

<PRE>
ScalarInterpolator {
   eventIn        SFFloat  set_fraction
   exposedField   MFFloat  key                  []
   exposedField   MFFloat  keyValue             []
   eventOut       SFFloat  value_changed
}
</PRE>

This node interpolates floating point values. With this, you could interpolate the intensity of a light, the transparency of an object, or any other scalar value. However, you could also "invert" 
a <STRONG>TimeSensor</STRONG>, by interpolating between 1 at fraction=0 and 0 at fraction=1. You could also translate a <STRONG>TimeSensor</STRONG> into a rough sine wave, or anything like that.

## Disco Duncan

I've just got one <A HREF="../worlds/tut34.wrl" TARGET=_new>example</A> for this world, but it contains all the types of interpolator. They are all driven by a single <STRONG>TimeSensor</STRONG>, so they go at the same rate. The examples are arranged around the
entry point, so you can move around and have a look at them. Just one quick note, the <STRONG>ScalarInterpolator</STRONG> is changing the intensity of the lighting on the cylinder. The rest are fairly self-explanatory.
You should
take a look at the <A HREF="../source/tut34.html">code</A> for this one, as it gets a bit complex.


Well, that's about it for the basic animation functions of VRML97. Now, by linking together the stuff you've already
covered in this section, you should be able to create any number of impressive worlds. However, there are a few more
things to cover. Next time, I'm going to explain bindable nodes. Should be fun!