var katalogramApp = angular.module('katalogramApp',['ngRoute', 'ngTagsInput']);

katalogramApp

// route angular

.config(['$routeProvider',  function($routeProvider) {
	    $routeProvider.when('/', {
	        templateUrl: 'view/catalog/list.html',
	        controller: 'listController'
	    }).when('/profile', {
	        templateUrl: 'view/member/profile.html',
	        controller: 'memberProfile'
	    }).when('/catalog/edit', {
	        templateUrl: 'view/catalog/edit.html',
	    	controller: 'editCatalog'
	    });

}])
.controller('kgController', ['$scope', '$http', function($scope, $http) {
	$scope.modalCreate = function() {
		$scope.modalTemplate = "view/catalog/create.html";

		$http.get("categories.json").success(function(result) {
			$scope.listCategories = result.categories;

		});
	}
}])
.controller('listController',  ['$routeParams','$scope','$http', function($routeParams,$scope, $http) {

	// Simple GET request example :
	$http.get("json/list.json").
	  success(function(result) {

	  	$scope.listCatalog = result.lists;

       	// this callback will be called asynchronously
	    // when the response is availables

	});
}])
.controller('memberProfile',  ['$routeParams','$scope','$http', function($routeParams,$scope, $http) {
	refreshGrid('#memberProfile');
	refreshGrid('#memberCatalog');
}])
.controller('editCatalog',  ['$routeParams','$scope','$http', function($routeParams,$scope, $http) {
	$http.get("json/categories.json").success(function(result) {
		$scope.listCategories = result.categories;
	});
	$http.get("json/rate_criteria.json").success(function(result) {
		$scope.rate_criteria= result.rate_criteria;
	});
	$http.get("json/product_tag.json").success(function(result) {
		$scope.product_tag= result.product_tag;
	});
}])

//Custom Directive UIkit
/*.directive('ngUkGridList', function($timeout) {
    return {
        link: function (scope, element, attrs) {
        	if (scope.$last) {
        		$timeout(function() {
	        	 	refreshGrid(attrs.targetElement);
        		})
       		}
        }
    }
})
.directive('ukTab', function() {
    return {
        link: function (scope, element) {
        	UIkit.tab(element);
        }
    }
})
.directive('ukSlider', function() {
    return {
        link: function (scope, element) {
        	UIkit.slider(element);
        }
    }
})
.directive('ukSwitcher', function() {
    return {
        link: function (scope, element, attrs) {
			UIkit.switcher(element, UIkit.Utils.options(attrs.ukSwitcher));
        }
    }
})
.directive('ukSwitcherList', function($timeout) {
    return {
        link: function (scope, element, attrs) {
        	if (scope.$last) {
				$timeout(function() {
					UIkit.switcher(element.parent(), UIkit.Utils.options(attrs.ukSwitcherList));
				})
			}
        }
    }
})
.directive('ukSliderList', function($timeout) {
    return {
        link: function (scope, element, attrs) {
        	if (scope.$last) {
				$timeout(function() {
					UIkit.slider(element.parent().parent(), UIkit.Utils.options(attrs.ukSliderList));
				})
			}
        }
    }
})

function refreshGrid(element) {tag
	var grid = UIkit.grid(element, {gutter: '10' });
	grid.updateLayout();	
}

function switcher() {
	UIkit.switcher("#editProductTab",{connect: "#editProduct"});
}
.directive('kgTags', function(){
	return{
		link: function(scope, element, attrs) {
			var opt = $.parseJSON(attrs.kgTags);
			$(element).tagsInput(opt);
		}
	}
})*/
.directive('metroRating', function() {
    return {
        link: function () {
        	$(".rating").rating({ showScore: false });
        }
    }
});