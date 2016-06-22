---
title: "VRML97 Tutorial 4.1: VRML Scripting with ECMAScript"
keywords: VRML scripting with ECMAScript, VRML scripting with javascript, javascript, vrmlscript:, VRMLScript,
---

# More Tea, Vicar?

OK. In the previous three parts of this tutorial, we've covered most of the standard VRML97 spec.
Now, we move onto a completely new topic. We move away from the descriptive language of VRML towards
sequential programming. We're going to learn how to use the most powerful tool in the whole of
VRML97: scripting.

## Java, JavaScript, VRMLScript, or ECMAscript?

Hmmm. It seems like we've been here before. The first thing we need to clear up is confusion about
names of things, so that we know what we're talking about.  You've almost certainly heard of Java
and JavaScript. Java is a complete programming language created by Sun, which is platform-
independent. You compile your program into <EM>bytecode</EM>, which can then be executed on any
type of machine, as long as it has a Java <EM>virtual machine</EM> installed. Java is a full-featured
programming language suitable for large application development. JavaScript is a language developed
by Netscape with a similar syntax to Java (i.e. the language <EM>looks</EM> the same). However, it is
much less complete, and is not compiled.  It is intended to be used for scripting within web pages,
and as such is very simple. It consists of a core language and a number of external <EM>objects</EM>
which provide extra functionality such as communications with the current document or whatever.

Now, we get to the VRML-related bits. When VRML 2.0 was being proposed, they needed a simple
language to use for the scripting element of VRML. Java was to be supported, but they also wanted a
simple language for lightweight scripts. So, as they didn't need all the elements of JavaScript,
they started creating a cut-down version of it, essentially the core language components. The VRML
browser would provide external objects for interaction in the same way that a normal web browser
does. This was VRMLScript. However, before VRML97 was made into an official standard, core
JavaScript itself was standardised, and called ECMAScript. Seeing as this was basically the same as
VRMLScript, but was standardised, VRMLScript was abandoned, and VRML97 supports just Java and ECMAScript
in the <STRONG>Script</STRONG> node.

Unfortunately, it's not as simple as that. Not all browsers stick to the ECMAScript spec. Many
provide extensions to the core language that were introduced in JavaScript 1.2, while some still
only support basic VRMLScript. It can be awkward getting your code to work on different browsers
unless to stick exactly to the ECMAScript spec. So, in our first adventures into scripting, I'm
going to teach you just how to do it with ECMAScript. We'll cover the step up to Java later on. It's
not a big step, and ECMAScript is much better suited to beginners.

## Using ECMAScript in VRML

Because of the history involved, while browsers support ECMAScript in the script node,
you still use the "javascript: ..." URL protocol as discussed a couple of tutorials back. You can also
include inline VRMLScript by using "vrmlscript: ..." in the same way, but as we're going to ignore
VRMLScript to all intents and purposes, we won't worry about that. For now, all our scripting will
be done with inline ECMAScript.

You can include the ECMAScript code in a different file and reference that file in the <EM>url</EM>
field of the <STRONG>Script</STRONG> node. The standard extension for ECMAScript source is <EM>.js</EM>, so you would
have a file called <EM>filename.js</EM>. Anyway, like I said, we're going to inline ours for a while,
so don't worry about that. It's only really useful if you have many <STRONG>Script</STRONG> nodes using the
same code.

## Sequential Programming in ECMAScript

Now, I can't pretend to teach you the whole of ECMAScript in this tutorial. This is a VRML tutorial,
so all I'm going to teach you are the basics you need to do VRML scripting. Then we'll cover the
VRML-specific stuff. The rest of this tutorial is going to be a basic introduction to sequential
programming in general, and if you already know what you're doing in either ECMAScript or another
similar language, you'll probably want to skip it.

ECMAScript is a <EM>sequential</EM> programming language. This is unlike VRML, which is more
<EM>declarative</EM>. VRML declares an arrangement of various objects, each of which have various
attributes, and go together all at once to make a definition of a world. An ECMAScript program is a
sequence of commands that are executed one at a time to create the desired results. I'll start by
explaining a few basic concepts.

## Statements, Variables and Functions

An ECMAScript program is a sequence of <EM>statements</EM>, each of which executes certain commands.
For instance, the statement
<PRE>
x = a + b;
</PRE>
takes a and b, and adds them together. The result is then called x. Here is the first thing to
notice about ECMAScript statements - they end in a semicolon (;). This is not strictly necessary,
but it will save problems later if you end each statement with a semicolon. In the above statement,
you can also see an example of the next concept - <EM>variables</EM>. A variable is a way of storing
a piece of data in your program. In ECMAScript, variables can be of a number of types. These are
<EM>Undefined</EM>, <EM>Null</EM>, <EM>Boolean</EM>, <EM>Number</EM> or <EM>String</EM>. The only ones to
worry about for now are Boolean, Number and String. In the above statement, x, a and b are
variables, which have values. So, the values of a and b are added together and are assigned to x.
The = symbol doesn't actually mean 'is equal to', it means more 'takes the value of', so x takes the
value of a plus b. OK so far?
<PRE>
var x;
x = 3;
print(x);
x = x * 5;
print(x);
</PRE>
This is a slightly more complex piece of code. First of all, we declare a variable called x, using
the word <EM>var</EM>. Like the semicolons, this isn't always necessary, but it's a good idea to use
<EM>var</EM> to declare variable names. Then, we assign the number 3 to x. Then, we use a
<EM>function</EM> called print to print out the value of x. This will print the number 3. In the next
line, we assign x the value of x multiplied by 5. Because the right hand side is worked out first
and then assigned to the left, x takes the value 15, which is then printed out on the next line.
This is all fairly reasonable so far.

Now lets take a look at another building block - the <EM>function</EM>. A function is a piece of code
that performs a certain operation. The + operator is a function, as was the print(x) in the previous
example. Although they're used differently, they're essentially the same thing. We're going to
concentrate on the print(x) style for now. Functions have two important things: <EM>parameters</EM>
and <EM>return values</EM>. Parameters are the variables that go inside the brackets that you pass to
the function. The function then executes, and returns a variable back. This is the return value.
Imagine we have a function called <STRONG>square</STRONG>, which takes a single number as a parameter,
multiplies it by itself, and returns the result. We would use it like this:
<PRE>
var x, y;
x = 3;
y = square(x);
</PRE>
At the end of this piece of code, x will be 3 and y will be 9. Also here, you can see that we can
declare more than one variable per line. Now, let's take a closer look at the function itself. You
can create your own functions in ECMAScript in the following way:
<PRE>
function square(value) {
   var sq;
   sq = value * value;
   return sq;
}
</PRE>
The function is declared by using the word <STRONG>function</STRONG>, followed by the function name, followed
by a list of parameters in brackets. The parameters inside the brackets will be variables accessible
from inside the function. The statements that make up the function are enclosed inside curly
brackets. Inside the function you can see the declaration of a variable, the assignment to that
variable, and the <EM>return</EM> statement. This makes the variable sq the return value of the
function and ends the function's execution. The last line in any function should be the return
statement.

Well, that's quite a lot to take in in one go, and a lot to cover in such a short space. Next time
I'm going to cover a few of the basic constructs you can use in ECMAScript, such as loops,
conditionals, operators, and objects. See you there!

