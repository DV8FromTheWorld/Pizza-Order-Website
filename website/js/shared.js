// JavaScript Document

function createCookie(name,value,days) {
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  }
  else expires = "";
  document.cookie = name+"="+value+expires+"; path=/; domain=appstate.edu";
}

function readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}

function setPrefSearch(nckatb) {
	if (nckatb == "peeps")
	{
		document.getElementById('which1').checked = false;
		document.getElementById('which2').checked = true;
	}
	else
	{
		document.getElementById('which1').checked = true;
		document.getElementById('which2').checked = false;
	}
}

function srchWhat()
{
	var checkInput = false;
	checkInput = document.getElementById('frmSearch').getElementsByTagName('INPUT')[0];
	if (document.getElementById('which1').checked == true)
	{
		if (checkInput.id = 'last') {
			checkInput.id = 'q';
			checkInput.name = 'q';
			createCookie("ASUsearch", "gwebs", 365);
		}
		document.getElementById('frmSearch').action = 'http://gb1.appstate.edu/search';
		document.getElementById('frmSearch').method = 'get';
	}
	if (document.getElementById('which2').checked == true)
	{
		if (checkInput.id = 'q') {
			checkInput.id = 'last';
			checkInput.name = 'last';
			createCookie("ASUsearch", "peeps", 365);
		}
		document.getElementById('frmSearch').action = 'http://www1.appstate.edu/cgi-bin/cgiwrap/jmm/newcso4.pl';
		document.getElementById('frmSearch').method = 'post';
	}
	return true;
}

function checkValue(thisForm) {

	if (thisForm.getElementsByTagName('INPUT')[0].value ==" search " || thisForm.getElementsByTagName('INPUT')[0].value == " firstname lastname" || thisForm.getElementsByTagName('INPUT')[0].value == "")    	
		return false;
	else
		return true;
}

function focusClearInput(inputObject) {

    var hasBeenFocused = inputObject.getAttribute("hasBeenFocused") != null;
    
    if (!hasBeenFocused) {
        inputObject.setAttribute("hasBeenFocused", "true");
        inputObject.style.color = "#000000";
        inputObject.value = "";
        var thisForm = inputObject.form;
        for (ii = 0;  ii < thisForm.elements.length; ii++) {
            if (thisForm.elements[ii].type == "submit"){
                thisForm.elements[ii].disabled = false;
            }
        }
	
    }                                
}

function setFocus () {
	document.getElementById('frmSearch').getElementsByTagName('INPUT')[0].focus();
}

function searchInit() {
	var mrcookie = readCookie("ASUsearch");
	var mrvalue = mrcookie ? mrcookie : "gwebs";
  	setPrefSearch(mrvalue);
}

//window.onload = init();