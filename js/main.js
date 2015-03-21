$(function() {
	$( "#studentLogin" ).click(function() {
		// a popup box would be nicer :)
		/* Still trying to get the child window redirect the parent page */
		openInNewWindow("https://ivle.nus.edu.sg/api/login/?apikey=3bBGOIdtC1T2d7SXeQAO9&url=http://steps.tk/student/");	
	});
});

$(function() {
    $( "#lecturerLogin" ).click(function() {
        // a popup box would be nicer :)
        window.location.href = "https://ivle.nus.edu.sg/api/login/?apikey=3bBGOIdtC1T2d7SXeQAO9&url=http://steps.tk/lecturer/";
    });
});

function openInNewWindow(url) {
	var newWindow = window.open(url,'name','height=500,width=700');
	if (window.focus) {
		newWindow.focus();
		return newWindow;
	}
	return false;
}