function footer(image_url, parent_name, parent_url) {

	document.write('<HR>');
	document.write('<TABLE BORDER="0" WIDTH="100%">');

	document.write('<TD>');
	if (parent_url) document.write('<A HREF="' + parent_url + '">');
        document.write('<IMG SRC="' + image_url + '" BORDER="0" ALT="' + parent_name + '" ALIGN=ABSMIDDLE>');
       	if (parent_url) document.write('</A>');
        document.write('</TD>');
	document.write('<TD><FONT SIZE="-1"><STRONG>&copy; <A HREF="http://web3d.vapourtech.com/legal.html">Copyright</A> 1998-2002 Vapour Technology Ltd. - <A HREF="mailto:&#103;&#117;&#105;&#100;e&#64;&#119;e&#98;&#51;&#100;g&#117;i&#100;&#101;&#46;&#111;&#114;g&#46;&#117;&#107;">&#103;&#117;&#105;&#100;e&#64;&#119;e&#98;&#51;&#100;g&#117;i&#100;&#101;&#46;&#111;&#114;g&#46;&#117;&#107;</A></STRONG>');
	
	document.write(Modified('<BR><EM>Last modified: ','</EM>'));

	document.write('</FONT></TD>');
	document.write('<TD ALIGN="RIGHT"><A HREF="http://www.vapourtech.com/" TARGET="_blank"><IMG SRC="http://web3d.vapourtech.com/pics/vapour.gif" BORDER="0" HEIGHT="25" WIDTH="130" ALT="Vapour Technology Ltd."></A></TD>');
	document.write('</TABLE>');
}

function Modified(start,end) {
	d=Date.parse(document.lastModified);
	if (d>0) {
		m=new Date(d); 
		y=m.getYear(); 
		if (y<100) y+=2000; 
		if (y<1900) y+= 1900;
		return(start+m.getDate()+'/'+(m.getMonth()+1)+'/'+y+end);
	}
	else return("");
}
