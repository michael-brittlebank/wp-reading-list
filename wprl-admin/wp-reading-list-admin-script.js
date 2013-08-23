/*FILE: wp-reading-list-admin-script.js
*DESCRIPTION: Browser-side admin functions
*/
<!-- hide script from old browsers

var gw;
var linkdefault;
var row;
var titledefault;
var margin;
var padding;

function saveVars() {
	gw = document.getElementById("wprl-options-cover-width").value;
	linkdefault = document.getElementById("wprl-options-url").value;
	row = document.getElementById("wprl-options-list-size").value;
	titledefault = document.getElementById("wprl-options-title").value;
	margin = document.getElementById("wprl-options-margin-left").value;
	padding = document.getElementById("wprl-options-padding").value;
        }

window.onload = saveVars;

function numValGrid(){
	var g=document.getElementById("wprl-options-cover-width").value;
	if (isNaN(g) || g > 600 || g < 60)
	{
		alert("Please choose a number between 60 and 600.");
		numValHelper(1);
	}
	else
	{
		document.getElementById("wprl-options-cover-height").value = Math.round(g*4/3);
	}
}

function numValHelper(docObj){
	if (docObj == 1)
	{
		document.getElementById("wprl-options-cover-width").value = window.gw;
		document.getElementById("wprl-options-cover-height").value = Math.round(window.gw*4/3);

	}
}

function isUrl(s){
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
	var r=confirm('Deleting your Reading List items is permanent. This will also delete the list of authors.  If you are sure that you want to do this, click "Ok" and hit "Save Settings".');
	if (r==true)
  	{
		document.getElementById("wprl-options-delete").checked=true;
  	}
	else
  	{
		document.getElementById("wprl-options-delete").checked=false;
  	}
}

function titleCheck(){
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

function rowCheck(){
	var rowMod = document.getElementById("wprl-options-list-size").value;
	if (rowMod > 50 || rowMod < 1 || isNaN(rowMod) || rowMod.length === 0 || rowMod.replace(/\s/g,"") == "")
	{
		alert('Please pick a number of rows between 1 and 50.');
		document.getElementById("wprl-options-list-size").value = window.row;
	}
}

function marginCheck(){
	var marginMod = document.getElementById("wprl-options-margin-left").value;
	if (marginMod > 25 || marginMod < 0 || isNaN(marginMod) || marginMod.length === 0 || marginMod.replace(/\s/g,"") == "")
	{
		alert('Please pick a percentage between 0 and 25.');
		document.getElementById("wprl-options-margin-left").value = window.margin;
	}
}

function paddingCheck(){
	var paddingMod = document.getElementById("wprl-options-padding").value;
	if (paddingMod > 10 || paddingMod  < 1 || isNaN(paddingMod) || paddingMod.length === 0 || paddingMod.replace(/\s/g,"") == "")
	{
		alert('Please pick a percentage between 1 and 10.');
		document.getElementById("wprl-options-padding").value = window.padding;
	}
}


// end hiding script from old browsers -->