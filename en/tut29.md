---
title: "VRML97 Tutorial 2.9: Billboard, Transform"
keywords: Billboard, Transform,
---

# Let's Twist Again...

## Billboards
Just a couple more things to cover before we get on to the cool animation stuff, and the first is the <STRONG>Billboard</STRONG> node.
This is really just a fancy <STRONG>Transform</STRONG> which automatically rotates to face the user. Needless to say, this is
quite handy for things like text labels, sprites, and so on and so forth. Let's take a look at the node itself and
see what we've got to play with.

<PRE>
Billboard {
   eventIn        MFNode      addChildren
   eventIn        MFNode      removeChildren
   exposedField   SFVec3f     axisOfRotation    0 1 0
   exposedField   MFNode      children          []
   field          SFVec3f     bboxCenter        0 0 0
   field          SFVec3f     bboxSize          -1 -1 -1
}
</PRE>

As with all grouping nodes, we have the <EM>addChildren</EM>, <EM>removeChildren</EM>, <EM>bboxCenter</EM> and <EM>bboxSize</EM>
fields and events, all of which we'll deal with later. We also have a <EM>children</EM> field, which contains the geometry
you want on you billboard. So, if you want a cube to always have the same face to the user, put it in the <EM>children</EM> field.
This leaves only the <EM>axisOfRotation</EM> field. This is the axis about which the billboard will rotate. The default is 0 1 0, which
is the y-axis. This is what you would normally want, so that the user can always see the board. However, if you have an object at an angle, or whatever,
you might want a different axis. There is a special case for billboards of an axis of 0 0 0. Normally, this is not a valid axis, but it
tells the billboard that it can rotate in ANY axis at all. Normally, when the board is rotating around an axis, if you are looking down that axis,
you will not see the billboard clearly. If you have an axis of 0 0 0, it will face the user no matter where they are.


Well, that's about it for the <STRONG>Billboard</STRONG>, very short but quite a funky thing to play with. Take a look at this <A HREF="../worlds/tut29a.wrl" TARGET=_new>example</A> and its <A HREF="../source/tut29a.html">code</A>
for a demonstration. All the trees are on billboards aligned with the y-axis, so they always face the user. 

## More Transforms
We covered the <STRONG>Transform</STRONG> node ages and ages ago, but there's more we can do with it. Last time, we only covered simple rotations, translations, and scalings. The complete <STRONG>Transform</STRONG> node is more complex than
that, however. The full definition is shown here:
<PRE>
Transform {
   eventIn        MFNode      addChildren
   eventIn        MFNode      removeChildren
   exposedField   SFVec3f     center            0 0 0
   exposedField   MFNode      children          []
   exposedField   SFRotation  rotation          0 0 1 0
   exposedField   SFVec3f     scale             1 1 1
   exposedField   SFRotation  scaleOrientation  0 0 1 0
   exposedField   SFVec3f     translation       0 0 0 
   field          SFVec3f     bboxCenter        0 0 0
   field          SFVec3f     bboxSize          -1 -1 -1
}
</PRE>
As you can see, this grouping node also has the <EM>addChildren</EM>, <EM>removeChildren</EM>, <EM>bboxCenter</EM> and <EM>bboxSize</EM>
fields and events. We'll cover these later with scripting and optimisation issues. For now, we'll leave them alone and concentrate on the other fields.
We've already covered the <EM>rotation</EM>, <EM>scale</EM>, <EM>translation</EM> and <EM>children</EM> fields. However, there are a couple of fields that govern how the rotations
and scalings are applied. The <EM>center</EM> and <EM>scaleOrientation</EM> fields transform the local coordinate system of the node while the other transformations are applied.

The <EM>center</EM> field affects the <EM>rotation</EM> and <EM>scale</EM> transformations. It defines the local origin of the transformation. So, if you define a <EM>center</EM> at 5 0 0,
the rotations and scalings are done relative to that point. The object will rotate around that point, which is equivalent to translating the object by the inverse of the <EM>center</EM>, rotating it, and
then translating it back again. This also affects scalings, so if you scale something but move the scaling origin, the scaling will scale all the coordinates of the object relative to the <EM>center</EM> instead of the local origin.

The <EM>scaleOrientation</EM> field has much the same effect on the scaling, only this time it's a rotation being applied instead of a translation. It give you the power to scale in arbitrary directions. With <EM>scale</EM>, you can only scale along the axes, which is a bit limited.
Using <EM>scaleOrientation</EM>, you can rotate the scaling directions for an object. It has the same effect as applying the inverse rotation, scaling, and then rotating back. Essentially, it rotates the scaling axes by the <EM>scaleOrientation</EM> field.

Take a look at this <A HREF="../worlds/tut29b.wrl" TARGET=_new>example</A> and the <A HREF="../source/tut29b.html">code</A> that goes with it. On the left, we have a rotation about an arbitrary point. The red point marks the <EM>centre</EM>, about which the green box has been rotated.
The purple boxes have been scaled. The centre one is a normal box, with no scaling. The box below it has been scaled by 2 in the X direction. The one above it has been scaled by 2 in teh X direction again, but with a <EM>scaleOrientation</EM> of 0 0 1 0.78. This rotates the X axis anticlockwise by 45 degrees, giving a strange-looking scaling.

## Do The Funky Chicken
That about wraps it up for the static stuff. Now, in Part 3, we're going to take a look at animation and stuff like that. Hold on!
