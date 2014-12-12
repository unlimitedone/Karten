/*!
 * Author: Immanuel Plath
 * Copyright 2014 Jugendstadtplan Leipzig
 * Description: this file contains all helper functions
 */
 
// contentloader loads the content asynchronously into the divs of the details box 
//==================================================================================
function contentloader(uri, lang) {
    $("#label").load("details?lang=" + lang + "&uri=" + uri + " #heading");
    $("#properties").load("details.php?lang=" + lang + "&uri=" + uri + " #eigenschaften");
    $("#contact").load("details.php?lang=" + lang + "&uri=" + uri + " #address");
    $("#opening").load("details.php?lang=" + lang + "&uri=" + uri + " #openinghours");
	$("#description").load("details.php?lang=" + lang + "&uri=" + uri + " #description");
}

// send search request to webseerver and display response
//=======================================================
function searchRequest(searchKey) {
	requestStart = Date.now();
	$.ajax({
		url: "search.php?search=" + searchKey,
		type: "post",
		datatype: 'json',
		success: function(data){
			if(data.length == 0) {
				$('#searchResponse').html('<strong>Sorry!</strong> for your keyword: <strong>"' + searchKey + '"</strong> we found <strong>0</strong> search results!');
				$("#searchResponse").removeClass('alert-success');
				$("#searchResponse").addClass('alert-warning');
				$("#searchResponse").slideDown('slow').delay(4000).slideUp('slow');
			} else {
				$('#searchResponse').html('<strong>Success!</strong> for your keyword: <strong>"' + searchKey + '"</strong> we found <strong>' + data.length + '</strong> search results! It took ' + (Date.now() - requestStart) + ' ms!');
				$("#searchResponse").removeClass('alert-warning hide');
				$("#searchResponse").addClass('alert-success');
				$("#searchResponse").slideDown('slow').delay(4000).slideUp('slow');
			}
		}  
    }); 
}

// watch if search button is pressed by user
//==========================================
$('.startSearch').click(function() {
	searchRequest(document.getElementById("searchfield").value);
});