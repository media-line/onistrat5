jQuery(document).ready(function(){ 
    new WOW().init();
    
    /*
    jQuery('#main-slider .item').click(function(){ 
        jQuery(this).children('.uk-video-block').fadeIn(300);
        jQuery('.vjs-big-play-button').click();
    });*/
   /* var playing = true;
    jQuery("#myVideo").click(function(){ 
        this.paused ? this.play() : this.pause();
    });
    */
    
    resizeAboutImages();
    
    jQuery('.uk-carousel-about .uk-button').click(function(){
        resizeAboutImages();
    });
    /*
    jQuery(window).resize(function() {
        resizeAboutImages();
    });*/
    
    //main slider handler
    jQuery('.js-play').click(function(){
        jQuery('#main-slider').carousel('pause');
        jQuery('.js-play').removeClass('hidden');
        var id = jQuery(this).attr('data-video-id');
        jQuery('#main-slider img').removeClass('slide-image-hidden');
        jQuery('video').each(function(){
            getController(jQuery(this).attr('id')).pause();
        });
        jQuery(this).closest('.item').find('img').addClass('slide-image-hidden');
        jQuery(this).addClass('hidden');
        getController(id).play();
    });
    jQuery('.js-pause').click(function(){
        var id = jQuery(this).attr('data-video-id');
        getController(id).pause();
        jQuery('.js-play').removeClass('hidden');
        jQuery(this).closest('.item').find('img').removeClass('slide-image-hidden');
        jQuery('#main-slider').carousel('cycle');
    });
    
    
    //on scroll functions
	if ((jQuery('html').width()) > 991){
		jQuery(window).scroll(function () {
            //to top scroller
			if (jQuery(this).scrollTop() > 400) {
				jQuery('.uk-to-top').fadeIn(400);
			} else {
                jQuery('.uk-to-top').fadeOut(400);
			}
            //top-line menu
            /*var headerEndPosition = jQuery('.js-header-end').offset();
            alert(headerEndPosition);
            var scrollTopPosition = jQuery(window).scrollTop();
            console.log(headerEndPosition+' '+scrollTopPosition);
            if((headerEndPosition - scrollTopPosition) < 0){
                jQuery('.js-topline').addClass('uk-visible');
            } else {
                jQuery('.js-topline').removeClass('uk-visible');
            }*/
		});
	}	
	jQuery(window).scroll(function () {
            //top-line menu
            var headerEndPosition = jQuery('.js-header-end').offset().top;
            var scrollTopPosition = jQuery(window).scrollTop();
            if((headerEndPosition - scrollTopPosition) < 0){
                jQuery('.js-topline').addClass('uk-visible');
            } else {
                jQuery('.js-topline').removeClass('uk-visible');
            }
	});
    
    jQuery('.uk-to-top').click( function(){
	    var scroll_el = jQuery(this).attr('href');
        if (jQuery(scroll_el).length != 0) { 
			jQuery('html, body').animate({ scrollTop: jQuery(scroll_el).offset().top }, 700); 
        }
	    return false; 
    });
	
	//Эффекты формы в модальном окне на странице мероприятий (events)
	jQuery('.uk-ev-mod-content-button').click( function(){
		jQuery(this).addClass('uk-disable');
		jQuery(this).closest('.uk-events-modal-content').find('.uk-event-form').slideDown(500);
		return false; 
    });
    
    //Функция обработки формы платных мероприятий
    jQuery('.uk-ev-mod-pay-button').click(function(){ 
        var successUrl = jQuery(this).closest('.uk-event-form').find('.uk-success-url').val();
        var failedUrl = jQuery(this).closest('.uk-event-form').find('.uk-failed-url').val();
        var name = encodeURIComponent(jQuery(this).closest('.uk-event-form').find('.uk-name').val());
        var lastName = encodeURIComponent(jQuery(this).closest('.uk-event-form').find('.uk-lastname').val());
        var email = encodeURIComponent(jQuery(this).closest('.uk-event-form').find('.uk-email').val());
        var date = encodeURIComponent(jQuery(this).closest('.uk-event-form').find('.uk-date').val());
        var subject = encodeURIComponent(jQuery(this).closest('.uk-event-form').find('.uk-subject').val());
        successUrl = successUrl + '&date=' + date + '&subject=' + subject + '&name=' + name + '&last_name=' + lastName + '&email=' + email;
        failedUrl = failedUrl + '&date=' + date + '&subject=' + subject + '&name=' + name + '&last_name=' + lastName + '&email=' + email;
        alert(successUrl);
        
        var successUrl = jQuery(this).closest('.uk-event-form').find('.uk-success-url').val(successUrl);
        var failedUrl = jQuery(this).closest('.uk-event-form').find('.uk-failed-url').val(failedUrl);
        
        jQuery(this).closest('.uk-event-form').submit();
        
        return false;
    });
});
function resizeAboutImages(){
    jQuery('.js-about-image img').each(function(){ 
        jQuery(this).load(function(){ 
            if(jQuery(this).is(":visible")){ 
                var height = jQuery(this).parent().parent().outerHeight();
                var height2 = jQuery(this).parent().parent().next('.uk-about-content').outerHeight();
                if(height < height2){
                    jQuery(this).parent().parent().outerHeight(height2+30);
                    jQuery(this).css({
                        'margin-top': (height2-height+30)+'px'
                    });
                }
            }
        });
    });
};

(function ($) {
	// this function is a shortcut for creating new elements in jQuery
	$.ce = function(t){
		return $(document.createElement(t));
	};
	// this function draws SVG circle arcs on top of a SVG circle
	$.fn.drawCircle = function(a){
		var t = this;
		
		// theese are the default arguments of the svg drawings, you can use all of them to invoke your own paths.
		
		var args = $.extend({
			startAng:0, 							// the start angle of the arc in degrees
			endAng:360, 							// the end angle of the arc in degrees
			r:90, 									// the radius of the circles
			railHighlightColor:'rgba(0, 0, 0, 0)', 	// the color of the rail
			railFill:'none', 						// the fill color of the rail
			railStrokeColor:'#e4e4e4', 				// the stroke color of the rail
			railStrokeWidth:1, 						// the stroke width of the rail
			pathHiglightColor:'rgba(0, 0, 0, 0.4)',	// the path's hightlight color
			pathFill:'none',						// the path' fill color
			pathStrokeColor:'#16a6b6',				// the path's stroke color
			pathStrokeWidth:1						// the path's stroke width
		},a);
		
		
		args.diam = args.r*2;
		
		var stroke = args.railStrokeWidth;
		if (args.pathStrokeWidth > args.railStrokeWidth) stroke = args.pathStrokeWidth;
		var hs = stroke/2;
		var center = args.r+hs;
		
		// this creates the base object for the circle
		$.fn.createSvg = function(){
			var w = $.ce('div').css({
				width:(args.diam + stroke),
				height:(args.diam + stroke),
			});
			t.append(w);
			var o = ''+
			'<svg class="zeSvg" width="'+(args.diam+stroke)+'" width="'+(args.diam+stroke)+'" viewbox="0 0 '+(args.diam+stroke)+' '+(args.diam+stroke)+'" version="1.1" xmlns="http://www.w3.org/2000/svg">'+
			'<circle class="zeCircle" style="-webkit-tap-highlight-color: '+args.railHighlightColor+';" cx="'+center+'" cy="'+center+'" r="'+args.r+'" fill="'+args.railFill+'" stroke="'+args.railStrokeColor+'" stroke-width="'+args.railStrokeWidth+'"></circle>'+
			'<path class="zePath" style="-webkit-tap-highlight-color:'+args.pathHiglightColor+';" fill="'+args.pathFill+'" stroke="'+args.pathStrokeColor+'" stroke-width="'+args.pathStrokeWidth+'"></path>'+
			'</svg>';
			w.append(o);
		};
		
		// this converts polar coordinates to Cartesian... basic trigonometry stuff
		$.fn.drawCircle.polarToCartesian = function(centerX, centerY, radius, angleInDegrees) {
			var angleInRadians = (angleInDegrees - 90) * Math.PI / 180.0;

			return {
				x: centerX + (radius * Math.cos(angleInRadians)),
				y: centerY + (radius * Math.sin(angleInRadians))
			};
		};
		// this function creates the SVG arc description argument we are to draw with
		$.fn.drawCircle.describeArc =function(x, y, radius, startAngle, endAngle) {

			var start = $.fn.drawCircle.polarToCartesian(x, y, radius, endAngle);
			var end = $.fn.drawCircle.polarToCartesian(x, y, radius, startAngle);

			var arcSweep = endAngle - startAngle <= 180 ? "0" : "1";

			var d = [
				"M", start.x, start.y,
				"A", radius, radius, 0, arcSweep, 0, end.x, end.y
			].join(" ");

			return d;
		};
		
		// this function updates the arc attribute in the SVG element
		$.fn.drawCircle.draw = function() {
			var d = $.fn.drawCircle.describeArc(center,center,args.r,args.startAng,args.endAng);
			var svg = t.find('.zePath')[0];
			svg.setAttribute('d', d);
		};
		
		// here we find out if the SVG exists to change it, otherwise, we draw it
		if(t.find('.zeSvg').length>0){
			$.fn.drawCircle.draw(args.pct);
		} else {
			$.fn.createSvg();
			$.fn.drawCircle.draw(args.pct);
		}
		
	};
	
	// this function is a shortcut to handle the jQuery elements data function
	$.d = function(key,val){
		if (typeof(val)=='undefined'){
			return $(self).data(key);
		} else {
			$(self).data(key,val);
		}
	};
})(jQuery);


//video player
function getController(id) {
    
    document._video = document.getElementById(id);
    if (document._video.controller != undefined && document._video.controller != null) {
      document._controller = document._video.controller;
      document._hasController = true;
    } else {
      document._controller = document._video.controller;
      document._hasController = false;
    }
    
	if (document._hasController) {
		return document._controller;
	} else {
		return document._video;
	}
}