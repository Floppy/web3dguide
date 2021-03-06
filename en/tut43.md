---
title: "VRML97 Tutorial 4.3: VRML Scripting Functions"
keywords: VRML Scripting functions, initialize, shutdown, eventsProcessed,
---

# Bodily Functions

By now, you know enough about ECMAScript to start creating VRML **Script** nodes that perform
useful operations. This tutorial will take you through the general structure of a VRML script,
explaining how it all works and fits together. By the end, you should be able to produce simple
scripts of your own! Which is nice...

## Script Layout

The first thing we're going to look at is the layout of a VRML script. You've already seen the
**Script** node, and you know a bit about ECMAScript, so there should be no problems here. A VRML
script basically consists of a set of functions, each of which execute at specific times. All the
functions in the script have access to the fields and events defined in the **Script** node.
```
url "javascript:
   function initialize() {
      // initialisation code
   }
   function shutdown() {
      // shutdown code
   }
   function eventsProcessed() {
      // event handling code
   }
"
```
Above is the general sort of structure you have in a normal script. Let's now take a look at some of
the functions you will have in your scripts.

## Startup and Shutdown

First of all, we'll take a look at the *initialize()* function. This is called as soon as the
world is loaded, before it is displayed. The world is displayed when it has finished executing. The
function is declared as shown below:
```
function initialize() {
   // initialization code
}
```
The statements you want to execute on startup go inside the function body, instead of the comment.

To go with the *initialize()* function, there is a *shutdown()* function. This is executed
when the script is shut down, so when the browser is closed or when another URL is loaded.
```
function shutdown() {
   // shutdown code
}
```
This is useful for clearing up any mess that the script may have left behind it. You don't really
need to use it very often though, only when you start doing quite complex things.

## Event Handling

Now we get to the really useful bit, the event handlers. Your scripts will almost always react to
the outside world, by receiving eventIns from other nodes. You need some code that is executed when
these events are received. These are your event handler functions. Let's have a little example to
see how this works.
```
Script {
   eventIn SFTime touchTime
   url "javascript:
      function touchTime (value, time) {
         // event handler code
      }
   "
}
```
In this example, you can see that your event handlers have the same name as the eventIns that they
correspond to. They have two parameters, which you can give whatever name you want, but I've used
*value* and *time*. *value* is the value of the event received, and *time* is
the timestamp of the event. In the example above, when a *touchTime* event is received, the
code in the *touchTime* function is executed. All very simple.

## eventsProcessed and eventOuts

There are a couple more things to cover. Firstly, the *eventsProcessed()* function is another standard
function. This is called after a set of events have been processed. How often this happens is browser-
dependent, unfortunately. It can be after every event, or less often. In general, if you have a
calculation that doesn't need to be performed for *every* event, put it in here.
```
function eventsProcessed() {
   // post-event handler code
}
```
Just the one more thing, and that is how do we send events in ECMAScript? It's very, very easy, even
compared to the rest of this tutorial.
```
Script {
   eventOut SFInt32 choice
   url "javascript:
      function initialize() {
         choice = 2;
      }
   "
}
```
To send an eventOut, simply assign a value to the name of the eventOut. It's amazingly easy. This is
why I teach you ECMAScript first, Java is slightly more complex.

## Function Dysfunction

Well, that's covered the basic setup of a VRML script. I've shown you the functions you can use to
create your scripts, and govern how they behave. The <A HREF="../worlds/tut43.wrl" TARGET="_new">example</A> for this
tutorial and its <A HREF="../source/tut43.html">code</A> show you how these all work together. When
the script starts, its *initialize()* function is executed, which writes a message to the
console and the string "Ready..." to the **Text** node. When you click on the **TouchSensor**,
it sends an event to the script, executing the *touchTime()* function. This writes the count of
the number of *touchTime* events received to a temporary string, with a message to the console.
The *eventsProcessed* writes the number of times it has been called into the temporary string,
which is then output to the **Text** node. Therefore, each time the *eventsProcessed()*
function executes, the text in the world is updated. If *eventsProcessed* is called after
every *touchTime()*, the numbers will the same, otherwise they will be different, and you may
have to click more than once to update the display. This shows how your browser deals with
*eventsProcessed()*.

**NOTE:** The example above uses the *print()* function to print to the VRML console.
However, not all VRML browsers support this function. If you have problems, try this alternative
<A HREF="../worlds/tut43a.wrl" TARGET="_new">example</A> and <A HREF="../source/tut43a.html">code</A>. Also,
please <A HREF="http://web3d.vapourtech.com/contact/index.html">mail me</A> and tell me which
browser you are using and the error it reports. Thanks!

Next time out, we're going to cover the relationship between VRML and ECMAScript types. We're going
to need a bit of an introduction to objects as well. See you there!

