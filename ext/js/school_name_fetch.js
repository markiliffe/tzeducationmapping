/* afetch.js is a javascript file which creates the AJAX object and provides functions for the usability
 * and use of the school data from the database files. 
 */



/*
 * HTTPREQ creates the AJAX object
 */

function httpreq()
{
	var ajaxRequest; 
	try{
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				alert("Browser Error!");
				return false;
			}
		}
	}
	return ajaxRequest;
}

/*
 * This function 'brings' the school name and school ID and district name. This is called in index.php
 * "Shule" is Swahili for School. 
 * "schoolform" is the form for holding the school search functions. This created in index.php (for now...)
 * "dshule" is the <div> that holds the school names.
 * "mpunga" is the text field that holds the school names.
 */

function bring()
{
	mpunga=document.schoolform.tshule.value;
	/*var ajx = httpreq();
	if(ajx==false)return false;
	ajx.onreadystatechange = function()
	{
		if(ajx.readyState == 4){
	   document.getElementById('dshule').innerHTML = ajx.responseText;
		}
	}*/
	$.ajax({
	type:"get",
	url: "school_search.php?user_input="+mpunga,
	success:function(response){
	document.getElementById('dshule').innerHTML = response;	
	}
	});
	//ajx.open("GET", "school_search.php?user_input="+mpunga, true);	
	//ajx.send(null);
}

/*
 * Weka means put in Swahili. 
 * 
 * This function puts the schools that the user selected in the text box.
 * 
 * There is a hidden input to hold the school id, this is to fetch the school data from the database,
 * when the form is submitted.
 * 
 * document.schoolform.shule.value=school_id retrieves the unique record identificater from the database. 
 * document.schoolform.tshule.value=school_name retrieves school name and NECTA's unique identifier.
 * document.getElementById('dshule').innerHTML = '' clears the <div> of the school names and numbers.
 *
 * This is called by index.php.
 *
 */ 

function weka(school_id,school_name,id,district)
{ 
		document.schoolform.shule.value=school_id;
		document.schoolform.tshule.value=school_name;
		document.schoolform.dshule.value=district;
		document.getElementById('dshule').innerHTML = '';
		document.getElementById('dfetch').innerHTML = ''; 
}

/*
 * Ondoa means remove in Swahili.
 * 
 * This function clears the <div> when the mouse is not hovering over the dropdown field.
 *
 */

function ondoa()
{
	document.getElementById('dshule').innerHTML = '';
	document.getElementById('dfetch').innerHTML = '';
}