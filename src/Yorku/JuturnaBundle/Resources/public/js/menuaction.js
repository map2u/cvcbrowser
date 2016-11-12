/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {
    $("nav.navbar-custom li.dropdown ul.helper-dropdown-menu li").unbind("click");
    $("nav.navbar-custom li.dropdown ul.helper-dropdown-menu li").click(function (e) {
        var id = $(this).data("id");
       window.open(Routing.generate('help_showcontent',{'id':id,_locale: window.locale}));
    });


    $("nav.navbar-custom li button.well_being_indicators").unbind("click");
    $("nav.navbar-custom li button.well_being_indicators").click(function (e) {
        $(".navbar-custom div.well_being_indicators").hide();
        $(".navbar-custom div.environment_services").fadeIn();
        e.preventDefault();

        $.ajax({
            url: Routing.generate('menucategory_index',{_locale: window.locale}),
            method: 'GET',
            data: {'layerid': 0, 'category': 'well_being_indicators'},
            processData: true,
            contentType: false,
            success: function (response) {

                $(".leaflet-sidebar #sidebar-left #sidebar_content").html(response);
                if (window.leftSidebar.isVisible() === false)
                {
                    $('#sidebar-left #sidebar_content').css('visibility', 'visible');
                    $(".sonata-bc .leftsidebar-close-control").hide();
                    setTimeout(function () {
                        window.leftSidebar.show();
                    }, 500);
                }

            },
            error: function (error) {
                alert("error:" + error);
            }
        });
    });
    $("nav.navbar-custom li button.environment_services").click(function (e) {
        $(".navbar-custom div.environment_services").hide();
        $(".navbar-custom div.well_being_indicators").fadeIn();
        e.preventDefault();
        $.ajax({
            url: Routing.generate('menucategory_index',{_locale: window.locale}),
            method: 'GET',
            data: {'layerid': 0, 'category': 'environment_services'},
            processData: true,
            contentType: false,
            success: function (response) {

                $(".leaflet-sidebar #sidebar-left #sidebar_content").html(response);
                if (window.leftSidebar.isVisible() === false)
                {
                    $('#sidebar-left #sidebar_content').css('visibility', 'visible');
                    $(".sonata-bc .leftsidebar-close-control").hide();
                    setTimeout(function () {
                        window.leftSidebar.show();
                    }, 500);
                }
            },
            error: function (error) {
                alert("error:" + error);
            }
        });
    });
    $(".navbar.navbar-fixed-top").resize(function () {
        // alert("qqq=" + $(".navbar.navbar-fixed-top").height());
        $("body.sonata-bc").css('top', $(".navbar.navbar-fixed-top").height());
    });


    $("li a.health_well_being").click(function (e) {
        e.preventDefault();

        $.ajax({
            url: Routing.generate('menucategory_index',{_locale: window.locale}),
            method: 'GET',
            data: {'layerid': 0, 'category': 'health_well_being', 'content_id': $(this).data("id")},
            processData: true,
            contentType: false,
            success: function (response) {

                $(".leaflet-sidebar #sidebar-left #sidebar_content").html(response);
                if (window.leftSidebar.isVisible() === false)
                {
                    $('#sidebar-left #sidebar_content').css('visibility', 'visible');
                    $(".sonata-bc .leftsidebar-close-control").hide();
                    setTimeout(function () {
                        window.leftSidebar.show();
                    }, 500);
                }
            },
            error: function (error) {
                alert("error:" + error);
            }
        });
    });

    $("ul.navbar-nav li.category").click(function (e) {
        e.preventDefault();


        if ($(this).attr('category') === 'about' || $(this).attr('category') === undefined)
            return;
        window.graphchart.category = $(this).attr('category');
        //      if (window.graphchart.disabled !== false)
//        {
//            window.graphchart.update();
//            window.graphchart.activate(e);
//        }
//        else
        //       {
        if (window.category_update)
            window.category_update($(this).attr('category'));
        //      }
        $("ul.navbar-nav li.category").removeClass('selected');
        $(this).addClass('selected');
    });
    function category_update(category) {

        $.ajax({
            url: Routing.generate('menucategory_index',{_locale: window.locale}),
            method: 'GET',
            data: {'layerid': 14, 'category': category},
            processData: true,
            contentType: false,
            success: function (response) {

                $(".leaflet-sidebar #sidebar-left #sidebar_content").html(response);
                if (window.leftSidebar.isVisible() === false)
                {
                    $('#sidebar-left #sidebar_content').css('visibility', 'visible');
                    $(".sonata-bc .leftsidebar-close-control").hide();
                    setTimeout(function () {
                        window.leftSidebar.show();
                    }, 500);
                }
            },
            error: function (error) {
                alert("error:" + error);
            }
        });
    }
    window.category_update = category_update;
});