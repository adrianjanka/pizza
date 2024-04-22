
$(document).ready(function(){

	/*
	 * Autocomplete for plz und ort
	 */ 
	zipcity_autocomplete_type="";
	$(".jq_zip_autocomplete").keyup(function(){
		zipcity_autocomplete_type="zip";
	});
	$(".jq_city_autocomplete").keyup(function(){
		zipcity_autocomplete_type="city";
	});
	$(".jq_zipcity_autocomplete").autocomplete({
		source: zipCityAutocompleteValues,
		minLength: 2,
		select: function(event, ui) {
			// overwrite normal value of select
			value = ui.item.value.split(/\s(.+)/); // (new RegExp('%', 'gi'));
		},
		open: function (event, ui) {
			autocompleteOpen = true;
		},
		close: function (event, ui) {
			if(autocompleteOpen){
				if(!($.isEmptyObject(value))){
					// pre settings
					$(".jq_zip_autocomplete").val();
					$(".jq_city_autocomplete").val();
					// set inputs to specific value
					$(".jq_zip_autocomplete").val(value[0]);
					$(".jq_city_autocomplete").val(value[1]);
				}
			}
			autocompleteOpen = false;
		}
	});
	$(".jq_zip_autocomplete").attr("autocomplete", "asdf");
	$(".jq_city_autocomplete").attr("autocomplete", "asdf");
	
});


// get plz and ort for autocomplete | ADD
function zipCityAutocompleteValues(request, response) {
	// set post vars for autocomplete
	
	var zip="";
	var city="";
	
	if(zipcity_autocomplete_type=="zip") var zip = $(".jq_zip_autocomplete").val();
	else if(zipcity_autocomplete_type=="city") var city =$(".jq_city_autocomplete").val();
	
	postVars = {
		zip: zip,
		city: city,
		country: 1
	};
	console.log("autocomplete postVars: ",postVars);
	// autocomplete request
	$.ajax({
		type: "POST",
		url: "autocomplete.php",
		data: postVars,
		dataType: "json",
		success: function (data) {
			console.log("success autocomplete: ",data);
			response( $.map( data, function( item ) {
				return {
		    		label: item.zip+" "+item.city,
			      	value: item.zip+" "+item.city
			    }
			}));
		},
		error: function (result) {
			console.log("error autocomplete, result: ",result)
		}
	});
};
