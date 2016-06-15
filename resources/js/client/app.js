var kgApp = angular.module('kgApp', ['ui.router', 'ngTagsInput', 'satellizer', 'cropme', 'angular-input-stars', 'ui.knob', 'ngTouch','superswipe','validation.match','infinite-scroll' ]);
var host = window.location.hostname;
kgApp
// route angular
.constant('kgConfig', {
	'site': '//'+host+'/',
	'api': '//api.'+host+'/',
	'files': '//files.'+host+'/',
	'embedly': '8081dea79e164014bcd7cd7e1ab2363a'
})
.config(config)

//main controller
.controller('kgCtrl', kgCtrl)
.controller('catalogCtrl', catalogCtrl)
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

