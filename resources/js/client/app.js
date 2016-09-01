(function(w, d){
   var id='embedly-platform', n = 'script';
   if (!d.getElementById(id)){
     w.embedly = w.embedly || function() {(w.embedly.q = w.embedly.q || []).push(arguments);};
     var e = d.createElement(n); e.id = id; e.async=1;
     e.src = ('https:' === document.location.protocol ? 'https' : 'http') + '://cdn.embedly.com/widgets/platform.js';
     var s = d.getElementsByTagName(n)[0];
     s.parentNode.insertBefore(e, s);
   }
})(window, document);

window.onload = function () { window.loading_screen.finish(); }

/*var loadDeferredStyles = function() {
	var addStylesNode = document.getElementById("deferred-styles");
	var replacement = document.createElement("div");
	replacement.innerHTML = addStylesNode.textContent;
	document.body.appendChild(replacement)
	addStylesNode.parentElement.removeChild(addStylesNode);
  };
  var raf = requestAnimationFrame || mozRequestAnimationFrame ||
	  webkitRequestAnimationFrame || msRequestAnimationFrame;
  if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
  else window.addEventListener('load', loadDeferredStyles);*/


//angular app
var host = window.location.hostname;
if (host == 'www.katalogram.com') host = 'katalogram.com';

if (host == 'katalogram.dev') {
	fbid = '1506049499709287';
	googleid = '13356134084-uo1b2bi0sn6vhvdslphhem7desofd5rt.apps.googleusercontent.com';
} else if (host == 'katalogram.com') {
	fbid = '1496399374007633';
	googleid = '13356134084-uo1b2bi0sn6vhvdslphhem7desofd5rt.apps.googleusercontent.com';
}

var kgApp = angular.module('kgApp', ['ui.router', 'ngSanitize', 'ngTagsInput', 'satellizer', 'ngFileUpload', 'angular-input-stars',
	'ui.knob', 'ngTouch','superswipe','validation.match','infinite-scroll','textAngular', 'angulartics', 'angulartics.google.analytics' ]);
kgApp
// route angular
.constant('kgConfig', {
	'site': '//'+host+'/',
	'api': '//api.'+host+'/',
	'files': '//files.'+host+'/',
	'embedly': '8081dea79e164014bcd7cd7e1ab2363a',
	'fb': fbid,
	'google': googleid
})
.config(config)

//main controller
.controller('kgCtrl', kgCtrl)
.controller('homeCtrl', homeCtrl)
.controller('catalogCtrl', catalogCtrl)
.controller('catalogCategoryCtrl', catalogCategoryCtrl)
//.controller('catalogDetailCtrl', catalogDetailCtrl)
.controller('catalogEditCtrl',  catalogEditCtrl)
.controller('userCtrl', userCtrl)
.controller('userEditCtrl', userEditCtrl)

// custom directives
.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.ngEnter);
                });

                event.preventDefault();
            }
        });
    };
})
.directive('stopEvent', function () {
	return {
	  restrict: 'A',
	  link: function (scope, element, attr) {
	    element.on(attr.stopEvent, function (e) {
	      e.stopPropagation();
	    });
	  }
	};
})
.directive('kgUiDropdown', function () {
    return function (scope, element, attrs) {
		element.dropdown();
    };
})
.directive('kgUiAccordion', function() {
	return function (scope, element, attr) {
		$(element).accordion();
    };
})
.directive('kgUiCheckbox', function() {
	return function (scope, element, attr) {
		$(element).checkbox('toggle');
    };
})
.directive('kgUiDimmer', function() {
	return function (scope, element, attr) {
		$(element).dimmer({
			on: 'hover'
		});
    };
})
.directive('kgPopup', function () {
    return function (scope, element) {
		element.popup({
			variation: 'inverted',
			position: 'bottom center'
		});
    };
})
.directive('kgTab', function () {
    return function (scope, element) {
		element.tab();
    };
});
/*.directive('uiSidebar', function() {
	return function (scope, element, attr) {
		$(element).sidebar();
		$(element).sidebar('attach events', attr.trigger);
    };
})*/
/*.directive('kgEmbedly', ['$http', function($http) {
	return {
		template: '<blockquote class="embedly-card" data-card-key="{{ apikey }}" data-card-width="100%"><h4><a href="{{ embed.original_url }}"> {{ embed.title }}</a></h4><p>{{ embed.description }}</p></blockquote>',
		link: function(scope, element, attrs) {
			//url = encodeURI(scope.url);
			maxwidth = attrs.maxwidth;
			scope.apikey = attrs.apikey;
			attrs.$observe('url', function(value) {
				console.log(value);
				$http.get('http://api.embed.ly/1/extract?url='+value+'&maxwidth='+maxwidth+'&key='+scope.apikey)
				.success(function(response){
					scope.embed = response;
					$.getScript("//cdn.embedly.com/widgets/platform.js");
					//embedly('card', '.embedly-cardx');
					//console.log("embed="+value);
				})
			})
		}
	}
}])*/



