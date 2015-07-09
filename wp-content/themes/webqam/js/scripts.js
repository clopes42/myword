// Declare namespace
var Webqam = Webqam || {};

Webqam.General = function() {};

Webqam.General.prototype = {

    init: function() {

    }

};

$(document).ready(function(){

    var g = new Webqam.General();
    g.init();


    jQuery.scrollSpeed(150, 800);
});