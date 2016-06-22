---
title: "VRML97 Tutorial 1.6: Anchor"
keywords: Anchor, WWWAnchor, link,
---

# Get Off My Land!

This is only going to be a little one, as making something into a link is very very simple. Great, not much typing to do!

## Anchor

In VRML, you navigate between pages the same way as in HTML. You have an object that, when the user clicks on it, links to another page.
Exactly what you're all used to. In VRML, this is done with the **Anchor** node.

```
Anchor {
   children [
      USE HEAD
   ]
   description "Back to the Tutorial"
   url "tut16.html"
}
```

The **Anchor** node is activated whenever one of its children is clicked, and opens up the page specified
in **url**. The **description** field is a piece of text that appears somewhere in the browser when the mouse 
is over the hyperlink, just as in HTML.


There are a couple of extra fields not shown above. One of these is **parameter** field, which can take extra information, such as a frame name.

```
parameter [ "target=main_frame" ]
```

There are also two fields concerned with bounding boxes. These are concerned with providing a bounding box for the VRML browser to speed up its 
calculations when rendering the scene. The two fields are **bboxCenter** and **bboxSize**. I wouldn't worry about them, but if you do, make
sure the size is big enough to fit all the children of the object in. Both take X Y Z values as arguments.

## That was quick

That's all for that one. Wahey! Take a look at the world so far. You can click on the head to come back here.<BR><A HREF="../worlds/tut16.wrl" TARGET="_new">Tutorial 1.6 World</A> with <A HREF="../source/tut16.html">code</A>.


So, now you know enough to create a usable, useful world. Not *very* exciting yet, though. Soon we'll cover lighting, cameras, animation and scripting, and then
we'll start to see some really impressive stuff.
