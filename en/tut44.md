---
title: "VRML97 Tutorial 4.4: ECMAScript Objects"
keywords: objects, object oriented, OOD, OOP, ECMAScript objects, functions, properties, this,
---

# Unidentified Flying Objects

In this tutorial, we're going to cover a more advanced feature of ECMAScript. You already know about
the simple data types, *number*, *boolean*, and so on. Now we introduce *objects*,
which are simply collections of other variables that you can use as if they are single variables. If
you think of the basic types as bits of paper that you can write information on, then you can
imagine an object as a box that can hold a number of these papers. You can pass the box around just
as you would a single bit of paper, but you can pass a lot more information at once, because you can
have lots of papers in the box. There is also the fact that you can group together related variables
into a single object. So, if you wanted to store a vector, rather than having three numeric
variables for the X Y and Z values, you would declare a Vector object that had three numeric values
inside it. The vector is now one object, and is much easier to handle in your program. See?

There are various things you can store in your objects, and we're going to start by looking at the
bits of paper, the *properties*.

## Properties

A property is simply a variable that lives inside an object, so is equivalent to one of the bits of
paper on which you can store information. To access the properties of an object, you use the
following notation. If *myObject* is an object and *x* is one of its properties, to use
the variable *x* inside *myObject* you would write:

```
myObject.x
```

You can then use this in assignments, calculations or whatever. For instance:

```
myObject.x = 3;
print(myObject.x);
```

would print out the value 3. All pretty simple so far, right?

## Methods

Now, properties are not the only things you can have inside your objects. They can also contain
*methods*. Now, these are exactly the same as normal ECMAScript functions, except they exist
only as part of an object. You can't use a method of an object if you don't have an
instance of that object. You could imagine methods as pixies that sit on the edge of the box,
if you like. Each pixie has a particular function. One might convert the bits of paper in the box
into a String for you and then give it back, or whatever. The main thing is that you can ask them to
do stuff for you. They disappear into the box for a minute (looking at the paper) and then come back
with results for you. You can pass parameters to these methods in the same way as you
did with normal functions.

Now, can anyone guess how to use methods of an object? Yep, you've got it. The same as
using properties (which makes sense). If *myObject* has a method called *multiply(num)*
which multiplies *x* by *num*, we can do the following:

```
myObject.x = 3;
result = myObject.multiply(4);
print(result);
```

This will print the value 12. Don't forget, you can always chuck around entire object like they are
normal variables as well, so we could also do something like this, assuming we have two objects and
the appropriate code inside the *multiply()* method:

```
myObject.x = 3;
myOtherObject.x = 4;
result = myObject.multiply(myOtherObject);
print(result);
```

This would take the entire object as a parameter and then get the appropriate information from it
inside the function. And again, it would print out 12. 

## Creating Objects

So, where do these objects come from? Well, objects are created using a special type of function
called a *constructor*. This is used to create an object of a certain type for you. Let's
continue with our Vector object. If we want to create a new object type called Vector, we need to
write a constructor for it. This is what it would look like:

```
function Vector(x, y, z) {
   this.x = x;
   this.y = y;
   this.z = z;
}
```

This is a constructor that takes some parameters, but you can have them without, like so:

```
function Vector() {
   this.x = 0;
   this.y = 0;
   this.z = 0;
}
```

Lets take a closer look at this constructor thing. First thing to notice is that the function name
is the same as your object. That's how the interpreter knows which function to use. The second thing
is that inside the function we use the keyword *this*. This (or *this*) is a very
important word, in that it always refers to the current object. Also, notice that the constructor
doesn't return anything. Because we are modifying the object's properties, we don't need to return
any values.

So how do we create these objects inside our programs? Well, we use another keyword, *new*,
like so:

```
myVector1 = new Vector();
myVector2 = new Vector(1,2,3);
```

The *new* keyword tells the interpreter that we are creating a new object, so it calls the
function after it as a constructor. You can see from the above code that *myVector1* will have all
its properties set to 0, because it use the constructor with no parameters, while *myVector2* has the
values x=1, y=2, z=3. 

Once you have an object, you can add new properties to it by simply assigning values to them. If you
suddenly feel that *myVector2* should have a name, you can give it one by writing:

```
myVector2.name = "bob";
```

Let's now try to add a method to our object. This is quite a simple thing to do. If you
have a function that you want to add, say a scalar multiply of your Vector, you write the function
for it like so:

```
function vectorMultiply(scalar) {
   this.x *= scalar;
   this.y *= scalar;
   this.z *= scalar;
}
```

This is the function that will do the work. It will multiply each property of the object by the
scalar value passed to it. Now, how do we make it a method? Well, back to the constructor
again...

```
function Vector() {
   this.x = 0;
   this.y = 0;
   this.z = 0;
   this.multiply = vectorMultiply;
}
```

We have added the method *multiply*, which maps directly to the function
*vectorMultiply*. So, if we call myVector2.multiply(2), it calls the vectorMultiply() function
and does the business, altering the values in the object *myVector2*.

Take a look at this <A HREF="../worlds/tut44a.wrl" TARGET="_new">example</A> and its <A
HREF="../source/tut44a.html">code</A>. This is an example of a script that uses a constructor to create
a new object. The end result is that you have a texture displayed on a box which you can scale as
you want by dragging the red sphere around on the image. The red sphere will always correspond to
the top-right of the image.

As you can see, when the position of the sphere changes, the set_translation() method is called.
First of all, this checks two of the properties of the object it has been passed (an SFVec3f) to
make sure they never go to 0 (which would break the **TextureTransform**). A new SFVec2f object
is then created, using values calculated from the properties of the object passed into the method.
This is then sent out to the TextureTransform, where it updates the texture. This is an example of
using a script to do elementary type-conversion, in this case using the 3D position input from a
**PlaneSensor** to control a 2D scaling of a texture. Can you begin to see the possibilities that
are available using scripts?

The SFVec3f and SFVec2f objects used in that script are built-in VRML/ECMAScript objects that should
be provided in any VRML browser. We'll discuss them in a minute, after briefly mentioning *arrays*.

## Array Objects

I don't want to spend long on these. After this tutorial you should be going out and finding a
proper ECMAScript/javascript reference anyway, so I'll just brush over them quickly. *Arrays*
are normally a collection of variables that are all the same type. They are referenced by using the
name of the array followed by the zero-based index of the variable you want in square brackets. So,
if you had an array of numbers, myArray[0] would give you the first number, myArray[1] the second,
and so on. Now, the reason for bringing this up now is that some of the VRML types are basically
arrays, so I just thought I ought to tell you what they are and how they work. However, I think I'm
going to leave it at that for now. If we need arrays later, I'll explain then, otherwise I'll leave
it to you to look them up in a decent book or something. Now, we're going to get on to the useful
stuff, by seeing how VRML97 uses objects in ECMAScript.

## VRML Objects

If you want to create scripts in VRML that do more than just add a couple of numbers, you're going
to need to use the built-in VRML ECMAScript Objects. These are ECMAScript objects that are built
into your browser (though not all browsers have full functionality), which have as standard a
selection of properties, constructors and methods that you might find useful. For instance, the
SFVec3f object has various geometric operations within it that you can use, such as length,
normalise, dot and cross products, and so on.

Most VRML data types have an equivalent binding in ECMAScript, so an SFVec3f value in VRML is
equivalent to an SFVec3f object in ECMAScript. However, the simple types are mapped directly to
ECMAScript's built-in types:


* *SFFloat*, *SFInt32* and *SFTime* all map to the *numeric* datatype.
* *SFBool* maps directly to the *boolean* datatype. You can use the ECMAScript
*true* and *false* values, and also the VRML *TRUE* and *FALSE*.
* *SFString* maps to the ECMAScript *String* object.


All other VRML types map to ECMAScript objects, such as SFVec3f, SFColor, MFNode and so on. As well
as the standard types, another couple of objects are provided in the browser. These are the
*Browser* object, which can be used to get information from the Browser, and the
*VrmlMatrix* object, which is a 4x4 matrix useful for serious 3D geometry. If you need to use
this one, you'll probably have a decent grounding in 3D geometry anyway, so will already know how to
use it.

The SFxxx objects are all different, and have their own functions and behaviour as appropriate for
that type. Because they are all different, I'm not going to cover them all here. For more
information on what you can do with each type, I would refer you to the relevant section in the
specification, <A HREF="http://www.web3d.org/technicalinfo/specifications/vrml97/part1/javascript.html">Annex C</A>, the ECMAScript scripting
reference. This has full details of how all the built-in types work and what you can do with them.

I will just mention the MFxxx types, though, as they are all very similar. They are all basically
arrays of the appropriate SF type, and have very few functions. They all have one property,
*length*, which is the number of items currently in the list. They have one method,
*toString()*, which does exactly what it says on the tin. They also have only one constructor,
which takes a list of SF objects to put in the new MF object. This can be empty if you want to make
an empty array. You can access SF objects inside an MF object in the same way as you would access
any array, by using the square brackets with the index inside. So, *vectors[0]* gives the first element
in the MFVec3f object *vectors*, and *vectors[7]* gives the eighth. If you want to write to an SF object in an
MF object, you use the same notation. So:
```
var vectors = new MFVec3f();
vectors[5] = new SFVec3f(0,1,0);
```
assigns the new SFVec3f(0,1,0) to the sixth element in *vectors*. If you write into a position
past the end of an MFxxx array, the object will expand to allow you to write to it. So, you can
create an empty array as above and then write into it wherever you like.

This <A HREF="../worlds/tut44b.wrl" TARGET="_new">example</A> shows how you can use the many methods of the VRML97 built-in
types to create some great effects. This is a simple geometry tutorial world, which shows you how the
cross product of two vectors behaves when you move the vectors. You can imagine this sort of thing
being very useful in online maths courses and things like that. Anyway, what do we have? For a start,
there are two cylinders (red and green) which represent the two unit vectors. They are both attached to
**SphereSensor**s, so you can drag them around. The third (blue) cylinder represents the cross
product of the two vectors, i.e. red x green. The cross product is the vector that is orthogonal to
both vectors, and its length is dependent on the angle between them. You can't move the blue
cylinder, because it is generated by a **Script**, based on the positions of the other two cylinders.
Play with the example for a while until you understand what it does, and then have a look at the
<A HREF="../source/tut44b.html">code</A> to see how we get the effect.

To generate the cross product, we need two vectors. However, what we get from the
**SphereSensors** are rotations, so we first have to convert them into vectors. This is done in
the two event handlers by creating a unit vector and rotating it by the new rotation value of the
*eventIn* using the *multVec()* method of the *SFRotation* object. The
result is stored in a SFVec3f object for use when calculating the cross product. So, each time an
event is received (or when the world is loaded), we want to recalculate the cross product and output
it. This is done very simply in the *calc_cross_product* function. The first line actually does
the hard work of calculating the product. The rest converts it into a form we can use. So, first
we calculate the product of *vector1* and *vector2*, giving us our result,
*crossVec*. However, to get this vector into our VRML world, we need to convert it into a
rotation about the origin (to get the current orientation) and a length (to use as a scale factor).
These can then be applied to the blue cylinder in our world for a perfect result.

OK, let's deal with the scale factor first. We can get the length by simply using the
*length()* method of the SFVec3f type. However, we can't have a scale factor of 0, so we just
need to make sure it never gets there with an **if** statement. Now, we want to scale by this
amount in the Y direction, so we create a new SFVec3f to use as a scale *eventOut* with 1s in
the X and Z, and our new scale factor in the Y. Now, we need to set the rotation correctly. What
we'll do is use one of the constructors of the SFRotation type. It allows you to create a new
rotation using two vectors, one *from*, and one *to*. The rotation created will be the one
that rotates the *from* vector to the *to* vector. So, we create a unit vector in the Y
direction (the default position for our cylinder) and create a rotation using that and our cross
product vector. This is then the rotation we need to use as our output. Clever, eh?

You can see from this example that there are all sorts of useful methods available in the standard
VRML97 objects, and I can't possibly cover them all here. It's certainly worth sitting down for a
while and reading through the descriptions of the objects before you actually do any programming,
otherwise you might miss something that would make you life ten times easier!

## Fallen Angel

Well, now you're really ready to rock and roll as far as scripting with ECMAScript is concerned. If
you need a handy reference to the VRML97 ECMAScript Objects, there is a handy cheat sheet available
on the <A HREF="http://web3d.vapourtech.com/info/index.html">specs</A> page. This has a quick summary of all the properties,
constructors and methods for all the VRML97 Objects. If you're programming scripts in ECMAScript,
it's a very handy thing to have by your side. I would also suggest you now go and look at some
javascript references, and learn a little more about the other built-in objects, such as Date, Math,
Array, and so on.

Now, I know the last few have been a bit harsh, with a lot to take in, but teaching people how to
program in four tutorials isn't a simple thing. If you've made it this far, though, you'll be fine!
We've covered all the concepts you need to create scripts, and from now on it's plain sailing. Until
we convert to Java, of course...

Next time out, we're going to cover how to use the Browser object. This is a special object that
gives you all sorts of useful information, and also allows you to muck about with your world at a
really low level. Should be fun!

*Linux Penguin Logo &copy; Larry Ewing*
