---
title: "VRML97 Tutorial 3.2: TimeSensor, VisibilitySensor, ProximitySensor, Collision"
keywords: TimeSensor, VisibilitySensor, ProximitySensor, Collision, Sensors, animation,
---

# There's Klingons On The Starboard Bow...

Now that you know the basic architecture of the VRML animation system, we're going to start covering the actual nodes you will use to add interaction and animation to your worlds.
There are three main classes of nodes that we're going to learn about: Sensors, Interpolators and Scripts. These, in turn, can be divided into sub-categories.
Right now, we're going to look at Sensors. The first load we're going to learn about are Environmental Sensors. These do not accept input directly from the user, but instead detect
environmental events, such as the passage of time, the position of the user, and so on.

## TimeSensor

The TimeSensor is basically a timer. It is quite unique in VRML, in that it has no position in the world, and no associated geometry. It is simply an abstract timer, just sitting there counting.
It is also one of the most important nodes in VRML animation. It can be used to generate regular events, to provide one-off timed events, or to drive interpolator nodes. The syntax is as follows,
I'll explain the individual fields in a minute...

<PRE>
TimeSensor {
   exposedField   SFTime      cycleInterval     1
   exposedField   SFBool      enabled           TRUE
   exposedField   SFBool      loop              FALSE
   exposedField   SFTime      startTime         0
   exposedField   SFTime      stopTime          0
   eventOut       SFTime      cycleTime
   eventOut       SFFloat     fraction_changed
   eventOut       SFBool      isActive
   eventOut       SFTime      time
}
</PRE>

OK. First of all is the <EM>cycleInterval</EM> field. This is quite self-explanatory, and is the time that the timer will run for before resetting. <EM>enabled</EM> is a fairly obvious field, and very useful 
for starting and stopping timers. The <EM>loop</EM> field specifies whether the timer will continuously loop or run just once. If it loops, an event will be generated every <EM>cycleInterval</EM>, otherwise only
one will be generated, after <EM>cycleInterval</EM>. <EM>startTime</EM> and <EM>stopTime</EM> are SFTime values that specify when the timer is to start and stop, the same as for the <STRONG>Sound</STRONG> node.

Now, the events. These are the really important parts of the <STRONG>TimeSensor</STRONG>. The first is <EM>cycleTime</EM>. This event is sent every time the timer reaches its <EM>cycleInterval</EM>, whether it loops or not.
The value sent is the current time. So, if you had a looping <STRONG>TimeSensor</STRONG> with a <EM>cycleInterval</EM> of 1 second, the <EM>cycleTime</EM> event would be sent every second with a value of the current time (which would increase by 1 each time).
This is useful for regular events and one-off signals. To drive continuous animations, such as Interpolator nodes, we need a continuous stream of signals. This is provided by the <EM>fraction_changed</EM> eventOut.
This generates events as fast as it can (though there is no guarantee in the spec of how regularly such events will occur) which have a SFFloat value that is the fraction of the <EM>cycleInterval</EM> that is currently complete.
For instance, if you had a <EM>cycleInterval</EM> of 10 seconds, if a <EM>fraction_changed</EM> event happens to be generated after 5 seconds, it would have a value of 0.5. The diagram below shows the relationship between the various 
values in a looping <STRONG>TimeSensor</STRONG>.

<IMG SRC="../pics/timesensor.gif" WIDTH=320 HEIGHT=200 ALT="TimeSensor">

Note, however, that there is not guarantee that an event will be generated at this particular time, only that events in general will be generated. This event is very useful for driving interpolators, which use key values 
for the values which they are interpolating, tied to particular fractions. This will all be covered later, though. The <EM>time</EM> event is generated at the same time as a <EM>fraction_changed</EM> event, and contains a value 
corresponding to the absolute time of the event. The <EM>isActive</EM> event is generated whenever the timer starts and stops. The value of the SFBool is TRUE or FALSE, depending on whether the timer has started or stopped running.


This <A HREF="../worlds/tut32a.wrl" TARGET=_new>example</A> (<A HREF="../source/tut32a.html">code</A>) is a very simple one, with the <EM>cycleTime</EM> event of a looping <STRONG>TimeSensor</STRONG> routed to the <EM>startTime</EM> exposedField of a one-shot <STRONG>AudioClip</STRONG> node. This world is just a piece of text and
the sound, which triggers every 2 seconds. Obviously, there is a simpler way to do this particular effect, but it gets the point across, doesn't it? You'll learn more about using <EM>fraction_changed</EM> when we come across interpolators later on.

## VisibilitySensor

The next type of sensor is the <STRONG>VisibilitySensor</STRONG>. This is more of an interaction sensor, in that it defines an invisible box shape which sends events when it enters and leaves the users field of vision.
If the box enters the users view, the <EM>isActive</EM> event is sent with a value of TRUE, and the <EM>enterTime</EM> event is sent with the time of entry. If it leaves, the <EM>isActive</EM> event is sent with a value of FALSE, and the
<EM>exitTime</EM> event is sent with the time of exit. The <EM>center</EM> and <EM>size</EM> fields define the size of the box. The complete definition is shown below:

<PRE>
VisibilitySensor {
   exposedField   SFVec3f     center            0 0 0
   exposedField   SFBool      enabled           TRUE
   exposedField   SFVec3f     size              0 0 0
   eventOut       SFTime      enterTime
   eventOut       SFTime      exitTime
   eventOut       SFBool      isActive
}
</PRE>

<STRONG>VisibilitySensor</STRONG>s are very useful for optimising your worlds. Having a large number of animations running at a time can be very CPU-intensive, and will slow your worlds down horrendously. By using <STRONG>VisibilitySensor</STRONG>s to stop animations that are outside 
the users field of vision, you can speed up heavily animated worlds no end. This is done by simply routing the <EM>isActive</EM> event to the <EM>enabled</EM> field of the appropriate <STRONG>TimeSensor</STRONG>s or whatever.


Now, take a look at this <A HREF="../worlds/tut32b.wrl" TARGET=_new>example</A> world and its associated <A HREF="../source/tut32b.html">code</A>. It consists of a box, with a VisibilitySensor in the same position. When you can see the box, you can hear the sound. If you turn away, until the box disappears off the edge of the screen,
the sound will stop. Then, it will restart when you see the box again. This is done all very simply. The sound is a looping <STRONG>AudioClip</STRONG>, and the <EM>enterTime</EM> and <EM>exitTime</EM> fields of the <STRONG>VisibilitySensor</STRONG> are routed to the <EM>startTime</EM> and
<EM>stopTime</EM> of the <STRONG>AudioClip</STRONG>.

## ProximitySensor
A <STRONG>ProximitySensor</STRONG> is very similar to a <STRONG>VisibilitySensor</STRONG>, except that is generates <EM>isActive</EM> events when the user enters or leaves the box defined. The <EM>enterTime</EM> and <EM>exitTime</EM> events function as before, as does the <EM>isActive</EM> event.
While the user is inside the <STRONG>ProximitySensor</STRONG>, events will be generated whenever his position or orientation change relative to the sensor, along the eventOuts <EM>position_changed</EM> and <EM>orientation_changed</EM>. These will contain the new value of the avatar's position or orientation, whichever 
is appropriate. Remember, these are in the local coordinate system of the <STRONG>ProximitySensor</STRONG>, so will be relative to the centre of the sensor.

<PRE>
ProximitySensor {
   exposedField   SFVec3f     center            0 0 0
   exposedField   SFVec3f     size              0 0 0
   exposedField   SFBool      enabled           TRUE
   eventOut       SFBool      isActive
   eventOut       SFVec3f     position_changed
   eventOut       SFRotation  orientation_changed
   eventOut       SFTime      enterTime
   eventOut       SFTime      exitTime
}
</PRE>

This <A HREF="../worlds/tut32c.wrl" TARGET=_new>example</A> world (with <A HREF="../source/tut32c.html">code</A>) shows a <STRONG>ProximitySensor</STRONG> in action. If the user approaches within a certain distance of the box, he enters the <STRONG>ProximitySensor</STRONG> and the sound is started. When he leaves, the sound stops. This uses
the same routings as in the previous example, routing the <EM>enterTime</EM> and <EM>exitTime</EM> to the <EM>startTime</EM> and <EM>stopTime</EM> of the <STRONG>AudioClip</STRONG>.

## Collision

This node is perhaps slightly different from those we've already covered. This is really used to control collision detection in a world, but also can be used as a collision sensor for animation. Basically, it is a grouping node that you can use to enable or disable collision detection
between the user and its children. If <EM>collide</EM> is TRUE, collision detection will be performed, and the object will appear solid. If it is FALSE, it will not be tested for collisions, and the user will be able to pass straight through.
You can also specify a <EM>proxy</EM>, which is a node used for collision detection INSTEAD OF the geometry in the <EM>children</EM> field. It has the standard fields of any grouping node, <EM>addChildren</EM>, <EM>removeChildren</EM>, <EM>bboxCenter</EM>, and <EM>bboxSize</EM>. Don't worry about these for now, we'll deal with 
them later. The reason this is included in this section is the <EM>collideTime</EM> eventOut. This can be used to activate an event when the user hits the geometry. It is an SFTime eventOut, and is generated whenever the user hits the appropriate geometry (<EM>children</EM> or <EM>proxy</EM>), with the value of the time at which the collision occurred.

<PRE>
Collision {
   eventIn        MFNode      addChildren
   eventIn        MFNode      removeChildren
   exposedField   MFNode      children          []
   exposedField   SFBool      collide           TRUE
   field          SFVec3f     bboxCenter        0 0 0
   field          SFVec3f     bboxSize          -1 -1 -1
   field          SFNode      proxy             NULL
   eventOut       SFTime      collideTime
}
</PRE>

The <STRONG>Collision</STRONG> node can be very useful in speeding up your worlds. If you have some very complex geometry, you can replace the collision detection with that object with collision detection for a bounding box, by providing a <EM>proxy</EM> geometry to collide with. This will reduce realism slightly, but increase the rendering performance
of your world no end. You can also use proxy geometry to constrain the user to certain parts of the world, so that the user is bounded by an invisible wall beyond which he can't pass. This is useful for making your worlds easier to navigate and use.


This <A HREF="../worlds/tut32d.wrl" TARGET=_new>example</A> world and its <A HREF="../source/tut32d.html">code</A> demonstrate the use of the <STRONG>Collision</STRONG> node as a sensor, but also how proxy geometry and the <EM>collision</EM> field affect the world.
The cyan sphere on the left has its <EM>collision</EM> field set to FALSE. The magenta sphere has <EM>collision</EM> TRUE, and its <EM>collideTime</EM> is routed to the <EM>startTime</EM> of a one-shot <STRONG>AudioClip</STRONG>. The
yellow sphere on the right has a proxy geometry which is a box that is 4 metres each side. The <EM>collideTime</EM> of the node is also routed to a different <STRONG>AudioClip</STRONG>. Note that you cannot approach the yellow sphere as closely as the magenta sphere before the noise sounds and you cannot approach further.

## Scrape 'Em Off, Jim

Well, that the environmental sensors for you. Next time, we're going to cover pointing device sensors, which we can use to get input and control data from the user.
