function plug_emp(a, p3,p1,p2)
{
	var str = p1 + '@' + p2 + '.' + p3;
	
	if(a == 0)
	{
		document.write(str);
		return;
	}
	
	var alink = '<a href="mailto:' + str + '" title="' + str + '">' + str + '</a>'
	document.write(alink);
}