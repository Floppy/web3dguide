---
title: "VRML97 Tutorial 3.6: Script"
keywords: Script, scripting, scripts, VRML scripts,
---

# It's Life, Jim, But Not As We Know It

In this tutorial, I'm going to show you how to use scripts in your worlds. I'm NOT going to teach you to write scripts. That comes later.
For now, just assume that you already have a script that you want to use. I'm going to show you how to plug
the script into your world so that you can use it.

## The Script Node

The **Script** node is probably the most important aspect of VRML97. It transforms the language from a simple static one (albeit with animation) into
an almost infinite universe of possibilities. Basically, the **Script** node allows you to build your own nodes with their own fields, eventIns and eventOuts.
The syntax of the script node is as follows:

```
Script {
   exposedField   MFString    url               []
   field          SFBool      directOutput      FALSE
   field          SFBool      mustEvaluate      FALSE

   Also, any number of the following:
   eventIn        Type        eventInName
   field          Type        fieldName         default value
   eventOut       Type        eventOutName
}
```

So, all scripts have three basic fields in common. We'll cover these in a moment. As well as these, they have any number of
user-defined fields, eventIns and eventOuts. These are defined in a similar way to the PROTO declaration. You define them by using the
keyword *field*, *eventIn* or *eventOut* depending on what you want, then the type (ie SFBool), then the name. In the case of
fields, you then specify a value for the field. An example of this is shown below:

```
Script {
   eventIn  SFBool   input
   field    SFBool   boolValue   TRUE
   eventOut SFBool   output
   url "filter.js"
}
```

This specifies one field of each type for our script node. One eventIn called *input*, one eventOut called *output*, and one field called *boolValue* with a
default value of TRUE. It also specifies that the code for the script can be found in the file "filter.js".


Note: **Script** nodes cannot have exposedFields.

## Languages

There are three ways to define scripts in VRML. Firstly, you can use compiled Java code, in a .class file referenced in the *url* field. Secondly, you can use Javascript code in an external
.js file. Thirdly, you can include inline Javascript directly into the *url* field. An example of inline javascript is shown below:

```
url "javascript:
   function input(value, time) {
      if (value==boolValue) output = value;
   }
"
```

The inline script is specified by using the url "javascript:" followed by the code in the field itself. This is quite appropriate for small
amounts of code, or code that is only used once per file, where the time taken to transmit the extra file information needed for a separate file is more than the time taken to transmit a larger VRML file.


What is more complex is the choice of language. Javascript is a very simple language to learn, with simple event processing and integration with the VRML. However, it lacks the
power and flexibility of Java code. For this reason, Javascript is appropriate for small simple scripts such as toggles, switches, filters and so on. Java is more appropriate for
heavier scripting such as large scripts doing a lot of mathematical work or hardware interaction. Also, because Java is compiled into bytecode, it has the advantage that others can't see the
inner workings of your script. IF you wanted to protect your VRML files from tampering or viewing by other people, you could have the Java script generate the whole lot on the fly.

## Plugging It In

Once you've defined your scripts, you can plug them into the event chain wherever you like. They will the process the events you send them and send events on to where you route them,
and the fields you've defined can influence their internal behaviour. There are a couple of things to cover, though, before you go off and start building huge complex worlds left and right.
The two fields that we ignored earlier need to be described in detail. The first is the *mustEvaluate* field. This tells the browser to evaluate events sent to this script as soon as it can. Otherwise, if there is
a lot going on at once, it may queue events up and process them all at once, which is more efficient. Generally, leave this as FALSE, unless you start getting lags in event processing, in which case set it TRUE.
The *directOutput* field allows a script to bypass the event chain and place values directly into the fields of nodes that it has access to. This will be covered in greater detail later on in Part 4.

## Not As We Know It, Captain

Right, then. Take a look at this <A HREF="../worlds/tut36.wrl" TARGET="_new">example</A>, along with its <A HREF="../source/tut36.html">code</A>.
It's the same as the last world, but this time the script is used to filter the *isActive* messages so that only TRUE events get through. This allows us to bind permanently to a node.
You will notice that you can click and release the mouse button, and the bindings will change permanently until you click again. The script takes the *isActive* events, and compares them
with the value in its *boolValue* field. It only lets through those which are the same (ie the TRUE ones).


Right, next time we're going to use the **Switch** node, and then I'll tell you how to make your own scripts.
