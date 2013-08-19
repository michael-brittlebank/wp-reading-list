/*FILE: wp-reading-list-admin-script.js
*DESCRIPTION: Browser-side admin functions
*/
<!-- hide script from old browsers

var gw;
var linkdefault;
var row;
var titledefault;

function saveVars() {
	gw = document.getElementById("wprl-options-grid-width").value;
	linkdefault = document.getElementById("wprl-options-url").value;
	row = document.getElementById("wprl-options-list-size").value;
	titledefault = document.getElementById("wprl-options-title").value;
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

function numValHelper(docObj)
{
	if (docObj == 1)
	{
		document.getElementById("wprl-options-grid-width").value = window.gw;
		document.getElementById("wprl-options-grid-height").value = Math.round(window.gw*4/3);

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

function deleteConfirm(){
	var r=confirm('Deleting your books is permanent. If you are really sure that you want to delete your books, click "Ok".');
	if (r==true)
  	{
		document.getElementById("wprl-options-delete").checked=true;
  	}
	else
  	{
		document.getElementById("wprl-options-delete").checked=false;
  	}
}

function rowCheck()
{
	var rowMod = document.getElementById("wprl-options-list-size").value;
	if (rowMod > 50 || rowMod < 1 || isNaN(rowMod))
	{
		alert('Please pick a number of rows between 1 and 50.');
		document.getElementById("wprl-options-list-size").value = window.row;
	}
}

function titleCheck()
{
	var title= document.getElementById("wprl-options-title").value;
	if (isUrl(title))
	{
		alert('Do not enter a URL here. Instead, just enter what you would like to call the main body text.');
		document.getElementById("wprl-options-title").value = window.titledefault;
	}
	else if (title.length > 30)
	{
		alert('Sorry, the text you entered is too long.');
		document.getElementById("wprl-options-title").value = window.titledefault;
	}
}









// end hiding script from old browsers -->