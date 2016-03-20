<!DOCTYPE html>
<html>
<head ng-app="kgApp">
	<meta charset="utf-8" />
	<title>.:: katalogram.com (Alpha Version) - Situs Katalogisasi Sosial untuk Ekonomi Kreatif Indonesia ::.</title>
	<meta name="author" content="KarsaKalana" />
	<meta name="description" content="Situs Katalogisasi Sosial (Social Cataloging) untuk Ekonomi Kreatif" />
	<meta name="keyword" content="social cataloging, social, cataloging, site, economy, product, creative, katalogisasi sosial, kreatif, ekonomi, industri, produk, produk kreatif, ekonomi kreatif, industri kreatif, insan kreatif, kreator" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
	<meta name="google-signin-client_id" content="13356134084-ij596q95of0e79k0qa592btnpo8uvang.apps.googleusercontent.com">
	<base href="http://katalogram.dev/index.html">
	<link rel="stylesheet" type="text/css" href="http://katalogram.dev/css/katalogram.min.css">
</head>
<body ng-controller="kgController">
   <div class="uk-cover-background uk-position-relative uk-contrast">
      <img class="uk-invincible" src="http://files.katalogram.dev/preview/KG-PV-1454571018.jpg" height="300">
      <div class="uk-position-cover uk-flex uk-flex-center uk-flex-bottom"><img class="uk-thumbnail uk-border-circle kg-logo-big" ng-src="http://files.katalogram.dev/logo/2ac88c89fe333.jpg" width="100" src="http://files.katalogram.dev/logo/2ac88c89fe333.jpg"></div>
   </div>
   <div class="uk-container uk-container-center ui image">
      <a class="ui teal ribbon label uk-text-large ng-binding"><img ng-src="public/img/category/percetakan.png" width="30" src="public/img/category/percetakan.png"> Penerbitan</a>
      <div class="uk-grid uk-grid-small uk-margin-top uk-text-center">
         <div class="uk-width-1-1 uk-margin-bottom">
            <div class="uk-grid uk-grid-small uk-text-center uk-text-large">
               <div class="uk-width-1-5">
                  <a ng-click="addCollect()"><i class="uk-icon-heart uk-icon-hover uk-icon-medium kg-color-crimson"></i></a>
                  <p><b class="ng-binding">1</b></p>
               </div>
               <div class="uk-width-1-5">
                  <i class="uk-icon-star uk-icon-hover uk-icon-medium"></i>
                  <p><b class="ng-binding">4.1</b></p>
               </div>
               <div class="uk-width-1-5"></div>
               <div class="uk-width-1-5">
                  <a href="#productFeedback" ng-click="feedback.feedback_type = 'P'"><i class="uk-icon-thumbs-o-up uk-icon-hover uk-icon-medium"></i></a>
                  <p><b class="ng-binding">5</b></p>
               </div>
               <div class="uk-width-1-5">
                  <a href="#productFeedback" ng-click="feedback.feedback_type = 'N'"><i class="uk-icon-thumbs-o-down uk-icon-hover uk-icon-medium"></i></a>
                  <p><b class="ng-binding">3</b></p>
               </div>
            </div>
         </div>
         <div class="uk-width-1-1">
            <h2 class="kg-heading kg-heading-separator uk-margin-bottom-remove"><span class="ng-binding">Black dan Yellow</span></h2>
         </div>
         <div class="uk-width-1-1 uk-margin-top"><q class="kg-quote ng-binding">Kisah sebuah warna yang bercampur dengan warna lain</q></div>
         <div class="uk-width-1-1 uk-margin-bottom kg-color-gray ng-binding"><img class="uk-border-circle" src="http://files.katalogram.dev/user_pict/16958b338798.jpg" width="24"> &nbsp; @popimitaya</div>
      </div>
      <div class="uk-grid uk-grid-small uk-grid-collapse">
         <div class="uk-width-medium-2-5 uk-width-small-1-1">
            <div class="uk-width-1-1 uk-text-center uk-margin-top">
               <knob knob-data="product.data" knob-options="{max:5, width:'200', height:'200', readOnly:true }"></knob>
            </div>
            <div class="uk-width-1-1">
               <table class="uk-table uk-table-condensed" width="100%">
                  <tbody>
                     <!-- ngRepeat: rate in productDetail.product_rate -->
                     <tr ng-repeat="rate in productDetail.product_rate" class="ng-scope">
                        <th class="uk-padding-remove ng-binding">cerita</th>
                        <td>
                           <ul ng-class="listClass" icon-full="uk-icon-star" icon-empty="uk-icon-star-o" max="5" ng-model="rate.value" ng-click="giveRate(rate)" class="ng-scope ng-valid angular-input-stars">
                              <!-- ngRepeat: item in items track by $index -->
                              <li ng-touch="paintStars($index)" ng-mouseenter="paintStars($index, true)" ng-mouseleave="unpaintStars($index, false)" ng-repeat="item in items track by $index" class="ng-scope"><i ng-class="getClass($index)" ng-click="setValue($index, $event)" class="fa fa-fw uk-icon-star active"></i></li>
                              <!-- end ngRepeat: item in items track by $index -->
                              <li ng-touch="paintStars($index)" ng-mouseenter="paintStars($index, true)" ng-mouseleave="unpaintStars($index, false)" ng-repeat="item in items track by $index" class="ng-scope"><i ng-class="getClass($index)" ng-click="setValue($index, $event)" class="fa fa-fw uk-icon-star active"></i></li>
                              <!-- end ngRepeat: item in items track by $index -->
                              <li ng-touch="paintStars($index)" ng-mouseenter="paintStars($index, true)" ng-mouseleave="unpaintStars($index, false)" ng-repeat="item in items track by $index" class="ng-scope"><i ng-class="getClass($index)" ng-click="setValue($index, $event)" class="fa fa-fw uk-icon-star active"></i></li>
                              <!-- end ngRepeat: item in items track by $index -->
                              <li ng-touch="paintStars($index)" ng-mouseenter="paintStars($index, true)" ng-mouseleave="unpaintStars($index, false)" ng-repeat="item in items track by $index" class="ng-scope"><i ng-class="getClass($index)" ng-click="setValue($index, $event)" class="fa fa-fw uk-icon-star active"></i></li>
                              <!-- end ngRepeat: item in items track by $index -->
                              <li ng-touch="paintStars($index)" ng-mouseenter="paintStars($index, true)" ng-mouseleave="unpaintStars($index, false)" ng-repeat="item in items track by $index" class="ng-scope"><i ng-class="getClass($index)" ng-click="setValue($index, $event)" class="fa fa-fw uk-icon-star-o"></i></li>
                              <!-- end ngRepeat: item in items track by $index -->
                           </ul>
                        </td>
                     </tr>
                     <!-- end ngRepeat: rate in productDetail.product_rate -->
                     <tr ng-repeat="rate in productDetail.product_rate" class="ng-scope">
                        <th class="uk-padding-remove ng-binding">gambar</th>
                        <td>
                           <ul ng-class="listClass" icon-full="uk-icon-star" icon-empty="uk-icon-star-o" max="5" ng-model="rate.value" ng-click="giveRate(rate)" class="ng-scope ng-valid angular-input-stars">
                              <!-- ngRepeat: item in items track by $index -->
                              <li ng-touch="paintStars($index)" ng-mouseenter="paintStars($index, true)" ng-mouseleave="unpaintStars($index, false)" ng-repeat="item in items track by $index" class="ng-scope"><i ng-class="getClass($index)" ng-click="setValue($index, $event)" class="fa fa-fw uk-icon-star active"></i></li>
                              <!-- end ngRepeat: item in items track by $index -->
                              <li ng-touch="paintStars($index)" ng-mouseenter="paintStars($index, true)" ng-mouseleave="unpaintStars($index, false)" ng-repeat="item in items track by $index" class="ng-scope"><i ng-class="getClass($index)" ng-click="setValue($index, $event)" class="fa fa-fw uk-icon-star active"></i></li>
                              <!-- end ngRepeat: item in items track by $index -->
                              <li ng-touch="paintStars($index)" ng-mouseenter="paintStars($index, true)" ng-mouseleave="unpaintStars($index, false)" ng-repeat="item in items track by $index" class="ng-scope"><i ng-class="getClass($index)" ng-click="setValue($index, $event)" class="fa fa-fw uk-icon-star active"></i></li>
                              <!-- end ngRepeat: item in items track by $index -->
                              <li ng-touch="paintStars($index)" ng-mouseenter="paintStars($index, true)" ng-mouseleave="unpaintStars($index, false)" ng-repeat="item in items track by $index" class="ng-scope"><i ng-class="getClass($index)" ng-click="setValue($index, $event)" class="fa fa-fw uk-icon-star active"></i></li>
                              <!-- end ngRepeat: item in items track by $index -->
                              <li ng-touch="paintStars($index)" ng-mouseenter="paintStars($index, true)" ng-mouseleave="unpaintStars($index, false)" ng-repeat="item in items track by $index" class="ng-scope"><i ng-class="getClass($index)" ng-click="setValue($index, $event)" class="fa fa-fw uk-icon-star active"></i></li>
                              <!-- end ngRepeat: item in items track by $index -->
                           </ul>
                        </td>
                     </tr>
                     <!-- end ngRepeat: rate in productDetail.product_rate -->
                     <tr ng-repeat="rate in productDetail.product_rate" class="ng-scope">
                        <th class="uk-padding-remove ng-binding">ide</th>
                        <td>
                           <ul ng-class="listClass" icon-full="uk-icon-star" icon-empty="uk-icon-star-o" max="5" ng-model="rate.value" ng-click="giveRate(rate)" class="ng-scope ng-valid angular-input-stars">
                              <!-- ngRepeat: item in items track by $index -->
                              <li ng-touch="paintStars($index)" ng-mouseenter="paintStars($index, true)" ng-mouseleave="unpaintStars($index, false)" ng-repeat="item in items track by $index" class="ng-scope"><i ng-class="getClass($index)" ng-click="setValue($index, $event)" class="fa fa-fw uk-icon-star active"></i></li>
                              <!-- end ngRepeat: item in items track by $index -->
                              <li ng-touch="paintStars($index)" ng-mouseenter="paintStars($index, true)" ng-mouseleave="unpaintStars($index, false)" ng-repeat="item in items track by $index" class="ng-scope"><i ng-class="getClass($index)" ng-click="setValue($index, $event)" class="fa fa-fw uk-icon-star active"></i></li>
                              <!-- end ngRepeat: item in items track by $index -->
                              <li ng-touch="paintStars($index)" ng-mouseenter="paintStars($index, true)" ng-mouseleave="unpaintStars($index, false)" ng-repeat="item in items track by $index" class="ng-scope"><i ng-class="getClass($index)" ng-click="setValue($index, $event)" class="fa fa-fw uk-icon-star active"></i></li>
                              <!-- end ngRepeat: item in items track by $index -->
                              <li ng-touch="paintStars($index)" ng-mouseenter="paintStars($index, true)" ng-mouseleave="unpaintStars($index, false)" ng-repeat="item in items track by $index" class="ng-scope"><i ng-class="getClass($index)" ng-click="setValue($index, $event)" class="fa fa-fw uk-icon-star active"></i></li>
                              <!-- end ngRepeat: item in items track by $index -->
                              <li ng-touch="paintStars($index)" ng-mouseenter="paintStars($index, true)" ng-mouseleave="unpaintStars($index, false)" ng-repeat="item in items track by $index" class="ng-scope"><i ng-class="getClass($index)" ng-click="setValue($index, $event)" class="fa fa-fw uk-icon-star-o"></i></li>
                              <!-- end ngRepeat: item in items track by $index -->
                           </ul>
                        </td>
                     </tr>
                     <!-- end ngRepeat: rate in productDetail.product_rate -->
                  </tbody>
               </table>
            </div>
         </div>
         <div class="uk-width-medium-3-5 uk-width-small-1-1">
            <div class="uk-width-1-1 uk-margin-bottom">
               <div class="uk-panel uk-panel-hover">
                  <h3 class="uk-panel-title kg-heading"><i class="uk-icon-file-text-o"></i> Description</h3>
                  <p ng-bind-html="productDetail.product[0].product_desc" class="ng-binding">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>
               </div>
            </div>
            <div class="uk-width-1-1">
               <div class="uk-panel uk-panel-hover">
                  <h3 class="uk-panel-title kg-heading"><i class="uk-icon-table"></i> Detail</h3>
                  <table class="uk-table">
                     <tbody>
                        <tr>
                           <th>Table Data</th>
                           <td>Table Data</td>
                        </tr>
                        <tr>
                           <th>Table Data</th>
                           <td>Table Data</td>
                        </tr>
                        <tr>
                           <th>Table Data</th>
                           <td>Table Data</td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <div class="uk-grid uk-grid-divider uk-margin-top-remove">
         <div class="uk-width-1-1">
            <a href="https://www.mangamon.id/title/340429.html?volume=1" class="embedly-card">Embedly</a>
         </div>
         <div class="uk-width-1-1 uk-text-center uk-margin-bottom">
            <!-- ngRepeat: tag in productDetail.product_tag --><span class="ui tag label teal uk-text-large ng-binding ng-scope" ng-repeat="tag in productDetail.product_tag">komik</span><!-- end ngRepeat: tag in productDetail.product_tag --><span class="ui tag label teal uk-text-large ng-binding ng-scope" ng-repeat="tag in productDetail.product_tag">romance</span><!-- end ngRepeat: tag in productDetail.product_tag --><span class="ui tag label teal uk-text-large ng-binding ng-scope" ng-repeat="tag in productDetail.product_tag">shoujo</span><!-- end ngRepeat: tag in productDetail.product_tag --><span class="ui tag label teal uk-text-large ng-binding ng-scope" ng-repeat="tag in productDetail.product_tag">yellow</span><!-- end ngRepeat: tag in productDetail.product_tag -->
         </div>
         <div id="productFeedback" class="uk-width-1-1 uk-margin-bottom" ng-init="feedback.feedback_type = ''">
            <div class="uk-grid-width-1-2 ui labeled icon two item menu">
               <a class="item green" ng-class="{active: feedback.feedback_type == 'P' }" ng-click="feedback.feedback_type = 'P'">
                  <i class="uk-icon-thumbs-o-up icon"></i>
                  <div>Plus <span class="ui label ng-binding">5</span></div>
               </a>
               <a class="item red" ng-class="{active: feedback.feedback_type == 'N' }" ng-click="feedback.feedback_type = 'N'">
                  <i class="uk-icon-thumbs-o-down icon"></i>
                  <div>Minus <span class="ui label ng-binding">3</span></div>
               </a>
            </div>
            <!-- ngIf: feedback.feedback_type != '' -->
         </div>
         <div class="uk-width-1-2">
            <div class="ui comments">
               <!-- ngRepeat: fbPlus in productDetail.feedback_plus -->
               <div class="comment ng-scope" ng-repeat="fbPlus in productDetail.feedback_plus">
                  <a class="avatar"><img class="uk-border-circle" ng-src="http://files.katalogram.dev//user_pict/613b645a99d5.jpg" src="http://files.katalogram.dev//user_pict/613b645a99d5.jpg"></a>
                  <div class="content">
                     <a class="author ng-binding">raysaber</a>
                     <div class="text ng-binding">desain karakernya suka banget</div>
                     <div class="actions"><a ng-click="respondFb($index, fbPlus.feedback_id, 1)"><i class="uk-icon-thumbs-o-up"></i></a> <a ng-click="respondFb($index, fbPlus.feedback_id, 2)"><i class="uk-icon-thumbs-o-down"></i></a></div>
                  </div>
               </div>
               <!-- end ngRepeat: fbPlus in productDetail.feedback_plus -->
               <div class="comment ng-scope" ng-repeat="fbPlus in productDetail.feedback_plus">
                  <a class="avatar"><img class="uk-border-circle" ng-src="http://files.katalogram.dev//user_pict/613b645a99d5.jpg" src="http://files.katalogram.dev//user_pict/613b645a99d5.jpg"></a>
                  <div class="content">
                     <a class="author ng-binding">raysaber</a>
                     <div class="text ng-binding">Idenya juga saya suka, unik-unik gitu</div>
                     <div class="actions"><a ng-click="respondFb($index, fbPlus.feedback_id, 1)"><i class="uk-icon-thumbs-o-up"></i></a> <a ng-click="respondFb($index, fbPlus.feedback_id, 2)"><i class="uk-icon-thumbs-o-down"></i></a></div>
                  </div>
               </div>
               <!-- end ngRepeat: fbPlus in productDetail.feedback_plus -->
               <div class="comment ng-scope" ng-repeat="fbPlus in productDetail.feedback_plus">
                  <a class="avatar"><img class="uk-border-circle" ng-src="http://files.katalogram.dev//user_pict/613b645a99d5.jpg" src="http://files.katalogram.dev//user_pict/613b645a99d5.jpg"></a>
                  <div class="content">
                     <a class="author ng-binding">raysaber</a>
                     <div class="text ng-binding">wah suka banget artnya, stylenya itu lho</div>
                     <div class="actions"><a ng-click="respondFb($index, fbPlus.feedback_id, 1)"><i class="uk-icon-thumbs-o-up"></i></a> <a ng-click="respondFb($index, fbPlus.feedback_id, 2)"><i class="uk-icon-thumbs-o-down"></i></a></div>
                  </div>
               </div>
               <!-- end ngRepeat: fbPlus in productDetail.feedback_plus -->
               <div class="comment ng-scope" ng-repeat="fbPlus in productDetail.feedback_plus">
                  <a class="avatar"><img class="uk-border-circle" ng-src="http://files.katalogram.dev//user_pict/613b645a99d5.jpg" src="http://files.katalogram.dev//user_pict/613b645a99d5.jpg"></a>
                  <div class="content">
                     <a class="author ng-binding">raysaber</a>
                     <div class="text ng-binding">Bagus banget, tetep lanjutin yaaa</div>
                     <div class="actions"><a ng-click="respondFb($index, fbPlus.feedback_id, 1)"><i class="uk-icon-thumbs-o-up"></i></a> <a ng-click="respondFb($index, fbPlus.feedback_id, 2)"><i class="uk-icon-thumbs-o-down"></i></a></div>
                  </div>
               </div>
               <!-- end ngRepeat: fbPlus in productDetail.feedback_plus -->
               <div class="comment ng-scope" ng-repeat="fbPlus in productDetail.feedback_plus">
                  <a class="avatar"><img class="uk-border-circle" ng-src="http://files.katalogram.dev//user_pict/613b645a99d5.jpg" src="http://files.katalogram.dev//user_pict/613b645a99d5.jpg"></a>
                  <div class="content">
                     <a class="author ng-binding">raysaber</a>
                     <div class="text ng-binding">Wah saya suka nih ceritanya</div>
                     <div class="actions"><a ng-click="respondFb($index, fbPlus.feedback_id, 1)"><i class="uk-icon-thumbs-o-up"></i></a> <a ng-click="respondFb($index, fbPlus.feedback_id, 2)"><i class="uk-icon-thumbs-o-down"></i></a></div>
                  </div>
               </div>
               <!-- end ngRepeat: fbPlus in productDetail.feedback_plus -->
            </div>
         </div>
         <div class="uk-width-1-2 uk-text-right uk-margin-large-bottom">
            <div class="ui comments right">
               <!-- ngRepeat: fbMinus in productDetail.feedback_minus -->
               <div class="comment ng-scope" ng-repeat="fbMinus in productDetail.feedback_minus">
                  <a class="avatar"><img class="uk-border-circle" ng-src="http://files.katalogram.dev//user_pict/613b645a99d5.jpg" src="http://files.katalogram.dev//user_pict/613b645a99d5.jpg"></a>
                  <div class="content">
                     <a class="author ng-binding">raysaber</a>
                     <div class="text ng-binding">Ceritanya mestinya bisa lebih bagus lagi</div>
                     <div class="actions"><a ng-click="respondFb($index, fbPlus.feedback_id, 1)"><i class="uk-icon-thumbs-o-up"></i></a> <a ng-click="respondFb($index, fbPlus.feedback_id, 2)"><i class="uk-icon-thumbs-o-down"></i></a></div>
                  </div>
               </div>
               <!-- end ngRepeat: fbMinus in productDetail.feedback_minus -->
               <div class="comment ng-scope" ng-repeat="fbMinus in productDetail.feedback_minus">
                  <a class="avatar"><img class="uk-border-circle" ng-src="http://files.katalogram.dev//user_pict/613b645a99d5.jpg" src="http://files.katalogram.dev//user_pict/613b645a99d5.jpg"></a>
                  <div class="content">
                     <a class="author ng-binding">raysaber</a>
                     <div class="text ng-binding">dih kok begitu sih ceritanya</div>
                     <div class="actions"><a ng-click="respondFb($index, fbPlus.feedback_id, 1)"><i class="uk-icon-thumbs-o-up"></i></a> <a ng-click="respondFb($index, fbPlus.feedback_id, 2)"><i class="uk-icon-thumbs-o-down"></i></a></div>
                  </div>
               </div>
               <!-- end ngRepeat: fbMinus in productDetail.feedback_minus -->
               <div class="comment ng-scope" ng-repeat="fbMinus in productDetail.feedback_minus">
                  <a class="avatar"><img class="uk-border-circle" ng-src="http://files.katalogram.dev//user_pict/613b645a99d5.jpg" src="http://files.katalogram.dev//user_pict/613b645a99d5.jpg"></a>
                  <div class="content">
                     <a class="author ng-binding">raysaber</a>
                     <div class="text ng-binding">yah sayang banget kurang greget</div>
                     <div class="actions"><a ng-click="respondFb($index, fbPlus.feedback_id, 1)"><i class="uk-icon-thumbs-o-up"></i></a> <a ng-click="respondFb($index, fbPlus.feedback_id, 2)"><i class="uk-icon-thumbs-o-down"></i></a></div>
                  </div>
               </div>
               <!-- end ngRepeat: fbMinus in productDetail.feedback_minus -->
            </div>
         </div>
      </div>
   </div>
   <div class="uk-container-center uk-grid uk-modal-footer uk-text-center" data-uk-sticky="{bottom:0}">
      <div class="ui labeled button" tabindex="0">
         <div class="ui red button"><i class="uk-icon-heart"></i> Favorit</div>
         <a class="ui basic red left pointing label ng-binding">1</a>
      </div>
      <div class="ui labeled button" tabindex="0">
         <div class="ui yellow button"><i class="uk-icon-star-o"></i> Rating</div>
         <a class="ui basic yellow left pointing label ng-binding">4.1</a>
      </div>
      <div class="ui labeled button" tabindex="0">
         <div class="ui basic blue button"><i class="uk-icon-thumbs-o-up"></i> Pros</div>
         <a class="ui basic left pointing blue label ng-binding">5</a>
      </div>
      <div class="ui labeled button" tabindex="0">
         <div class="ui basic blue button"><i class="uk-icon-thumbs-o-down"></i> Cons</div>
         <a class="ui basic left pointing blue label ng-binding">3</a>
      </div>
   </div>
   <script src="http://katalogram.dev/js/lib.min.js" type="text/javascript"></script>
	<script src="http://katalogram.dev/js/katalogram.min.js" type="text/javascript"></script>
   <script>
	  /*(function(w, d){
	   var id='embedly-platform', n = 'script';
	   if (!d.getElementById(id)){
	     w.embedly = w.embedly || function() {(w.embedly.q = w.embedly.q || []).push(arguments);};
	     var e = d.createElement(n); e.id = id; e.async=1;
	     e.src = ('https:' === document.location.protocol ? 'https' : 'http') + '://cdn.embedly.com/widgets/platform.js';
	     var s = d.getElementsByTagName(n)[0];
	     s.parentNode.insertBefore(e, s);
	   }
	  })(window, document);*/
	</script>
</body>
</html>