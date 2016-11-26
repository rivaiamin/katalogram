/* Kisikg JS Script App */
var hostName = window.location.hostname;
var hostNameArray = hostName.split(".");  
var posOfTld = hostNameArray.length - 1;  
var ext = hostNameArray[posOfTld];
var host = 'katalogram.'+ext;

app = angular.module('kgApp', ['ui.router', 'satellizer', 'ngTouch', 'superswipe',
	'xeditable', 'ui-notification',	'ngFileUpload','ngTagsInput', 'infinite-scroll','validation.match' ]);
app
.constant('kgConfig', {
	'site': '//'+host+'/',
	'api': '//api.'+host+'/',
	'files': '//files.'+host+'/',
	'admin': '//admin.'+host+'/',
	'embedly': '8081dea79e164014bcd7cd7e1ab2363a'
})
.run(['editableOptions', 'editableThemes',function(editableOptions, editableThemes) {
  editableThemes.bs3.inputClass = 'ui input';
  editableThemes.bs3.buttonsClass = 'ui button';
  editableOptions.theme = 'bs3';
}])
.config(config)
.controller('kgCtrl', kgCtrl)
.controller('homeCtrl', homeCtrl)
.controller('authCtrl', authCtrl)
.controller('productCtrl', productCtrl)
.controller('categoryCtrl', categoryCtrl)
.controller('feedbackCtrl', feedbackCtrl)
.controller('tagCtrl', tagCtrl)
.controller('criteriaCtrl', criteriaCtrl)
.controller('pageCtrl', pageCtrl)
.controller('userCtrl', userCtrl)
//.controller('adminMappingCtrl', adminMappingCtrl)


.directive('datepicker', function() {
    return function(scope, element, attr) {
        $(element).datepicker();
    }
});
