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
	if (isNaN(pagesMod))
	{
		alert('Please pick a number and do not write it out.  Unfortunately at this time we cannot support page ranges, i.e. "210-450".');
		document.getElementById("wprl-pages-admin").value = window.pagesdefault;
	}	
	else if (pagesMod > 10000)
	{
		alert('Sorry that number is too long.');
		document.getElementById("wprl-pages-admin").value = window.pagesdefault;
	}
}

window.onload = saveVars;

// end hiding script from old browsers -->