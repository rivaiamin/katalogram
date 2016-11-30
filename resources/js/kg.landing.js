

window.onload = function () { window.loading_screen.finish(); }


$(document).ready(function() {
  // fix menu when passed
  /*$('.masthead')
	.visibility({
	  once: false,
	  onBottomPassed: function() {
		$('.fixed.menu').transition('fade in');
	  },
	  onBottomPassedReverse: function() {
		$('.fixed.menu').transition('fade out');
	  }
	})
  ;*/

  // create sidebar and attach to menu open
  $('.ui.sidebar').sidebar('attach events', '.toc.item');
  $('.menu .item').tab();
  $('#callAct').modal('attach events', '#callActBtn', 'show');
});

/* smartsupp */
var _smartsupp = _smartsupp || {};
_smartsupp.key = 'cc1fd97b1ddc57f93720906a8da2de07d915ce03';
window.smartsupp||(function(d) {
	var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
	s=d.getElementsByTagName('script')[0];c=d.createElement('script');
	c.type='text/javascript';c.charset='utf-8';c.async=true;
	c.src='//www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
})(document);

/* Chatra.io */
/*(function(d, w, c) {
    w.ChatraID = 'LKxAZDW9MYtH5KbSs';
    var s = d.createElement('script');
    w[c] = w[c] || function() {
        (w[c].q = w[c].q || []).push(arguments);
    };
    s.async = true;
    s.src = (d.location.protocol === 'https:' ? 'https:': 'http:')
    + '//call.chatra.io/chatra.js';
    if (d.head) d.head.appendChild(s);
})(document, window, 'Chatra');*/

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=1496399374007633";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

