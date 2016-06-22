---
title: "VRML97 Tutorial 5.1: Hold On To Your Hat"
keywords: JDK, compiling, JSAI, CLASSPATH, Class, compiler, method, instance variable, public, private, protected, extends,
---

# Hold On To Your Hat

So, you know how to create scripts in ECMAScript, and you've got a pretty good idea of how the whole
scripting thing works. But you want more power! ECMAScript is too slow, to restrictive, to hard to
use for large programs. Well, help is at hand, because not only does VRML support ECMAScript in
**Script** nodes, it also supports Java! And I'm going to show you how to use it -
aren't you lucky? First, though, I have to give you a couple of warnings...

PUBLIC HEALTH WARNING #1: Java is a full-blown programming language! While we went through most of
what ECMAScript can do before learning about VRML scripts, there is no way we can do this with Java.
It's just too big. It would take an entire tutorial bigger than this one to give you a thorough
grounding in Java, which I just don't have time or space to write. Besides, this is supposed to be a
VRML tutorial! Because of this, this part of the tutorial is going to skip a lot of Java detail.
It's OK though, you'll find that the syntax is quite similar to ECMAScript, so that you should be
able to follow what's going on. I'll explain the major differences, and I'll try not to completely
confuse you. However, I would recommend that if you're serious about scripting in Java, go away and
learn the language somewhere else as well as reading these tutorials, as there will be a lot that
I'll skip over. I'll explain most things in brief, but you should try and get a more thorough
understanding of it as well. Take a look at <A HREF="http://java.about.com/"
TARGET="_top">java.about.com</A> for a starting point for Java info.

PUBLIC HEALTH WARNING #2: Not all browsers support Java! Unfortunately, this includes Blaxxun, so be
aware of what platform you're developing for when you're writing (although, that's always important
in VRML). If you want to create something cool for ColonyCity, don't bother reading this bit.
Just concentrate on the ECMAScript!

Anyway that's enough of that. Let's get in with it, shall we? As the title says, hold on to your hats...

## But why?

Let's start by taking a little look at why you would want to use Java in the first place. Isn't
ECMAScript good enough? Well, in a word, no. Not for large projects. If you're just doing simple
stuff like we have done up to now, it's fine, but if you want to link your VRML world directly to a
central server, or to a database, or to a complex AI engine for your game, it's not going to happen
in ECMAScript. Java provides the structure necessary in larger projects, which is absolutely vital.
In short, if you're doing simple stuff, ECMAScript is great (that's why it's there), but for complex
applications, you really need to be using Java.

## Basic Java concepts

OK, if we're going to be writing Java, we'd better introduce a few language concepts. Actually
writing down instructions in Java is really very similar to ECMAScript, so once you've seen a few
examples you should be OK there. However, these instructions fit together in slightly different way.
We're going to talk for a minute about *classes*, *inheritance*, and a couple of other
things.

Do you remember objects from when we did ECMAScript? They were like boxes which can contain lots of
bits of data, and also can contain methods which operate on the data contained in the box
(remember the pixies?). Now, in ECMAScript, we never really created our own objects, we just used
the built-in VRML97 ones. You didn't really need to think about them. In Java, however, the object
is king, and it is known as a *class*. Java is a prime example of an *object-oriented*
programming language, and everything you write has to be part of a class. All the functions you
write will be methods of some class or other, and all your data will be kept in member
variables (known as *instance variables* in Java). Now this sounds needlessly complicated, but
when you're creating a Java interface between VRML97 and your database server, you'll be thankful.

The next concept to introduce is the idea of *inheritance*. There are two ways of creating
classes. Three if you count "out of paper and string", but you might have difficulty using those
ones online. The first way is to create your own, from scratch. You start with an empty class, and
there will be nothing in the class except what you put there. The other way is to use inheritance.
This involves taking a class that already exists (this will be your *base class*), and
extending it to add your own stuff to it. Now, this isn't like just editing someone else's source
code, but more like adding bits on. A *derived* class (the one you've created) has all the
instance variables and methods of the base class, plus whatever you add to it. If you change the
behaviour of the base class, the behaviour of the derived class will change in the same way. Let's
look at an example...
```
Vehicle {
   colour;
   Drive();
}
```
OK, we have a base class of type vehicle. This isn't Java, by the way, don't get excited just yet.
The vehicle has one instance variable, colour. It also has a method, Drive(). Notice that
these are both things that apply equally to all things that could be considered vehicles. Now, if we
use a bit of inheritance to create a Car and a Truck...
```
Car extends Vehicle {
   num_doors;
}
Truck extends Vehicle {
   Unload();
}
```
We have created a couple of derived classes, both based on vehicles. This is a good example of the
idea behind classes and inheritance, actually. Derived classes will tend to be types of the base
class - cars and trucks are both types of vehicle. Anyway, Car has a new instance variable,
num_doors, and Truck has a new method, Unload(). For each derived class we can use the instance variables
and methods of both it and it's base classes, so a car has a colour and we can Drive() it. However, we
can't Unload() it, as this is a method of Truck, not Car. You should have the idea by now,
so we'll carry on. It's pretty easy once you've got the idea of classes down.

One more thing to talk about, and those are access modifiers. Sound daunting, but again really
aren't. Each variable or function in a class has an access modifier, which tells you who or what is
allowed to use it. Oh, I just have to introduce *packages* as well, which are just like a
collection of classes. Anyway, here's a list of the access modifiers and what they mean:

<DL>
<DT>public</DT>
<DD>Members (methods or instance variables) that are declared public can be accessed by anything, anywhere.</DD>
<DT>private</DT>
<DD>Private members can only be used by things inside the same class.</DD>
<DT>*default*</DT>
<DD>If a member does not have a modifier, it can only be used by things in the same package.</DD>
<DT>protected</DT>
<DD>Private members can be use by anything in the same package, or by derived classes in a different package.</DD>
</DL>

Don't worry if you don't understand this now, we'll see more of it later. It's important to
introduce it though, so you don't panic when you see all these words flying around. Classes can
also have access control, default or public, but until you get on to complex stuff, you don't need
to worry about it. For now, we'll keep all classes *public*, so anything can use them. So, with
all that out of the way, now we'll get on to Java itself and discuss how to write a basic VRML
Script class.

## A good tutorial on Java objects (A class class class, haha)

This section is going to dive straight in and introduce the syntax of the sort of class you can use
directly in a Script node. I think what we'll do it just make a class and then I'll explain it
afterwards. Here we go...
```
import vrml.node.*;

public class NewScript extends Script {
}
```
Blimey, a bit of actual Java! Stunning. Right, let's take it line by line, and start at the
beginning. The first line imports some stuff from the standard VRML Java package. This package is a
collection of classes that are used to interface to a VRML Script node. All your scripts will need
something like this. Don't worry about it for now, though, we'll cover that later.
The big long line is the class declaration. This tells us that this is a public class
(anything can use it), it's called NewScript, and it extends (inherits from) a base class called
Script. Script is the Java class that all VRML Java scripts are based on, and it provides the
general framework for your scripts. All your basic VRML script class declarations should look like
this, just with a different name. If you wanted to create a class from scratch, you wouldn't have
the 'extends Script' part. It's a bit dull so far though - let's add a couple of instance variables.
```
import vrml.node.*;

public class NewScript extends Script {

   public  int public_value;

   private int private_value;

}
```
There we go. We've now got two instance variables, one public and one private. Anyone will be able
to view the public one, but no other classes can see the private one. Also, notice here that Java
has explicit types for variables. In ECMAScript, we could change the type of a variable during
execution, and add members to objects even. No more. In Java, each variable has a particular type,
and it retains that type forever. I won't go through the types now, we'll meet them all later.
Suffice to say that these two are integers (whole numbers). So, our class is growing, but it doesn't
have any methods! What if we wanted to allow people to *read* the value of private_value, but
not write it. We can provide a function to do that!
```
import vrml.node.*;

public class NewScript extends Script {

   public int public_value;

   private int private_value;

   public int GetPrivateValue() {
      return private_value;
   }

}
```
Now, anyone can call GetPrivateValue to get the value of private_value, because the function is
public. It can read private_value, as it is part of the same class. Here you see that in contrast to
some other languages, the implementation of a function goes together with the declaration (it's all
in one lump). It's much like ECMAScript, really. I'm sure you understand it.

So there we have a *very* simple class, just demonstrating how these things fit together.
Let's see how we would use it in a VRML world. Obviously it won't do anything yet, but we'll cover
making your scripts actually work in a VRML world next time round.

## Ketchup collecting (compiling your source, haha)

OK, no more poor jokes now. Promise. For a while, at least. Now that you've written your Java class,
what are you going to do with it? Well, Java isn't like ECMAScript in that it's just a text file
that you can use in your worlds. You need to use a thing called a *compiler*, which takes
your source code (what you just wrote), and compiles it into language that the machine can
understand directly. In the case of Java, the compiler creates stuff called *bytecode*, which
can be executed on any system with Java on it, making it nice and portable across different
operating systems.

So, where to get a compiler? Well, almost any Java compiler will do as long as works on
*standard* Java. Those of you using Microsoft Visual J++ may have problems with this. There
are loads around, but there is one which is totally free, and everything you need. This is the
official Java 2 Platform from Sun. You can get it at <A HREF="http://java.sun.com"
TARGET="_top">java.sun.com</A>. Download it, install it, and you're off! It doesn't provide a nice
interface, but it is free and does everything you need. Just write your code in a text editor and
use a command prompt to use the compiler. I use it for all my Java, so it's what I'll use for
the examples in this and subsequent tutorials.

In order to create a usable class out of our NewScript example, we perform the following steps. Save
the source code into a file called <FONT FACE="courier">NewScript.java (it's important that
it has the same name as the class defined in it - also, each source file can only contain one
class). Then, run the following command:
```
javac -target 1.1 NewScript.java
```
This should run the compiler (assuming it's installed right) and create a file for you called
<FONT FACE="courier">NewScript.class. This is the bytecode for the class you've just written.
If there are any errors in what you've written, the compiler will tell you about them when you run
it. One quick note - you need the "-target 1.1" bit in the javac command line because most VRML browsers only have Java 1.1 virtual machines in them. Chances are that you'll be using a more recent version of java to compile, so you have to tell the compiler to make code compatible with Java 1.1.

There's only one thing you need to do extra to create VRML Java scripts, and that's tell the Java
compiler where the VRML standard classes can be found. The JDK installation sets an environment
variable in your operating system called CLASSPATH, which contains the paths to all the standard
classes. You need to add the VRML classes to this CLASSPATH in order to compile scripts properly.

The VRML classes are supplied with your VRML browser. Cosmo has a file called <FONT FACE="courier">npcosmop21.zip, which
contains them, and Cortona has a file called <FONT FACE="courier">classes.zip. You should be able to find these in the
browser's install directory. I don't know about other browsers, but if anyone does, please let me
know and I'll put it in. This information will be summarised on the <A
HREF="http://web3d.vapourtech.com/info/faq.html">FAQ</A> page of the Guide. Take a look there for
more info. Anyway, you need to add these files to the CLASSPATH. How you do this will depend on your
browser, operating system and setup. Consult the documentation for each or ask a knowledgeable
friend to do it for you if you can't handle it.

## Using classes in your worlds

Well, once you've got your class, you want to know how to use it in your VRML worlds. Well, all you
need to do is just use it's name in a script node as you normally would, like this:
```
Script {
   url "NewScript.class"
}
```
Obviously, you'll have a load of fields, eventIns, eventOuts and so on for the Script but I've left
them out above. The browser will look at the URL for the script, and go off and get it from wherever
you've told it to.

Well, I think that's about enough to digest for this time around. I'll leave you with that for now,
and next time we'll go on to making useful scripts that can send and receive events and so on. see
you next time!
