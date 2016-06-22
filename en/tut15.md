---
title: "VRML97 Tutorial 1.5: Box, Cylinder, Cone, Sphere, Text, FontStyle"
keywords: shapes, Box, Cone, Cylinder, Sphere, Text, FontStyle, fonts
---

# The Shape Of Things To Come

This section of the tutorial is going to cover the basic types of geometry node. These are Box, Cylinder,
Sphere, Cone and Text. There are more types, but they are more advanced and will be explained later on in another section. So, without
further ado, let's get on with it! This one shouldn't take long...

## Box

The **Box** is exactly what is says, a cube or cuboid shape. The default **Box** is a cube, two metres to a side, centred on the origin.
To make a **Box** of a different size, you can define it with an explicit size:

```
geometry Box {
   size 5.5 3.75 1.0
}
```

This creates a **Box** with X, Y and Z dimensions as specified in the **size** parameter.


Textures are mapped onto the **Box** by applying them individually to each face. The texture is applied the obvious way up 
to the sides, and applied to the top so that if it is tilted towards the camera, the texture is the right way up. The bottom is texture-mapped the
opposite way, so if the bottom is tilted towards the camera, the texture is the right way up still.

## Cylinder

The **Cylinder** node is slightly more complex. The default is a cylinder from +1 to -1 in all dimensions, the same as the **Box** above (radius of 1, height of 2). This too is centred on the origin.
To specify a different size, we can use the **radius** and **height** fields. There are also three other fields, **side**, **top**, and **bottom**.
These are Boolean values (TRUE or FALSE), and tell the browser whether to display the appropriate section of the cylinder. These default to TRUE, so you don't need 
to put them in at all most of the time. However, if you had a cylinder where an end was obscured by another object, it would be worth turning off that end, as it
will reduce the amount of work for the browser, speeding up the execution of your world.
```
geometry Cylinder {
   radius 0.5
   height 10
   top FALSE
}
```

This gives a tall, thin cylinder with no top.


Textures are wrapped around **Cylinder**s so that the edges of the texture meet at the back. Circular pieces are cut out of the texture and applied
to the top and bottom in the same orientation as for the **Box**.

## Cone

Again, much the same as the Cylinder, except that instead of a **radius** field, we have a
**bottomRadius**, which does exactly what it says it does. Also, there is no **top** field, as
cones don't tend to have tops. Normally.

```
geometry Cone {
   bottomRadius 5
   height 10
   side TRUE      #this isn't actually needed, because it's the default.
   bottom FALSE
}
```

Textures are applied in the same way as for cylinders. The default value is a cone of the same dimensions as the **Cylinder** and **Box**.
The centre of this  one is a bit more difficult to visualise. The centre is in the middle, halfway up the cone. Now, when you consider the bounding
box of the cone, it seems obvious, but it's not totally intuitive. So, a default cone will extend 1 metre above the Y plane and 1 metre below, having a radius of 1 at the bottom.

## Sphere

A **Sphere** node has only one field, which is its **radius**. Hmmmm, that was easy.

```
geometry Sphere {
   radius 10,000,000
}
```

That's one very BIG sphere. Anyway, textures are applied by wrapping the texture around the sphere, and then pinching in the top and bottom. 
So, If you had a texture with a grid on it, the vertical lines would get closer together at the top and bottom, while the horizontal lines would stay the same distance apart all the time.

## Text & FontStyle

This node creates some 2D text in the world. It's all very simple really, unless you want to do more complex stuff using FontStyle. The **Text** node has only four fields. The first is 
**string**, where you define the string or list of strings to display. The **fontStyle** field contains a **FontStyle** node, which I'll cover in a minute.
The last two fields are **maxExtent**, where you specify the maximum width (in metres)  of the text, and **length**, which is a list of lengths (again, in metres) for each string, so you can
specify a specific width for each of them. If **length**s are specified, the browser will resize the text to fit in that size.

```
geometry Text {
   string ["Hello", "World"]
   fontStyle USE HELLOFONT
   maxExtent 5
   length [3, 3]
}
```

OK, that's the **Text** node then, all very simple stuff. **FontStyle** is more complex. The best way to start here
is to list all the fields.

```
FontStyle {
   size
   family
   style
   horizontal
   leftToRight
   topToBottom
   language
   justify
   spacing
}
```

OK then. **size** is the height, in metres, of the line of text. The **family** field can take one
of three values, and alters the typeface of the font. The three types are "SERIF", "SANS", or "TYPEWRITER". These are
all fairly self-explanatory. To change the look of the text, you can use the **style** field. This can be any of "PLAIN", "BOLD", "ITALIC", or "BOLD ITALIC".
**horizontal** is a boolean value showing whether the text is horizontal ("TRUE") or vertical ("FALSE"). **leftToRight** and **topToBottom** are also boolean,
and are fairly obvious in their operation. The same utf-8 string can appear differently, depending on which language
it is in, so this is a two-character code for the language. I really don't know what the codes are, so it's probably
best to ignore this field.
**justify** is very useful, and can be any of "BEGIN", "MIDDLE", or "END". **spacing** is the amount of space between the lines of text. 1 is normal, and 2 corresponds
to double-spacing (a blank line between each line).


That's **FontStyle** then. You can really ignore most of the fields, but things like the **style**, **family**, and **justify** are very useful.

## Happily Ever After

All the geometry nodes so far ( and all the others we'll meet later on) are centred on the origin of the local coordinate system. When we get onto more complex objects, this becomes more obvious.
For now, just remember that the point you position with transforms and so on is the centre of the object.
Right then, that's about it for this tutorial then. To see what we've done so far, take a look at <A HREF="../worlds/tut15.wrl" TARGET="_new">Tutorial 1.5 World</A> and its associated <A HREF="../source/tut15.html">code</A>.


So, now we have a small monument type thing, topped by a green plastic column with a replica of my head on the top. Groovy.
That's all then, carry on to the next lesson, which is a tiny little short one about linking to the outside world. Should be easy...