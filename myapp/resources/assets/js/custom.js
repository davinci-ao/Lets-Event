var letsEventModule = (function() {

	var hideMsg = function() {
		var alerts = document.getElementsByClassName('alert');
		for (var i = 0; i < alerts.length; i++) {
			alerts[i].style.display = 'none';
		}
	};

	setTimeout(function() { hideMsg(); }, 5000);

})();//console.log

$(document).ready(function(){
	$('.multi-tag').select2({
		placeholder: 'Select your category tags.',
		tags: true,
		closeOnSelect: false,
		tokenSeparators: [' ', ',', ';'],
		allowClear: true
	});

	$('.multi-tag').on('select2:closing', function(){
		var tag = document.getElementsByClassName('select2-search__field')[0].value;
		if (tag != '') {
			var data = {
				id: tag,
				text: tag
			};
			var newOption = new Option(data.text, data.id, true, true);
			$('.multi-tag').append(newOption).trigger('change');
		}
	});
});