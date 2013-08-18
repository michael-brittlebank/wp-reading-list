<!-- hide script from old browsers

var gw;
var lw;
var linkdefault;

function saveVars() {
	gw = document.getElementById("wprl-options-grid-width").value;
	lw = document.getElementById("wprl-options-list-width").value;
	linkdefault = document.getElementById("wprl-options-url").value;
        }
window.onload = saveVars;

function numValGrid()
{
	var g=document.getElementById("wprl-options-grid-width").value;
	if (isNaN(g))
	{
		alert("That is not a number.");
		numValHelper(1);
	}
	else if (g > 600)
	{
		alert("That is too large of a value. Please choose something smaller.");
		numValHelper(1);
	}
	else if (g < 60)
	{
		alert("Please choose a value larger than 60.");
		numValHelper(1);
	}
	else
	{
		document.getElementById("wprl-options-grid-height").value = Math.round(g*4/3);
	}
}

function numValList()
{
	var l=document.getElementById("wprl-options-list-width").value;
	if (isNaN(l))
	{
		alert("That is not a number.");
		numValHelper(2);
	}
	else if (l > 600)
	{
		alert("That is too large of a value. Please choose something smaller.");
		numValHelper(2);
	}
	else if (l < 60)
	{
		alert("Please choose a value larger than 60.");
		numValHelper(2);
	}
	else
	{
		document.getElementById("wprl-options-list-height").value = Math.round(l*4/3);
	}
}

function numValHelper(docObj)
{
	if (docObj == 1)
	{
		document.getElementById("wprl-options-grid-width").value = window.gw;
	}
	else if (docObj ==2)
	{
		document.getElementById("wprl-options-list-width").value = window.lw;	
	}
}

function linkCheck()
{
	var link = document.getElementById("wprl-options-url").value;
	if (isUrl(link))
	{
		alert('Do not enter a full Url here. That is reserved for the individual books. Instead just add what comes after the normal url, usually prefaced with a "?".');
		document.getElementById("wprl-options-url").value = window.linkdefault;
	}
	else if (link.length > 30)
	{
		alert('Sorry, the text you entered is too long.');
		document.getElementById("wprl-options-url").value = window.linkdefault;
	}
}

function isUrl(s) {
	var testFor =new Array("http","https","ftp","ftps",".com",".net",".org",".edu",".gov",".int",".mil",".biz",".info",".jobs",
	".mobi",".name","@");
	for (i=0;i<testFor.length;i++)
	{
	 	if (s.indexOf(testFor[i])!= -1)
	 	{
	 		return true;
	 	}
	}
	return false;
}













// end hiding script from old browsers -->