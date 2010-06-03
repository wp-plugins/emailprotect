function plug_emp(p3,p1,p2)
{
	var str = p1 + '@' + p2 + '.' + p3;
	var alink = '<a href="mailto:' + str + '" title="' + str + '">' + str + '</a>'
	document.write(alink);
}