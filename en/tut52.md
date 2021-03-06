---
title: "VRML97 Tutorial 5.2: Plug Me In"
keywords: initialize, Script, Java, SineGen, class,
---

# Plug Me In

OK, in the last tutorial, we had a bit of an introduction to Java. We looked at how it is written,
how to compile it, and how to create VRML scripts with it. This time round,  we're going to start
creating scripts that actually do things. There's a fair amount to cover, but when we're done,
you'll be able to create Java-based **Script**s that can receive inputs and send outputs.

So, what is this wonderful script that we're going to create? Well, for now, we're going to keep it
simple, and make a **Script** that will convert a simple linear **TimeSensor** into a sine-wave generator.
Then, we can create some cool effects with it.

## Creating the Class

So, for our sine wave generator, what will we need? Well, lets think about the actual **Script**
interface first. We need a SFFloat input (to come from the fraction_changed eventOut of a
**TimeSensor**), and an SFFloat output, which will send out our sine-wave signal.
Let's also have a way of setting the amplitude of the output wave - an SFFloat field will do for
that. So, the **Script** node will look something like this:
```
Script {
   eventIn  SFFloat set_fraction
   eventOut SFFloat fraction_changed
   field    SFFloat amplitude 1
   url "SineGen.class"
}
```
So, we have an input,  an output, and a name for our Java class. We now create a new Java class,
SineGen (which we create in a file called SineGen.java as described last time). The basic class
structure is exactly as we described it before. We declare a new public class, called SineGen, and
derive it from Script to get all the right behaviour.

```
import vrml.*;
import vrml.node.*;
import vrml.field.*;

public class SineGen extends Script {
}
```

## Linking to the Script

A this point, Java gets a bit harder. In ECMAScript, all you had to do was write functions with the
same name as the eventIns in order to handle those events. Java, unfortunately, doesn't work like
that. We have to write some code to even access the eventOuts, and then we have to
write the eventIn handler in a different way.

So, to start off our **Script**, let's grab the things that we need to talk to the outside world. You can do this
anywhere, but I'm going to do it in the initialize() function, which is just like the function of
the same name in ECMAScript (i.e. it is called by the browser when the script starts). I'll write
out the initialize() function, and then explain it all line by line.

```
import vrml.*;
import vrml.node.*;
import vrml.field.*;

public class SineGen extends Script {

   private SFFloat fraction_changed;
   //: A variable to represent our fraction_changed eventOut

   private SFFloat amplitude;
   //: A variable to represent the amplitude

   public void initialize() {
      // Grab the eventOuts and fields
      fraction_changed = (SFFloat) getEventOut("fraction_changed");
      amplitude        = (SFFloat) getField("amplitude");
   }

}
```

OK. So, we have created two instance variables, fraction_changed and amplitude. We're going to
use these to access the various events and fields that our **Script** will need. However, we can't
just use them straight off. In the initialize() function, we use the *getEventOut*
and *getField* functions to do this. Basically, this ties the VRML events and fields to the values of the
java variables. The function call is simple:
getXXXXX("name"). This gives us a variable which we *cast* (change type) to the correct field type
(in this case, SFFloat) and then assign to the appropriate instance variable. This bit of code gives us access
to the world outside our java class - we're linked into the VRML event system, and we're ready to send output. Now we have to
handle and process the events that come our way.

## Event Handling

Suprisingly, this involves writing an event handler. As you may be realising by now, this isn't as
easy as in ECMAScript. Before, we just wrote a function with the same name as the eventIn. In Java,
we have just one event handler which recieves all events - we have to separate them and process them
ourselves. The Java event handler looks like this:

```
   public void processEvent (Event e) {
      // Handle event in here
   }
```

In this case, it's pretty easy, as we only have one possible eventIn - *set_fraction*. In
future, however, you're going to have to be able to separate out which event you've just received,
so we're going to start here.

The key to working out what event you've just received is to look at it. The event is passed into
the processEvent() function as a parameter of type Event. This is a class that contains all the
information you need to work out what to do. In our case, the Event parameter is named e, though it
could be anything you like - it's just a function parameter. Working out which eventIn it represents
is simple:

```
   public void processEvent (Event e) {
      if (e.getName().equals("set_fraction")) {
         sine((ConstSFFloat)e.getValue());
      }
   }
```

We test the name of the event, and then if it's "set_fraction", we pass the value of the event on to
another function called *sine*, which we're going to write in a minute. Easy!

One thing to note - we used e.getValue() to get the value of the eventIn. This function
returns another class, called a ConstField. This is a class that represents a constant value of a VRML field
(in this case an SFFloat). Now, remember what we said about inheritance last time? Well, we know
(from looking at the documentation) that there is a class derived from ConstField called ConstSFFloat, which represents a constant
SFFloat value. This is what we want to pass to our sine() function, so we use a cast again to
convert the value to the right type.

## Surfing the Sine-Wave

Now that we've got the value of the event we've just received, we need to process it and send it out
again. We're going to do this in another function called *sine*. This function will take the
value of the eventIn as a parameter, process it, and send the eventOut. Let's create the skeleton of
the function before we fill it all in:

```
   private void sine (ConstSFFloat fraction) {
   }
```

Note the use of the word *private* instead of *public* at the beginning of the
function name. This means that other classes will not be able to call sine(). The function can only
be used within SineGen. This just stops other people fiddling about with bits of your code that they
shouldn't be able to get at.

OK - now we need some implementation inside this class. Lets write a sine generator!

```
   private void sine (ConstSFFloat fraction) {
      double result = Math.sin(fraction.getValue() * Math.PI * 2);
      result *= amplitude.getValue();
      fraction_changed.setValue((float)result);
   }
```

This shouldn't look to scary to you by now. The first line creates a variable called
*result*, which is assigned the value of the sine calculation. The sine calculation is done
using Java's built'in Math class, which is described in the Java API documentation. We multiply the
fraction we're received by 2 pi, in order to get a correct sine wave result. Note the use of the
getValue() function to get a java type that we can use (i.e. double) from a VRML type (SFFloat).

Next, multiply the result by our amplitude. This enables us to change the size of the resulting sine
wave. If amplitude is 1, the wave will stay between 1 and -1 at all times.

The final step is to send this new value out. This is done using fraction_changed (which we got
using getEventOut, remember?), and using it's setValue() function. This function expects a float, so
we cast the double to a float to keep the compiler happy.

## Creating a World

Right! That's it! You've written a java class that you can use in your worlds. Simply compile this
using `javac`, and you're away! We'll build it into a VRML world now. First, we need a
TimeSensor to provide the input for SineGen. Then, the output is sent to a PositionInterpolator,
with keys of -1 and 1. We set a position at each of these key points, and then hook it all up. The
TimeSensor feed a signal between 0 and 1 into the Sine Generator. This then sends a sine-wave signal
between 1 and -1 to the interpolator, which does it's job and creates a sine-wave shaped series of
positions, which we can route to an object. Take a look at the <A HREF="../worlds/tut52.wrl"
TARGET="_blank">result</A>.

As you can see, using a simple timer/interpolator/transform system, our Sine Generator transforms it
into something quite different. Take a look at the complete source code for both the <A
HREF="../source/SineGen.html">Java</A> and <A HREF="../source/tut52.html">VRML</A> components of
this scene.
