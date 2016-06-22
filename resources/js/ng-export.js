var kgApp = angular.module('kgApp', ['angular-input-stars', 'ui.knob' ]);
kgApp
.controller('kgController', ['$scope', '$http', '$sce', function($scope, $http, $sce) {
	//init
	var host = window.location.hostname;
	$scope.api = '//api.'+host+'/';
	$scope.files = '//files.'+host+'/';

    var href = window.location.href;
    var parseUrl = href.split("#");
	var productId = parseUrl[1];
    //console.log(productId);

    $scope.knob = {};
    $scope.catalog = {};
    $scope.catalog.avg_rate = 0;
    $scope.knob.options = {
    	readOnly: true,
    	max: 5,
    	trackWidth: 40,
    	barWidth: 30,
    	trackColor: '#eee',
    	barColor: '#0079ab',
    	animate: {
    		enabled:false
    	}
    }

    $http.get(
		$scope.api+"catalog/"+productId
	).success(function (response) {
        var detail = response;
        catalog = response.product;
        catalog.desc = $sce.trustAsHtml(catalog.desc);
        catalog.data = $sce.trustAsHtml(catalog.data);
        /*catalog.num_plus = Object.keys(catalog.feedback_plus).length;
        catalog.num_minus = Object.keys(catalog.feedback_minus).length;
        */
        /*//return num_collect
        var num_collect = Object.keys(response.product[0].num_collect).length;
        if (num_collect ==0) catalog.num_collect = 0;
        else catalog.num_collect = catalog.num_collect[0].numCollect;

        //return avg_rate
        var total_rate=0, num_criteria=0, criteria = catalog.criteria;
        for (var i=0; i<criteria.length; i++) {
        	if (criteria[i].avg_criteria.length != 0) {
        		total_rate += parseFloat(criteria[i].avg_criteria[0].criteria_rate);
        	}
        	num_criteria++;
        }
        catalog.avg_rate = Number((total_rate/num_criteria).toFixed(1));
        console.log(catalog.avg_rate);
        */
		$scope.productId = catalog.id;
        $scope.catalog = catalog;

    });
}]);
