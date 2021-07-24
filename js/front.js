$(document).ready(function () {

    'use strict';

    // ------------------------------------------------------- //
    // Search Box
    // ------------------------------------------------------ //
    $('#search').on('click', function (e) {
        e.preventDefault();
        $('.search-box').fadeIn();
        document.getElementById("b_en_menu").focus();
    });
    $('.dismiss_c').on('click', function () {
        $('.search-box').fadeOut();
    });

    // ------------------------------------------------------- //
    // Card Close
    // ------------------------------------------------------ //
    $('.card-close a.remove').on('click', function (e) {
        e.preventDefault();
        $(this).parents('.card').fadeOut();
    });


    // ------------------------------------------------------- //
    // Adding fade effect to dropdowns
    // ------------------------------------------------------ //
    $('.dropdown').on('show.bs.dropdown', function () {
        $(this).find('.dropdown-menu').first().stop(true, true).fadeIn();
    });
    $('.dropdown').on('hide.bs.dropdown', function () {
        $(this).find('.dropdown-menu').first().stop(true, true).fadeOut();
    });


    // ------------------------------------------------------- //
    // Sidebar Functionality
    // ------------------------------------------------------ //
    $('#toggle-btn').on('click', function (e, param1) {//
      //  console.log($("#tog_a").val());
        //  alert($("#tog_a").val()+" yes "+param1+"wi"+$(window).outerWidth());
        var pasa = true;
        if (($("#tog_a").val()) * 1 == 1) {
            if ((param1 * 1) == 1) {
                $("#i_tog").removeClass("fa fa-toggle-off color_negro").addClass("fa fa-toggle-on color_negro");
                $("#toggle-btn").attr('alt', 'Contraer menu');
                if ($(window).outerWidth() > 1183) {
                    pasa = false;
                } else {
                    pasa = true;
                }
                $("#tog_a").val(1);
                a_tog(1);
            } else {
                $("#i_tog").removeClass("fa fa-toggle-on color_negro").addClass("fa fa-toggle-off color_negro");
                $("#toggle-btn").attr('alt', 'Expandir menu');
                $("#tog_a").val(0);
                a_tog(0);
            }
        } else {
            if ((param1 * 1) == 1) {
                $("#i_tog").removeClass("fa fa-toggle-on color_negro").addClass("fa fa-toggle-off color_negro");
                $("#toggle-btn").attr('alt', 'Expandir menu');
                $("#tog_a").val(0);
                if ($(window).outerWidth() > 1183) {
                    pasa = true;
                } else {
                    pasa = false;
                }

                a_tog(0);
            } else {
                $("#i_tog").removeClass("fa fa-toggle-off color_negro").addClass("fa fa-toggle-on color_negro");
                $("#toggle-btn").attr('alt', 'Contraer menu');
                $("#tog_a").val(1);
                a_tog(1);
            }
        }
        if (pasa) {

            e.preventDefault();
            $(this).toggleClass('active');

            $('.side-navbar').toggleClass('shrinked');
            $('.content-inner').toggleClass('active');
            $(document).trigger('sidebarChanged');

            if ($(window).outerWidth() > 1183) {
                if ($('#toggle-btn').hasClass('active')) {
                    $('.navbar-header .brand-small').hide();
                    $('.navbar-header .brand-big').show();
                } else {
                    $('.navbar-header .brand-small').show();
                    $('.navbar-header .brand-big').hide();
                }
            }

            if ($(window).outerWidth() < 1183) {
                $('.navbar-header .brand-small').show();
            }
        }
    });

    // ------------------------------------------------------- //
    // Universal Form Validation
    // ------------------------------------------------------ //

    $('.form-validate').each(function () {
        $(this).validate({
            errorElement: "div",
            errorClass: 'is-invalid',
            validClass: 'is-valid',
            ignore: ':hidden:not(.summernote, .checkbox-template, .form-control-custom),.note-editable.card-block',
            errorPlacement: function (error, element) {
                // Add the `invalid-feedback` class to the error element
                error.addClass("invalid-feedback");
                console.log(element);
                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element.siblings("label"));
                } else {
                    error.insertAfter(element);
                }
            }
        });

    });

    // ------------------------------------------------------- //
    // Material Inputs
    // ------------------------------------------------------ //

    var materialInputs = $('input.input-material');

    // activate labels for prefilled values
    materialInputs.filter(function () {
        return $(this).val() !== "";
    }).siblings('.label-material').addClass('active');

    // move label on focus
    materialInputs.on('focus', function () {
        $(this).siblings('.label-material').addClass('active');
    });

    // remove/keep label on blur
    materialInputs.on('blur', function () {
        $(this).siblings('.label-material').removeClass('active');

        if ($(this).val() !== '') {
            $(this).siblings('.label-material').addClass('active');
        } else {
            $(this).siblings('.label-material').removeClass('active');
        }
    });

    // ------------------------------------------------------- //
    // Footer 
    // ------------------------------------------------------ //   

    var contentInner = $('.content-inner');

    $(document).on('sidebarChanged', function () {
        adjustFooter();
    });

    $(window).on('resize', function () {
        adjustFooter();
    })

    function adjustFooter() {
        var footerBlockHeight = $('.main-footer').outerHeight();
        contentInner.css('padding-bottom', footerBlockHeight + 'px');
    }

    // ------------------------------------------------------- //
    // External links to new window
    // ------------------------------------------------------ //
    $('.external').on('click', function (e) {

        e.preventDefault();
        window.open($(this).attr("href"));
    });

    // ------------------------------------------------------ //
    // For demo purposes, can be deleted
    // ------------------------------------------------------ //

    var stylesheet = $('link#theme-stylesheet');
    $("<link id='new-stylesheet' rel='stylesheet'>").insertAfter(stylesheet);
    var alternateColour = $('link#new-stylesheet');

    if ($.cookie("theme_csspath")) {
        alternateColour.attr("href", $.cookie("theme_csspath"));
    }

    $("#colour").change(function () {

        if ($(this).val() !== '') {

            var theme_csspath = 'css/style.' + $(this).val() + '.css';

            alternateColour.attr("href", theme_csspath);

            $.cookie("theme_csspath", theme_csspath, {
                expires: 365,
                path: document.URL.substr(0, document.URL.lastIndexOf('/'))
            });

        }

        return false;
    });

});

function pinta_modulo(mod) {

}

function b_s(color_c, opa) {
    return  'rgba(' + parseInt(color_c.slice(-6, -4), 16)
            + ',' + parseInt(color_c.slice(-4, -2), 16)
            + ',' + parseInt(color_c.slice(-2), 16)
            + ',' + opa + ')';
}

function cambia_color(color, mod) {//
    //  alert("asdas"+color);  style="opacity: 0.2;"
    jQuery('#panel_menu').removeClass('menu_rojo');
    jQuery('#panel_menu').removeClass('menu_aqua');
    jQuery('#panel_menu').removeClass('menu_azul');
    jQuery('#panel_menu').removeClass('menu_morado');
    jQuery('#panel_menu').removeClass('menu_cafe');
    jQuery('#panel_menu').removeClass('menu_negro');
    jQuery('#panel_menu').removeClass('menu_verde');

    jQuery('#panel_menu').addClass(color);
    /*jQuery('.menu_sub_u').css('background-color', b_s(color, 1));
    jQuery('.menu_sub_u').css('color', invertColor(color));

    jQuery('#left-panel').css('background-color', b_s(color, 1));
    jQuery('.sub_menu_a').css('background-color', b_s(color, 0.1));//
    jQuery(".sub_menu_a").addClass("sub_menu_red");*/


    //jQuery('.main-footer').css('background-color', b_s(color, .7));
    //jQuery('.main-footer_c').css('color', invertColor(color));

    //jQuery("#nom_usu_login").css('color', invertColor(color));


    jQuery.ajax({
        url: 'includes/evento_color.php',
        data: 'type=color&color=' + color,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            if (response.successful == 'true') {
                jQuery("#mod_" + mod).addClass( "menu_actual" );
               /* jQuery("#mod_" + mod).css("background-color", color);
                jQuery("#mod_" + mod).css("color", "#000");
                jQuery("#mod_" + mod).css("font-weight", "bold");
                jQuery("#mod_" + mod + " i:first-child").first().css("color", "#000");*/
            }
        },
        error: function (e) {
        }
    });

}
function a_tog(valor) {
    jQuery.ajax({
        url: 'includes/evento_color.php',
        data: 'type=m_t&val=' + valor,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            if (response.successful == 'true') {

            }
        },
        error: function (e) {
        }
    });
}


function invertColor(hexTripletColor) {
    var color = hexTripletColor;
    color = color.substring(1); // remove #
    color = parseInt(color, 16); // convert to integer
    color = 0xFFFFFF ^ color; // invert three bytes
    color = color.toString(16); // convert to hex
    color = ("000000" + color).slice(-6); // pad with leading zeros
    color = "#" + color; // prepend #

    return color;
}
var r_m = true;
jQuery(document).ready(function () {
    jQuery('.dismiss_c').click(function () {
        if (!r_m) {
            f_menu('');
            jQuery("#b_en_menu").val('');
        }
    });
    jQuery('#b_en_menu').keyup(function (e) {
        var des_modulo = jQuery("#b_en_menu").val();
        f_menu(des_modulo);
    });
    jQuery("#fileuploader").uploadFile({
        url: "./upload.php",
        dragDrop: false,
        acceptFiles: ".jpg,.bmp,.gif,.png",
        allowedTypes: "png,gif,jpg,jpeg",
        maxFileSize: 100 * 1024,
        showStatusAfterSuccess: false,
        fileName: "myfile",
        uploadButtonClass: "avatar",
        onSuccess: function (files, data, xhr) {
            jQuery(".foto_c").html(data);

        }
    });
    jQuery("#toggle-btn").trigger("click", ['1']);
    //jQuery("#fileuploader").css("display",'block');
    //                                            var monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    //                                            var dayNames = ["Sabado", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"]
    //
    //    // Create a newDate() object
    //                                            var newDate = new Date();
    //    // Extract the current date from Date object
    //                                            newDate.setDate(newDate.getDate());
    //    // Output the day, date, month and year    
    //                                            $('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());
    //                                            var con_p=2;
    //                                            setInterval(function () {
    //                                                if((con_p % 2)==0){//point
    //                                                    $(".point").html("&nbsp;");
    //                                                    con_p=1;
    //                                                }else{
    //                                                    $(".point").html(":");
    //                                                    con_p=2;
    //                                                }
    //                                            }, 500);
    //                                            setInterval(function () {
    //                                                var seconds = new Date().getSeconds();
    //                                                $("#sec").html((seconds < 10 ? "0" : "") + seconds);
    //                                            }, 1000);
    //
    //                                            setInterval(function () {
    //                                                var minutes = new Date().getMinutes();
    //                                                $("#min").html((minutes < 10 ? "0" : "") + minutes);
    //                                            }, 1000);
    //
    //                                            setInterval(function () {
    //                                                var hours = new Date().getHours();
    //                                                $("#hours").html((hours < 10 ? "0" : "") + hours);
    //                                            }, 1000);

});
function f_menu(des_m) {
    var datos = 'type=b_menu';
    datos += '&des_modulo=' + des_m;
    jQuery.ajax({
        url: 'includes/evento_color.php',
        data: datos,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.successful == 'true') {
                if (response.menu != '') {
                    jQuery("#main-menu").html(response.menu);
                    //cambia_color('' + response.color);
                    //update_f1(jQuery("#color_f_menu").val());
                    //cambi_f_s(1, '');
                    if (response.n_r > 0) {
                        r_m = true;
                    } else {
                        r_m = false;
                    }
                } else {
                    //alert(response.menu);
                    // jQuery("#main-menu").html('');
                }

            }
        },
        error: function (e) {
        }
    });
}

function update_c(jscolor) {
    cambia_color('#' + jscolor);
}



////
jQuery("#color_menu_1").addClass("jscolor {onFineChange:\'update_c1(this)\'}");
jQuery("#color_f_menu").addClass("jscolor {onFineChange:\'update_f1(this)\'}");
function update_c1(jscolor) {
    cambia_color('#' + jscolor);
}
function update_f1(color) {
    jQuery('.f_cmb').css('color', '#' + color);
    jQuery('.f_cmb_icon').css('color', '#' + color);
    var datos = 'type=color_f&color=' + color;
    cambia_ajustes(datos);
}
function cambi_f_s(op, val) {
    if (op == 1)
        var t = jQuery("#tam_f").val();
    else {
        var t = val;
        jQuery("#tam_f").val(t);
    }
    jQuery('.f_cmb').css('font-size', t + "em");
    var datos = 'type=f_s&f_s=' + t;
    cambia_ajustes(datos);
}
function cambi_f_l(op, val) {
    if (op == 1)
        var t = jQuery("#tam_l").val();
    else {
        var t = val;
        jQuery("#tam_l").val(t);
    }
    jQuery('.f_cmb_l').css('font-size', t + "em");
    var datos = 'type=f_l&f_l=' + t;
    cambia_ajustes(datos);
}
function cambia_theme_a(op){
    var datos = 'type=cmb_t&t=' + op;
    cambia_ajustes(datos);
}
function cambia_ajustes(datos) {//'type=color&color=' + color,
    jQuery.ajax({
        url: 'includes/evento_color.php',
        data: datos,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            if (response.successful == 'true') {
            }
        },
        error: function (e) {
        }
    });
}
function a_b() {

    jQuery("#myModal2").modal({backdrop: false});
}
function oculta(div, i) {
    var visible = 'none';
    var tam = '0%';
    var op = '0.5';
    if (jQuery('#' + div).css('display') == 'none')
    {
        jQuery('#' + i).removeClass('fa-plus-square');
        jQuery('#' + i).removeClass('text-light');
        jQuery('#' + i).addClass('fa-minus-square');
        jQuery('#' + i).addClass('text-danger');
        visible = 'block';
        tam = '100%';
        op = '1';
    } else {
        jQuery('#' + i).removeClass('fa-minus-square');
        jQuery('#' + i).removeClass('text-danger');
        jQuery('#' + i).addClass('fa-plus-square');
        jQuery('#' + i).addClass('text-light');
    }
    jQuery("#" + div).animate({
        opacity: op,
    }, 300, function () {
        if (visible == 'none') {
            jQuery("#" + div).hide();
        } else {
            jQuery("#" + div).show();
        }

    });
}
var navigationFn = {
    goToSection: function (id) {
        jQuery('html, body').animate({
            scrollTop: jQuery(id).offset().top
        }, 0);
    }
}
jQuery(function () {
    jQuery('[data-toggle="tooltip"]').tooltip();
});

function manda_foco(id) {
    var menubar = new Menubar(document.getElementById('menuaccess'));
    //menubar.init();
    $('#' + id).attr("tabindex", 0).focus();
    //document.getElementById(id).focus();
}
$(document).ready(function () {
    $('body').addClass('js'); // adds class to body tag when JavaScript is enabled (...but you already do this right?)
    skipNavigation('skip-nav'); // send container id
});



function skipNavigation(skipNavContainer) {
    var defaultHeight = $('#' + skipNavContainer).height(); // get default container height before this script minimizes the container
    closeSkipNavContainer(skipNavContainer); // minimize the container so that later we can slide it open
    skipNavTimeout = null;

    // if a link in the skip-nav container receives focus:
    // 1. apply class="active" to the container (class="active" should be set to 'visible' via CSS)
    // 2. slide open the container  
    // 3. apply class="nav-focused" to the linked element
    $('#' + skipNavContainer + ' a').bind('focusin', function (event) {
        if (!$('#' + skipNavContainer).hasClass('active')) {
            $('#' + skipNavContainer).addClass('active');
            $('#' + skipNavContainer).animate({"height": defaultHeight}, {duration: "medium"}); //
        }
        $(event.target).addClass('nav-focused');
    });

    // remove class 'nav-focused' if linked element loses focus
    $('#' + skipNavContainer + ' a').bind('focusout', function (event) { // if skip nav link loses focus
        $(event.target).removeClass('nav-focused'); // remove 'nav-focused' class

        // if none of the links in the skip-nav container have class="nav-focused" run the function to hide the container
        if (!skipNavTimeout) { // if skipNavTimeout is not set
            skipNavTimeout = setTimeout(function () { // set timer
                if ($('#' + skipNavContainer + ' .nav-focused').length == 0) { // if 'nav-focused' is not found close container
                    closeSkipNavContainer(skipNavContainer);
                }
                skipNavTimeout = null;
            }, 500);
        }

    });

    // reduce container height to 1 px and remove class="active" (CSS should be set to hide container if class is absent)
    function closeSkipNavContainer(skipNavContainer) {
        $('#' + skipNavContainer).animate({"height": '1px'}, 'medium', 'linear', function () {
            $(this).removeClass('active');
        });
    }
}
function dayTripper(div_s) {
    setTimeout(function () {
        var today = $('.ui-datepicker-today a')[0];

        if (!today) {
            today = $('.ui-state-active')[0] ||
                    $('.ui-state-default')[0];
        }


        // Hide the entire page (except the date picker)
        // from screen readers to prevent document navigation
        // (by headings, etc.) while the popup is open
        $(".page").attr('id', 'dp-container');
        $("#dp-container").attr('aria-hidden', 'true');
        $("#skipnav").attr('aria-hidden', 'true');


        // Hide the "today" button because it doesn't do what 
        // you think it supposed to do
        $(".ui-datepicker-current").hide();

        today.focus();
        datePickHandler(div_s);

    }, 0);

}
function datePickHandler(div_s) {
    var activeDate;
    var container = document.getElementById('ui-datepicker-div');
    var input = document.getElementById(div_s);

    if (!container || !input) {
        return;
    }

    $(container).find('table').first().attr('role', 'grid');

    container.setAttribute('role', 'application');
    container.setAttribute('aria-label', 'Dezplegando calendario');

    // the top controls:
    var prev = $('.ui-datepicker-prev', container)[0],
            next = $('.ui-datepicker-next', container)[0];


// This is the line that needs to be fixed for use on pages with base URL set in head
    next.href = 'javascript:void(0)';
    prev.href = 'javascript:void(0)';

    next.setAttribute('role', 'button');
    next.removeAttribute('title');
    prev.setAttribute('role', 'button');
    prev.removeAttribute('title');

    appendOffscreenMonthText(next);
    appendOffscreenMonthText(prev);

    // delegation won't work here for whatever reason, so we are
    // forced to attach individual click listeners to the prev /
    // next month buttons each time they are added to the DOM
    $(next).on('click', handleNextClicks);
    $(prev).on('click', handlePrevClicks);

    monthDayYearText();
    //$(".ui-datepicker-title").attr("tabindex",'0');
    $(".ui-datepicker-month").attr("tabindex", '1');
    $(".ui-datepicker-year").attr("tabindex", '1');

    $(container).on('keydown', function calendarKeyboardListener(keyVent) {

        var which = keyVent.which;
        var target = keyVent.target;
        var dateCurrent = getCurrentDate(container);

        if (!dateCurrent) {
            dateCurrent = $('a.ui-state-default')[0];
            setHighlightState(dateCurrent, container);
        }

        if (27 === which) {
            keyVent.stopPropagation();
            return closeCalendar(div_s);
        } else if (which === 9 && keyVent.shiftKey) { // SHIFT + TAB
            keyVent.preventDefault();
            if ($(target).hasClass('ui-datepicker-close')) { // close button
                $('.ui-datepicker-prev')[0].focus();
            } else if ($(target).hasClass('ui-state-default')) { // a date link
                $('.ui-datepicker-close')[0].focus();
            } else if ($(target).hasClass('ui-datepicker-prev')) { // the prev link
                $('.ui-datepicker-next')[0].focus();
            } else if ($(target).hasClass('ui-datepicker-next')) { // the next link
                activeDate = $('.ui-state-highlight') ||
                        $('.ui-state-active')[0];
                if (activeDate) {
                    activeDate.focus();
                }
            }
        } else if (which === 9) { // TAB
            keyVent.preventDefault();
            if ($(target).hasClass('ui-datepicker-close')) { // close button
                activeDate = $('.ui-state-highlight') ||
                        $('.ui-state-active')[0];
                if (activeDate) {
                    activeDate.focus();
                }
            } else if ($(target).hasClass('ui-state-default')) {
                $('.ui-datepicker-next')[0].focus();
            } else if ($(target).hasClass('ui-datepicker-next')) {
                $('.ui-datepicker-prev')[0].focus();
            } else if ($(target).hasClass('ui-datepicker-prev')) {
                $('.ui-datepicker-close')[0].focus();
            }
        } else if (which === 37) { // LEFT arrow key
            // if we're on a date link...
            if (!$(target).hasClass('ui-datepicker-close') && $(target).hasClass('ui-state-default')) {
                keyVent.preventDefault();
                previousDay(target);
            }
        } else if (which === 39) { // RIGHT arrow key
            // if we're on a date link...
            if (!$(target).hasClass('ui-datepicker-close') && $(target).hasClass('ui-state-default')) {
                keyVent.preventDefault();
                nextDay(target);
            }
        } else if (which === 38) { // UP arrow key
            if (!$(target).hasClass('ui-datepicker-close') && $(target).hasClass('ui-state-default')) {
                keyVent.preventDefault();
                upHandler(target, container, prev);
            }
        } else if (which === 40) { // DOWN arrow key
            if (!$(target).hasClass('ui-datepicker-close') && $(target).hasClass('ui-state-default')) {
                keyVent.preventDefault();
                downHandler(target, container, next);
            }
        } else if (which === 13) { // ENTER
            if ($(target).hasClass('ui-state-default')) {
                setTimeout(function () {
                    closeCalendar(div_s);
                }, 100);
            } else if ($(target).hasClass('ui-datepicker-prev')) {
                handlePrevClicks();
            } else if ($(target).hasClass('ui-datepicker-next')) {
                handleNextClicks();
            }
        } else if (32 === which) {
            if ($(target).hasClass('ui-datepicker-prev') || $(target).hasClass('ui-datepicker-next')) {
                target.click();
            }
        } else if (33 === which) { // PAGE UP
            moveOneMonth(target, 'prev');
        } else if (34 === which) { // PAGE DOWN
            moveOneMonth(target, 'next');
        } else if (36 === which) { // HOME
            var firstOfMonth = $(target).closest('tbody').find('.ui-state-default')[0];
            if (firstOfMonth) {
                firstOfMonth.focus();
                setHighlightState(firstOfMonth, $('#ui-datepicker-div')[0]);
            }
        } else if (35 === which) { // END
            var $daysOfMonth = $(target).closest('tbody').find('.ui-state-default');
            var lastDay = $daysOfMonth[$daysOfMonth.length - 1];
            if (lastDay) {
                lastDay.focus();
                setHighlightState(lastDay, $('#ui-datepicker-div')[0]);
            }
        }
        $(".ui-datepicker-current").hide();
    });

}

function closeCalendar(div_s) {
    var container = $('#ui-datepicker-div');
    $(container).off('keydown');
    var input = $('#' + div_s)[0];
    $(input).datepicker('hide');

    input.focus();
}

function removeAria() {
    // make the rest of the page accessible again:
    $("#dp-container").removeAttr('aria-hidden');
    $("#skipnav").removeAttr('aria-hidden');
}

///////////////////////////////
//////////////////////////// //
///////////////////////// // //
// UTILITY-LIKE THINGS // // //
///////////////////////// // //
//////////////////////////// //
///////////////////////////////
function isOdd(num) {
    return num % 2;
}

function moveOneMonth(currentDate, dir) {
    var button = (dir === 'next')
            ? $('.ui-datepicker-next')[0]
            : $('.ui-datepicker-prev')[0];

    if (!button) {
        return;
    }

    var ENABLED_SELECTOR = '#ui-datepicker-div tbody td:not(.ui-state-disabled)';
    var $currentCells = $(ENABLED_SELECTOR);
    var currentIdx = $.inArray(currentDate.parentNode, $currentCells);

    button.click();
    setTimeout(function () {
        updateHeaderElements();

        var $newCells = $(ENABLED_SELECTOR);
        var newTd = $newCells[currentIdx];
        var newAnchor = newTd && $(newTd).find('a')[0];

        while (!newAnchor) {
            currentIdx--;
            newTd = $newCells[currentIdx];
            newAnchor = newTd && $(newTd).find('a')[0];
        }

        setHighlightState(newAnchor, $('#ui-datepicker-div')[0]);
        newAnchor.focus();

    }, 0);

}

function handleNextClicks() {
    setTimeout(function () {
        updateHeaderElements();
        prepHighlightState();
        $('.ui-datepicker-next').focus();
        $(".ui-datepicker-current").hide();
    }, 0);
}

function handlePrevClicks() {
    setTimeout(function () {
        updateHeaderElements();
        prepHighlightState();
        $('.ui-datepicker-prev').focus();
        $(".ui-datepicker-current").hide();
    }, 0);
}

function previousDay(dateLink) {
    var container = document.getElementById('ui-datepicker-div');
    if (!dateLink) {
        return;
    }
    var td = $(dateLink).closest('td');
    if (!td) {
        return;
    }

    var prevTd = $(td).prev(),
            prevDateLink = $('a.ui-state-default', prevTd)[0];

    if (prevTd && prevDateLink) {
        setHighlightState(prevDateLink, container);
        prevDateLink.focus();
    } else {
        handlePrevious(dateLink);
    }
}


function handlePrevious(target) {
    var container = document.getElementById('ui-datepicker-div');
    if (!target) {
        return;
    }
    var currentRow = $(target).closest('tr');
    if (!currentRow) {
        return;
    }
    var previousRow = $(currentRow).prev();

    if (!previousRow || previousRow.length === 0) {
        // there is not previous row, so we go to previous month...
        previousMonth();
    } else {
        var prevRowDates = $('td a.ui-state-default', previousRow);
        var prevRowDate = prevRowDates[prevRowDates.length - 1];

        if (prevRowDate) {
            setTimeout(function () {
                setHighlightState(prevRowDate, container);
                prevRowDate.focus();
            }, 0);
        }
    }
}

function previousMonth() {
    var prevLink = $('.ui-datepicker-prev')[0];
    var container = document.getElementById('ui-datepicker-div');
    prevLink.click();
    // focus last day of new month
    setTimeout(function () {
        var trs = $('tr', container),
                lastRowTdLinks = $('td a.ui-state-default', trs[trs.length - 1]),
                lastDate = lastRowTdLinks[lastRowTdLinks.length - 1];

        // updating the cached header elements
        updateHeaderElements();

        setHighlightState(lastDate, container);
        lastDate.focus();

    }, 0);
}

///////////////// NEXT /////////////////
/**
 * Handles right arrow key navigation
 * @param  {HTMLElement} dateLink The target of the keyboard event
 */
function nextDay(dateLink) {
    var container = document.getElementById('ui-datepicker-div');
    if (!dateLink) {
        return;
    }
    var td = $(dateLink).closest('td');
    if (!td) {
        return;
    }
    var nextTd = $(td).next(),
            nextDateLink = $('a.ui-state-default', nextTd)[0];

    if (nextTd && nextDateLink) {
        setHighlightState(nextDateLink, container);
        nextDateLink.focus(); // the next day (same row)
    } else {
        handleNext(dateLink);
    }
}

function handleNext(target) {
    var container = document.getElementById('ui-datepicker-div');
    if (!target) {
        return;
    }
    var currentRow = $(target).closest('tr'),
            nextRow = $(currentRow).next();

    if (!nextRow || nextRow.length === 0) {
        nextMonth();
    } else {
        var nextRowFirstDate = $('a.ui-state-default', nextRow)[0];
        if (nextRowFirstDate) {
            setHighlightState(nextRowFirstDate, container);
            nextRowFirstDate.focus();
        }
    }
}

function nextMonth() {
    nextMon = $('.ui-datepicker-next')[0];
    var container = document.getElementById('ui-datepicker-div');
    nextMon.click();
    // focus the first day of the new month
    setTimeout(function () {
        // updating the cached header elements
        updateHeaderElements();

        var firstDate = $('a.ui-state-default', container)[0];
        setHighlightState(firstDate, container);
        firstDate.focus();
    }, 0);
}

/////////// UP ///////////
/**
 * Handle the up arrow navigation through dates
 * @param  {HTMLElement} target   The target of the keyboard event (day)
 * @param  {HTMLElement} cont     The calendar container
 * @param  {HTMLElement} prevLink Link to navigate to previous month
 */
function upHandler(target, cont, prevLink) {
    prevLink = $('.ui-datepicker-prev')[0];
    var rowContext = $(target).closest('tr');
    if (!rowContext) {
        return;
    }
    var rowTds = $('td', rowContext),
            rowLinks = $('a.ui-state-default', rowContext),
            targetIndex = $.inArray(target, rowLinks),
            prevRow = $(rowContext).prev(),
            prevRowTds = $('td', prevRow),
            parallel = prevRowTds[targetIndex],
            linkCheck = $('a.ui-state-default', parallel)[0];

    if (prevRow && parallel && linkCheck) {
        // there is a previous row, a td at the same index
        // of the target AND theres a link in that td
        setHighlightState(linkCheck, cont);
        linkCheck.focus();
    } else {
        // we're either on the first row of a month, or we're on the
        // second and there is not a date link directly above the target
        prevLink.click();
        setTimeout(function () {
            // updating the cached header elements
            updateHeaderElements();
            var newRows = $('tr', cont),
                    lastRow = newRows[newRows.length - 1],
                    lastRowTds = $('td', lastRow),
                    tdParallelIndex = $.inArray(target.parentNode, rowTds),
                    newParallel = lastRowTds[tdParallelIndex],
                    newCheck = $('a.ui-state-default', newParallel)[0];

            if (lastRow && newParallel && newCheck) {
                setHighlightState(newCheck, cont);
                newCheck.focus();
            } else {
                // theres no date link on the last week (row) of the new month
                // meaning its an empty cell, so we'll try the 2nd to last week
                var secondLastRow = newRows[newRows.length - 2],
                        secondTds = $('td', secondLastRow),
                        targetTd = secondTds[tdParallelIndex],
                        linkCheck = $('a.ui-state-default', targetTd)[0];

                if (linkCheck) {
                    setHighlightState(linkCheck, cont);
                    linkCheck.focus();
                }

            }
        }, 0);
    }
}

//////////////// DOWN ////////////////
/**
 * Handles down arrow navigation through dates in calendar
 * @param  {HTMLElement} target   The target of the keyboard event (day)
 * @param  {HTMLElement} cont     The calendar container
 * @param  {HTMLElement} nextLink Link to navigate to next month
 */
function downHandler(target, cont, nextLink) {
    nextLink = $('.ui-datepicker-next')[0];
    var targetRow = $(target).closest('tr');
    if (!targetRow) {
        return;
    }
    var targetCells = $('td', targetRow),
            cellIndex = $.inArray(target.parentNode, targetCells), // the td (parent of target) index
            nextRow = $(targetRow).next(),
            nextRowCells = $('td', nextRow),
            nextWeekTd = nextRowCells[cellIndex],
            nextWeekCheck = $('a.ui-state-default', nextWeekTd)[0];

    if (nextRow && nextWeekTd && nextWeekCheck) {
        // theres a next row, a TD at the same index of `target`,
        // and theres an anchor within that td
        setHighlightState(nextWeekCheck, cont);
        nextWeekCheck.focus();
    } else {
        nextLink.click();

        setTimeout(function () {
            // updating the cached header elements
            updateHeaderElements();

            var nextMonthTrs = $('tbody tr', cont),
                    firstTds = $('td', nextMonthTrs[0]),
                    firstParallel = firstTds[cellIndex],
                    firstCheck = $('a.ui-state-default', firstParallel)[0];

            if (firstParallel && firstCheck) {
                setHighlightState(firstCheck, cont);
                firstCheck.focus();
            } else {
                // lets try the second row b/c we didnt find a
                // date link in the first row at the target's index
                var secondRow = nextMonthTrs[1],
                        secondTds = $('td', secondRow),
                        secondRowTd = secondTds[cellIndex],
                        secondCheck = $('a.ui-state-default', secondRowTd)[0];

                if (secondRow && secondCheck) {
                    setHighlightState(secondCheck, cont);
                    secondCheck.focus();
                }
            }
        }, 0);
    }
}


function onCalendarHide() {
    closeCalendar();
}

// add an aria-label to the date link indicating the currently focused date
// (formatted identically to the required format: mm/dd/yyyy)
function monthDayYearText() {
    var cleanUps = $('.amaze-date');

    $(cleanUps).each(function (clean) {
        // each(cleanUps, function (clean) {
        clean.parentNode.removeChild(clean);
    });

    var datePickDiv = document.getElementById('ui-datepicker-div');
    // in case we find no datepick div
    if (!datePickDiv) {
        return;
    }

    var dates = $('a.ui-state-default', datePickDiv);

    $(dates).each(function (index, date) {
        var currentRow = $(date).closest('tr'),
                currentTds = $('td', currentRow),
                currentIndex = $.inArray(date.parentNode, currentTds),
                headThs = $('thead tr th', datePickDiv),
                dayIndex = headThs[currentIndex],
                daySpan = $('span', dayIndex)[0],
                monthName = $('.ui-datepicker-month', datePickDiv)[0].innerHTML,
                year = $('.ui-datepicker-year', datePickDiv)[0].innerHTML,
                number = date.innerHTML;

        if (!daySpan || !monthName || !number || !year) {
            return;
        }

        // AT Reads: {month} {date} {year} {day}
        // "December 18 2014 Thursday"
        var dateText = monthName + ' ' + date.innerHTML + ' ' + year + ' ' + daySpan.title;
        // AT Reads: {date(number)} {name of day} {name of month} {year(number)}
        // var dateText = date.innerHTML + ' ' + daySpan.title + ' ' + monthName + ' ' + year;
        // add an aria-label to the date link reading out the currently focused date
        date.setAttribute('aria-label', dateText);
    });
}



// update the cached header elements because we're in a new month or year
function updateHeaderElements() {
    var context = document.getElementById('ui-datepicker-div');
    if (!context) {
        return;
    }

    $(context).find('table').first().attr('role', 'grid');

    prev = $('.ui-datepicker-prev', context)[0];
    next = $('.ui-datepicker-next', context)[0];

    //make them click/focus - able
    next.href = 'javascript:void(0)';
    prev.href = 'javascript:void(0)';

    next.setAttribute('role', 'button');
    prev.setAttribute('role', 'button');
    appendOffscreenMonthText(next);
    appendOffscreenMonthText(prev);

    $(next).on('click', handleNextClicks);
    $(prev).on('click', handlePrevClicks);

    // add month day year text
    monthDayYearText();
}


function prepHighlightState() {
    var highlight;
    var cage = document.getElementById('ui-datepicker-div');
    highlight = $('.ui-state-highlight', cage)[0] ||
            $('.ui-state-default', cage)[0];
    if (highlight && cage) {
        setHighlightState(highlight, cage);
    }
}

// Set the highlighted class to date elements, when focus is recieved
function setHighlightState(newHighlight, container) {
    var prevHighlight = getCurrentDate(container);
    // remove the highlight state from previously
    // highlighted date and add it to our newly active date
    $(prevHighlight).removeClass('ui-state-highlight');
    $(newHighlight).addClass('ui-state-highlight');
}


// grabs the current date based on the hightlight class
function getCurrentDate(container) {
    var currentDate = $('.ui-state-highlight', container)[0];
    return currentDate;
}

/**
 * Appends logical next/prev month text to the buttons
 * - ex: Next Month, January 2015
 *       Previous Month, November 2014
 */
function appendOffscreenMonthText(button) {
    var buttonText;
    var isNext = $(button).hasClass('ui-datepicker-next');
    var months = [
        'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
    ];
    if (($('.ui-datepicker-month').val()) * 1 >= 0) {
        var currentMonth = $(".ui-datepicker-month option:selected").text().toLowerCase();
        var monthIndex = $.inArray(currentMonth.toLowerCase(), months);
        var currentYear = $(".ui-datepicker-year option:selected").text().toLowerCase();
        var adjacentIndex = (isNext) ? monthIndex + 1 : monthIndex - 1;
    } else {
        var currentMonth = $('.ui-datepicker-title .ui-datepicker-month').text().toLowerCase();
        var monthIndex = $.inArray(currentMonth.toLowerCase(), months);
        var currentYear = $('.ui-datepicker-title .ui-datepicker-year').text().toLowerCase();
        var adjacentIndex = (isNext) ? monthIndex + 1 : monthIndex - 1;
    }


    if (isNext && currentMonth === 'diciembre') {
        currentYear = parseInt(currentYear, 10) + 1;
        adjacentIndex = 0;
    } else if (!isNext && currentMonth === 'enero') {
        currentYear = parseInt(currentYear, 10) - 1;
        adjacentIndex = months.length - 1;
    }

    if (isNext) {
        buttonText = 'Next Month, ' + firstToCap(months[adjacentIndex]) + ' ' + currentYear;
    } else {
        buttonText = 'Previous Month, ' + firstToCap(months[adjacentIndex]) + ' ' + currentYear;
    }

    $(button).find('.ui-icon').html(buttonText);

}
// Returns the string with the first letter capitalized
function firstToCap(s) {
    return s.charAt(0).toUpperCase() + s.slice(1);
}
function cambia_theme(op) {//op: 1 black theme, 2: light_theme
    if (op == 1) {
        //black theme
        jQuery('#panel_menu').addClass('menu_oscuro');
        //update_f1('#ffffff');
        quita_clase(1);
        cambia_theme_a(1);
        $(".nav_sys, .nom_sys, .op_u_sys, .contra_sys > i, .busca_sys > i, .sub_menu_red, .tabla_sys_en > thead > tr *,.sub_menu_sys,h2").addClass("oscuro_1");
        $(".op_u_menu, .op_u_menu > li > a, .a_sub_nivel_sys, .a_sub_nivel_sys > i, .a_sub_nivel_sys > span > i").addClass("oscuro_2");
        $(".op_u_sys, .contra_sys, .busca_sys, .aj_sys, .op_u_menu > li, .b_s_sys, .a_sub_nivel_sys").addClass("punteados_s");
        $(".menu_sys").addClass("border_os_2");
        $(".principal_sys, .main-footer, .main-footer *, .search_sys, .tabla_sys_en > caption *,.card_sys,.tabla_sys_en > .row").addClass("oscuro_3");
        $(".principal_sys").addClass("oscuro_4");
        $(".b_s_sys, .b_s_sys *").addClass("oscuro_b");
        $(".input_text_sys, .input_text_sys *").addClass("input_t_osc");
        $(".bread_sys *, .div_tabla_sys, .div_form_sys").addClass('oscuro_bread');
        $(".label_sys").addClass('label_oscuro');
        $(".table_hover_sys").addClass("table_hover_oscuro");
        $(".obligatorio_sys,.obligatorio_sys *").addClass("obligatorio_oscuro");
        $(".div_form_acor_sys").addClass("div_form_acor_oscuro");
        $(".checks_forms_sys").addClass("checks_forms_os");
        $(".alert_warning_sys *,.alert_warning_sys").addClass('alert_warning_sys_osc');
        $(".b_s_sys").removeClass("border_l");
    } else if (op == 2) {
        //light theme
        jQuery('#panel_menu').addClass('menu_claro');
        quita_clase(2);
        cambia_theme_a(2);
        $(".nav_sys, .nom_sys, .op_u_sys, .contra_sys > i, .busca_sys > i, .sub_menu_red, .tabla_sys_en > thead > tr *,.sub_menu_sys").addClass("claro_1");
        $(".op_u_menu, .op_u_menu > li > a, .a_sub_nivel_sys, .a_sub_nivel_sys > i, .a_sub_nivel_sys > span > i").addClass("claro_2");
        $(".op_u_sys, .contra_sys, .busca_sys, .aj_sys, .op_u_menu > li, .b_s_sys, .a_sub_nivel_sys").addClass("punteados_l");
        $(".menu_sys").addClass("border_li_2");
        $(".principal_sys, .main-footer, .main-footer *, .search_sys, .tabla_sys_en > caption *,.card_sys,.tabla_sys_en > .row").addClass("claro_3");
        $(".principal_sys").addClass("claro_4");
        $(".b_s_sys, .b_s_sys *").addClass("claro_b");
        $(".input_text_sys, .input_text_sys *").addClass("input_t_claro");
        $(".bread_sys *, .div_tabla_sys, .div_form_sys").addClass('claro_bread');
        $(".label_sys").addClass('label_claro');
        $(".table_hover_sys").addClass("table_hover_claro");
        $(".obligatorio_sys,.obligatorio_sys *").addClass("obligatorio_claro");
        $(".div_form_acor_sys").addClass("div_form_acor_claro");
        $(".checks_forms_sys").addClass("checks_forms_claro");
        $(".alert_warning_sys *,.alert_warning_sys").addClass('alert_warning_sys_claro');
    }else if (op == 0) {
        quita_clase(2);
        quita_clase(1);
        cambia_theme_a(0);
    }
    $(".b_s_sys").removeClass("border_l");

}
function quita_clase(tipo) {
    if (tipo == 1) {
        jQuery('#panel_menu').removeClass('menu_claro');
        $(".nav_sys, .nom_sys, .op_u_sys, .contra_sys > i, .busca_sys > i, .menu_sys,.menu_sys,.menu_sub_u,.sub_menu_red, .tabla_sys_en > thead > tr *,.sub_menu_sys").removeClass("claro_1");
        $(".op_u_menu, .op_u_menu > li > a, .a_sub_nivel_sys, .a_sub_nivel_sys > i, .a_sub_nivel_sys > span > i").removeClass("claro_2");
        $(".op_u_sys, .contra_sys, .busca_sys, .aj_sys, .op_u_menu > li, .b_s_sys, .a_sub_nivel_sys").removeClass("punteados_l");
        $(".menu_sys").removeClass("border_li_2");
        $(".principal_sys, .main-footer, .main-footer *, .search_sys, .tabla_sys_en > caption *,.card_sys,.tabla_sys_en > .row").removeClass("claro_3");
        $(".principal_sys").removeClass("claro_4");
        $(".b_s_sys, .b_s_sys *").removeClass("claro_b");
        $(".input_text_sys, .input_text_sys *").removeClass("input_t_claro");
        $(".bread_sys *, .div_tabla_sys, .div_form_sys").removeClass('claro_bread');
        $(".label_sys").removeClass('label_claro');
        $(".table_hover_sys").removeClass("table_hover_claro");
        $(".obligatorio_sys,.obligatorio_sys *").removeClass("obligatorio_claro");
        $(".div_form_acor_sys").removeClass("div_form_acor_claro");
        $(".checks_forms_sys").removeClass("checks_forms_claro");
        $(".alert_warning_sys *,.alert_warning_sys").removeClass('alert_warning_sys_claro');
    } else if (tipo == 2) {
        jQuery('#panel_menu').removeClass('menu_oscuro');
        $(".nav_sys, .nom_sys, .op_u_sys, .contra_sys > i, .busca_sys > i, .menu_sys,.menu_sys,.menu_sub_u,.sub_menu_red, .tabla_sys_en > thead > tr *,.sub_menu_sys,h2").removeClass("oscuro_1");
        $(".op_u_menu, .op_u_menu > li > a, .a_sub_nivel_sys, .a_sub_nivel_sys > i, .a_sub_nivel_sys > span > i").removeClass("oscuro_2");
        $(".op_u_sys, .contra_sys, .busca_sys, .aj_sys, .op_u_menu > li, .b_s_sys, .a_sub_nivel_sys").removeClass("punteados_s");
        $(".menu_sys").removeClass("border_os_2");
        $(".principal_sys, .main-footer, .main-footer *, .search_sys, .tabla_sys_en > caption *,.card_sys,.tabla_sys_en > .row").removeClass("oscuro_3");
        $(".principal_sys").removeClass("oscuro_4");
        $(".b_s_sys, .b_s_sys *").removeClass("oscuro_b");
        $(".input_text_sys, .input_text_sys *").removeClass("input_t_osc");
        $(".bread_sys *, .div_tabla_sys, .div_form_sys").removeClass('oscuro_bread');
        $(".label_sys").removeClass('label_oscuro');
        $(".table_hover_sys").removeClass("table_hover_oscuro");
        $(".obligatorio_sys,.obligatorio_sys *").removeClass("obligatorio_oscuro");
        $(".div_form_acor_sys").removeClass("div_form_acor_oscuro");
        $(".checks_forms_sys").removeClass("checks_forms_os");
        $(".alert_warning_sys *,.alert_warning_sys").removeClass('alert_warning_sys_osc');
        $(".b_s_sys").removeClass("border_l");
    }
}
