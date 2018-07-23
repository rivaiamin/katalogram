function downloadJSAtOnload() {
    var element = document.createElement("script");
    element.src = "js/lib.min.js";
    document.body.appendChild(element);

    var element = document.createElement("script");
    element.src = "js/katalogram.min.js";
    document.body.appendChild(element);
}
if (window.addEventListener) window.addEventListener("load", downloadJSAtOnload, false);
else if (window.attachEvent) window.attachEvent("onload", downloadJSAtOnload);
else window.onload = downloadJSAtOnload;