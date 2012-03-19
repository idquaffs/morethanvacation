/* Author:

*/
$(document).ready(function () {
    $("a[rel^='prettyPhoto']").prettyPhoto({
        default_width: 800,
        deeplinking: false,
		social_tools:false
    });
    $("a#videolink").prettyPhoto({
        deeplinking: false,
		social_tools:false
    });
	
});