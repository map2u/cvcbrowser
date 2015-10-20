/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//var mapapp;
//
//
//
//

//var canvas;
//
//var context;
//
//var path;



window.onload = function () {
    var map;
    var leafletmap_tooltip;
    var layersControl;
    var leftSidebar;
    $('#leafmap').height($(window).height() - $(".juturna-page-header").height() - $(".juturna-main_menu").height() - 2);
    $('.leaflet-sidebar #sidebar-left').height($(window).height() - $(".juturna-page-header").height() - $(".juturna-main_menu").height() - 60);
    $(window).resize(function () { /* do something */
        $('#leafmap').height($(window).height() - $(".juturna-page-header").height() - $(".juturna-main_menu").height() - 2);
        $('#map-ui').height($(window).height() - $(".juturna-page-header").height() - $(".juturna-main_menu").height() - 2);
        $('.leaflet-sidebar #sidebar-left').height($(window).height() - $(".juturna-page-header").height() - $(".juturna-main_menu").height() - 60);
    });
    map = new L.MAP2U.Map('leafmap', {
        'zoomControl': false
    }).setView([43.73737, -79.95987], 10);
    this.map = map;
    //add a tile layer to add to our map, in this case it's the 'standard' OpenStreetMap.org tile server
    var mapnik = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
        maxZoom: 18
    });
    var googleLayer_satellite = new L.Google('SATELLITE', {attribution: ""});
    var googleLayer_roadmap = new L.Google('ROADMAP', {attribution: ""});
    var googleLayer_hybrid = new L.Google('HYBRID', {attribution: ""});
    var googleLayer_terrain = new L.Google('TERRAIN', {attribution: ""});
    var bingkey = 'Ahxau5mtl944aCyAb8tfmrLebWENWZDXEmMIQWRaRQjTho2U0NkHqAUpcT1nTW1v';
    var BingAttribution = '';
    //  var bing = new L.BingLayer("AqTGBsziZHIJYYxgivLBf0hVdrAk9mWO5cQcb8Yux8sW5M8c8opEC2lZqKR1ZZXf", {type: 'Road'});

    //   map.addLayer(bing);

    var Thunderforest_Transport = L.tileLayer('http://{s}.tile2.opencyclemap.org/transport/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://www.opencyclemap.org">OpenCycleMap</a>, &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>'
    });
    var mapnik_minimap = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
        maxZoom: 18
    });
    var miniMap = new L.Control.MiniMap(mapnik_minimap, {position: 'bottomright', width: 150, height: 150, zoomLevelOffset: -4, zoomAnimation: false, toggleDisplay: true, autoToggleDisplay: false}).addTo(map);
    map.addLayer(mapnik);
    var subwatersheds = new L.TileLayer.WMS(
            "http://cobas.juturna.ca:8080/geoserver/juturna/wms",
            {
                layers: 'juturna:cvcsubwatersheds',
                format: 'image/png',
                transparent: true,
                srs: 'EPSG:4326',
                attribution: ""
            });
    map.baseLayers = [
        {'layer': mapnik, 'layerName': 'Open Street Map'},
        {'layer': Thunderforest_Transport, 'layerName': 'Thunderforest_Transport'},
        //       {'layer': bing, 'name': 'Bing'},
        {'layer': googleLayer_roadmap, 'layerName': 'Google Road Map'},
        {'layer': new L.Google('SATELLITE'), 'layerName': 'Google Satellite'},
        {'layer': new L.Google('HYBRID'), 'layerName': 'Google Hybrid'},
        {'layer': new L.Google('TERRAIN'), 'layerName': 'Google Terrain'}

    ];
    map.noteLayer = new L.FeatureGroup();
    map.noteLayer.options = {code: 'N'};
    map.dataLayers = [];
    var index;
    var layers = [];
    var leftsidebarControl = L.Control.extend({
        options: {
            position: 'topleft'

        },
        onAdd: function (map) {
            // create the control container with a particular class name
            var container = L.DomUtil.create('div', 'leftsidebar-control');
            L.DomEvent
                    .addListener(container, 'click', L.DomEvent.stopPropagation)
                    .addListener(container, 'click', L.DomEvent.preventDefault)
                    .addListener(container, 'click', function () {
                        ShowLeftSideBar(leftSidebar);
                    });
            var controlUI = L.DomUtil.create('div', 'leftsidebar-close-control hidden', container);
            controlUI.title = 'Show Left Side Bar';
            return container;
        }
    });
    map.addControl(new leftsidebarControl());
    var history = new L.HistoryControl({position: 'topleft', useExternalControls: true});
    map.addControl(history);
    var MapToolbarControl = L.Control.extend({
        options: {
            position: 'topright'

        },
        onAdd: function (map) {
            // create the control container with a particular class name
            var container = L.DomUtil.create('div', 'maptoolbar-control');
            var measureUI = L.DomUtil.create('div', 'maptoolbar-control-measure', container);
            L.DomEvent
                    .addListener(measureUI, 'click', L.DomEvent.stopPropagation)
                    .addListener(measureUI, 'click', L.DomEvent.preventDefault)
                    .addListener(measureUI, 'click', function () {
                        if ($(this).hasClass("active")) {
                            $(this).removeClass("active");
                        }
                        else {
                            $(this).addClass("active");
                        }
                        MapMeasurement(this, map);
                    });
            measureUI.title = I18n.t('Map Measurement');

            var controlUI = L.DomUtil.create('div', 'maptoolbar-control-reset', container);
            L.DomEvent
                    .addListener(controlUI, 'click', L.DomEvent.stopPropagation)
                    .addListener(controlUI, 'click', L.DomEvent.preventDefault)
                    .addListener(controlUI, 'click', function () {
                        MapExtentReset(map);
                    });
            controlUI.title = I18n.t('Reset Map Extent');


            var Prev_Extent = L.DomUtil.create('div', 'maptoolbar-control-prev', container);
            L.DomEvent
                    .addListener(Prev_Extent, 'click', L.DomEvent.stopPropagation)
                    .addListener(Prev_Extent, 'click', L.DomEvent.preventDefault)
                    .addListener(Prev_Extent, 'click', function () {
                        // PrevMapExtent(map);
                        history.goBack();
                    });
            Prev_Extent.title = I18n.t('Prev Map Extent');
            var Next_Extent = L.DomUtil.create('div', 'maptoolbar-control-next', container);
            L.DomEvent
                    .addListener(Next_Extent, 'click', L.DomEvent.stopPropagation)
                    .addListener(Next_Extent, 'click', L.DomEvent.preventDefault)
                    .addListener(Next_Extent, 'click', function () {
                        //   NextMapExtent(map);
                        history.goForward();
                    });
            Next_Extent.title = I18n.t('Next Map Extent');
            return container;
        }
    });
    map.addControl(new MapToolbarControl());




    var MapMeasurementControl = L.Control.extend({
        options: {
            position: 'topleft'

        },
        onAdd: function (map) {
            var toolbuttons = ['polyline', 'polygon', 'rectangle', 'circle'];
            // create the control container with a particular class name
            var container = L.DomUtil.create('div', 'mapmeasurement-control hidden');

            var list = $('<ul>')
                    .attr("class", "leaflet-measure-toolbar")
                    .appendTo(container);
            toolbuttons.forEach(function (tool_name) {
                var item = $('<li>')
                        .attr("class", "leaflet-measure-actions mapmeasurement-control-" + tool_name)
                        .attr('value', tool_name)
                        .appendTo(list);
                item.on('click', function () {
                    $(".mapmeasurement-control .leaflet-measure-actions").removeClass("active");
                    $(this).addClass("active");
                    measureArea(map, $(this).attr('value'));
                });
            });
            return container;
        }
    });
    map.addControl(new MapMeasurementControl());



    var position = $('html').attr('dir') === 'rtl' ? 'topleft' : 'topright';
    L.MAP2U.zoom({position: position}).addTo(map);
    L.control.locate({
        position: position,
        strings: {
            title: I18n.t('javascripts.map.locate.title'),
            popup: I18n.t('javascripts.map.locate.popup')
        }
    }).addTo(map);
    L.control.scale().addTo(map);
    mouseposition = L.control.mousePosition({'emptyString': '', 'position': 'bottomleft'}).addTo(map);
    leafletmap_tooltip = d3.select("#leafmap").append("div").attr("class", "leafmap_title_tooltip hidden");
    //  var map_tooltip = d3.select("#leafmap").append("div").attr("class", "leafmap_title_tooltip hidden");

    leftSidebar = L.control.sidebar('sidebar-left', {
        position: 'left'
    });
    map.addControl(leftSidebar);
    var rightSidebar = L.control.sidebar('sidebar-right', {
        position: 'right'
    });
    map.addControl(rightSidebar);
    this.rightSidebar = rightSidebar;
    this.leftSidebar = leftSidebar;
    layersControl = L.MAP2U.layers({
        position: position,
        map: map,
        map_tooltip: leafletmap_tooltip,
        layers: map.baseLayers,
        sidebar: rightSidebar
    });
    layersControl.addTo(map);
    this.layersControl = layersControl;
    L.MAP2U.uploadfile({position: position,
        sidebar: rightSidebar,
        'short': true
    }).addTo(map);
    L.MAP2U.uploadfile_list({position: position,
        sidebar: rightSidebar,
        'short': true
    }).addTo(map);
    var graphchart = L.MAP2U.graphchart({
        position: position,
        sidebar: rightSidebar
    });
    graphchart.addTo(map);
    this.graphchart = graphchart;
//    var measure = L.MAP2U.measure({
//        position: position,
//        sidebar: rightSidebar,
//        'short': true
//    });
//    measure.addTo(map);
//    this.measure = measure;
    L.MAP2U.query({
        position: position,
        sidebar: rightSidebar,
        'short': true
    }).addTo(map);
    setTimeout(function () {
        leftSidebar.toggle();
    }, 500);
    map.on("click", function (e) {
        if ($("div#useraccount_mapbookmark  form.useraccount_mapbookmark_form td.get_address input.get_address_from_map").length > 0 && $("div#useraccount_mapbookmark  form.useraccount_mapbookmark_form td.get_address input.get_address_from_map").is(":checked"))
        {

            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': e.latlng}, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK)
                {

                    var old_address = false;
                    $("div#useraccount_mapbookmark  form.useraccount_mapbookmark_form .address input[type='text']").map(function () {
                        if ($(this).val().toString() !== null && $(this).val().toString() !== '') {
                            old_address = true;
                        }
                    });
                    if (old_address) {
                        if (!confirm("Address already exist, do you want to overwrite it?"))
                            return;
                    }

                    var pt = results[0].geometry.location;
                    var lng = pt.lng();
                    var lat = pt.lat();
                    $("div#useraccount_mapbookmark  form.useraccount_mapbookmark_form input[type='hidden'][name='lat']").map(function () {
                        $(this).val(lat);
                    });
                    $("div#useraccount_mapbookmark  form.useraccount_mapbookmark_form input[type='hidden'][name='lng']").map(function () {
                        $(this).val(lng);
                    });
                    $("div#useraccount_mapbookmark  form.useraccount_mapbookmark_form .address input[type='text']").map(function () {
                        $(this).val(results[0].formatted_address);
                    });
                    var layers = map.drawnItems.getLayers();
                    for (var i = layers.length - 1; i >= 0; i--) {
                        if (layers[i].source !== undefined && layers[i].source === 'searchbox_query') {
                            map.drawnItems.removeLayer(layers[i]);
                        }
                    }

                    var feature = L.marker([pt.lat(), pt.lng()], {draggable: 'true'});
                    feature.bindLabel(results[0].formatted_address);
                    feature.id = 0;
                    feature.name = results[0].formatted_address;
                    feature.index = map.drawnItems.getLayers().length;
                    feature.type = 'marker';
                    feature.source = 'searchbox_query';
                    feature.on("dragend", function (e) {

                        geocoder.geocode({'latLng': e.target.getLatLng()}, function (results, status) {
                            if (status === google.maps.GeocoderStatus.OK)
                            {
                                var pt = results[0].geometry.location;
                                var lng = pt.lng();
                                var lat = pt.lat();
                                map.removeLayer(feature.label);
                                feature.bindLabel(results[0].formatted_address);
                                $("div#useraccount_mapbookmark  form.useraccount_mapbookmark_form input[type='hidden'][name='lat']").map(function () {
                                    $(this).val(lat);
                                });
                                $("div#useraccount_mapbookmark  form.useraccount_mapbookmark_form input[type='hidden'][name='lng']").map(function () {
                                    $(this).val(lng);
                                });
                                $("div#useraccount_mapbookmark  form.useraccount_mapbookmark_form .address input[type='text']").map(function () {
                                    $(this).val(results[0].formatted_address);
                                });
                            }
                        });
                    });
                    map.drawnItems.addLayer(feature);
                }
                else {
                    alert("The given address is not able geocoding!");
                }
            });
        }
    });
// if close left sidebar, then show sidebar controller icon
    $(".sonata-bc div.leaflet-sidebar.left a.close").click(function () {
        if ($(".leaflet-sidebar.left").css('left') === 0 || $(".leaflet-sidebar.left").css('left') === '0px') {
            $(".sonata-bc .leftsidebar-close-control").removeClass("hidden");
            $(".sonata-bc .leftsidebar-close-control").show();
        } else {

            $(".sonata-bc .leftsidebar-close-control").hide();
        }
    });
    $.ajax({
        url: Routing.generate('leaflet_userlayers', {_locale: window.locale}),
        method: 'GET',
        complete: function () {

        },
        success: function (response) {
            var result;
            if (typeof response !== 'object')
                result = JSON.parse(response);
            else
                result = response;
            if (result.success === true && result.layers) {

                result.layers = sortByKey(result.layers, 'seq');
                var keys = Object.keys(result.layers).map(function (k) {

                    return k;
                });
                // alert(keys.length + "," + keys[0]);
                // div style="height: 305px;" class="leaflet-control" id="sidebar-left" data-viewtype="benefit" data-viewlayers="8,7,"
                var default_layers = $("div#sidebar-left.leaflet-control").data("viewlayers"); //.toString();
                var default_datatype = $("div#sidebar-left.leaflet-control").data("viewtype");
                var default_layers_array = [];
                if (default_layers !== undefined && default_layers.trim().length > 0) {
                    default_layers = default_layers.substr(0, default_layers.length - 1);
                    default_layers_array = default_layers.split(",");
                }

                var cluster_layers = $("div#sidebar-left.leaflet-control").data("viewclusterlayers"); //.toString();
                var cluster_layers_array = [];
                if (cluster_layers !== undefined && cluster_layers.trim().length > 0) {
                    cluster_layers = cluster_layers.substr(0, cluster_layers.length - 1);
                    cluster_layers_array = cluster_layers.split(",");
                }
                var geoserver_layers = $("div#sidebar-left.leaflet-control").data("viewgeoserverlayers"); //.toString();
                var geoserver_layers_array = [];
                if (geoserver_layers !== undefined && geoserver_layers.trim().length > 0) {
                    geoserver_layers = geoserver_layers.substr(0, geoserver_layers.length - 1);
                    geoserver_layers_array = geoserver_layers.split(",");
                }

                for (var k = 0; k < keys.length; k++)
                {
                    var layer = result.layers[keys[k]];
                    if ((default_datatype === 'benefit') && default_layers_array.length > 0) {
                        if (layer.layerType === 'uploadfilelayer') {
                            if (default_layers_array.indexOf(layer.id.toString()) !== -1) {
                                layer.defaultShowOnMap = '1';
                            }
                            else
                            {
                                layer.defaultShowOnMap = '0';
                            }
                        }
                        if (layer.layerType === 'clustermap') {
                            if (cluster_layers_array.indexOf(layer.id.toString()) !== -1) {
                                layer.defaultShowOnMap = '1';
                            }
                            else
                            {
                                layer.defaultShowOnMap = '0';
                            }
                        }
                        if (layer.layerType === 'wms' || layer.layerType === 'wfs') {
                            if (geoserver_layers_array.indexOf(layer.id.toString()) !== -1) {
                                layer.defaultShowOnMap = '1';
                            }
                            else
                            {
                                layer.defaultShowOnMap = '0';
                            }
                        }
                    }
                    map.dataLayers[map.dataLayers.length] = {'map': map, 'layerType': layer.layerType, 'clusterLayer': layer.clusterLayer, 'defaultShowOnMap': layer.defaultShowOnMap, 'layer': null, 'minZoom': layer.minZoom, 'maxZoom': layer.maxZoom, 'index_id': k, 'layerId': layer.id, layerTitle: layer.layerTitle, 'datasource': layer.datasource, 'sld': layer.sld, 'filename': layer.filename, 'layerName': layer.layerName, 'hostName': layer.hostName};
                }
                //    map.dataLayers[map.dataLayers.length] = {'map': map, 'layerType': 'userdraw', 'layer': null, 'index_id': -1, 'layerId': -1, layerTitle: "My draw geometries", 'layerName': 'My draw geometries', type: 'geojson'};
                //    layersControl.refreshOverlays();
                loadStoriesLayer(map, layersControl);
                setTimeout(function () {


                    $(".section.overlay-layers .overlay_ul .overlay_li").map(function () {
                        if ($(this).find("input[type='checkbox']").is(":checked")) {
                            $(this).find(".layer_legend_icon i").removeClass("fa-plus");
                            $(this).find(".layer_legend_icon i").addClass("fa-minus");
                            $(this).find(".layer_legend").removeClass("hidden");
                            $(this).find(".layer_legend").show();
                        }
                    });
                    if ($(".section.overlay-layers .overlay_ul .overlay_li input[type='checkbox']:checked").length > 0) {
                        $(".leaflet-sidebar.right").removeClass("hidden");
                        $(".leaflet-sidebar.right").show();
                        $(".control-layers.leaflet-control .control-button").trigger("click");
                    }
                }, 3000);
            }
        }
    });
    $(window).resize();
    // $(".navbar.navbar-fixed-top").resize();


    initMapDraw(map);
    if ($("div#sidebar-left.leaflet-control").data("viewtype") === 'story' || $("div#sidebar-left.leaflet-control").data("viewtype") === 'stories') {
        $(".leaflet-draw.leaflet-control").show();
    }
    else
    {
        $(".leaflet-draw.leaflet-control").hide();
    }



//   layersControl.createHeatMapLayer();
    $(".search_form").on("submit", function (e) {
        e.preventDefault();
//    $("header").addClass("closed");
        var query = $(this).find("input[name=query]").val();
        if (query !== undefined && query.trim() !== '') {






            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'address': query}, function (results, status) {


                if (status === google.maps.GeocoderStatus.OK)
                {
                    var pt = results[0].geometry.location;
                    var layers = map.drawnItems.getLayers();
                    for (var i = layers.length - 1; i >= 0; i--) {
                        if (layers[i].source !== undefined && layers[i].source === 'searchbox_query') {
                            map.drawnItems.removeLayer(layers[i]);
                        }
                    }

                    var feature = L.marker([pt.lat(), pt.lng()]);
                    feature.bindLabel(results[0].formatted_address);
                    feature.id = 0;
                    feature.name = results[0].formatted_address;
                    feature.index = map.drawnItems.getLayers().length;
                    feature.type = 'marker';
                    feature.source = 'searchbox_query';
                    feature.on('click', function (e) {

                        if (map.drawControl._toolbars.edit._activeMode === null) {



                        }
                        else if (map.drawControl._toolbars.edit._activeMode && map.drawControl._toolbars.edit._activeMode.handler.type === 'edit') {

                            var radius = 0;
                            $.ajax({
                                url: Routing.generate('draw_' + e.target.type),
                                method: 'GET',
                                data: {
                                    id: e.target.id,
                                    name: e.target.name,
                                    radius: radius,
                                    index: e.target.index
                                },
                                success: function (response) {
                                    if ($('body.sonata-bc #ajax-dialog').length === 0) {
                                        $('<div class="modal fade" id="ajax-dialog" role="dialog"></div>').appendTo('body');
                                    } else {
                                        $('body.sonata-bc #ajax-dialog').html('');
                                    }

                                    $(response).appendTo($('body.sonata-bc #ajax-dialog'));
                                    $('#ajax-dialog').modal({show: true});
                                    $('#ajax-dialog').draggable();
                                    //  alert(JSON.stringify(html));
                                }
                            });
                        }
                        ;
                    });
                    map.drawnItems.addLayer(feature);
                    if (pt !== undefined && pt.lat !== undefined && pt.lng !== undefined)
                        //      map.panTo(new L.LatLng(pt.lat(), pt.lng()));
                        map.setView(new L.LatLng(pt.lat(), pt.lng()), 14);
                }
                ;
            });
        } else {
            alert("search can not be empty!");
//      OSM.router.route("/" + OSM.formatHash(map));
        }
    });
    $(".sonata-bc .describe_location").on("click", function (e) {

        e.preventDefault();
//            alert(" map center=" + map.getCenter().lat + "  " + map.getCenter().lng);

        var HOST_URL = 'http://open.mapquestapi.com';
        var SAMPLE_POST = HOST_URL + '/nominatim/v1/search.php?format=json';
        var searchType = '';
        var safe = SAMPLE_POST + "&q=" + map.getCenter().lat + "," + map.getCenter().lng; //westminster+abbey";
//            alert(safe);
        $.ajax({
            url: safe,
            method: 'GET',
//                data: {
//                  zoom: map.getZoom(),
//                  minlon: map.getBounds().getWest(),
//                  minlat: map.getBounds().getSouth(),
//                  maxlon: map.getBounds().getEast(),
//                  maxlat: map.getBounds().getNorth()
//                },
            success: function (html) {
                alert(html[0].display_name)
                //  alert(JSON.stringify(html));
            }
        });
    });
    if (typeof initLeftsidebarPanel === 'function') {
        initLeftsidebarPanel();
    }
    $('.leaflet-control .control-button').tooltip({placement: 'left', container: 'body'});
    viewingscale(map);
};
function saveuserdraw() {
    for (var i = 0; i < map.drawlayer._originalPoints.length; i++) {
        //  layer._originalPoints.each(function(point) {
        alert(map.drawlayer._originalPoints[i]);
        var position = map.containerPointToLatLng(layer._originalPoints[i]);
        alert("Lat, Lon : " + position.lng.toFixed(3) + "," + position.lat.toFixed(3));
    }
}


function ShowLeftSideBar(leftSidebar) {
    if ($(".leaflet-sidebar.left").css('left') === 0 || $(".leaflet-sidebar.left").css('left') === '0px') {

        $(".sonata-bc .leftsidebar-close-control").show();
        setTimeout(function () {
            leftSidebar.hide();
        }, 500);
    } else {

        $(".sonata-bc .leftsidebar-close-control").hide();
        setTimeout(function () {
            leftSidebar.show();
        }, 500);
    }
}

function MapExtentReset(map) {
    map.setView([43.73737, -79.95987], 10);
}
function NextMapExtent(map) {
    map.setView([9.37421, -83.59669], 12);
    // history.goForward();
}
function PrevMapExtent(map) {
    map.setView([33.5363, -117.044], 6);
    // history.goBack();
}
function showStoryOnLeftsisebar(id) {

    $.ajax({
        url: Routing.generate('homepage_leftsidebar_view', {_locale: window.locale, id: id, view: "story"}),
        method: 'GET',
        success: function (response) {
            $("div#leaflet_content.overlay-sidebar #sidebar_content").html(response);
            if (window.leftSidebar.isVisible() === false) {
                $(".sonata-bc .leftsidebar-close-control").hide();
                window.leftSidebar.show();
            }
        }
    });
}

function loadStoriesLayer(map, layersControl) {

    $.ajax({
        url: Routing.generate('appleaflet_storylayer', {_locale: window.locale}),
        method: 'GET',
        success: function (response) {
            var result;
            if (typeof response !== 'object')
                result = JSON.parse(response);
            else
                result = response;
            if (result.success === true && result.stories) {


                var photo_markers = new L.MarkerClusterGroup({
                    showCoverageOnHover: false,
                    spiderfyDistanceMultiplier: 5,
                    maxClusterRadius: 40
                }).addTo(map);
                var photo_layer = L.layerGroup();
                var default_showonmap = false;
                if ($("div#sidebar-left.leaflet-control").data("viewtype")) {
                    var default_layers = $("div#sidebar-left.leaflet-control").data("viewtype").toString();
                    if (default_layers === 'stories')
                    {
                        default_showonmap = true;
                        photo_layer.addTo(map);
                    }
                }
                map.dataLayers[map.dataLayers.length] = {'map': map, 'layerType': 'stories', 'clusterLayer': true, 'defaultShowOnMap': default_showonmap, 'layer': photo_markers, 'minZoom': null, 'maxZoom': null, 'index_id': 0, 'layerId': 0, layerTitle: 'Stories', 'datasource': -2, 'sld': null, 'filename': null, 'layerName': 'Stories', 'hostName': null};
                $.each(result.stories, function (k, photo) {

                    if (photo.lat && photo.lng) {
                        var images;
                        var icon_image = '';
                        var medium_image = '';
                        if (typeof photo.image_file === 'string')
                            images = JSON.parse(photo.image_file);
                        else
                            images = photo.image_file;
                        if (images.length === 0) {
                            //  images[0] = '/bundles/map2uleaflet/images/photo_unavailable_t.png';
                            icon_image = '/bundles/map2uleaflet/images/photo_unavailable_t.png';
                            medium_image = '/bundles/map2uleaflet/images/photo_unavailable.png';
                        }
                        else {
                            icon_image = '/uploads/stories/' + photo.id + "/images/icon_" + images[0];
                            medium_image = '/uploads/stories/' + photo.id + "/images/medium_" + images[0];
                        }

                        var photo_marker = new L.PhotoMarker(new L.LatLng(photo.lat, photo.lng), {
                            src: icon_image,
                            size: [50, 40],
                            resize: function (e) {


                                var zoom = e._zoom;
                                if (zoom <= 11) {
                                    photo_marker.scale(0.5);
                                }
                                else if (zoom <= 13) {
                                    // Half of the size option
                                    photo_marker.scale(0.75);
                                }
                                else {
                                    // Scale 1 is 100% as defined in the size option
                                    photo_marker.scale(1);
                                }
                            }
                        });
                        var html = '<a href="#" onclick="showStoryOnLeftsisebar(' + photo.id + '); return false;"><h4>' + photo.story_name + '</h4></a>';
                        if (medium_image === '') {
                            if (images.length > 1) {

                            }
                            else {
                                html = html + '<img src="' + medium_image + '" style="width:300px;"/>';
                            }
                        }
                        else
                        {
                            html = html + '<img src="' + medium_image + '" style="width:300px;"/>';
                        }

                        photo_marker.bindPopup('<a href="#" onclick="showStoryOnLeftsisebar(' + photo.id + '); return false;"><h4>' + photo.story_name + '</h4></a><img src="' + medium_image + '" style="width:300px;"/>');
                        $("<img>").attr("src", medium_image).load(function () {
                            photo_markers.addLayer(photo_marker);
                        });
                    }
                    ;
                });
                layersControl.refreshOverlays();
                map.fire('zoomend');
            }
        }
    });
}

function sortByKey(array, key) {
    return array.sort(function (a, b) {
        if (a[key] === undefined || a[key] === null)
        {
            a[key] = "0";
        }
        if (b[key] === undefined || b[key] === null)
        {
            b[key] = "0";
        }
        var x = parseInt(a[key]);
        var y = parseInt(b[key]);
        return ((x < y) ? -1 : ((x > y) ? 1 : 0));
    });
}

function viewingscale(map) {

    $("li#viewingscale ul li a").click(function () {
        var scale = $(this).data("zoom");
        var center = $(this).data("center");
        var address = $(this).data("address");
        if ((center === null || center === undefined) && (parseInt(scale) !== 0)) {
            center = map.getCenter();
            map.setView(center, scale);
            createSearchFeatureIcon(map, center.lat, center.lng, address);
            return;
        }
        if (parseInt(scale) === 0) {

            $.ajax({
                url: Routing.generate('useraccount_mapbookmark', {'_locale': window.locale}),
                method: 'GET',
                success: function (response) {

                    $("div#leaflet_content.overlay-sidebar #sidebar_content").html(response);
                    if (window.leftSidebar.isVisible() === false) {
                        $(".sonata-bc .leftsidebar-close-control").hide();
                        window.leftSidebar.show();
                    }
                }
            });
            return;
        }
        center = center.split(",");
        map.setView([center[0], center[1]], scale);
        createSearchFeatureIcon(map, center[0], center[1], address);
    });
}

function createSearchFeatureIcon(map, lat, lng, address) {
    var layers = map.drawnItems.getLayers();
    for (var i = layers.length - 1; i >= 0; i--) {
        if (layers[i].source !== undefined && layers[i].source === 'searchbox_query') {
            map.drawnItems.removeLayer(layers[i]);
        }
    }

    var feature = L.marker([lat, lng]);
    feature.bindLabel(address);
    feature.id = 0;
    feature.name = address;
    feature.index = map.drawnItems.getLayers().length;
    feature.type = 'marker';
    feature.source = 'searchbox_query';
    map.drawnItems.addLayer(feature);
}