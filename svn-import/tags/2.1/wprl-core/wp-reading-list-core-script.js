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
	if(isNaN(pagesMod) && pagesMod.indexOf('-') == -1 || pagesMod > 10000 || pagesMod < 1)
	{
		alert('Please pick a number between 1 and 10,000 and do not write it out.  Otherwise, please use a dash to represent a page range, i.e. "210-450".');
		document.getElementById("wprl-pages-admin").value = window.pagesdefault;
	}
	else
	{
		pagesRay = pagesMod.replace(/ /g,'').split('-');
		if (pagesRay.length > 2)
		{
			alert('You have too many dashes in your entry. Please try again with only one dash for the page range.');
			document.getElementById("wprl-pages-admin").value = window.pagesdefault;
		}
		else if (pagesRay[0] > pagesRay[1])
		{
			alert('The first number in the page range is bigger than the second.  Please enter the range again.');
			document.getElementById("wprl-pages-admin").value = window.pagesdefault;
		}
		else if (pagesRay[1] > 10000)
		{
			alert('Please pick a number less than 10,000 for the page range.');
			document.getElementById("wprl-pages-admin").value = window.pagesdefault;
		}
		else{
		document.getElementById("wprl-pages-admin").value = pagesMod;
		}
	}
}

window.onload = saveVars;

// end hiding script from old browsers -->