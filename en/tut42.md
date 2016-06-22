---
title: "VRML97 Tutorial 4.2: ECMAScript types, operators, conditionals, loops"
keywords: variables, types, operators, conditional, loops, while, if, for, function,
---

# Loop The Loop

Last tutorial I gave you an extremely quick introduction to ECMAScript. I introduced functions,
variables, and statements. This time out, I'm going to explain how to do useful stuff with these
basic building blocks, so we can start to make useful VRML scripts.

## More About Functions and Statements

Just to recap; an ECMAScript program is made up of *functions*, which contain a sequence of
*statements*. These statements can do all sorts of things. They can declare variables, using
the *var* keyword, they can perform calculations, or they can call other functions. When a
functions is called, the function is executed and then the result returned to the point in the
program where the function call came from, and the program carries on. So, if we assume we start in
the *main* function, 

```
function main() {
   var a, b;
   a = 3;
   b = square(a);
   print(b);
}

function square(x) {
   return x * x;
}
```

will declare the variables a and b, and give a the value 3. Then, the function square(a) is
evaluated. This means it is called with the value of a (3), and returns a * a (9). B is then given
this value. The value of b is then printed, and we get the number 9 out.

OK, this all makes sense. You can see that in an assignment, the RHS (right hand side) of the
expression is evaluated and then assigned to the variable on the LHS (left hand side). All makes
sense so far? Good, lets take a look at some of the basic variable *types* we can use in ECMAScript.

## Basic Variable Types

Built in to ECMAScript, there are various *types*. These represent different types of data,
such as numbers, strings, and so on. Each variable you declare has a certain type. ECMAScript is
different from many other languages in that you do not have to tell the interpreter (the bit that
runs your program) what type your variables are. Also, a variable can change type, as shown below.

```
var a;
a = 42;
print(a);
a = "hello";
print(a);
```

At first, the variable a has no type, as it has not had anything assigned to it. Then, it is given
the value 3, making it a number. However, after this, we give it the value of "hello", a string. This
is all perfectly legal, and can take a bit of getting used to if you've come from more strongly
typed languages like Java or C. The different types are:
<DL>
<DT>**Undefined**
<DD>This is the type a variable has before it is assigned to. It has the value **undefined**.
<DT>**Null**
<DD>This is a type that signifies that the variable contains no data. It is not undefined, but it is
empty. This has only one value, **null**.
<DT>**Boolean**
<DD>This is a boolean **true** or **false** value, like a SFBool.
<DT>**String**
<DD>This can be any sequence of characters, like an SFString.
<DT>**Number**
<DD>This is a numerical type, which can contain any number in the range 2<SUP>53</SUP> to
-2<SUP>53</SUP>. The actual explanation of the range is a bit complex. Rest assured that if you
know enough to need to look it up, you don't need it explained by me. There are also the values **NaN**
(Not a Number), **+infinity**, **-infinity** and + and -0.
<DT>**Object**
<DD>This is a collection of **properties**. We'll leave this for now, and come back to it when it
becomes important.
</DL>

Just to go back to the example above briefly, in this piece of code there are two *literals*.
These are values that are actually typed into the program. Above, the number 42 and the string
"hello" are literals (string literals are enclosed in 'single' or "double" quotes). These cannot be
changed, and are physically part of the program, unlike the variables, which are temporary and can
change.

Now, we're going to move on to expressions and operators, and start to learn how we can perform
calculations.

## Operators

ECMAScript, and most other programming languages have a set of functions called *operators*,
which are basic operations that are defined for the simple types. You use these to build up your
program, along with other functions. I'm just going to give a brief overview of the most important
operators here, so you have a bit of knowledge of how these work before we start in earnest.

There are a number of different types of operators. There are the *unary* operators, which act
only on one variable. This is like a negation operator, which inverts the sign of a value.

```
a = -a;
```

- is a unary negation operator in this case.
Next, there are *binary* operators, which work on two values, like an addition operator:

```
a = a + 3;
```

There are also *relational* operators, which work on relationships between two variables. These
are like the greater-than (&gt) operator.

```
a = (b < 3);
```

If b is less than three, a will be assigned the boolean value **true**. Relational operators
return boolean values. Equality operators are also relational operators. The last type we're going
to cover now are logical operators. These are AND and OR operators, which work on boolean values.
The table below is a list of all the simple operators, and a brief description of what they do and
how to use them.

**Unary operators**
<TABLE BORDER=1 CELLSPACING=0>
<TR><TD>Operator</TD>
<TD>Description</TD></TR>
<TR><TD>-</TD>
<TD>Negates the argument</TD></TR>
<TR><TD>!</TD>
<TD>NOT operator. !**true** is **false**, !**false** is **true**</TD></TR>
<TR><TD>++</TD>
<TD>Increments (adds 1 to) the argument.</TD></TR>
<TR><TD>--</TD>
<TD>Decrements (subtracts 1 from) the argument.</TD></TR>
<TR><TD>typeof</TD>
<TD>Returns a string containing the type of the argument.</TD></TR>
</TABLE>

Before we cover binary operators, one small point about the increment and decrement operators. These
can come either before or after their argument, depending on how you want them to work.

```
var a = 3;
var b = a++;
```

In this case, at the end, b will be 3 and a will be 4. The value of a is used in evaluating the RHS
of the statement, and is then incremented.

```
var a = 3;
var b = ++a;
```

Here, b will be 4 and so will a. The value of a is incremented and then used in evaluation.

**Binary operators**
<TABLE BORDER=1 CELLSPACING=0>
<TR><TD>Operator</TD>
<TD>Description</TD></TR>
<TR><TD>+</TD>
<TD>Addition</TD></TR>
<TR><TD>-</TD>
<TD>Subtraction</TD></TR>
<TR><TD>*</TD>
<TD>Multiplication</TD></TR>
<TR><TD>/</TD>
<TD>Division</TD></TR>
<TR><TD>%</TD>
<TD>Modulo (Integer Remainder)</TD></TR>
</TABLE>

**Relational operators**
<TABLE BORDER=1 CELLSPACING=0>
<TR><TD>Operator</TD>
<TD>Description</TD></TR>
<TR><TD>&lt</TD>
<TD>Less-than</TD></TR>
<TR><TD>&gt</TD>
<TD>Greater-than</TD></TR>
<TR><TD>&lt=</TD>
<TD>Less-than or equal</TD></TR>
<TR><TD>&gt=</TD>
<TD>Greater-than or equal</TD></TR>
<TR><TD>==</TD>
<TD>Equality</TD></TR>
<TR><TD>!=</TD>
<TD>Inequality</TD></TR>
</TABLE>

**Logical operators**
<TABLE BORDER=1 CELLSPACING=0>
<TR><TD>Operator</TD>
<TD>Description</TD></TR>
<TR><TD>&&</TD>
<TD>Logical AND</TD></TR>
<TR><TD>||</TD>
<TD>Logical OR</TD></TR>
</TABLE>

The relational operators return boolean values, depending on how they evaluate. Well, That about
wraps up operators. Now, we can put them to use! We're very close to being able to write scripts in
VRML.

## Conditionals

There's a few things you still need to know before you start scripting. There are certain types of
statement that allow you to build choice into your programs, to create more complex behaviour. These
are *loops* and *conditionals*. We'll cover conditionals first.

A conditional statement allows you to check something in your program and make a choice based upon
the result. The first conditional statement we'll look at is the **if** statement. This is of the
form

```
if (*boolean expression*) *statement*;
```

or 

```
if (*boolean expression*) {
   *statements*
}
```

Now, these are actually exactly the same. A *block* of statements (enclosed in curly brackets)
looks the same from outside as a single statement. So, whenever you are allowed to put a single
statement, you can put a sequence in curly brackets.

Anyway, back to the **if**. The value in brackets is a boolean expression, so an expression that
evaluates to a boolean result. If the result is **true** the statement (or statements) following
are executed. If it is **false**, they are not. So, the following code will print "hello" if a is
equal to the number 3.
```
if (a==3) print("hello");
```
There is another construct we can use with the **if**. This is the **else** statement. This
must follow the **if** statement, and is executed if the boolean expression is **false**.
```
if ((a==3) || (b==4)) print("hello");
else print("goodbye");
```
This will print "hello" if a is 3 or b is 4, or "goodbye" if neither. Simple!

OK, all very simple so far. However, now we come across the only *ternary* operator. This is
the *conditional operator*. This is really a shorthand for an **if..else** statement. It
works like this:
```
*test* ? *true_statement* : *false_statement*;
```
This can be used in places where a full **if** statement might be a bit bulky and messy. For
instance, to assign a value to a variable based on another:
```
var b = (a<4) ? 3 : 5;
```
If a is less than 4, b will be 3, otherwise it will be 5.

## Loops

ECMAScript has two basic loops, the **while** loop and the **for** loop. These allow you to
perform a statement or set of statements until a condition is met. Let's take a look at the
**while** loop first.
```
while (*boolean expression*) *statement*;
```
As for the **if** statement, you can have a block of statements in place of the single statement.
The **while** loop tests the boolean expression before the statement is executed. If the result
is **true**, the statement is executed. Then, the expression is evaluated again and the process
repeats. So, the loop executes until the expression is **false**.
```
var a=0;
while (a<3) {
   a = a + 1;
}
```
This loop will execute until a is not less than 3, so the loop will execute three times, and
afterwards a will be 3.

The other type of loop is the **for** loop. This has the form
```
for (*initialiser*; *boolean expression*; *loop_statement*) *statement*;
```
This, as you can see, is a bit more complex. There are three parts to the control structure of the
loop. The first part is executed before the loop starts, so only happens once. The second part is
like the boolean expression in the **while** statement. If it is **true**, the loop executes,
otherwise it exits. The third part, the loop statement, is executed each time the loop restarts. So,
looking at an example...
```
var a;
for (a=0; a<3; a++) {
   print(a);
}
print("done");
```
This code declares a variable a. Then, the **for** loop starts. a is assigned the value 0 in the
initialiser. Then, the test is executed. a IS less than 3, so the loop body executes, printing the
value 0. Then, a is incremented by the loop statement. The test is then executed again. a is still
less than 3, so the loop body executes again, printing the value 1. a is incremented again, tested
again, and the loop executes again, printing 2. a is incremented, to become the value 3. This time,
the test is **false**, as a is NOT less than 3, so the loop finishes, and the program continues,
printing "done". All very easy.

There are just two more things to cover before we finish this up. These are the **break** and
**continue** statements. These can sometimes be useful if you want to change how a loop
functions. A break statement will immediately break out of the loop body and continue with the
program. A continue statement will stop the current execution of the loop body and skip to the next
iteration of the loop.
```
var a=0;
while (a<2) {
   print("hello ");
   a++;
   break;
}
print("goodbye!");
```
This will print "hello goodbye!", as the loop is broken out of on the first iteration by a break
statement.
```
var a=0;
while (a<2) {
   print("hello ");
   a++;
   continue;
   print("hi ");
}
print("goodbye!");
```
This will print "hello hello goodbye!", as the loop is stopped halfway through and restarted by the
continue statement. You shouldn't need these statements very much, but they're always useful to
know.

## Corkscrew

Well, that was another huge amount of information to take in, but now you should be ready to attack
VRML scripting properly! If you want more information on ECMAScript programming, there are plenty
of Javascript resources out there. Just remember that ECMAScript is only core Javascript 1.0, so
enhancements in later versions won't necessarily work. You can get a free copy of the official
ECMAScript spec from <A HREF="http://www.ecma.ch" TARGET=_top>ECMA</A> themselves. Next time, we're
going to have a go at creating our first script. It won't do anything amazing just yet, but we'll
get there, I promise. Next time, we'll be back to the practical VRML stuff. About time, too!

