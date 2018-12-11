$(document).ready(function(){

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    },
	   	dataType: "json"
	});

	function createSelect(selected = 0)
	{
		var select = '<option ';
		if (selected === 0) select += "selected";
		select += ' value="0">student number</option><option ' 
		if (selected === 1) select += "selected";
		select += ' value="1">first name</option><option ';
		if (selected === 2) select += "selected";
		select += ' value="2">prefix</option><option ';
		if (selected === 3) select += "selected";
		select += ' value="3">last name</option>'

		return select;
	}

	var order = [0, 1, 2, 3];
	var colums = [ [], [], [], [] ]; 

	$("#csv_file").on("input", function() {

		const reader = new FileReader;

		

		reader.onload = function(input) {
			colums = [ [], [], [], [] ]; 
			order = [0, 1, 2, 3];
			
			text = reader.result;
			text = text.split('\n');

			var table = "<table class=\"table\">"

			for (i in text) {
				if (i == 0) continue;
				row = text[i].split(';');

				table += '<tr>'                      		

				for (t in row) {	
					if (t >= 4 || row.length < 4) continue;

					if (row[t] == "") {
						table += '<td class="'+t+'"></td>'
						continue;
					} 

			    table += '<td class="'+t+'">'+ row[t] +'</td>';
            }

		  	table += '</tr>' 
		  }

		 	var forum = '\
		  		<td><select data-colum="0" class="form-control">'+ createSelect(0) + '</select></td>\
		  		<td><select data-colum="1" class="form-control">'+ createSelect(1) + '</select></td>\
		  		<td><select data-colum="2" class="form-control">'+ createSelect(2) + '</select></td>\
		  		<td><select data-colum="3" class="form-control">'+ createSelect(3) + '</select></td>\
		  		<td><button id="upload" class="btn btn-primary">Upload</button></td></table>'
 
		  table += "</table>"

		  $('#table').append(table).append(forum);

		  	for (i = 0; i < 4; i++) {
		  		$('.' + i).text( function(index, text) 
		  		{
		  			colums[i].push(text);
		  		})
			}		  	

			$('#upload').on("click", function()
			{
				submitData();
			})

			$( ".form-control" ).change(function(e) {
				order[$( this ).data('colum')] = $( this ).val();
			})
		}
		var extension = this.files[0].name.match(/\..+/);
		$('#table').empty();
		$('#feedback').empty().hide();
		if ( extension[0] === '.csv' ) {
			reader.readAsText(this.files[0]);
		} else {
			showFeedback( 'Error this is not a csv file' );
		}
	});	

	function submitData() 
	{
		$.ajax({
		    url: "/import",
		    method: "POST",
		    cache : false,
		    data: 
		    {
                student:   getOrder(0),
                firstName: getOrder(1),
                prefix:    getOrder(2),
                lastName:  getOrder(3)
		    },
		    success: function(data) {
		    	if (data.succes === 'true') {

		    		$('#table').empty();
		    		showFeedback( data.feedback , 'positive');

		    	} else {
		    		showFeedback( 'One or more of the data is not valid please make sure the data is correctly marked with the <strong>select boxes</strong>' );
		    	}
		    },  
		    error: function (err) {
				showFeedback( 'something went wrong when uploading the data')
			}
		});
	}

	function showFeedback(feedback, type = "negative")
	{
		if (type === "negative") {
			$('#feedback').addClass( 'alert-danger'  ).empty().removeClass( 'alert-success' ).append( feedback ).show()
		} else if (type === "positive") {
			$('#feedback').addClass( 'alert-success' ).empty().removeClass( 'alert-danger' ).append( feedback ).show()
		}
	}

	function getOrder(orderNmr)
    {
        for (var i = 0; i < 4; i++) {
            if (order[i] == orderNmr) {
                return colums[i];
            }
        }
    }

})
