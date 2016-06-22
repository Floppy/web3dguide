---
title: "VRML97 Tutorial 3.7: Switch"
keywords:  Switch
---

# Smack My Switch Up

The last thing we're going to cover in this part of the tutorial is the last thing that can
change the appearance of your worlds easily without much scripting. You do need a bit, but nothing too complex.
This is the **Switch** node, which allows you to have a number of choices for a node and switch between them at will.
The syntax is shown below:

```
Switch {
   exposedField   MFNode      choice            []
   exposedField   SFInt32     whichChoice       -1
}
```

The choice field contains a number of nodes, all of which must be valid *children* nodes. This means you can't switch
between **Appearance** nodes, you have to switch between **Shape**s with different appearances.

The *whichChoice* field is the number of the current selection. The choice nodes are enumerated from 0 to x, where x is one less than the number of nodes. So,
if you have 3 nodes in the *choice* field, they are numbered from 0 to 2. If this field is below 0 or higher than the maximum number, no
field is chosen. So, if you do not specify a value for *whichChoice* in the declaration of the node, nothing will be displayed until you select one.

The nodes within a **Switch** remain part of the scene at all times, even if they are not visible. This means that they can still generate, receive and process events even when not selected.So, a TimeSensor within a **Switch** will still generate events at the same rate whether it is chosen or not.

You will almost certainly need a little script to do the selection based on some other input, as the node requires
SFInt32 values to set the choice, but it's not hard. There is a small sample script in the example for this tutorial, included
as inline Javascript.

The switch node is really very simple. Therefore, that's all I actually have to show you in this tutorial. Take a look at this
<A HREF="../worlds/tut37.wrl" TARGET="_new">example</A> for a display of how the mode works. Each time you click on the sphere, it cycles round to the
next node in the **Switch**. Take a look at the <A HREF="../source/tut37.html">code</A> to see how it works. Especially, take a look at the script to
see how the cycling is done. If you need to use **Switch** before I cover scripting, you should be able to adapt the code for your own needs.

Just one more thing to cover in part 3, and then we've covered all the nodes in VRML! Next time out, we're going to take a look at LOD... see you there!

