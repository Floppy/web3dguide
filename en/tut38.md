---
title: "VRML97 Tutorial 3.8: LOD"
keywords:  LOD,
---

# These Are Small, But Those Are Far Away...

In the last tutorial in this part, we're going to cover the one remaining VRML node that we don't know about - <STRONG>LOD</STRONG>. OK, 
I hear what you're saying - all the other node names made sense! What the hell does LOD mean? Well, LOD stands for 
<STRONG>L</STRONG>evel <STRONG>O</STRONG>f <STRONG>D</STRONG>etail, and it allows you to display different objects 
depending on how far away the user is.

Why on earth would you want to do that? There are a few reasons - first of all, you could create cool effects with it. That's 
not a great reason for an entire node though. After all, you could create your own with a ProximitySensor, Script and Switch.
The real reason is for speed. If you want a world that displays quickly, you need to keep the number of faces in the scene
down. Now, imagine you've got a virtual art gallery, with a very intricate sculpture in one corner. The sculpture has thousands
of faces, and is very detailed. Now, from the other side of the room, you can't see all the detail, but it's still being drawn, 
thus slowing down the browser. If you only displayed the fully detailed model when the user was close to it, and used a 
low-detail version the rest of the time, you wouldn't waste time displaying detail that you can't see. Well, this is exactly 
what <STRONG>LOD</STRONG> does. If displays one of a list of nodes, depending on the distance of the user from a particular point.

So, how do you use the <STRONG>LOD</STRONG> node? Well, it's really very very simple. It's very similar to the Switch node, but it selects 
the choice automatically. Let's take a look at the definition of the node:
<PRE>
LOD {
   exposedField   MFNode      level             []
   field          SFVec3f     center            0 0 0
   field          MFFloat     range             []
}
</PRE>
As you can see, <STRONG>LOD</STRONG> is a pretty simple node. Firstly, the <EM>level</EM> field is the list of nodes that 
are displayed. These can be any valid child node, but bear in mind that the <STRONG>LOD</STRONG> will only display one of 
them at a time. If you want to display multiple objects, put them in a <STRONG>Group</STRONG>. <EM>center</EM> specifies the 
point from which the distance to the user is measured. This should normally be the centre of the object. The only other field 
is <EM>range</EM>. This field specifies the distances at which the level changes. The values in this field should be greater 
than zero, and specified in increasing order. So, lowest distance first, highest last. There should be 1 less value in this field 
than there are nodes in the <EM>level</EM> field. If the distance from the user to <EM>center</EM> is lower than the first 
entry in <EM>range</EM>, the first node in <EM>level</EM> is displayed. Otherwise, if the distance is lower than the second 
entry in <EM>range</EM>, the second node in <EM>level</EM> is displayed, and so on. If the distance is 
not less than the last entry in <EM>range</EM>, the last node in <EM>level</EM> is displayed.

You can see the LOD node in action in this <A HREF="../worlds/tut38.wrl" TARGET=_new>example</A>, and see how we've coded it 
<A HREF="../source/tut38.html">here</A>. There are three separate objects for the different levels of detail. 'lump_near.wrl' 
is the highest detail, 'lump_medium.wrl' is a medium version, and 'lump_far.wrl' is a very low detail model. If you switch 
between the Viewpoints in your browser, you can see the change in model during the transitions. If you are closer than 15 
metres, you see the high-res version; if you are closer than 50 metres away, you see the medium-res version, and otherwise 
you see the low-res version. Simple.

There's one more thing you can do with LOD. If you don't enter anything in the <EM>range</EM> field, the browser should work 
out which level to display in order to keep up a good frame rate. If you don't care when levels change (different browsers 
and different systems will change level at different times), then you can use it for automatic optimisation. However, I would 
say it's safer to specify your own range settings, as this feature is probably not supported in all browsers.

OK well, that about winds it all up for Part 3, VRML Animation. We've covered every node in VRML, and now we can do some serious scripting and start creating some really special effects. Hold on!
