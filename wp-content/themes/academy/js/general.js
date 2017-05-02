//Theme Options
var themeElements = {
	siteWrap: '.site-wrap',
	footerWrap: '.footer-wrap',
	mainMenu: '.header-navigation',
	selectMenu: '.select-menu',
	ratingForm: '.rating-form',
	themexSlider: '.themex-slider',
	parallaxSliderClass: 'parallax-slider',
	toolTip: '.tooltip',
	toolTipWrap: '.tooltip-wrap',
	tooltipSwitch: '.switch-button',
	button: '.button',
	submitButton: '.submit-button',
	printButton: '.print-button',
	facebookButton: '.facebook-button',
	toggleTitle: '.toggle-title',
	toggleContent: '.toggle-content',
	toggleElement: '.toggle-element',
	toggleContainer: '.toggle-container',
	accordionContainer: '.accordion',
	tabsContainer: '.tabs-container',
	tabsTitles: '.tabs',
	tabsPane: '.pane',
	playerContainer: '.jp-container',
	playerSource: '.jp-source a',
	player: '.jp-jplayer',
	playerFullscreen: '.jp-screen-option',
	placeholderFields: '.popup-form input',
	userImageUploader: '.user-image-uploader',
	popupContainer: '.popup-container',
	googleMap: '.google-map-container',
	woocommercePrice: '.product-price',
	woocommerceTotal: 'tr.total',
	widgetTitle: '.widget-title',
	ajaxForm: '.ajax-form',
	galleryBoxHome : '.gallery-box',
	teamBoxHome : '.slide-holder',
	comProgramsHome : '.program-box .list-box > li',
	subMenu : 'ul.menu-header-menu > li > .sub-menu > li',
	infoHome : '.clarke-bg .col-holder > div.col',
	infoHome1 : '.info-block-1 .col-holder > div.col'
};

//DOM Loaded
jQuery(document).ready(function($) {
	
	//Home gallery
	$(themeElements.galleryBoxHome).slick({
		dots: true,
		autoplay: true,
		autoplaySpeed: 5000,
	});
	
	// resize 'compare' blocks on home page
	initCalcBlockWidth(themeElements.comProgramsHome, 97.5);
	function initCalcBlockWidth( item, size ){
		var width = 0;
		var countli = $(item).length;
		if (countli > 0 && $(window).width() > 766) {
			width = size/countli;
			$(item).css({'width': width+'%'});
		}
	}
	
	//Team slider on home page
	initTeamSlider();
	function initTeamSlider(){
		if ( $(window).width() < 481 ) {
			$(themeElements.teamBoxHome).slick({
				adaptiveHeight: true,
				arrows: false,
				infinite: true,
				slidesToShow: 1,
				slidesToScroll: 1,
			});
		}
	}
	
	//
	
	function initComProgramsSameHeight(item){
		var item_height = 0;
		var chek_height = 0;
		$(item).height('');
		$(item).each(function(item){
			chek_height = $(this).height();
			if (item_height < chek_height) {
				item_height = chek_height;
			}
		});
		$(item).height(item_height);
	}
	
	$(window).on('resize', function (e) {
		if ( $(window).width() >= 481 && $("div").is(themeElements.teamBoxHome+".slick-slider") ) {
			$(themeElements.teamBoxHome).slick('unslick');
		}else{
			if ( $(window).width() < 481 && $("div").is(themeElements.teamBoxHome+".slick-slider") == false ){
				$(themeElements.teamBoxHome).slick({
					adaptiveHeight: true,
					arrows: false,
					infinite: true,
					slidesToShow: 1,
					slidesToScroll: 1,
				});
			}
		}
		
		if ( $(window).width() > 766){
			initCalcBlockWidth(themeElements.comProgramsHome, 97.5);
		}else{
			$(themeElements.comProgramsHome).css({'width': '100%'});
		}
	});
	
	// Ajax load posts
	$(window).scroll(function(){
		if ( $('div').is('.article-box .post')){
			var scroll_pos = ($('.post:last').offset().top)-200;
			if( $(this).scrollTop() >= scroll_pos && !$('body').hasClass('loading-gif') && !$('body').hasClass('allposts') && typeof true_posts !=="undefined"){
				var data = {
					'action': 'loadmore',
					'query': true_posts,
					'page' : current_page
				};
				$.ajax({
					url:ajaxurl,
					data:data,
					type:'POST',
					beforeSend: function( xhr){
						$('body').addClass('loading-gif');
					},
					success:function(data){
						if( data ) { 
							$('.article-box').append(data);
							$('body').removeClass('loading-gif');
							current_page++;
						}else{
							$('body').removeClass('loading-gif').addClass('allposts');
						}
					}
				});
			}
		}
	});
	
	$(document).on('mouseover', '.menu-header-menu > li', function(){
		initComProgramsSameHeight(themeElements.subMenu);
	});
	
	$(document).on('click', '.no-link', function(event){
		event.preventDefault();
	});
	
	//Dropdown Menu
	$(themeElements.mainMenu).find('li').hoverIntent(
		function() {
			var menuItem=$(this);
			menuItem.parent('ul').css('overflow','visible');			
			menuItem.children('ul').slideToggle(200, function() {
				menuItem.addClass('hover');
			});
		},
		function() {
			var menuItem=$(this);
			menuItem.children('ul').slideToggle(200, function() {
				menuItem.removeClass('hover');
			});
		}
	);
	
	//Select Menu
	$(themeElements.selectMenu).find('select').fadeTo(0, 0);
	$(themeElements.selectMenu).find('span').text($(themeElements.selectMenu).find('option:eq(0)').text());
	$(themeElements.selectMenu).find('option').each(function() {
		if(window.location.href==$(this).val()) {
			$(themeElements.selectMenu).find('span').text($(this).text());
			$(this).attr('selected','selected');
		}
	});
	
	$(themeElements.selectMenu).find('select').change(function() {
		window.location.href=$(this).find('option:selected').val();
		$(themeElements.selectMenu).find('span').text($(this).find('option:selected').text());
	});

	//Course Rating
	$(themeElements.ratingForm).each(function() {
		var rating=$(this).children('div'),
			form=$(this).children('form');
			
		rating.raty({
			score: rating.data('score'),
			readOnly: rating.data('readonly'),
			hints   : ['', '', '', '', ''],
			noRatedMsg : '',
			click: function(score, evt) {
				form.find('.rating').val(score);
				form.submit();
			}
		});
	});
	
	//Audio and Video
	$(themeElements.playerContainer).bind('contextmenu', function() {
		return false;
	}); 

	if($(themeElements.playerContainer).length) {
		$(themeElements.playerContainer).each(function() {
			var mediaPlayer=$(this);
			var suppliedExtensions='';
			var suppliedMedia=new Object;
			
			mediaPlayer.find(themeElements.playerSource).each(function() {
				var mediaLink=$(this).attr('href');
				var mediaExtension=$(this).attr('href').split('.').pop();
				
				if(mediaExtension=='webm') {
					mediaExtension='webmv';
				}
				
				if(mediaExtension=='mp4') {
					mediaExtension='m4v';
				}
				
				suppliedMedia[mediaExtension]=mediaLink;				
				suppliedExtensions+=mediaExtension;
				
				if(!$(this).is(':last-child')) {
					suppliedExtensions+=',';
				}
			});
		
			mediaPlayer.find(themeElements.player).jPlayer({
				ready: function () {
					$(this).jPlayer('setMedia', suppliedMedia);
				},
				swfPath: 'js/jplayer/Jplayer.swf',
				supplied: suppliedExtensions,
				cssSelectorAncestor: '#'+mediaPlayer.attr('id'),
				solution: 'html, flash',
				wmode: 'window'
			});		
			
			mediaPlayer.show();
		});		
		
		$(themeElements.playerFullscreen).click(function() {
			$('body').toggleClass('fullscreen-video');
		});
	}	
	
	//Sliders
	$(themeElements.themexSlider).each(function() {
		var sliderOptions= {
			speed: parseInt($(this).find('.slider-speed').val()),
			pause: parseInt($(this).find('.slider-pause').val()),
			effect: $(this).find('.slider-effect').val()
		};
		
		$(this).themexSlider(sliderOptions);
	});
	
	//Tooltips
	$(themeElements.toolTip).click(function(e) {
		var tooltipButton=$(this).children(themeElements.button);
		if(!tooltipButton.hasClass('active')) {
			var tipCloud=$(this).find(themeElements.toolTipWrap).eq(0);
			if(!tipCloud.hasClass('active')) {
				tooltipButton.addClass('active');
				$(themeElements.toolTipWrap).hide();
				tipCloud.addClass('active').fadeIn(200);
			}
		}
		
		return false;
	});
	
	$(themeElements.tooltipSwitch).click(function() {
		var tipCloud=$(this).parent();
		while(!tipCloud.is(themeElements.toolTipWrap)) {
			tipCloud=tipCloud.parent();
		}
		
		tipCloud.fadeOut(200, function() {
			$(this).next(themeElements.toolTipWrap).addClass('active').fadeIn(200);
		});
		
		return false;
	});
	
	$('body').click(function() {
		$(themeElements.toolTipWrap).fadeOut(200, function() {
			$(this).removeClass('active');
		});
		$(themeElements.toolTipWrap).parent().children(themeElements.button).removeClass('active');
	});
	
	//Placeholders
	$('input, textarea').each(function(){
		if($(this).attr('placeholder')) {
			$(this).placeholder();
		}		
	});
	
	$(themeElements.placeholderFields).each(function(index, item){
		item = $(item);
		var defaultStr = item.val();
	
		item.focus(function () {
			var me = $(this);
			if(me.val() == defaultStr){
				me.val('');
			}
		});
		item.blur(function () {
			var me = $(this);			
			if(!me.val()){
				me.val(defaultStr);
			}
		});
	});
	
	//Popup
	$(themeElements.popupContainer).each(function() {
		var popup=$(this).find('.popup');

		if(popup.length) {
			$(this).find('a').each(function() {
				if(!$(this).hasClass('disabled')) {
					$(this).click(function() {
						popup.stop().hide().fadeIn(300, function() {
							window.setTimeout(function() {
								popup.stop().show().fadeOut(300);
							}, 2000);
						});
						
						return false;
					});
				}
			});
		}
	});
	
	//Toggles
	$(themeElements.accordionContainer).each(function() {
		if(!$(this).find(themeElements.toggleContainer+'.expanded').length) {
			$(this).find(themeElements.toggleContainer).eq(0).addClass('expanded').find(themeElements.toggleContent).show();
		}
	});
	
	$(themeElements.toggleTitle).live('click', function() {
		if($(this).parent().parent().hasClass('accordion') && $(this).parent().parent().find('.expanded').length) {
			if($(this).parent().hasClass('expanded')) {
				return false;
			}
			$(this).parent().parent().find('.expanded').find(themeElements.toggleContent).slideUp(200, function() {
				$(this).parent().removeClass('expanded');			
			});
		}
		
		$(this).parent().find(themeElements.toggleContent).slideToggle(200, function(){
			$(this).parent().toggleClass('expanded');		
		});
	});
	
	if(window.location.hash && $(window.location.hash).length) {
		$(window.location.hash).each(function() {
			var item=$(this);
			
			if(item.parent().hasClass('children')) {
				item=$(this).parent().parent();
			}
			
			item.addClass('expanded');
		});
	}
	
	$(themeElements.toggleElement).each(function() {
		var element=$(this);
		
		if(element.data('class')) {
			var toggles=$('.'+element.data('class'));
			
			if(toggles.length) {
				toggles.find('*').hide();				
				element.click(function() {
					toggles.find('*').slideToggle(200);
					setTimeout(function() {
						element.toggleClass('expanded');
					}, 200);
				});
			}
		}
	});
	
	//Tabs
	$(themeElements.tabsContainer).each(function() {		
		var tabs=$(this);
		
		//show current pane
		if(window.location.hash && tabs.find(window.location.hash+'-tab').length) {
			var currentPane=tabs.find(window.location.hash+'-tab');
			currentPane.show();
			$(window).scrollTop(tabs.offset().top);
			tabs.find(themeElements.tabsTitles).find('li').eq(currentPane.index()).addClass('current');
		} else {
			tabs.find(themeElements.tabsPane).eq(0).show().addClass('current');
			tabs.find(themeElements.tabsTitles).find('li').eq(0).addClass('current');
		}
		
		tabs.find('.tabs li').click(function() {
			//set tab link
			window.location.href=$(this).find('a').attr('href');
			
			//set active state to tab
			tabs.find('.tabs li').removeClass('current');
			$(this).addClass('current');
			
			//show current tab
			tabs.find('.pane').hide();
			tabs.find('.pane:eq('+$(this).index()+')').show();

			return false;
		});
	});	
	
	//AJAX Form
	$(themeElements.ajaxForm).each(function() {
		var form=$(this);
		
		form.submit(function() {
			var message=form.find('.message'),
				loader=form.find('.form-loader'),
				button=form.find(themeElements.submitButton);
				
			var data={
					action: form.find('.action').val(),
					nonce: form.find('.nonce').val(),
					data: form.serialize(),
				}
						
			button.addClass('disabled');
			loader.show();
			message.slideUp(300);
			
			$.post(form.attr('action'), data, function(response) {
				if($('.redirect', response).length) {
					if($('.redirect', response).attr('href')) {
						window.location.href=$('.redirect',response).attr('href');
					} else {
						window.location.reload();
					}
				} else {
					loader.hide();
					button.removeClass('disabled');
					message.html(response).slideDown(300);
				}
			});
			
			return false;
		});
	});
	
	//Submit Button
	$(themeElements.submitButton).not('.disabled').click(function() {
		var form=$($(this).attr('href'));
		
		if(!form.length || !form.is('form')) {
			form=$(this).parent();
			while(!form.is('form')) {
				form=form.parent();
			}
		}
			
		form.submit();		
		return false;
	});
	
	$('input').keypress(function (e) {
		var form=$(this).parent();
	
		if (e.which==13) {
			e.preventDefault();
			
			while(!form.is('form')) {
				form=form.parent();
			}
			
			
			form.submit();
		}
	});
	
	//Print Button
	$(themeElements.printButton).click(function() {
		window.print();
		return false;
	});
	
	//Facebook Button
	$(themeElements.facebookButton).click(function() {
		var redirect=$(this).attr('href');
		
		if(typeof(FB)!='undefined') {
			FB.login(function(response) {
				if (response.authResponse) {
					window.location.href=redirect;
				}
			}, {
				scope: 'email',
			});
		}
		
		return false;
	});
	
	//Image Uploader
	$(themeElements.userImageUploader).find('input[type="file"]').change(function() {
		var form=$(this).parent();
		
		while(!form.is('form')) {
			form=form.parent();
		}
		
		form.submit();
	});
	
	//Google Map
	$(themeElements.googleMap).each(function() {
		var container=$(this);		
		var position = new google.maps.LatLng(container.find('.map-latitude').val(), container.find('.map-longitude').val());
		var myOptions = {
		  zoom: parseInt(container.find('.map-zoom').val()),
		  center: position,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(
			document.getElementById('google-map'),
			myOptions);
	 
		var marker = new google.maps.Marker({
			position: position,
			map: map,
			title:container.find('.map-description').val()
		});  
	 
		var infowindow = new google.maps.InfoWindow({
			content: container.find('.map-description').val()
		});
	 
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map,marker);
		});
	});
	
	//WooCommerce
	$('body').bind('updated_checkout', function() {
		var total=$(themeElements.woocommerceTotal).find('.amount');
		
		if(total.length) {
			$(themeElements.woocommercePrice).find('.amount').each(function() {
				if(!$(this).parent().is('del')) {
					$(this).text(total.text());
				}
			});
		}
	});
	
	//Window Loaded
	$(window).bind('load resize', function(e) {
		image_scalling();
		initComProgramsSameHeight(themeElements.comProgramsHome);
		initComProgramsSameHeight(themeElements.infoHome);
		initComProgramsSameHeight(themeElements.infoHome1);
		
		if(e.type == 'load'){
		    setTimeout(image_scalling,1000);
		}
	}).trigger('resize');
	
    function image_scalling(){
        $('.col img.box-image').removeClass('fix-height').height('');
        $('.col img.box-image').each(function(){
            var parent = $(this).parent().height(),
                current_height = $(this).height();
            
            if(parent > current_height){
                $(this).addClass('fix-height').height(parent);
            }
        });
    }
    
	//IE Detector
	if ( $.browser.msie ) {
		$('body').addClass('ie');
	}
	
	//DOM Elements
	$('p:empty').remove();
	$('h1,h2,h3,h4,h5,h6,blockquote').prev('br').remove();
	
	$(themeElements.widgetTitle).each(function() {
		if($(this).text()=='') {
			$(this).remove();
		}
	});
	
	$('ul, ol').each(function() {
		if($(this).css('list-style-type')!='none') {
			$(this).css('padding-left', '1em');
			$(this).css('text-indent', '-1em');
		}
	});
    
    $('.login-form').submit(function(e){
        e.preventDefault();
    });
    $('.login-form').keyup(function(e){
        if(e.keyCode == 13){
            e.preventDefault();
            
            var data = $(this).serialize();
            data += '&action=themex_login_user';
            $.post(ajaxUrl,data,function(response){
                if(response.status == 'ok'){
                    window.location.href = response.redirect;
                }else{
                    alert(response.message);
                }
            },'json');
        }
    });
    
    $('#video-play').click(function(e){
        e.preventDefault();
        
        var h = $('#video-block img').height();
        $('#video-block').height(h).html('<iframe src="//player.vimeo.com/video/102013114?autoplay=1" width="100%" height="'+h+'" frameborder="0" title="MC Website Promo" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');
    });
    
    $('.menu-header-menu a').click(function(e){
        if($(this).attr('href') == '#'){
            e.preventDefault();
        }
    });
	
    if($('.article-box').length){
        $(window).resize(function(){
            $('.article-box').sameHeight({
                elements: '.col',
                multiLine: true
            });
        }).trigger('resize');
    }
	
    if($('#top-box').length){
        $(window).scroll(function(){
            var top = $(this).scrollTop();
            if(top > 200){
                $('#top-box').fadeIn(500);
            }else{
                $('#top-box').fadeOut(500);
            }
        }).trigger('scroll'); 
        
        $('#top').click(function(e){
            e.preventDefault();
            
            $('html,body').animate({scrollTop:0},1000);
        });   
    }
    
    $('.panel-box .menu').click(function(e){
        e.preventDefault();
        
        $('.nav').slideToggle(500);
    });
    
    $('.menu-header-menu > li,.account-block .block').hover(function(){
        $(this).find('.sub-menu').stop(true,true).fadeIn(300);
    },function(e){
        $('.menu-header-menu .sub-menu,.account-block .sub-menu').stop(true,true).fadeOut(300);
    });
    
    window._do = {
        elements: [],
        detectList: [],
        visit: [],
        
        set: function(el){
            var items = $(el), $this = this;
            items.each(function(){
                var ind = $(this).attr('class').replace(' ','');
                if(typeof($this.detectList[ind]) == 'undefined'){
                    var item = $(this);
                    var t = item.offset().top;
                    
                    $this.detectList[ind] = {
                        id: item.attr('t'),
                        top: t,
                        item: item,
                        bottom: t + item.height()
                    }
                }
            });
        },
        
        detect: function(winInfo){
        	var finded = false;
            for(var el in this.detectList){
                if(this.detectList[el].bottom < winInfo.bottom && !this.visit[el]){
                    this.visit[el] = true;
                    finded = true;
                    _do.elements.push(this.detectList[el].item);
                }  
            }
            
            if(finded)
            	return true;
            return false;
        },
        
        in_proc: false,
        show: function(el){
            if(_do.in_proc)
                return;
            
            _do.in_proc = true;
            
            function act(i){
                if(typeof(_do.elements[i]) == 'undefined'){
                    _do.in_proc = false;
                    _do.elements = [];
                    return;
                }
                
                $(_do.elements[i]).animate({opacity:1},300,function(){
                    setTimeout(function(){
                    	i++;
                        act(i);
                    },300);
                });
            }
            
            act(0);
        }
    }
    
    if($('#fade-box').length){
        _do.set('#fade-box .box');
        $(window).scroll(function(){
            var t = $(this).scrollTop(),
                h = $(this).height();
            var winInfo = {
                top: t,
                bottom: t + h
            }
            if(_do.detect(winInfo)){
                _do.show();
            }
        }).trigger('scroll');
    }
    
    date_left('#date-box-1');
    date_left('#date-box-2');
    setInterval(function(){
        date_left('#date-box-1');
        date_left('#date-box-2');
    },10000);
    
    function date_left(tar){
        var current = new Date();
        
        var y = parseInt($(tar).attr('y')),
            m = parseInt($(tar).attr('m'))-1,
            d = parseInt($(tar).attr('d'));
            
        var finish = new Date(y,m,d);
        var left = parseInt((finish.getTime() - current.getTime())/1000);
        
        var days  = parseInt(left/(3600*24));
        left -= days*3600*24;
        
        var hours = parseInt(left/3600);
        left -= hours*3600;
        
        var mins = parseInt(left/60);
        
        if(days > 9)
            days = days.toString().split('');
        else
            days = [0,days < 0 ? 0 : days];
        
        if(hours > 9)
            hours = hours.toString().split('');
        else
            hours = [0,hours < 0 ? 0 : hours];
        
        if(mins > 9)
            mins = mins.toString().split('');
        else
            mins = [0,mins < 0 ? 0 : mins];
        
        $(tar).find('.days .n1').html(days[0]);
        $(tar).find('.days .n2').html(days[1]);
        if(days.length == 3){
            $(tar).find('.days').addClass('big');
            $(tar).find('.days .n3').show().html(days[2]);
        }
            
        $(tar).find('.hours .n1').html(hours[0]);
        $(tar).find('.hours .n2').html(hours[1]);
        
        $(tar).find('.mins .n1').html(mins[0]);
        $(tar).find('.mins .n2').html(mins[1]);
    }
    
    $('#pay-deposit,#pay-balance').click(function(e){
        e.preventDefault();
        
        var _this = this;
        
        if($(_this).hasClass('paid')){
            alert('You have already paid the '+$(_this).attr('id').replace('pay-',''));
            return false;
        }
        
        if($(_this).hasClass('unpaid')){
            alert('First you need to pay the deposit');
            return false;
        }
        
        if($(_this).hasClass('process') || $(_this).hasClass('bloked'))
            return false;
        
        var data = {
            action: 'pay_deposit',
            product_id: $(_this).attr('pid')
        }
        
        $(_this).addClass('process');
        $.post(ajaxUrl,data,function(response){
            if(response.in_cart){
                window.location.href = '/checkout';
            }else{
                data.action = 'woocommerce_add_to_cart';
                
                $.post(ajaxUrl,data,function(result){
                    if(response.error){
                        $(_this).removeClass('process');
                        alert('Some error');
                    }else{
                        window.location.href = '/checkout';
                    }
                },'json');
            }
        },'json');
    });
    
    // gallery shadow
    if($('.ngg-gallery-thumbnail').length){
        $('.ngg-gallery-thumbnail').append('<div class="ngg-gallery-boxshadow"></div>');
    }
    // end
    
    $('.share-btn').click(function(e){
        e.preventDefault();
                
        var width = screen.width - 200;
        var height = screen.height - 200;
        
        window.open($(this).attr('href'),'share','width='+width+',height='+height+',left=100,top=100');
    });
});

(function($){
    $.fn.sameHeight = function(opt) {
        var options = $.extend({
            skipClass: 'same-height-ignore',
            leftEdgeClass: 'same-height-left',
            rightEdgeClass: 'same-height-right',
            elements: '>*',
            flexible: false,
            multiLine: false,
            useMinHeight: false,
            biggestHeight: false
        },opt);
        return this.each(function(){
            var holder = $(this), postResizeTimer, ignoreResize;
            var elements = holder.find(options.elements).not('.' + options.skipClass);
            if(!elements.length) return;

            // resize handler
            function doResize() {
                elements.css(options.useMinHeight && supportMinHeight ? 'minHeight' : 'height', '');
                if(options.multiLine) {
                    // resize elements row by row
                    resizeElementsByRows(elements, options);
                } else {
                    // resize elements by holder
                    resizeElements(elements, holder, options);
                }
            }
            doResize();

            // handle flexible layout / font resize
            var delayedResizeHandler = function() {
                if(!ignoreResize) {
                    ignoreResize = true;
                    doResize();
                    clearTimeout(postResizeTimer);
                    postResizeTimer = setTimeout(function() {
                        doResize();
                        setTimeout(function(){
                            ignoreResize = false;
                        }, 10);
                    }, 100);
                }
            };

            // handle flexible/responsive layout
            if(options.flexible) {
                $(window).bind('resize orientationchange fontresize', delayedResizeHandler);
            }

            // handle complete page load including images and fonts
            $(window).bind('load', delayedResizeHandler);
        });
    };

    // detect css min-height support
    var supportMinHeight = typeof document.documentElement.style.maxHeight !== 'undefined';

    // get elements by rows
    function resizeElementsByRows(boxes, options) {
        var currentRow = $(), maxHeight, maxCalcHeight = 0, firstOffset = boxes.eq(0).offset().top;
        boxes.each(function(ind){
            var curItem = $(this);
            if(curItem.offset().top === firstOffset) {
                currentRow = currentRow.add(this);
            } else {
                maxHeight = getMaxHeight(currentRow);
                maxCalcHeight = Math.max(maxCalcHeight, resizeElements(currentRow, maxHeight, options));
                currentRow = curItem;
                firstOffset = curItem.offset().top;
            }
        });
        if(currentRow.length) {
            maxHeight = getMaxHeight(currentRow);
            maxCalcHeight = Math.max(maxCalcHeight, resizeElements(currentRow, maxHeight, options));
        }
        if(options.biggestHeight) {
            boxes.css(options.useMinHeight && supportMinHeight ? 'minHeight' : 'height', maxCalcHeight);
        }
    }

    // calculate max element height
    function getMaxHeight(boxes) {
        var maxHeight = 0;
        boxes.each(function(){
            maxHeight = Math.max(maxHeight, $(this).outerHeight());
        });
        return maxHeight;
    }

    // resize helper function
    function resizeElements(boxes, parent, options) {
        var calcHeight;
        var parentHeight = typeof parent === 'number' ? parent : parent.height();
        boxes.removeClass(options.leftEdgeClass).removeClass(options.rightEdgeClass).each(function(i){
            var element = $(this);
            var depthDiffHeight = 0;
            var isBorderBox = element.css('boxSizing') === 'border-box';

            if(typeof parent !== 'number') {
                element.parents().each(function(){
                    var tmpParent = $(this);
                    if(parent.is(this)) {
                        return false;
                    } else {
                        depthDiffHeight += tmpParent.outerHeight() - tmpParent.height();
                    }
                });
            }
            calcHeight = parentHeight - depthDiffHeight;
            calcHeight -= isBorderBox ? 0 : element.outerHeight() - element.height();

            if(calcHeight > 0) {
                element.css(options.useMinHeight && supportMinHeight ? 'minHeight' : 'height', calcHeight);
            }
        });
        boxes.filter(':first').addClass(options.leftEdgeClass);
        boxes.filter(':last').addClass(options.rightEdgeClass);
        return calcHeight;
    }
})(jQuery)