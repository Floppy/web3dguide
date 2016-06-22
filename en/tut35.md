---
title: "VRML97 Tutorial 3.5: Bindable Nodes"
keywords: Bindable nodes, Fog, Background, NavigationInfo, Viewpoint, bind stack,
---

# A Change Is As Good As A Rest

This tutorial is going to cover *bindable* nodes. Now, these aren't new nodes, just a new way of using them.
Certain nodes that affect the general appearance and behaviour of the world are *bindable*, that is they can be *bound* and *unbound*.
When a node is bound, the settings within it affect the state of the world. When a node is *unbound*, another node of the same type must be bound, so the
settings in this other node affect the world. In this way, you can switch between a number of different settings for a world by setting which of the nodes is bound.


We've already met all of the bindable nodes, so you should know what they do already. These are the ones:


* **Background**
* **Fog**
* **NavigationInfo**
* **Viewpoint**


As you can see, we've come across all these before, and as you should know, they all affect the overall appearance and
behaviour of the world. Now, it's time to discuss the internals behind node binding; how it all works.

## The Bind Stack

OK. The browser maintains four structures inside its inner workings, one for each type of bindable node. These are called
**bind stack**s. When a VRML file is parsed, the first node of the appropriate type is placed on top of its respective bind stack.
Subsequent nodes are added to the bottom of the stack. The currently bound node (ie the one that is active) is the one one the top of the
stack. Once the world has loaded, we can manipulate the stack with a certain set of events.

## Binding Nodes

All bindable nodes have a couple of events in common. They all have the *set_bind* eventIn and the *isBound* eventOut.
These are both **SFBool** values. When you send a *set_bind* event to a node with a value of TRUE, it is moved to the
top of the stack, and so becomes the bound node. This node will then send a TRUE *isBound* event. The node that was on the
top of the stack sends a FALSE *isBound* with the same timestamp. One exception, which is that if the node is already on top of
the stack, nothing happens and no events are sent.

If you send a FALSE *set_bind* event to a node, it is removed from the stack for good. If this is the bound node, it sends a FALSE *isBound*, and
the next node in the stack is made the bound node. If not, it is simply removed without further ado.

If you send *set_bind* events to a node that has been removed from the stack, it has no effect and nothing further happens. If a node is deleted, it acts as though
is was sent a *set_bind* FALSE event.

## Using Bindings

Now that you know how to use bindings, what are they useful for? Well, being able to change the background and fog styles is quite useful, as you can imagine.
Also, by using different NavigationInfo nodes, you can resize your avatar, change the movement style, all sorts of things.

However, the most useful node is the **Viewpoint**. If you bind the user to a viewpoint, he will be moved there instantly in the style defined in the node (ie its *jump* field)
This means you can have scripts moving the user around the world, by binding to different viewpoints. Another effect of binding to a viewpoint is to set the user's position
in the transformation hierarchy. So, if you are moving an object around the world, and you bind the user to a viewpoint grouped together with that object,
the user will be animated at the same time as the object. 

## Fully Rested...

This <A HREF="../worlds/tut35.wrl" TARGET="_new">example</A> and its associated <A HREF="../source/tut35.html">code</A> shows the uses of bindings. All the user interaction is
done with bindings, no scripts or anything. The small yellow sphere is a switch that temporarily binds the user to a **Viewpoint** on the moving platform around the outside.
The effect is only temporary as the **TouchSensor** generates a FALSE event on release that moves the user back to the middle. This can be fixed, but we need a bit of scripting to do it. For the meantime, hold down the button to
get the effect. The three coloured switches temporarily swap **Background** nodes around in the same way.

Right then, that's all you need to know about binding nodes. Next time I'm going to give a brief introduction to script nodes and how to use them in your worlds.
We're not going to cover writing them, just how to plug them together into your worlds.

