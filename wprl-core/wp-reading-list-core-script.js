/*FILE: wp-reading-list-core-script.js
*DESCRIPTION: Browser-side admin/editor functions
*/
<!-- hide script from old browsers

var pagesdefault;

function saveVars() {
	pagesdefault = document.getElementById("wprl-pages-admin").value;
	if (pagesdefault === null)
	{
		pagesdefault = '';
        }
}

function pageCheck()
{
	var pagesMod = document.getElementById("wprl-pages-admin").value;
	if(isNaN(pagesMod) || pagesMod > 10000 || pagesMod < 1)
	{
		alert('Please pick a number between 1 and 10,000 and do not write it out.  Unfortunately at this time we cannot support page ranges, i.e. "210-450".');
		document.getElementById("wprl-pages-admin").value = window.pagesdefault;
	}	
}

window.onload = saveVars;

// end hiding script from old browsers -->