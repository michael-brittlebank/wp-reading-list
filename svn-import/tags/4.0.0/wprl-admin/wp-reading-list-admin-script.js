/*FILE: wp-reading-list-admin-script.js
 *DESCRIPTION: Browser-side admin functions
 */
var gw;
var linkdefault;
var row;
var titledefault;
var multititledefault;
var margin;
var padding;

/*Save default variables printed on screen */
function saveVars() {
    gw = document.getElementById("wprl-options-cover-width").value;
    linkdefault = document.getElementById("wprl-options-url").value;
    row = document.getElementById("wprl-options-list-size").value;
    titledefault = document.getElementById("wprl-options-title").value;
    margin = document.getElementById("wprl-options-margin-left").value;
    padding = document.getElementById("wprl-options-padding").value;
    multititledefault = document.getElementById("wprl-options-multiple-title").value;
}
window.onload = saveVars;

/*validate the work cover size */
function numValGrid(){
    var g=document.getElementById("wprl-options-cover-width").value;
    if (isNaN(g) || g > 600 || g < 60) {
        alert("Please choose a number between 60 and 600.");
        numValHelper(1);
    }
    else {
        document.getElementById("wprl-options-cover-height").value = Math.round(g*4/3);
    }
}

/*helper function for work cover validatation */
function numValHelper(docObj){
    if (docObj == 1) {
        document.getElementById("wprl-options-cover-width").value = window.gw;
        document.getElementById("wprl-options-cover-height").value = Math.round(window.gw*4/3);
    }
}

/* helper check if string is url or not */
function isUrl(s){
    var testFor =new Array("http","https","ftp","ftps",".com",".net",".org",".edu",".gov",".int",".mil",".biz",".info",".jobs",
        ".mobi",".name","@");
    for (i=0;i<testFor.length;i++) {
        if (s.indexOf(testFor[i])!= -1) {
            return true;
        }
    }
    return false;
}

/* confirm box for delete feature */
function deleteConfirm(){
    document.getElementById("wprl-options-delete").checked=confirm('Deleting your Reading List items is permanent. This will also delete the list of authors.  If you are sure that you want to do this, click "Ok" and hit "Save Settings".');
}

/* validate the title of archive header*/
function layoutHeaderCheck(){
    var multititle= document.getElementById("wprl-options-multiple-title").value;
    if (isUrl(multititle)) {
        alert('Do not enter a URL here. Instead, just enter what you would like to call the list of items.');
        document.getElementById("wprl-options-multiple-title").value = window.multititledefault;
    }
    else if (multititle.length > 30) {
        alert('Sorry, the text you entered is too long.');
        document.getElementById("wprl-options-multiple-title").value = window.multititledefault;
    }
}

/* validate number of list items */
function rowCheck(){
    var rowMod = document.getElementById("wprl-options-list-size").value;
    if (rowMod > 50 || rowMod < 1 || isNaN(rowMod) || rowMod.length === 0 || rowMod.replace(/\s/g,"") == "") {
        alert('Please pick a number of rows between 1 and 50.');
        document.getElementById("wprl-options-list-size").value = window.row;
    }
}

/*Cover image uploader*/
jQuery(document).ready(function($){
    var custom_uploader;
    jQuery('#wprl-options-cover-image-button').on("click", function(e) {
        e.preventDefault();
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#wprl-options-cover-image').val(attachment.url);
            $("#wprl-options-cover-image-preview").attr("src",attachment.url);
        });
        //Open the uploader dialog
        custom_uploader.open();
    });
});