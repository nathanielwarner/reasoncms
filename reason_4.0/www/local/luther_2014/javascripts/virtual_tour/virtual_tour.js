function setCookie(cname, cvalue) {
    document.cookie = cname + "=" + cvalue;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

function checkCookie() {
    var user = getCookie("viewedHelp");
    if (user != "") {
    	//user has seen help so we can hide it, or not show it
//        alert("Welcome again " + user);
    	
    	
    } else {
    	//user has not seen help so dont hide it, or show it
//        user = prompt("Please enter your name:", "");
//        if (user != "" && user != null) {
//            setCookie("username", user, 365);
//        }
    	
    }
}

$(document).ready(function() {
	alert("here");
});