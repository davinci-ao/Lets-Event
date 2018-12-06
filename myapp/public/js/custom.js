/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 44);
/******/ })
/************************************************************************/
/******/ ({

/***/ 44:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(45);


/***/ }),

/***/ 45:
/***/ (function(module, exports) {

var letsEventModule = function () {

	var hideMsg = function hideMsg() {
		var alerts = document.getElementsByClassName('hideMsg');
		for (var i = 0; i < alerts.length; i++) {
			alerts[i].style.display = 'none';
		}
	};

	setTimeout(function () {
		hideMsg();
	}, 5000);
}(); //console.log

$(document).ready(function () {
	$('.multi-tag').select2({
		placeholder: 'Select your category tags.',
		tags: true,
		closeOnSelect: false,
		tokenSeparators: [' ', ',', ';'],
		allowClear: true
	});

	$('.multi-tag').on('select2:closing', function () {
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



/***/ })

/******/ });


	function readURL1(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#inputGroupFile01PR').attr('src', e.target.result);
				$('#inputGroupFile01div').css({'padding-bottom' : '250px'});
				
			};

			reader.readAsDataURL(input.files[0]);
		}
	}
	function readURL2(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#inputGroupFile02PR').attr('src', e.target.result);
				$('#inputGroupFile02div').css({'padding-bottom' : '250px'});
				
			};

			reader.readAsDataURL(input.files[0]);
		}
	}