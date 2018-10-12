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
		tokenSeparators: [' ', ',', ';'],
		allowClear: true
	});
});