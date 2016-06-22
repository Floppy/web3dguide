---
title: "VRML97 Tutorial 1.2: WorldInfo, Shape, Inline"
keywords: WorldInfo, Shape, Inline
---
# In The Beginning...

This time out, we're going to cover the basic node types in a VRML file, the **WorldInfo** node, and the **Shape** node.

## WorldInfo

OK, now we can start to add information to the file. The first node to deal with is the **WorldInfo** node. This
node contains general information about the world, such as a title for the world. This is displayed in the title bar
of the browser window, the same as a TITLE tag in HTML. **WorldInfo** can also contain an info string, which contain other
information about the file. You can put what you like in this, such as keywords for search engines, or whatever.
A sample **WorldInfo** node is shown below:

```
WorldInfo {
   title "Floppy's VRML97 Tutorial Example 1"
   info ["(C) Copyright 1999 Vapour Technology"
         "&#103;&#117;&#105;&#100;e&#64;&#119;e&#98;&#51;&#100;g&#117;i&#100;&#101;&#46;&#111;&#114;g&#46;&#117;&#107;"]
}
```

You can have multiple strings in the info field, by putting them all inside square brackets. The
title does not need square brackets, as it is only a single string. A VRML file can have as many
**WorldInfo** nodes as you like, but only the first will be parsed. The rest will be
ignored.

## Basic Shapes

Now, this is all very nice, but no good at all at the moment, as there's nothing to see! Let's add a simple object to the scene.
We'll add a **Box** object, with the default values, just so you can get the idea of how the structure works.
There are a number of nodes required, such as **Appearance** and so on, but just ignore those, they're for the next tutorial.
Just remember, if you don't specify a value for a field, it will use the default. So, this will use the default values.
We add a **Shape** node to the world now, as shown below.

```
Shape {
   appearance Appearance {
      material Material {
      }
   }
   geometry Box {
   }
}
```

This adds a **Shape** node, which contains two fields for describing an object. These are the **appearance**
and **geometry** fields, which describe the look and shape of the object respectively. These will be covered in a later tutorial. For now, 
it is enough to have a Box with the default values and colours in our world.

## Object Reuse

If you have a lot of identical objects, it's often awkward to keep writing in many objects of exactly the same type. Therefore, you can reuse 
previous definitions. Using our box, we could define it to have the name FBOX. Then, whenever we want to use that box again, we can just type USE FBOX instead of the
complete definition. An example is shown below.

```
DEF FBOX Shape {
   appearance Appearance {
      material Material {
      }
   }
   geometry Box {
   }
}

USE FBOX
```

Not that this is a bit of a daft example, as it would create two boxes in exactly the same place.
Not normally what you want. Usually, you would USE the definition somewhere a bit more meaningful.
Also, you can DEF/USE any type of node, so if you just wanted to reuse the **Appearance** of an
object, you can do that as well.

```
Shape {
   appearance DEF APP1 Appearance {
      material Material {
      }
   }
   geometry Box {
   }
}

Shape {
   appearance USE APP1
   geometry Box {
   }
}
```

Again, you're not going to see anything stunning here, as the two boxes are in the same position in
the world, but you get the idea.

Another way to reuse VRML code is to use **Inline** nodes. These take the data from an external file and insert it into your file.
So, if you had a model of a chair called *chair.wrl* you could insert it into your scene like so:

```
Inline {
   url "chair.wrl"
}
```

The file you are including in this way has to be valid VRML, so it must have the headers and everything that a normal VRML world has to have. If you
can't load it legally into a browser, you can't inline it either.

## End Bits

The complete code for the world as it stands so far is shown <A HREF="../source/tut12.html">here</A>.
Notice that although we've DEFed the box to be called FBOX, we've not USEd it anywhere. That's
because we only want one box at the moment. We'll USE the box next time round when we learn how to
position objects around the world.


You can see what this all looks like (not particularly impressive yet) by checking it out the way its meant to be seen. You can use this to get used to moving around in your browser as well, and using the different types of movement.<BR>
<A HREF="../worlds/tut12.wrl" TARGET="_new">Tutorial 1.2 World</A>


That concludes the tutorial for the absolute basics, with a grey box in an otherwise empty world. Thrilling, isn't it. 
Never mind, we'll get onto more complex stuff later on. There's PointSets, Backgrounds, Animation,
Sensors, Lights, Cameras and everything. You'll see! It really is quite cool later on, trust me.
