(function ($)
{

    function number_format(number, decimals, dec_point, thousands_sep) {
        // Strip all characters but numerical ones.
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    function setT(obj, number, delay)
    {
        setTimeout(function ()
        {
            if (number >= 1000)
            {

                number = number_format(number, 0, '', '');
            }
            $(obj).html(number);
        }, delay);
    }



    function setCountUp(obj)
    {
        var number = parseInt($(obj).attr('data-number'));
        var max = 1350;
        var delay = (max / number);

        if (number > 1000)
        {
            for (var i = 1; i <= (number + 100); i += 100)
            {
                var s = i;

                if (s > number)
                {
                    s = number;
                }
                setT(obj, s, i * delay);
            }
        } else
        {
            for (var i = 1; i <= number; i++)
            {
                setT(obj, i, i * delay);
            }
        }


    }

    var map;

    function googleMapsStartWithManyPins()
    {
        if (typeof google_maps_key === 'undefined')
        {
            return;
        }

        if (!gmInit)
        {
            initTheGoogleMaps(function ()
            {
                googleMapsStartWithManyPins();
            });
            return;
        }
        if (!map)
        {
            var center = new google.maps.LatLng(40.6700, -73.9400);


            if ($('#the-map').length === 0)
            {
                return true;
            }

            if (typeof studios === 'undefined' || $(studios).length === 0)
            {
                return true;
            }


            var mapOptions = {
                zoom: 15,
                scrollwheel: false,
                draggable: false,
                mapTypeControl: false,
                center: center,
                styles: [{"featureType": "administrative", "elementType": "labels.text", "stylers": [{"visibility": "on"}]}, {"featureType": "poi", "elementType": "all", "stylers": [{"visibility": "off"}]}, {"featureType": "transit.station.rail", "elementType": "all", "stylers": [{"visibility": "simplified"}, {"saturation": "-100"}]}, {"featureType": "water", "elementType": "all", "stylers": [{"visibility": "on"}]}]
            };

            var map = new google.maps.Map($('#the-map')[0], mapOptions);
        }

        $(infowindows).each(function (kk, vv) {
            vv.close();
        });
        $(markers).each(function (kk, vv)
        {
            vv.setMap(null);
        });

        markers = [];
        infowindows = [];


        function setMarker(v)
        {



            var lat = parseFloat(v.position_on_the_map.lat);
            var lng = parseFloat(v.position_on_the_map.lng);
            var center = new google.maps.LatLng(lat, lng);
            var marker = new google.maps.Marker({
                position: center,
                map: map,
                icon: map_pin
            });

            markers.push(marker);

            var infowindow = new google.maps.InfoWindow({
                content: v.html
            });

            marker.addListener('click', function () {
                $(infowindows).each(function (kk, vv) {
                    vv.close();
                });
                infowindow.open(map, marker);

            });

            infowindows.push(infowindow);


        }



        $(studios).each(function (k, v)
        {
            setMarker(v);
        });


        var mybounds = new google.maps.LatLngBounds();


        if ($(markers).length > 0)
        {

            $(markers).each(function (k, v)
            {
                mybounds.extend(v.getPosition());
            });

            map.fitBounds(mybounds);

            setTimeout(function ()
            {
                map.setZoom(map.getZoom() - 2);
            }, 1000);
        } else
        {
            alert('No results found.');
        }
    }

    var gmInit = false;

    function initTheGoogleMaps(callback)
    {
        var script = document.createElement('script');
        script.onload = function () {
            gmInit = true;
            callback();
        };
        script.src = 'https://maps.googleapis.com/maps/api/js?key=' + google_maps_key;

        document.head.appendChild(script);
    }

    function googleMapsStart(object)
    {
        if (typeof google_maps_key === 'undefined')
        {
            return;
        }
        if (!gmInit)
        {
            initTheGoogleMaps(function ()
            {
                googleMapsStart(object);
            });
            return;
        }
        if ($(object).length === 0)
        {
            return true;
        }

        var lat = parseFloat($(object).attr('data-lat'));
        var lng = parseFloat($(object).attr('data-lng'));
        var center = new google.maps.LatLng(lat, lng);





        var mapOptions = {
            zoom: 17,
            scrollwheel: false,
            draggable: true,
            mapTypeControl: false,
            center: center
        };

        var map = new google.maps.Map($(object)[0], mapOptions);

        var marker = new google.maps.Marker({
            position: center,
            map: map
        });
    }

    function eh(selector)
    {
        $(selector).css('min-height', '0px');
        $(selector).css('box-sizing', 'border-box');
        var min = 0;
        if ($(window).width() < 575)
        {
            return;
        }
        $(selector).each(function (k, v)
        {
            var h = $(v).outerHeight();

            if (h > min)
            {
                min = h;
            }
        });
        $(selector).css('min-height', min);
    }
    function setEh()
    {
        eh('.eh-1');
        eh('.eh-2');
    }


    $(window).on('load', function ()
    {
        setTimeout(function ()
        {
            $('.lazy-load-picture,img:not([data-src=""]),iframe:not([data-src=""])').each(function (k, v)
            {
                $(v).waypoint(function () {
                    $(v).attr('src', $(v).attr('data-src'));
                    $(v).attr('srcset', $(v).attr('data-srcset'));
                    $(v).removeClass('lazy-load-picture');
                }
                , {offset: '100%'});
            });
        }, 500);
    });


    function onScroll()
    {
        var sr = $(window).scrollTop();
        if (sr >= 50)
        {
            $('header,#mobile-header').addClass('scrolled');
        } else
        {
            $('header,#mobile-header').removeClass('scrolled');
        }
    }

    $(window).scroll(function (e)
    {
        onScroll();
    });

    function onResize()
    {

    }

    $(window).resize(function ()
    {
        onResize();
    });

    function addClassDelay(v, className, delay)
    {
        $(v).removeClass(className);
        $(v).css('opacity', '0');
        setTimeout(function ()
        {
            $(v).waypoint(function () {
                setTimeout(function ()
                {
                    $(v).css('opacity', '1');
                    $(v).addClass(className);
                }, delay);
            }
            , {offset: '100%'});
        }, delay);
    }

    function setAnimateWithWaypoints()
    {
        $('.fadeInUp').each(function (k, v)
        {

            var delay = $(this).attr('data-delay');
            addClassDelay(v, 'fadeInUp', delay);
        });

        $('.fadeInDown').each(function (k, v)
        {

            var delay = $(this).attr('data-delay');
            addClassDelay(v, 'fadeInDown', delay);
        });

        $('.fadeIn').each(function (k, v)
        {

            var delay = $(this).attr('data-delay');
            addClassDelay(v, 'fadeIn', delay);
        });

        $('.fadeInLeft').each(function (k, v)
        {

            var delay = $(this).attr('data-delay');
            addClassDelay(v, 'fadeInLeft', delay);
        });

        $('.fadeInRight').each(function (k, v)
        {

            var delay = $(this).attr('data-delay');
            addClassDelay(v, 'fadeInRight', delay);
        });
    }

    $(window).on('load', function ()
    {
        
        if($('.the-map').length>0)
        {
            initTheGoogleMaps(function ()
            {
                $('.the-map').each(function(k,v)
                {
                    googleMapsStart($(v));
                });
            });
        }


        $('#the-map').each(function (k, v)
        {
            $(v).waypoint(function () {
                googleMapsStart();
            }
            , {offset: '100%'});
        });


    });


    $(document).ready(function ()
    {
        
        $('.page-id-181 #home-tiles .button-wrapper a').contents().wrap('span');
        $('.page-id-181 #home-tiles .button-wrapper a').append('<svg width="34" height="23" viewBox="0 0 34 23" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 9.87573C1.17157 9.87573 0.5 10.5473 0.5 11.3757C0.5 12.2042 1.17157 12.8757 2 12.8757L2 9.87573ZM33.0607 12.4364C33.6464 11.8506 33.6464 10.9009 33.0607 10.3151L23.5147 0.769133C22.9289 0.183346 21.9792 0.183346 21.3934 0.769132C20.8076 1.35492 20.8076 2.30467 21.3934 2.89045L29.8787 11.3757L21.3934 19.861C20.8076 20.4468 20.8076 21.3965 21.3934 21.9823C21.9792 22.5681 22.9289 22.5681 23.5147 21.9823L33.0607 12.4364ZM2 12.8757L32 12.8757L32 9.87574L2 9.87573L2 12.8757Z" fill="#DD1C74"/></svg>');
        
        $('footer button').html('<svg width="44" height="24" viewBox="0 0 44 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 10.5005C1.17157 10.5005 0.5 11.1721 0.5 12.0005C0.5 12.8289 1.17157 13.5005 2 13.5005L2 10.5005ZM43.0607 13.0612C43.6464 12.4754 43.6464 11.5256 43.0607 10.9398L33.5147 1.39389C32.9289 0.808106 31.9792 0.808105 31.3934 1.39389C30.8076 1.97968 30.8076 2.92943 31.3934 3.51521L39.8787 12.0005L31.3934 20.4858C30.8076 21.0716 30.8076 22.0213 31.3934 22.6071C31.9792 23.1929 32.9289 23.1929 33.5147 22.6071L43.0607 13.0612ZM2 13.5005L42 13.5005L42 10.5005L2 10.5005L2 13.5005Z" fill="#003B20"/></svg>');
        
        $('#new-menu-nav a').click(function(e){
            e.preventDefault();
            var key = $(this).attr('data-key');
            $('.new-menu-tab,#new-menu-nav a').removeClass('active');
            $('.new-menu-tab[data-key="'+key+'"],#new-menu-nav a[data-key="'+key+'"]').addClass('active');
        });
        
        if($('body').hasClass('home'))
        {
            var button = $('.home #home-hero .the-button');
            $('.home #home-hero h1').append(button);
            $('.home #home-hero .button-wrapper').remove();
        }
        


        $('.one-faq-question').click(function (e)
        {
            e.preventDefault;
            var wrapper = $(this).closest('.faq-wrapper');
            var tf = $(this).closest('.one-faq');
            var of = $(wrapper).find('.one-faq').not(tf);
            $(tf).toggleClass('active');

            if ($(tf).hasClass('active'))
            {
                $(tf).find('.one-faq-answer').slideDown(550);
            } else
            {
                $(tf).find('.one-faq-answer').slideUp(550);
            }

            $(of).removeClass('active');
            $(of).find('.one-faq-answer').slideUp(550);
        });

        $("[data-delay!=''][data-delay]").each(function ()
        {
            if (!$(this).hasClass('animated'))
            {
                var dd = $(this).attr('data-delay');
                dd = dd.split('|');
                if (dd.length === 2)
                {
                    var delay = dd[0];
                    var kk = dd[1] * $(this).index();
                    $(this).attr('data-delay', parseInt(delay) + parseInt(kk));
                }
                if (dd.length === 3)
                {
                    var delay = dd[0];
                    var modulo = parseInt(dd[2]);
                    var kk = (dd[1] * ($(this).index() % modulo));
                    $(this).attr('data-delay', parseInt(delay) + parseInt(kk));
                }

                $(this).addClass('animated');
                $(this).addClass('fadeInUp');
            }
        });

        $('.one-artists-feed').click(function ()
        {
            window.location = $(this).attr('data-url');
        });


        $('.close-the-modal').click(function (e)
        {
            e.preventDefault();
            $(this).closest('.the-modal').fadeOut(550);
            $('body').removeClass('no-scroll');
        });

        $('#mobile-menu-button').click(function (e)
        {
            e.preventDefault();
            $(this).toggleClass('active');
        });

        $('.the-modal').click(function ()
        {
            $(this).fadeOut(550);
            $('body').removeClass('no-scroll');
        });

        $('.the-modal-content').click(function (e)
        {
            e.stopPropagation();
        });

        $('a').click(function ()
        {
            var href = $(this).attr('href');
            if (href[0] === '#' && href.length > 1 && $(href).length > 0 && $(href).hasClass('the-modal'))
            {
                $(href).fadeIn(550);
                $('body').addClass('no-scroll');
            }
        });


        ajaxurl = $('body').attr('data-ajax-url');
        homeurl = $('body').attr('data-home-url');

        if ($('body').hasClass('home'))
        {
            setTimeout(function ()
            {
                $('#overlay').fadeOut(300);
                setAnimateWithWaypoints();
            }, 800);
        } else
        {
            setTimeout(function ()
            {
                $('#overlay').fadeOut(300);
                setAnimateWithWaypoints();
            }, 300);
        }

        $('.open-popup').click(function (e)
        {
            e.preventDefault();
            window.open($(this).attr('href'), null, 'width=500 height=300')
        });

        /*<span class="counter">1234</span>*/
        $('.counter').each(function (k, v)
        {
            var num = $(this).html();
            $(this).attr('data-number', num);
            $(this).attr('data-started', 'false');
            $(this).html('1');
        });

        $('.counter').each(function (k, v)
        {
            $(v).waypoint(function () {
                var started = $(v).attr('data-started');

                if (started === 'false')
                {
                    $(v).attr('data-started', 'true');
                    setCountUp($(v));
                }
            }, {offset: '90%'});
        });

        $('a').click(function (e)
        {
            var href = $(this).attr('href');
            if (href[0] === '#' && href.length > 0)
            {
                e.preventDefault();
                var delimiter = 84;
                if ($(window).width() < 1024)
                {
                    delimiter = 50;
                }
                if (href === '#')
                {

                } else if (href !== "#" && $(href).length === 0)
                {
                    window.location = homeurl + href;
                } else
                {
                    if (!$(href).hasClass('the-modal'))
                    {
                        $('body,html').animate({
                            scrollTop: $(href).offset().top - delimiter
                        }, 600);
                        $('#mobile-menu-wrapper,#mobile-header').removeClass('active');
                        $('#menu-toggle').removeClass('open');
                        $('body').removeClass('no-scroll');

                    }
                }
            }
        });


        $('.modal').on('hidden.bs.modal', function ()
        {
            var c = $(this).find('#modal-content-itself').html();
            $(this).find('#modal-content-itself').html(c);
        });

        onScroll();
        onResize();

        $('.ajax-form').submit(function (e)
        {
            e.preventDefault();
            var thisForm = $(this);
            $(thisForm).css('opacity', '0.5');
            $.ajax({
                url: ajaxurl,
                type: 'post',
                data: $(thisForm).serialize(),
                success: function (data)
                {
                    $(thisForm).css('opacity', '1');
                    $(thisForm).html(data);
                }
            });
        });

        $('#menu-toggle').click(function (e)
        {
            e.preventDefault();
            $('#mobile-menu-wrapper,#mobile-header').toggleClass('active');
            $(this).toggleClass('open');
            $('body').toggleClass('no-scroll');
        });


        var navText = [leftArrow, rightArrow];
        
        $('#about-community-slider,#press-media-slider').owlCarousel({
            responsive: {
                0: {
                    autoWidth: true,
                    items: 1,
                    loop: true,
                    margin: 20,
                    nav: true,
                    navText: navText
                },
                576: {
                    autoWidth: true,
                    items: 1,
                    loop: true,
                    margin: 40,
                    nav: true,
                    navText: navText
                }
            }
        });

        $('#home-menu-slider,.new-menu-slider').owlCarousel({
            responsive: {
                0: {
                    items: 1,
                    autoWidth: true,
                    nav: true,
                    margin: 15,
                    loop: true,
                    navText: navText
                },
                576: {
                    items: 2,
                    nav: true,
                    margin: 15,
                    loop: true,
                    navText: navText
                },
                911: {
                    items: 3,
                    margin: 15,
                    loop: true,
                    nav: true,
                    navText: navText
                }
            }
        });
        $('.catering-slider').owlCarousel({
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                    margin: 15,
                    loop: true,
                    navText: navText
                },
                576: {
                    items: 2,
                    nav: true,
                    margin: 15,
                    loop: true,
                    navText: navText
                }
            }
        });





    });
})(jQuery);