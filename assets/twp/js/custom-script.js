(function (e) {
    "use strict";
    var n = window.TWP_JS || {};
    var iScrollPos = 0;
    var loadType, loadButton, loader, pageNo, loading, morePost, scrollHandling;

    n.mobileMenu = {
        init: function () {
            this.toggleMenu(), this.menuMobile(), this.menuArrow()
        },
        toggleMenu: function () {
            e('#masthead').on('click', '.toggle-menu', function (event) {
                var ethis = e('.main-navigation .menu .menu');
                if (ethis.css('display') == 'block') {
                    ethis.slideUp('300');
                    e("#masthead").removeClass('menu-active');
                } else {
                    ethis.slideDown('300');
                    e("#masthead").addClass('menu-active');
                }
                e('.ham').toggleClass('exit');
            });
            e('#masthead .main-navigation ').on('click', '.menu a i', function (event) {
                event.preventDefault();
                var ethis = e(this),
                    eparent = ethis.closest('li'),
                    esub_menu = eparent.find('> .sub-menu');
                if (esub_menu.css('display') == 'none') {
                    esub_menu.slideDown('300');
                    ethis.addClass('active');
                } else {
                    esub_menu.slideUp('300');
                    ethis.removeClass('active');
                }
                return false;
            });

            e(document).keyup(function(j) {
                if (j.key === "Escape") { // escape key maps to keycode `27`
                    
                    

                    if( e('.ham').hasClass('exit') ){
                       
                        var ethis = e('.main-navigation .menu .menu');
                        if (ethis.css('display') == 'block') {
                            ethis.slideUp('300');
                            e("#masthead").removeClass('menu-active');
                        } else {
                            ethis.slideDown('300');
                            e("#masthead").addClass('menu-active');
                        }
                        e('.ham').toggleClass('exit');

                    }

                }
            });

        },
        menuMobile: function () {
            if (e('.main-navigation .menu > ul').length) {
                var ethis = e('.main-navigation .menu > ul'),
                    eparent = ethis.closest('.main-navigation'),
                    pointbreak = eparent.data('epointbreak'),
                    window_width = window.innerWidth,
                    current_mode = eparent.data('display_mode');
                if (typeof pointbreak == 'undefined') {
                    pointbreak = 991;
                }
                if (typeof current_mode == 'undefined') {
                    if (pointbreak >= window_width) {
                        current_mode = 'mobile';
                    } else {
                        current_mode = 'desktop';
                    }
                }
                if (pointbreak >= window_width && current_mode == 'desktop') {
                    var ethis = e('.main-navigation .menu');
                    //ethis.css('display', 'none');
                    ethis = e('.main-navigation .menu .menu');
                    ethis.css('display', 'none');
                } else if (pointbreak < window_width && current_mode == 'mobile') {
                    var ethis = e('.main-navigation .menu');
                    //ethis.css('display', 'block');
                    ethis = e('.main-navigation .menu .menu');
                    ethis.css('display', 'block');
                    e('.ham').removeClass('exit');
                }
                if (pointbreak >= window_width) {
                    var new_mode = 'mobile';
                } else {
                    var new_mode = 'desktop';
                }
                eparent.data('display_mode', new_mode);
            }
        },
        menuArrow: function () {
            if (e('#masthead .main-navigation div.menu > ul').length) {
                e('#masthead .main-navigation div.menu > ul .sub-menu').parent('li').find('> a').append('<i class="arrow_carrot-down">');
            }
        }
    },

        n.twp_preloader = function () {
            e(window).load(function () {
                e("body").addClass("page-loaded");
            });
        },

        n.TwpReveal = function () {
            e('.icon-search').on('click', function (event) {
                e('body').toggleClass('reveal-search');
                e('html').attr('style','overflow-y: scroll; position: fixed; width: 100%; left: 0px; top: 0px;');
            });
            e('.close-popup').on('click', function (event) {
                e('body').removeClass('reveal-search');
                e('html').attr('style','');
                setTimeout(function () {
                    e('.icon-search').focus();
                }, 300);
            });

            e(document).keyup(function(j) {
                if (j.key === "Escape") { // escape key maps to keycode `27`
                    
                    

                    if( e('body').hasClass('reveal-search') ){
                        e('body').removeClass('reveal-search');
                        setTimeout(function () {
                            e('html').attr('style','');
                            e('.icon-search').focus();
                        }, 300);

                    }
                    if( e('body').hasClass('reveal-location') ){
                        e('body').removeClass('reveal-location');
                        setTimeout(function () {
                            e('.icon-location').focus();
                        }, 300);

                    }
                }
            });

            e( 'input, a, button' ).on( 'focus', function() {
                if ( e( 'body' ).hasClass( 'reveal-search' ) ) {

                    if ( ! e( this ).parents( '.popup-search' ).length ) {
                        e('.close-popup').focus();
                    }
                }
            } );
            
            e(".twp-nulanchor").focus(function(){
                e('.close-popup-1').focus();
            });
        },

        n.DataBackground = function () {
            var pageSection = e(".data-bg");

            pageSection.each(function (indx) {
                if (e(this).attr("data-background")) {
                    e(this).css("background-image", "url(" + e(this).data("background") + ")");
                }
            });

            e('.bg-image').each(function () {
                var src = e(this).children('img').attr('src');
                if( src ){
                    e(this).css('background-image', 'url(' + src + ')').children('img').hide();
                }
            });
        },

        n.TwpSlider = function () {
            e(".twp-slider").each(function () {
                e(this).owlCarousel({
                    loop: (e('.twp-slider').children().length) == 1 ? false : true,
                    autoplay: 5000,
                    nav: true,
                    navText: ["<i class='arrow_carrot-left'></i>", "<i class='arrow_carrot-right'></i>"],
                    items: 1
                });
            });
            e(".single-slide").css('display', 'block');
            e(".slide-title").css('display', 'block');
            e(".slider-button").css('display', 'block');

            e(".twp-testimonial").owlCarousel({
                items: 1,
                slideSpeed: 350,
                singleItem: true,
                autoHeight: true,
                nav: true,
                navText: ["<i class='arrow_carrot-left'></i>", "<i class='arrow_carrot-right'></i>"
                ]
            });

            var rtled = false;

            if (e('body').hasClass('rtl')) {
                rtled = true;
            }

            e("figure.wp-block-gallery.has-nested-images.columns-1").each(function () {
                e(this).owlCarousel({
                    loop: (e('figure.wp-block-gallery.has-nested-images.columns-1').children().length) == 1 ? false : true,
                    margin: 3,
                    autoplay: 5000,
                    nav: true,
                    navText: ["<i class='arrow_carrot-left'></i>", "<i class='arrow_carrot-right'></i>"],
                    items: 1,
                    rtl: rtled,
                    dots:false
                });
            });

            e(".wp-block-gallery.columns-1 ul.blocks-gallery-grid").each(function () {
                e(this).owlCarousel({
                    loop: (e('.wp-block-gallery.columns-1 ul.blocks-gallery-grid').children().length) == 1 ? false : true,
                    margin: 3,
                    autoplay: 5000,
                    nav: true,
                    navText: ["<i class='arrow_carrot-left'></i>", "<i class='arrow_carrot-right'></i>"],
                    items: 1,
                    rtl: rtled,
                    dots:false
                });
            });

            e(".gallery-columns-1").each(function () {
                e(this).owlCarousel({
                    loop: (e('.gallery-columns-1').children().length) == 1 ? false : true,
                    margin: 3,
                    autoplay: 5000,
                    nav: true,
                    navText: ["<i class='arrow_carrot-left'></i>", "<i class='arrow_carrot-right'></i>"],
                    items: 1,
                    rtl: rtled,
                    dots:false
                });
            });
        },

        n.show_hide_scroll_top = function () {
            if (e(window).scrollTop() > e(window).height() / 2) {
                e(".scroll-up").fadeIn(300);
            } else {
                e(".scroll-up").fadeOut(300);
            }
        },

        n.scroll_up = function () {
            e(".scroll-up").on("click", function () {
                e("html, body").animate({
                    scrollTop: 0
                }, 700);
                return false;
            });
        },
        n.setLoadPostDefaults = function () {
            if(  e('.load-more-posts').length > 0 ){
                loadButton = e('.load-more-posts');
                loader = e('.load-more-posts .ajax-loader');
                loadType = loadButton.attr('data-load-type');
                pageNo = 2;
                loading = false;
                morePost = true;
                scrollHandling = {
                    allow: true,
                    reallow: function() {
                        scrollHandling.allow = true;
                    },
                    delay: 400
                };
            }
        },

        n.fetchPostsOnScroll = function () {
            if(  e('.load-more-posts').length > 0 && 'scroll' === loadType ){
                var iCurScrollPos = e(window).scrollTop();
                if( iCurScrollPos > iScrollPos ){
                    if( ! loading && scrollHandling.allow && morePost ) {
                        scrollHandling.allow = false;
                        setTimeout(scrollHandling.reallow, scrollHandling.delay);
                        var offset = e(loadButton).offset().top - e(window).scrollTop();
                        if( 2000 > offset ) {
                            loading = true;
                            n.ShowPostsAjax(loadType);
                        }
                    }
                }
                iScrollPos = iCurScrollPos;
            }
        },

        n.fetchPostsOnClick = function () {
            if( e('.load-more-posts').length > 0 && 'click' === loadType ){
                e('.load-more-posts a').on('click',function (event) {
                    event.preventDefault();
                    n.ShowPostsAjax(loadType);
                });
            }
        },

        n.ShowPostsAjax = function (loadType) {
            e.ajax({
                type : 'GET',
                url : businessVal.ajaxurl,
                data : {
                    action : 'business_insights_load_more',
                    nonce: businessVal.nonce,
                    page: pageNo,
                    post_type: businessVal.post_type,
                    search: businessVal.search,
                    cat: businessVal.cat,
                    taxonomy: businessVal.taxonomy,
                    author: businessVal.author,
                    year: businessVal.year,
                    month: businessVal.month,
                    day: businessVal.day
                },
                dataType:'json',
                beforeSend: function() {
                    loader.addClass('ajax-loader-enabled');
                },
                success : function( response ) {
                    loader.removeClass('ajax-loader-enabled');
                    if(response.success){
                        e('.business-posts-lists').append( response.data.content );

                        pageNo++;
                        loading = false;
                        if(!response.data.more_post){
                            morePost = false;
                            loadButton.fadeOut();
                        }

                        /*For audio and video to work properly after ajax load*/
                        e('video, audio').mediaelementplayer({ alwaysShowControls: true });
                        /**/
                        var rtled = false;

                        if (e('body').hasClass('rtl')) {
                            rtled = true;
                        }

                        e("figure.wp-block-gallery.has-nested-images.columns-1").owlCarousel({
                            loop: (e('figure.wp-block-gallery.has-nested-images.columns-1').children().length) == 1 ? false : true,
                            margin: 3,
                            autoplay: 5000,
                            nav: true,
                            navText: ["<i class='arrow_carrot-left'></i>", "<i class='arrow_carrot-right'></i>"],
                            items: 1,
                            rtl: rtled,
                            dots:false
                        });

                        e(".wp-block-gallery.columns-1 ul.blocks-gallery-grid").owlCarousel({
                            loop: (e('.wp-block-gallery.columns-1 ul.blocks-gallery-grid').children().length) == 1 ? false : true,
                            margin: 3,
                            autoplay: 5000,
                            nav: true,
                            navText: ["<i class='arrow_carrot-left'></i>", "<i class='arrow_carrot-right'></i>"],
                            items: 1,
                            rtl: rtled,
                            dots:false
                        });

                        e(".gallery-columns-1").owlCarousel({
                            loop: (e('.gallery-columns-1').children().length) == 1 ? false : true,
                            margin: 3,
                            autoplay: 5000,
                            nav: true,
                            navText: ["<i class='arrow_carrot-left'></i>", "<i class='arrow_carrot-right'></i>"],
                            items: 1,
                            rtl: rtled,
                            dots:false
                        });
                    }else{
                        loadButton.fadeOut();
                    }
                }
            });
        },

        e(document).ready(function () {
            n.mobileMenu.init(), n.TwpReveal(), n.twp_preloader(), n.DataBackground(), n.TwpSlider(), n.scroll_up(), n.setLoadPostDefaults(), n.fetchPostsOnClick();
        }),
        e(window).scroll(function () {
            n.show_hide_scroll_top(), n.fetchPostsOnScroll();
        }),
        e(window).resize(function () {
            n.mobileMenu.menuMobile();
        })
})(jQuery);