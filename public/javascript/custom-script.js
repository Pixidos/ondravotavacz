(function ($) {
    "use strict";


    /* =============== Page pre-loader =============== */
    $(window).load(function () {
        $('#page-loader').fadeOut(400);

        $('#intro').addClass('animated fadeInDown');
        $('#intro-div').addClass('animated fadeInUp');
        $('#profile').addClass('animated zoomIn');

    });


    $(document).ready(function () {

        var isScroling = false;

        function menuLinkActive(linkHash) {
            $('nav a').each(function () {
                $(this).removeClass('active');
            });
            $('a[href="' + linkHash + '"]').each(function () {
                $(this).addClass('active');
            });
        }

        function sectionChangePropagation(linkHash) {
            if (!isScroling) {
                history.pushState(null, null, linkHash);
                menuLinkActive(linkHash);
            }
        }

        /* =============== AOS Initialize =============== */
        AOS.init({
            offset: 50,
            duration: 500,
            delay: 300,
            easing: 'ease-in-sine',
            once: true,
        });
        AOS.refresh();



        $('#about').waypoint(function (direction) {
            sectionChangePropagation('#about');
        }, {
            offset: '40%'
        });

        $('#experience').waypoint(function (direction) {
            sectionChangePropagation('#experience');
        }, {
            offset: '25%'
        });
        $('#skills').waypoint(function (direction) {
            sectionChangePropagation('#skills');
        }, {
            offset: '25%'
        });
        $('#certifications').waypoint(function (direction) {
            sectionChangePropagation('#certifications');
        }, {
            offset: '25%'
        });
        $('#interest').waypoint(function (direction) {
            sectionChangePropagation('#interest');
        }, {
            offset: '25%'
        });
        $('#contact').waypoint(function (direction) {
            sectionChangePropagation('#contact');
        }, {
            offset: '40%'
        });

        /* =============== Side Nav =============== */
        var $menuBtn = $('#nav-btn');
        var $sideNav = $('#side-nav');
        var $sideNavMask = $('#side-nav-mask');
        var $link = $('.nav-link');

        $menuBtn.on('click', function () {
            $sideNav.animate({left: 0}, 'fast');
            $sideNavMask.addClass('visible');
        });

        $link.on('click', function () {
            $sideNav.animate({left: -240}, 'fast');
            $sideNavMask.removeClass('visible');
        });

        $sideNavMask.on('click', function () {
            $sideNav.animate({left: -240}, 'fast');
            $sideNavMask.removeClass('visible');
        });


        /* =============== Page Scrolling Smoothly to Link Target =============== */
        $('a[href*=#]:not([href=#])').on('click', function () {
            isScroling = true;
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '')
                || location.hostname === this.hostname) {

                var target;
                if(this.hash === '#about'){
                    target = $('#header');
                } else {
                    target = $(this.hash);
                }
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top - 32
                    }, 1000, function () {
                        isScroling = false;
                    });
                    history.pushState(null, null, this.hash);
                    menuLinkActive(this.hash);

                    return false;
                }
            }
            isScroling = false;
        });


        /* =============== Skill Bar value =============== */
        $('.skill-progress').each(function () {
            $(this).find('.skill-determinate').css({
                width: jQuery(this).attr('data-percent')
            }, 7000);
        });


        /* =============== Back To Top =============== */
        var offset = 300,
            scroll_top_duration = 700,
            $back_to_top = $('.back-to-top');
        $(window).scroll(function () {
            ($(this).scrollTop() > offset) ? $back_to_top.addClass('back-to-top-is-visible') : $back_to_top.removeClass('back-to-top-is-visible');
        });

        //smooth scroll to top --->>> Optional
        $back_to_top.on('click', function (event) {
            event.preventDefault();
            $('body,html').animate({
                    scrollTop: 0,
                }, scroll_top_duration
            );
        });

        $('form#contact-form input').on('focus', function (e) {
            var id = $(this).attr('id');
            var $ul = $('.input-field ul#' + id + '-errors');
            if($ul.length){
                $ul.remove();
            }
        });


        /* =============== Email Handling =============== */
        $('form#contact-form').on('submit', function (e) {
            e.preventDefault(); //Prevents default submit
            var form = $(this);
            $("#submit").attr('disabled', 'disabled'); //Disable the submit button on click
            var post_data = form.serialize(); //Serialized the form data

            $.ajax({
                type: 'POST',
                url: form.attr('action'), // Form script
                data: post_data,
                dataType: 'json'
            })
                .done(function (response) {

                    // Get the snackbar DIV
                    var x = document.getElementById("snackbar");
                    // Add the "show" class to DIV
                    x.className = "show";
                    // After 7 seconds, remove the show class from DIV
                    setTimeout(function () {
                        x.className = x.className.replace("show", "");
                    }, 7000);

                    $("form#contact-form")[0].reset();
                    Materialize.updateTextFields(); // Rest floating labels
                    // $("#submit").removeAttr('disabled', 'disabled'); // Enable submit button

                })
                .fail(function (response) {

                    var data = JSON.parse(response.responseText);
                    var errors = data.errors;
                    Object.keys(errors).forEach(function (key) {
                        var value = errors[key];
                        var $element = $('#' + key).parent('.input-field');
                        var $ul = $('<ul></ul>').attr('id', key + '-errors');
                        if (Array.isArray(value)) {
                            for (var k in value) {
                                if (value.hasOwnProperty(k)) {
                                    $ul.append($('<li/>').text(value[k]));
                                }
                            }
                        } else {
                            $ul.append('<li>' + value + '</li>');
                        }
                        $element.append($ul);
                    });

                    // Get the fail-snackbar DIV
                    var y = document.getElementById("fail-snackbar");
                    // Add the "show" class to DIV
                    y.className = "show";
                    // After 7 seconds, remove the show class from DIV
                    setTimeout(function () {
                        y.className = y.className.replace("show", "");
                    }, 7000);

                    $("form#contact-form")[0].reset();
                    Materialize.updateTextFields(); // Rest floating labels
                    $("#submit").removeAttr('disabled', 'disabled'); // Enable submit button
                });
        });

    });

})(jQuery);
