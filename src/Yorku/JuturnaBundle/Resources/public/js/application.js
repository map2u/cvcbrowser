/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (typeof app === 'undefined') {
    app = {};
}

if (typeof app.map2u === 'undefined') {
    app.map2u = {};
}

if (typeof ol3 === 'undefined') {
    ol3 = {};
}
if (typeof ol3.map2u === 'undefined') {
    ol3.map2u = {};
}
if (typeof ol3.map2u.overlays === 'undefined') {
    ol3.map2u.overlays = [];
}
if (typeof ol3.map2u.slds === 'undefined') {
    ol3.map2u.slds = [];
}
if (typeof ol3.map2u.cachedMarkers === 'undefined') {
    ol3.map2u.cachedMarkers = [];
}
if (typeof ol3.map2u.cachedLayerStyles === 'undefined') {
    ol3.map2u.cachedLayerStyles = [];
}

if (typeof ol3.map2u.basemapLayers === 'undefined') {
    ol3.map2u.basemapLayers = [];
}
if (typeof ol3.contextmenu === 'undefined') {
    ol3.contextmenu = {};
}



ol3.map2u.createMap = function (mapId) {
    app.mapId = mapId;
    var geolocation;
    var map;
    // default zoom, center and rotation
    var zoom = 12;
    var center = [-79.4000, 43.7000];
    var rotation = 0;
    if (window.location.hash !== '') {
        // try to restore center, zoom-level and rotation from the URL
        var hash = window.location.hash.replace('#map=', '');
        var parts = hash.split('/');
        if (parts.length === 4) {
            zoom = parseInt(parts[0], 10);
            center = [
                parseFloat(parts[1]),
                parseFloat(parts[2])
            ];
            rotation = parseFloat(parts[3]);
        }
    }

    if (document.getElementById(mapId) === null) {
        return;
    }
    /**
     * @constructor
     * @extends {ol.control.Control}
     * @param {Object=} opt_options Control options.
     */
    app.RotateNorthControl = function (opt_options) {

        var options = opt_options || {};
        var button = document.createElement('button');
        button.innerHTML = 'N';
        var this_ = this;
        var handleRotateNorth = function (e) {
            this_.getMap().getView().setRotation(0);
        };
        button.addEventListener('click', handleRotateNorth, false);
        button.addEventListener('touchstart', handleRotateNorth, false);
        var element = document.createElement('div');
        element.className = 'rotate-north ol-unselectable ol-control';
        element.appendChild(button);
        var button2 = document.createElement('button');
        button2.innerHTML = '<i class="fa fa-dot-circle-o"></i>';
        var this_ = this;
        var handleLocation = function (e) {

            navigator.geolocation.getCurrentPosition(function (position) {
                // alert(JSON.stringify(position));
                this_.getMap().getView().setCenter([position.coords.longitude, position.coords.latitude]);
                if (document.getElementById('mapping_current_position')) {
                    document.getElementById('mapping_current_position').innerHTML = "Latitude: " + position.coords.latitude.toFixed(4) + "   Longitude: " +
                            position.coords.longitude.toFixed(4) + "<p>";
                }
            });
        };
        button2.addEventListener('click', handleLocation, false);
        button2.addEventListener('touchstart', handleLocation, false);
        element.appendChild(button2);
        var button3 = document.createElement('button');
        button3.innerHTML = 'L';
        var this_ = this;
        var handleMeasurement = function (e) {
            this_.getMap().getView().setRotation(0);
        };
        button3.addEventListener('click', handleMeasurement, false);
        button3.addEventListener('touchstart', handleMeasurement, false);
        element.appendChild(button3);
        ol.control.Control.call(this, {
            element: element,
            target: options.target
        });
    };


    ol.inherits(app.RotateNorthControl, ol.control.Control);
    app.LocationControl = function (opt_options) {

        var options = opt_options || {};
        var button = document.createElement('button');
        button.innerHTML = 'L';
        var this_ = this;
        var handleLocation = function (e) {



        };
        button.addEventListener('click', handleLocation, false);
        button.addEventListener('touchstart', handleLocation, false);
        var element = document.createElement('div');
        element.className = 'ol-location ol-unselectable ol-control';
        element.appendChild(button);
        ol.control.Control.call(this, {
            element: element,
            target: options.target
        });
    };

    app.BottomFeatureListControl = function (opt_options) {
        var options = opt_options || {};
        var element = document.createElement('div');
        element.className = 'ol-bottom-feature-list ol-unselectable ol-control';
        ol.control.Control.call(this, {
            element: element,
            target: options.target
        });
    };

    ol.inherits(app.BottomFeatureListControl, ol.control.Control);
    ol.inherits(app.LocationControl, ol.control.Control);
    if (document.getElementById('map2u_mapping-mouse-position')) {
        var mousePositionControl = new ol.control.MousePosition({
            coordinateFormat: ol.coordinate.createStringXY(4),
            projection: 'EPSG:4326',
            // comment the following two lines to have the mouse position
            // be placed within the map.
            className: 'map2u_mapping-mouse-position',
            target: document.getElementById('map2u_mapping-mouse-position'),
            undefinedHTML: 'outside'
        });
    }
    var projectionSelect = document.getElementById('projection');
    if (projectionSelect) {
        projectionSelect.addEventListener('change', function (event) {
            mousePositionControl.setProjection(ol.proj.get(event.target.value));
        });
    }
    var openStreetMapLayer = new ol.layer.Tile({
        source: new ol.source.OSM({
            attributions: [
                new ol.Attribution({
                    html: 'All maps &copy; ' +
                            '<a href="http://www.openstreetmap.org/">OpenStreetMap</a>'
                }),
                ol.source.OSM.ATTRIBUTION
            ],
            crossOrigin: null,
            url: 'https://www.map2u.com/tiles/{z}/{x}/{y}.png'
        })
    });
    var osmSource = new ol.source.OSM({projection: 'EPSG:3857'});
    var view;

    if (typeof center !== 'undefined' && typeof zoom !== 'undefined' && typeof rotation !== 'undefined') {
        view = new ol.View({
            projection: "EPSG:3857",
            units: 'm',
            center: ol.proj.transform(center, 'EPSG:4326', 'EPSG:3857'),
            zoom: zoom,
            maxZoom: 20,
            minZoom: 4,
            rotation: rotation

        });
    } else {
        view = new ol.View({
            projection: "EPSG:3857",
            units: 'm',
            maxZoom: 20,
            minZoom: 4
        });
    }
    map = new ol.Map({
        controls: ol.control.defaults({
            attributionOptions: /** @type {olx.control.AttributionOptions} */ ({
                collapsible: true
            })
        }).extend([
            mousePositionControl, new app.RotateNorthControl(), new ol.control.ScaleLine(), new app.BottomFeatureListControl()//, new app.MeasurementControl()
        ]),
        interactions: ol.interaction.defaults({mouseWheelZoom: false}),
        target: mapId,
        layers: [

            new ol.layer.Tile({
                source: osmSource
            }),
        ],
        view: view
    });

    var userdrawItems = new ol.source.Vector({});
    ol3.map2u.userdrawItems = userdrawItems;
    ol3.map2u.userdrawLayer = new ol.layer.Vector({name: 'userdrawlayer', source: ol3.map2u.userdrawItems});
    map.addLayer(ol3.map2u.userdrawLayer);
    var shouldUpdate = true;
    view = map.getView();

    var updatePermalink = function () {
        if (!shouldUpdate) {
            // do not update the URL when the view was changed in the 'popstate' handler
            shouldUpdate = true;
            return;
        }

        var center = view.getCenter();
        center = ol.proj.transform(center, 'EPSG:3857', 'EPSG:4326');

        var hash = '#map=' +
                view.getZoom() + '/' +
                Math.round(center[0] * 1000) / 1000 + '/' +
                Math.round(center[1] * 1000) / 1000 + '/' +
                view.getRotation();
        var state = {
            zoom: view.getZoom(),
            center: view.getCenter(),
            rotation: view.getRotation()
        };
        window.history.pushState(state, 'map', hash);
    };

    map.on('moveend', updatePermalink);
    ol3.map2u.map = map;


    // restore the view state when navigating through the history, see
    // https://developer.mozilla.org/en-US/docs/Web/API/WindowEventHandlers/onpopstate
    window.addEventListener('popstate', function (event) {
        if (event.state === null) {
            return;
        }
        map.getView().setCenter(event.state.center);
        map.getView().setZoom(event.state.zoom);
        map.getView().setRotation(event.state.rotation);
        shouldUpdate = false;
    });
//var url = Routing.generate('welcome_home', {_locale: app.locale});

    var contextmenu = new ContextMenu({
        width: 170,
        defaultItems: true, // defaultItems are (for now) Zoom In/Zoom Out
        items: [
//            {
//                text: 'Center map here',
//
//                classname: 'some-style-class', // add some CSS rules
//                callback: ol3.contextmenu.center // `center` is your callback function
//            },
//            {
//                text: 'Add a Marker',
//                classname: 'some-style-class', // you can add this icon with a CSS class
//                // instead of `icon` property (see next line)
//                icon: '/images/contextmenu/marker.png', // this can be relative or absolute
//                callback: ol3.contextmenu.marker
//
//            },
//            '-' // this is a separator
        ]
    });
    map.addControl(contextmenu);
    contextmenu.on('beforeopen', function (evt) {
        var layer;
        var feature = map.forEachFeatureAtPixel(evt.pixel, function (ft, l) {
            layer = l;
            return ft;
        });
        if (feature) {

            var editStyleItem = {
                text: 'Edit layer style',
                icon: '/images/contextmenu/marker.png',
                callback: ol3.contextmenu.editLayerStyle
            }
            editStyleItem.data = {feature: feature, layer: layer};
            var contextMenuEntries = [editStyleItem];

            contextmenu.clear();
            contextmenu.extend(contextMenuEntries);

            contextmenu.extend(contextmenu.getDefaultItems());


            contextmenu.enable();
        } else {
            if ($("div#mapstatus #current_view").data("view") === 'stories') {

                var contextMenuEntries = [{
                        text: 'Add a story',
                        icon: '/images/contextmenu/marker.png',
                        callback: ol3.contextmenu.createStory
                    }];
                contextmenu.clear();
                contextmenu.extend(contextMenuEntries);

                //   contextmenu.items.push({text: 'Add a story', classname: 'some-style-class', icon: '/images/contextmenu/marker.png', callback: ol3.contextmenu.marker});
                contextmenu.enable();
            } else {
                contextmenu.disable();
            }
        }
    });
    contextmenu.on('open', function (evt) {


        var feature = map.forEachFeatureAtPixel(evt.pixel, function (ft, l)
        {
            return ft;
        });
        if (feature) {
            // add some other items to the menu
        }
    });
    contextmenu.on('close', function (evt) {
        // it's upon you
    });
    $(window).resize(function () { /* do something */
        $('#' + mapId).height($(window).height() - $(".juturna-page-header").height() - $(".juturna-main_menu").height() - 50);
        $("#ol3map-sidebar").height($('#' + mapId).height() - 70);
        $("#ol3map-sidebar").css("margin-top", ($(".juturna-page-header").height() + $(".juturna-main_menu").height() + 8) + "px");
        $("#ol3map-sidebar").css("margin-right", "0px");
        $("#ol3map-sidebar").css("right", "7px");
        ol3.map2u.map.updateSize();
        ol3.map2u.updateBottomFeatureListPosition();
    });
    ol3.map2u.map.getView().on('change:resolution', function () {
        //  alert($('div#' + mapId + " .ol-scale-line").width());
        //   $('div#' + mapId + " .ol-bottom-feature-list").css("margin-left", ($('div#' + mapId + " .ol-scale-line").width() + 10) + "px");
        ol3.map2u.updateBottomFeatureListPosition();
    });
// change mouse cursor when over marker

    var tooltip = document.getElementById('ol3map_map_tooltip');
    ol3.map2u.tooltip = tooltip;
    var overlay = new ol.Overlay({
        element: tooltip,
        offset: [10, 0],
        positioning: 'bottom-left'
    });
    ol3.map2u.tooltip_overlay = overlay;
    ol3.map2u.map.addOverlay(overlay);

    ol3.map2u.map.on("pointermove", function (e) {
        var pixel = ol3.map2u.map.getEventPixel(e.originalEvent);
        var hit = ol3.map2u.map.hasFeatureAtPixel(pixel);
        ol3.map2u.map.getViewport().style.cursor = hit ? 'pointer' : '';

        ol3.map2u.displayTooltip(e);
    });

    var select = new ol.interaction.Select({
        layers: []
    });
    ol3.map2u.map.addInteraction(select);
    ol3.map2u.map.select = select;
    var selectedFeatures = select.getFeatures();
    selectedFeatures.on('add', function (event) {
        var feature = event.target.item(0);
        var url;
        var features = feature.get('features');
        if (typeof features !== 'undefined') {
            url = features[0].get('img');
        } else {
            url = feature.get('img');
        }
        alert(url);
        // put the url of the feature into the photo-info div
        // $('#photo-info').html(url);
    });

    ol3.map2u.map.on("click", function (evt) {
        //   alert(evt.pixel);


        var fl = ol3.map2u.map.forEachFeatureAtPixel(evt.pixel, function (ft, layer) {
            return {feature: ft, layer: layer};
        });
        if (fl && fl.feature) {
            if (typeof fl.feature.get("features") !== 'undefined') {
                var features = fl.feature.get("features");
                if (features.length === 1 && fl.layer.get('type') === 'story') {
                    var id = features[0].get("id");


                    $.when(app.map2u.activateMapSidebar("feature_information", 'Story')).then(function () {
                        var data = new FormData();
                        data.append("id", id);
                        data.append("view", "story");
                        app.map2u.setMapSidebarContent("feature_information", 'homepage_leftsidebar_view', data);
                    });
                } else {

                    if (features.length <= 10) {
                        $('div#' + app.mapId + " .ol-bottom-feature-list").html('');
                        features.forEach(function (feature) {
                            var id = feature.get("id");
                            var img = feature.get("img");
                            var name = feature.get("name");
//                          var img=feature.get("img");
//                            var style = feature.getStyle();
//                            var img = style.getImage();
                            ol3.map2u.updateBottomFeatureListPosition();
                            if (img) {
                                $('div#' + app.mapId + " .ol-bottom-feature-list").removeClass('hidden');
                                $('div#' + app.mapId + " .ol-bottom-feature-list").show();

                                var item = $("<div class='feature-list-item' data-id='" + id + "'><img title=" + name + " alt=" + name + " src='" + img + "'  height='36' ></div>");
                                $('div#' + app.mapId + " .ol-bottom-feature-list").append(item);
                            }
                        });
                        $('div#' + app.mapId + " .ol-bottom-feature-list .feature-list-item").unbind("click");
                        $('div#' + app.mapId + " .ol-bottom-feature-list .feature-list-item").click(function () {
                            var id = $(this).data("id");


                            $.when(app.map2u.activateMapSidebar("feature_information", 'Story')).then(function () {
                                var data = new FormData();
                                data.append("id", id);
                                data.append("view", "story");
                                app.map2u.setMapSidebarContent("feature_information", 'homepage_leftsidebar_view', data);
                            });
                        });

                    } else {
                        var zoom_level = app.map2u.map.getView().getZoom();
                        app.map2u.map.getView().setZoom(zoom_level + 1);
                    }
                }
            } else {
                if (fl.feature.get("type") === 'story') {
                    var id = fl.feature.get("id");
                    if (typeof id === 'undefined' || id === null || id.trim() === '') {
                        $.when(app.map2u.activateMapSidebar("feature_information", 'Create a new story')).then(function () {
                            app.map2u.setMapSidebarContent("feature_information", 'draw_createstory', new FormData());
                        });
                    } else {


                        $.when(app.map2u.activateMapSidebar("feature_information", fl.get("name"))).then(function () {
                            var data = new FormData();
                            data.append("id", id);
                            data.append("view", "story");
                            app.map2u.setMapSidebarContent("feature_information", 'homepage_leftsidebar_view', data);
                        });
                    }
                }
            }
        } else {
            $('div#' + app.mapId + " .ol-bottom-feature-list").hide();
        }
    });
    $(window).trigger("resize");
};
ol3.map2u.displayTooltip = function (evt) {
    var pixel = evt.pixel;
    var layer;
    var feature = ol3.map2u.map.forEachFeatureAtPixel(pixel, function (feature, l) {
        layer = l;
        return feature;
    });
    ol3.map2u.tooltip.style.display = feature ? '' : 'none';
    if (feature) {
        ol3.map2u.tooltip_overlay.setPosition(evt.coordinate);
        var labelfield = layer.get("label_field");
        var label = '';

        if (typeof labelfield !== 'undefined' && labelfield.length > 0) {
            if (feature.get("features")) {
                label = "<div style='padding:10px;'><div><h4>" + layer.get("name") + "</h4></div><ul style='list-style:decimal;padding-left:10px;'>";

                $.map(feature.get("features"), function (f, index) {
                    if (index < 10) {
                        label = label + "<li style='margin-bottom:4px;'>" + f.get('name') + "</li>";
                    }
                });
                label = label + "</ul></div>";
            } else {
                label = feature.get('name');
            }
        }
        if (label === '') {
            ol3.map2u.tooltip.style.display = 'none';
        } else {
            ol3.map2u.tooltip.innerHTML = label;
        }

    }
};

ol3.map2u.updateBottomFeatureListPosition = function (width, height) {
    $('div#' + app.mapId + " .ol-bottom-feature-list").css("left", ($('div#' + app.mapId + " .ol-scale-line .ol-scale-line-inner").width() + 25) + "px");
    $('div#' + app.mapId + " .ol-bottom-feature-list").width($('div#' + app.mapId).width() - ($('div#' + app.mapId + " .ol-scale-line .ol-scale-line-inner").width() + 25) - 50);
};
ol3.contextmenu.center = function (obj) {
    alert("obj=" + obj);
    alert("center");
};
ol3.contextmenu.marker = function (obj) {
    alert("obj=" + obj);
    alert("marker");
};
ol3.contextmenu.editLayerStyle = function (obj) {

    $.when(app.map2u.activateMapSidebar("mapping_featurestyle", 'Edit layer feature style')).then(function () {
        var layerid = obj.data.layer.get("id");

        var featureid = [];
        if (obj.data.feature.get("features")) {
            $.map(obj.data.feature.get("features"), function (feature) {
                featureid.push(feature.get("id"));
            });
        } else {
            featureid.push(obj.data.feature.get("id"));
        }

        var data = new FormData();
        data.append("layer", layerid);
        data.append("features", JSON.stringify(featureid));
        app.map2u.setMapSidebarContent("mapping_featurestyle", 'layer_editstyle', data);
    });
};
ol3.contextmenu.createStory = function (obj) {
    createSearchFeatureIcon(ol3.map2u.map, obj.coordinate[0], obj.coordinate[1], 'Create a new story', 'draw_createstory', 'New Story', 'story');
    $.when(app.map2u.activateMapSidebar("feature_information", 'Create a new story')).then(function () {
        var data = new FormData();
        var lnglat = ol.proj.transform(obj.coordinate, 'EPSG:3857', 'EPSG:4326');

        data.append('lng', lnglat[0]);
        data.append('lat', lnglat[1]);

        app.map2u.setMapSidebarContent("feature_information", 'draw_createstory', data);
    });
};



ol3.map2u.layerlistCheckboxRefresh = function () {
    var layers = ol3.map2u.map.getOverlays();
    layers.forEach(function (layer) {
        if (typeof layer.id !== 'undefined') {
            alert(layer.id);
            alert($("#ol3-map-layers-list li.overlay_li[data-id='" + layer.id + "']").length);
            if ($("#ol3-map-layers-list li.overlay_li[data-id='" + layer.id + "']").length > 0) {
                $("#ol3-map-layers-list li.overlay_li[data-id='" + layer.id + "'] input[type='checkbox']").prop("checked", true);
            }
        }
    });

}
ol3.map2u.TopMenubarControl = function (opt_options) {
    var options = opt_options || {};
    var RotateNorthButton = document.createElement('button');
    RotateNorthButton.innerHTML = 'N';
    var this_ = this;
    var handleRotateNorth = function (e) {
        this_.getMap().getView().setRotation(0);
    };
    RotateNorthButton.addEventListener('click', handleRotateNorth, false);
    RotateNorthButton.addEventListener('touchstart', handleRotateNorth, false);
    var element = document.createElement('div');
    element.className = 'ol-topmenu-bar ol-selectable ol-control';
    element.appendChild(RotateNorthButton);
    var LocationButton = document.createElement('button');
    LocationButton.innerHTML = '<i class="fa fa-dot-circle-o"></i>';
    var this_ = this;
    var handleLocation = function (e) {

        navigator.geolocation.getCurrentPosition(function (position) {
            // alert(JSON.stringify(position));
            this_.getMap().getView().setCenter(ol.proj.transform([position.coords.longitude, position.coords.latitude], "EPSG:4326", "EPSG:3857"));
            if (document.getElementById('mapping_current_position')) {
                document.getElementById('mapping_current_position').innerHTML = "Latitude: " + position.coords.latitude.toFixed(4) + "   Longitude: " +
                        position.coords.longitude.toFixed(4) + "<p>";
            }
        });
    };
    LocationButton.addEventListener('click', handleLocation, false);
    LocationButton.addEventListener('touchstart', handleLocation, false);
    element.appendChild(LocationButton);



    var drawButton = document.createElement('button');
    drawButton.innerHTML = '<i class="fa fa-pencil-square-o"></i>';

    var handleDraw = function (e) {

        if ($(this).hasClass("btn-primary")) {
            $(this).removeClass("btn-primary");
        } else {
            $(this).addClass("btn-primary");
        }

    };
    drawButton.addEventListener('click', handleDraw, false);
    drawButton.addEventListener('touchstart', handleDraw, false);

    element.appendChild(drawButton);


    var PrintMapButton = document.createElement('button');
    PrintMapButton.innerHTML = '<i class="fa fa-print"></i>';

    var handlePrintMapButton = function (e) {

    };
    PrintMapButton.addEventListener('click', handlePrintMapButton, false);
    PrintMapButton.addEventListener('touchstart', handlePrintMapButton, false);
    element.appendChild(PrintMapButton);


    var SidebarMenuButton = document.createElement('button');
    SidebarMenuButton.innerHTML = '<i class="fa fa-list"></i>';

    var handleSidebarMenuButton = function (e) {
        if ($("div#ol3map-sidebar").hasClass("hidden")) {
            $("div#ol3map-sidebar").removeClass("hidden");
        }
        if ($("div#ol3map-sidebar").is(":visible") === false) {
            $("div#ol3map-sidebar").show();
            $("#page-wrapper #page-right-sidebar #right-sidebar-content").css("padding-left", "40px");
        } else {
            $("div#ol3map-sidebar").hide();
            $("#page-wrapper #page-right-sidebar #right-sidebar-content").css("padding-left", "10px");
        }
    };
    SidebarMenuButton.addEventListener('click', handleSidebarMenuButton, false);
    SidebarMenuButton.addEventListener('touchstart', handleSidebarMenuButton, false);
    element.appendChild(SidebarMenuButton);
    ol.control.Control.call(this, {
        element: element,
        target: options.target
    });


    ol.control.Control.call(this, {
        element: element,
        target: options.target
    });
}
ol.inherits(ol3.map2u.TopMenubarControl, ol.control.Control);

ol3.map2u.SidebarMenuControl = function (opt_options) {
    var options = opt_options || {};
    var button = document.createElement('button');
    button.innerHTML = '<i class="fa fa-left"></i>';
    var this_ = this;
    var handleSidebarMenu = function (e) {

        if ($("div#ol3map-sidebar").is(":visible")) {
            $("div#ol3map-sidebar").hide();
            $("div#ol3map-sidebar i").hide();
        } else {
            $("div#ol3map-sidebar").show();
        }


    };
    button.addEventListener('click', handleSidebarMenu, false);
    button.addEventListener('touchstart', handleSidebarMenu, false);
    var element = document.createElement('div');
    element.className = 'sidebar-menu ol-selectable ol-control';
    element.appendChild(button);

    ol.control.Control.call(this, {
        element: element,
        target: options.target
    });

};
ol.inherits(ol3.map2u.SidebarMenuControl, ol.control.Control);

ol3.map2u.LocationControl = function (opt_options) {
    var options = opt_options || {};
    var button = document.createElement('button');
    button.innerHTML = '<i class="fa fa-dot-circle-o"></i>';
    var this_ = this;
    var handleLocation = function (e) {

        navigator.geolocation.getCurrentPosition(function (position) {
            // alert(JSON.stringify(position));
            this_.getMap().getView().setCenter(ol.proj.transform([position.coords.longitude, position.coords.latitude], "EPSG:4326", "EPSG:3857"));
            if (document.getElementById('mapping_current_position')) {
                document.getElementById('mapping_current_position').innerHTML = "Latitude: " + position.coords.latitude.toFixed(4) + "   Longitude: " +
                        position.coords.longitude.toFixed(4) + "<p>";
            }
        });

    };
    button.addEventListener('click', handleLocation, false);
    button.addEventListener('touchstart', handleLocation, false);
    var element = document.createElement('div');
    element.className = 'ol-location ol-unselectable ol-control';
    element.appendChild(button);
    ol.control.Control.call(this, {
        element: element,
        target: options.target
    });
};

ol.inherits(ol3.map2u.LocationControl, ol.control.Control);

ol3.map2u.DrawControl = function (opt_options) {
    var options = opt_options || {};
    var button = document.createElement('button');
    button.innerHTML = '<i class="fa fa-pencil-square-o"></i>';
    var this_ = this;
    var handleDraw = function (e) {



    };
    button.addEventListener('click', handleDraw, false);
    button.addEventListener('touchstart', handleDraw, false);
    var element = document.createElement('div');
    element.className = 'ol-draw ol-unselectable ol-control';
    element.appendChild(button);
    ol.control.Control.call(this, {
        element: element,
        target: options.target
    });
};

ol.inherits(ol3.map2u.DrawControl, ol.control.Control);

app.UserRegistrationRequiredCheck = function (item) {
    var span = $(item).closest(".form-group").find("span.required_check");

    if ($(item).val() === '') {
        $(item).addClass('alert-error');
        $(span).removeClass("fa-check");
        $(span).removeClass("success");
        $(span).removeClass("fa-close");
        $(span).removeClass("failure");
        return;
    }
    $(item).removeClass("alert-error");
    $.ajax({
        url: Routing.generate('default_userregistrationcheck', {value: $(item).val(), name: $(item).attr("name"), _locale: app.locale}),
        type: 'GET',
        complete: function () {
        },
        success: function (data) {

            if (data.success === true) {
                $(item).removeClass("alert-error");
                $(span).removeClass("fa-close");
                $(span).removeClass("failure");
                $(span).addClass("fa-check");
                $(span).addClass("success");
            } else {
                $(span).addClass("fa-close");
                $(span).addClass("failure");
                $(span).removeClass("fa-check");
                $(span).removeClass("success");
            }
        },
        cache: false,
        contentType: false,
        processData: true
    });
}
;
/**
 * This is a workaround.
 * Returns the associated layer.
 * @param {ol.Map} map.
 * @return {ol.layer.Vector} Layer.
 */
ol.Feature.prototype.getLayer = function (map) {
    var this_ = this, layer_, layersToLookFor = [];
    /**
     * Populates array layersToLookFor with only
     * layers that have features
     */
    var check = function (layer) {
        var source = layer.getSource();
        if (source instanceof ol.source.Vector) {
            var features = source.getFeatures();
            if (features.length > 0) {
                layersToLookFor.push({
                    layer: layer,
                    features: features
                });
            }
        }
    };
    //loop through map layers
    map.getLayers().forEach(function (layer) {
        if (layer instanceof ol.layer.Group) {
            layer.getLayers().forEach(check);
        } else {
            check(layer);
        }
    });
    layersToLookFor.forEach(function (obj) {
        var found = obj.features.some(function (feature) {
            return this_ === feature;
        });
        if (found) {
            //this is the layer we want
            layer_ = obj.layer;
        }
    });
    return layer_;
};

ol3.map2u.createBasemapLayers = function () {
    ol3.map2u.basemapLayers['openstreetmap'] = new ol.layer.Tile({
        source: new ol.source.OSM({
            attributions: [
                new ol.Attribution({
                    html: 'All maps &copy; ' +
                            '<a href="http://www.opencyclemap.org/">OpenCycleMap</a>'
                }),
                ol.source.OSM.ATTRIBUTION
            ],
            url: 'http://{a-c}.tile.opencyclemap.org/cycle/{z}/{x}/{y}.png'
        })
    });
    ol3.map2u.basemapLayers['opencyclemap'] = new ol.layer.Tile({
        source: new ol.source.OSM({
            attributions: [
                new ol.Attribution({
                    html: 'All maps &copy; ' +
                            '<a href="http://www.opencyclemap.org/">OpenCycleMap</a>'
                }),
                ol.source.OSM.ATTRIBUTION
            ],
            url: 'http://{a-c}.tile.opencyclemap.org/cycle/{z}/{x}/{y}.png'
        })
    });
    ol3.map2u.basemapLayers['openseamap'] = new ol.layer.Tile({
        source: new ol.source.OSM({
            attributions: [
                new ol.Attribution({
                    html: 'All maps &copy; ' +
                            '<a href="http://www.openseamap.org/">OpenSeaMap</a>'
                }),
                ol.source.OSM.ATTRIBUTION
            ],
            crossOrigin: null,
            url: 'http://tiles.openseamap.org/seamark/{z}/{x}/{y}.png'
        })
    });


// transport
    ol3.map2u.basemapLayers['opentransportmap'] = new ol.layer.Tile({
        source: new ol.source.OSM({
            "url": "http://tile2.opencyclemap.org/transport/{z}/{x}/{y}.png"
        })
    });

// end transport

};

function getPhotoFeatureStyle(feature, resolution, sel)
{
    //  alert(feature.get("img"));
    var style = new ol.style.Style
            ({image: new ol.style.Photo(
                        {src: feature.get("img"),
                            radius: 20,
                            crop: false,
                            kind: 'anchored',
                            shadow: 0,
                            stroke: new ol.style.Stroke(
                                    {width: sel ? 3 : 0,
                                        color: sel ? 'red' : '#fff'
                                    })
                        })
            });

    return [style];
}


ol3.map2u.createBasemapLayers = function () {
    ol3.map2u.basemapLayers['openstreetmap'] = new ol.layer.Tile({
        title: 'Open Street Map',
        type: 'base',
        visible: true,

        source: new ol.source.OSM({
            attributions: [
                new ol.Attribution({
                    html: 'All maps &copy; ' +
                            '<a href="http://www.opencyclemap.org/">OpenCycleMap</a>'
                }),
                ol.source.OSM.ATTRIBUTION
            ],
            crossOrigin: null,
            url: 'https://www.map2u.com/tiles/{z}/{x}/{y}.png'
        })
    });
    ol3.map2u.basemapLayers['opencyclemap'] = new ol.layer.Tile({
        title: 'Open Cycle Map',
        type: 'base',
        visible: true,

        source: new ol.source.OSM({
            attributions: [
                new ol.Attribution({
                    html: 'All maps &copy; ' +
                            '<a href="http://www.opencyclemap.org/">OpenCycleMap</a>'
                }),
                ol.source.OSM.ATTRIBUTION
            ],
            crossOrigin: null,
            url: 'http://{a-c}.tile.opencyclemap.org/cycle/{z}/{x}/{y}.png'
        })
    });
    ol3.map2u.basemapLayers['openseamap'] = new ol.layer.Tile({
        title: 'Open Sea Map',
        type: 'base',
        visible: true,

        source: new ol.source.OSM({
            attributions: [
                new ol.Attribution({
                    html: 'All maps &copy; ' +
                            '<a href="http://www.openseamap.org/">OpenSeaMap</a>'
                }),
                ol.source.OSM.ATTRIBUTION
            ],
            crossOrigin: null,
            url: 'http://tiles.openseamap.org/seamark/{z}/{x}/{y}.png'
        })
    });


// transport
    ol3.map2u.basemapLayers['opentransportmap'] = new ol.layer.Tile({
        title: 'Open Transport Map',
        type: 'base',

        visible: true,
        source: new ol.source.OSM({
            crossOrigin: null,
            "url": "http://tile2.opencyclemap.org/transport/{z}/{x}/{y}.png"
        })
    });

// end transport

};

ol3.map2u.getMarkerStyle = function (type, fill, stroke, size) {

    var markerStyleKeys = ['x', 'diamond', 'cross', 'star', 'triangle', 'square'];

    if (type === null || type === '' || typeof type === 'undefined') {
        return null;
    }
    var marker_styles_p = [];
    //   var stroke = new ol.style.Stroke({color: fillColor, width: width});
    //   var fill = new ol.style.Fill({color: color});
    marker_styles_p['square'] = {
        points: 4,
        rotation: 0,
        angle: Math.PI / 4
    };

    marker_styles_p[ 'diamond'] = {
        points: 4,
        rotation: Math.PI / 4,
        angle: Math.PI / 4
    };
    marker_styles_p[ 'triangle'] = {
        points: 3,
        rotation: Math.PI / 4,
        angle: 0
    };
    marker_styles_p[ 'star'] = {
        points: 5,
        radius2: 4,
        angle: 0
    };
    marker_styles_p['cross'] = {
        points: 4,
        radius2: 0,
        angle: 0
    };
    marker_styles_p['x'] = {
        points: 4,
        radius2: 0,
        angle: Math.PI / 4
    };

//    var marker_styles = {
//        'square': new ol.style.Style({
//            image: new ol.style.RegularShape({
//                fill: fill,
//                stroke: stroke,
//                points: 4,
//                radius: size,
//                angle: Math.PI / 4
//            })
//        }),
//        'diamond': new ol.style.Style({
//            image: new ol.style.RegularShape({
//                fill: fill,
//                stroke: stroke,
//                points: 4,
//                radius: size,
//                rotation: Math.PI / 4,
//                angle: Math.PI / 4
//            })
//        }),
//        'triangle': new ol.style.Style({
//            image: new ol.style.RegularShape({
//                fill: fill,
//                stroke: stroke,
//                points: 3,
//                radius: size,
//                rotation: Math.PI / 4,
//                angle: 0
//            })
//        }),
//        'star': new ol.style.Style({
//            image: new ol.style.RegularShape({
//                fill: fill,
//                stroke: stroke,
//                points: 5,
//                radius: size,
//                radius2: 4,
//                angle: 0
//            })
//        }),
//        'cross': new ol.style.Style({
//            image: new ol.style.RegularShape({
//                fill: fill,
//                stroke: stroke,
//                points: 4,
//                radius: size,
//                radius2: 0,
//                angle: 0
//            })
//        }),
//        'x': new ol.style.Style({
//            image: new ol.style.RegularShape({
//                fill: fill,
//                stroke: stroke,
//                points: 4,
//                radius: size,
//                radius2: 0,
//                angle: Math.PI / 4
//            })
//        })
//    };
    return marker_styles_p[type];
};


app.map2u.setFeatureStyle = function (feature, resolution) {
    //  alert(this instanceof ol.style.Style);
//alert(sld);
    var style;
    var fill = new ol.style.Fill({color: '#f04'});
    var stroke = new ol.style.Stroke({color: '', width: 1});
    var polygon = new ol.style.Style({fill: fill});
    var strokedPolygon = new ol.style.Style({fill: fill, stroke: stroke});
    var line = new ol.style.Style({stroke: stroke});
    var text = new ol.style.Style({text: new ol.style.Text({
            text: '', fill: fill, stroke: stroke
        })});
    var features = feature.get('features');
    var layer = feature.getLayer(ol3.map2u.map);
    var sld = layer.get("sld");
    var bShowLabel = layer.get("showlabel");
    var labelfield = layer.get("labelfield");

    if (typeof features !== 'undefined') {
//      alert(size);
        var size = feature.get('features').length;
        if (size > 1) {
            style = ol3.map2u.cachedMarkers[size];
            //    alert(typeof style);
            if (!style) {
                // alert("new style");

                var color = ol.color.asArray('#3399CC');
                color = color.slice();
                color[3] = 0.7;

                style = new ol.style.Style({
                    image: new ol.style.Circle({
                        radius: 15,
                        stroke: new ol.style.Stroke({
                            color: '#fff'
                        }),
                        fill: new ol.style.Fill({
                            color: color

                        })
                    }),
                    text: new ol.style.Text({
                        text: size.toString(),
                        fill: new ol.style.Fill({
                            color: '#fff'
                        })
                    })
                });
                ol3.map2u.cachedMarkers[size] = style;
            }

            return [style];
        } else {
            if (size === 1 && features[0].getGeometry().getType() === 'Point' && typeof features[0].get("img") !== 'undefined') {




                style = new ol.style.Style({
                    image: new ol.style.Photo({
                        src: features[0].get("img"),
                        radius: 20,
                        crop: true,
                        kind: 'anchored',
                        shadow: 5,
                        fill: new ol.style.Fill({
                            color: '#ff9900'
                        }),
                        stroke: new ol.style.Stroke({width: 3,
                            color: '#fff'
                        })
                    })
                });
                return [style];
            }

        }
    } else {
        // feature is not cluster feature
        var geom_type = feature.getGeometry().getType();
        //   alert(sld);

        //   alert(geom_type);

        var styles = [];
        var stroke = new ol.style.Stroke({color: 'black', width: 2});
        var fill = new ol.style.Fill({color: 'red'});
        var iconCache = {};
        function getIcon(iconName) {
            var icon = iconCache[iconName];
            if (!icon) {
                icon = new ol.style.Style({image: new ol.style.Icon({
                        src: 'https://cdn.rawgit.com/mapbox/maki/master/icons/' + iconName + '-15.svg',
                        imgSize: [15, 15]
                    })});
                iconCache[iconName] = icon;
            }
            return icon;
        }

        var length = 0;


        if (typeof sld !== 'undefined' && sld !== null && sld !== '') {
            if (typeof sld === 'string') {
                sld = JSON.parse(sld);
            }

            if (sld.length === 0) {
                layer.setStyle(app.map2u.getDefaultStyle(geom_type.toString().toLowerCase()));
                return;
            }
            $.map(sld, function (sld_style) {

                if (typeof sld_style.rule !== 'undefined') {
                    $.map(sld_style.rule, function (rule) {
                        var style = new ol.style.Style();


                        if (typeof rule === 'string') {
                            rule = JSON.parse(rule);
                        }
                        var filter = null;

                        if (rule.filter !== null && typeof rule.filter !== 'undefined') {

                            filter = rule.filter;

                        }

                        //   alert("filter 001");
                        //      alert('filter='+(filter===null||filter==='null'||filter===''));
                        //        alert('typeof filter='+typeof filter);
                        if (filter !== null && filter !== 'null' && filter !== '') {


                            if (typeof filter === 'string') {
                                filter = JSON.parse(filter);
                            }
                            // alert('filter=' + typeof filter);
                            // alert(filter.type);
                            if (filter.type === null || filter.type === 'null' || filter.type === '') {
                                var frule = filter.rules[0];
                                //                      alert(frule.type);
                                var value = feature.get(frule.property);
                                if (typeof value === 'undefined') {
                                    value = feature.get(frule.property.toString().toLowerCase());
                                }
                                //    alert(value + "  " + frule.value);
//                                    var i = Math.max(0, value.length - frule.value.length);
//                                    value = value.substr(i);
                                value = value.trim().toLowerCase();
                                frule.value = frule.value.trim().toLowerCase();
                                var result = false;
                                if ($.isNumeric(value) && $.isNumeric(frule.value)) {
                                    result = eval(value + frule.type + frule.value);
                                } else {
                                    //   alert('"' + value.toLowerCase() + '"' + frule.type + '"' + frule.value.toLowerCase() + '"');
                                    result = eval('"' + value.trim().toLowerCase() + '"' + frule.type + '"' + frule.value.trim().toLowerCase() + '"');
                                }
                                //alert(result);
                                if (result === true || result === 'true') {
                                    //  alert("1111111111");
                                    //                                  alert('"' + value.toLowerCase() + '"' + frule.type + '"' + frule.value.toLowerCase() + '"');

                                    //             alert(JSON.stringify(rule.symbolizers));
                                    style = app.map2u.getSymbolizers(rule.symbolizers);
                                    //           alert(JSON.stringify(style));
                                    //         alert(length);
                                    styles[length++] = style;// app.map2u.getSymbolizers(rule.symbolizers);
                                    //alert(length);

                                }
                                //                        alert(frule.property);
                                //                          alert(frule.value);

//                            alert(eval("'" + value.toLowerCase() + "'" + frule.type + "'" + frule.value.toLowerCase() + "'"));

                            } else {
                                var filterstr = '';
                                var result = false;
                                $.map(filter.rules, function (frule) {

                                    var value = feature.get(frule.property);
                                    if (typeof value === 'undefined') {
                                        value = feature.get(frule.property.toString().toLowerCase());
                                    }


                                    if ($.isNumeric(value) && $.isNumeric(frule.value)) {

                                        if (filterstr === '') {
                                            filterstr = ' ( ' + value + frule.type + frule.value + ' ) ';
                                        } else {
                                            filterstr = filterstr + filter.type + ' ( ' + value + frule.type + frule.value + ' ) ';
                                        }

                                    } else {
                                        value = value.trim().toLowerCase();
                                        frule.value = frule.value.trim().toLowerCase();

                                        if (filterstr === '') {
                                            filterstr = ' ( ' + value + frule.type + frule.value + ' ) ';
                                        } else {
                                            filterstr = filterstr + filter.type + ' (" ' + value + '"' + frule.type + '"' + frule.value + '" ) ';
                                        }

                                    }
                                    // 2017-02-23 important alert(frule.type);
                                });
                                if (filterstr !== '') {
                                    result = eval(filterstr);
                                    if (result === true || result === 'true') {
                                        //  alert("1111111111");
                                        //                                  alert('"' + value.toLowerCase() + '"' + frule.type + '"' + frule.value.toLowerCase() + '"');

                                        //             alert(JSON.stringify(rule.symbolizers));
                                        style = app.map2u.getSymbolizers(rule.symbolizers);
                                        //           alert(JSON.stringify(style));
                                        //         alert(length);
                                        styles[length++] = style;// app.map2u.getSymbolizers(rule.symbolizers);
                                        //alert(length);

                                    }
                                }
                            }
                        } else {
                            style = app.map2u.getSymbolizers(rule.symbolizers);
                            styles[length++] = style;// app.map2u.getSymbolizers(rule.symbolizers);
                        }
                        if (geom_type === 'Polygon' && typeof feature.get('name') !== 'undefined') {
                            text = new ol.style.Text({
                                text: feature.get('name').toString(), fill: new ol.style.Fill({color: 'red'}), stroke: new ol.style.Stroke({color: 'black', width: 1})
                            });
                            style.setText(text);
                        }
                    });
                }
            });
            styles.length = length;
            return styles;
        } else {
            layer.setStyle(app.map2u.getDefaultStyle(geom_type.toString().toLowerCase()));

            return;
        }

    }

};
app.map2u.getDefaultStyle = function (geom_type) {
    var fill = new ol.style.Fill({color: '#f04'});
    var stroke = new ol.style.Stroke({color: '', width: 1});
    var polygon = new ol.style.Style({fill: fill});
    var strokedPolygon = new ol.style.Style({fill: fill, stroke: stroke});
    var line = new ol.style.Style({stroke: stroke});
    var text = new ol.style.Style({text: new ol.style.Text({
            text: '', fill: fill, stroke: stroke
        })});
    if (geom_type === 'point') {
        return   new ol.style.Style({
            image: new ol.style.Circle({
                stroke: new ol.style.Stroke({
                    color: '#0059FF',
                    width: 1
                }),
                radius: 5
            })
        });
    }
    if (geom_type === 'polygon' || geom_type === 'multipolygon') {
        return   strokedPolygon;
    }
    if (geom_type === 'line' || geom_type === 'linestring') {
        return   line;
    }
    if (geom_type === 'text') {
        return   text;
    }
};
app.map2u.getSymbolizers = function (symbolizers) {
    var style = new ol.style.Style();
    var image = null;
    var fill = new ol.style.Fill();
    var stroke = new ol.style.Stroke();
    var cachedId = '';

    var marker_styles_p = [];

    if (typeof symbolizers !== 'undefined') {

        if (typeof symbolizers === 'string') {
            symbolizers = JSON.parse(symbolizers);
        }
        //   alert(typeof symbolizers['Graphic']);
        //  alert(typeof symbolizers['WellKnownName']);



        //   alert("1");
        if (typeof symbolizers['fillColor'] !== 'undefined') {

            //      alert(FeatureTypeStyle.Rule[key].Fill['fill']);
            if (typeof symbolizers['fillOpacity'] !== 'undefined' && typeof fill.setOpacity === 'function') {
                fill.setOpacity(symbolizers['fillOpacity']);
                cachedId = cachedId + symbolizers['fillOpacity'];

            }
            if (typeof symbolizers['fillColor'] !== 'undefined' && typeof fill.setColor === 'function') {
                fill.setColor(symbolizers['fillColor']);
                cachedId = cachedId + symbolizers['fillColor'];

            }

            //     alert(typeof style.setFill);
            style.setFill(fill);
            //    alert(fill.getColor());

        }
        //       alert("2");

        //    alert(typeof FeatureTypeStyle.Rule[key].Stroke);
        if (symbolizers['stroke'] === true) {

            //    alert(FeatureTypeStyle.Rule[key].Stroke['stroke']);
            if (typeof symbolizers['color'] !== 'undefined' && typeof stroke.setColor === 'function') {
                stroke.setColor(symbolizers['color']);
                cachedId = cachedId + symbolizers['color'];

            }
            if (typeof symbolizers['strokeWidth'] !== 'undefined' && typeof stroke.setWidth === 'function') {
                stroke.setWidth(symbolizers['strokeWidth']);
                cachedId = cachedId + symbolizers['strokeWidth'];

            }
            if (typeof symbolizers['stroke-linejoin'] !== 'undefined' && typeof stroke.setLineJoin === 'function') {
                stroke.setLineJoin(symbolizers['stroke-linejoin']);
            }
            if (typeof symbolizers['stroke-linecap'] !== 'undefined' && typeof stroke.setLineCap === 'function') {
                stroke.setLineCap(symbolizers['stroke-linecap']);
            }
            if (typeof symbolizers['strokeOpacity'] !== 'undefined' && typeof stroke.setOpacity === 'function') {
                stroke.setOpacity(symbolizers['strokeOpacity']);
                cachedId = cachedId + symbolizers['strokeOpacity'];

            }
            style.setStroke(stroke);

        }
        if (typeof symbolizers['Graphic'] !== 'undefined' && typeof symbolizers['WellKnownName'] !== 'undefined') {
            // alert(symbolizers['WellKnownName']);&& typeof ol3.map2u.marker_styles[symbolizers['WellKnownName']] !== 'undefined'
            // ol.style.RegularShape
            cachedId = cachedId + symbolizers['WellKnownName'];

            //    style.setImage(image);
            var size = 10;
            if (typeof symbolizers['Size'] !== 'undefined') {

                size = symbolizers['Size'];

                // style.image.setRadius(symbolizers['Size']);
            }
            cachedId = cachedId + size;
            cachedId = cachedId.replace('#', '')
//            alert(cachedId);
//            alert(typeof ol3.map2u.cachedMarkers['"'+cachedId+'"']);
            if (typeof ol3.map2u.cachedMarkers['"' + cachedId + '"'] === 'undefined') {
                size = parseInt(size);
                switch (symbolizers['WellKnownName']) {
                    case  'square' :
                        style = new ol.style.Style({
                            image: new ol.style.RegularShape({
                                fill: fill,
                                stroke: stroke,
                                points: 4,
                                radius: size,

                                rotation: 0,
                                angle: Math.PI / 4
                            })
                        });
                        break;
                    case 'diamond':
                        style = new ol.style.Style({
                            image: new ol.style.RegularShape({
                                fill: fill,
                                stroke: stroke,
                                points: 4,
                                radius: size,

                                rotation: Math.PI / 4,
                                angle: Math.PI / 4
                            })
                        });
                        break;

                    case 'triangle':
                        style = new ol.style.Style({
                            image: new ol.style.RegularShape({
                                fill: fill,
                                stroke: stroke,
                                radius: size,

                                points: 3,
                                rotation: Math.PI / 4,
                                angle: 0
                            })
                        });
                        break;
                    default:
                        style = new ol.style.Style({
                            image: new ol.style.RegularShape({
                                fill: fill,
                                stroke: stroke,
                                points: 5,
                                radius: size,

                                radius2: 4,
                                angle: 0
                            })
                        });
                        break;
                    case 'cross':
                        style = new ol.style.Style({
                            image: new ol.style.RegularShape({
                                fill: fill,
                                stroke: stroke,
                                radius: size,

                                points: 4,
                                radius2: 0,
                                angle: 0
                            })
                        });
                        break;
                    case 'x':
                        style = new ol.style.Style({
                            image: new ol.style.RegularShape({
                                fill: fill,
                                stroke: stroke,
                                points: 4,
                                radius: size,
                                radius2: 0,
                                angle: Math.PI / 4
                            })
                        });
                        break;

                }
                ol3.map2u.cachedMarkers['"' + cachedId + '"'] = style;
            } else {
                style = ol3.map2u.cachedMarkers['"' + cachedId + '"'];
            }
            //      alert("length=" + ol3.map2u.cachedMarkers.length);
//            style = new ol.style.Style({
//                image: new ol.style.RegularShape({
//                    fill: fill,
//                    stroke: stroke,
//                    points: 4,
//                    radius: 10,
//                    rotation: Math.PI / 4,
//                    angle: Math.PI / 4
//                })
//            });
            //   var stroke = new ol.style.Stroke({color: fillColor, width: width});
            //   var fill = new ol.style.Fill({color: color});

//            style = new ol.style.Style({
//                image: new ol.style.RegularShape({
//                    fill: fill,
//                    stroke: stroke,
//                    points: 4,
//                    radius: parseInt(size),
//
//                    rotation: Math.PI / 4,
//                    angle: Math.PI / 4
//                })
//            });
            //  style = marker_styles_p[symbolizers['WellKnownName']];
            //   style = ol3.map2u.getMarkerStyle(symbolizers['WellKnownName'], fill, stroke, size);
            //   alert(typeof style);

        }
        //  alert("3");

    }
    return style;
};

app.UserRegistrationFormConfirmPasswrodCheck = function (item) {
    var form = $(item).closest("form");
    if ($(form).find("input[name='sonata_user_registration_form[plainPassword][first]']").val() !== $(form).find("input[name='sonata_user_registration_form[plainPassword][second]']").val()) {
        $(form).find("input[name='sonata_user_registration_form[plainPassword][second]']").addClass('alert-error');
        //   $(form).find("input[name='sonata_user_registration_form[plainPassword][second]']").focus();

        //    var confirm_password = document.getElementById("password-confirm");
        //    alert("2");
        item.setCustomValidity("Password doesn't match.");
        $(form).click();
    }
};
app.map2u.activateMapSidebar = function (id, title) {
    $("div#ol3map-sidebar.ol3map-sidebar.ol3map-sidebar-right .ol3map-sidebar-content #" + id + ".ol3map-sidebar-pane .ol3map-sidebar-header .title").html(title);
    if ($("div#ol3map-sidebar.ol3map-sidebar.ol3map-sidebar-right .ol3map-sidebar-content #" + id + ".ol3map-sidebar-pane").is(":visible") === false || $("div#ol3map-sidebar.ol3map-sidebar.ol3map-sidebar-right .ol3map-sidebar-content").width() === 0) {
        $("div#ol3map-sidebar.ol3map-sidebar.ol3map-sidebar-right .ol3map-sidebar-tabs ul li a[href='#" + id + "']").trigger("click");
    }

};
app.map2u.setMapSidebarContent = function (id, url, parameters) {
    $.ajax({
        url: Routing.generate(url, {_locale: app.locale}),
        data: parameters,
        type: 'POST',
        complete: function () {
            $('div#leafmap').spin(false);
        },
        success: function (data) {

            $("div#ol3map-sidebar.ol3map-sidebar.ol3map-sidebar-right .ol3map-sidebar-content #" + id + ".ol3map-sidebar-pane .ol3map-sidebar-panel-content").html(data);
        },
        cache: false,
        contentType: false,
        processData: false
    });


};
app.UserRegistrationFormCheck = function (form) {
    var isValid = true;
    if ($(form['sonata_user_registration_form[firstname]']).val() === '') {
        isValid = false;
        $(form['sonata_user_registration_form[firstname]']).addClass('alert-error');
    } else {
        $(form['sonata_user_registration_form[firstname]']).removeClass('alert-error');
    }
    if ($(form['sonata_user_registration_form[lastname]']).val() === '') {
        isValid = false;
        $(form['sonata_user_registration_form[lastname]']).addClass('alert-error');
    } else {
        $(form['sonata_user_registration_form[lastname]']).removeClass('alert-error');
    }
    if ($(form['sonata_user_registration_form[username]']).val() === '') {
        isValid = false;
        $(form['sonata_user_registration_form[username]']).addClass('alert-error');
    } else {
        $(form['sonata_user_registration_form[username]']).removeClass('alert-error');
    }
    if ($(form['sonata_user_registration_form[email]']).val() === '') {
        isValid = false;
        $(form['sonata_user_registration_form[email]']).addClass('alert-error');
    } else {
        $(form['sonata_user_registration_form[email]']).removeClass('alert-error');
    }
    if ($(form['sonata_user_registration_form[plainPassword][first]']).val() === '') {
        isValid = false;
        $(form['sonata_user_registration_form[plainPassword][first]']).addClass('alert-error');
    } else {
        $(form['sonata_user_registration_form[plainPassword][first]']).removeClass('alert-error');
    }
    if ($(form['sonata_user_registration_form[plainPassword][second]']).val() === '') {
        isValid = false;
        $(form['sonata_user_registration_form[plainPassword][second]']).addClass('alert-error');
    } else {
        $(form['sonata_user_registration_form[plainPassword][second]']).removeClass('alert-error');
    }
    if ($(form['sonata_user_registration_form[phone]']).val() === '') {
        isValid = false;
        $(form['sonata_user_registration_form[phone]']).addClass('alert-error');
    } else {
        $(form['sonata_user_registration_form[phone]']).removeClass('alert-error');
    }
    if ($(form['sonata_user_registration_form[security_question]']).val() === '') {
        isValid = false;
        $(form['sonata_user_registration_form[security_question]']).addClass('alert-error');
    } else {
        $(form['sonata_user_registration_form[security_question]']).removeClass('alert-error');
    }
    if ($(form['sonata_user_registration_form[security_answer]']).val() === '') {
        isValid = false;
        $(form['sonata_user_registration_form[security_answer]']).addClass('alert-error');
    } else {
        $(form['sonata_user_registration_form[security_answer]']).removeClass('alert-error');
    }
    var confirm_password = document.getElementById("password-confirm");

    if ($(form['sonata_user_registration_form[plainPassword][first]']).val() !== $(form['sonata_user_registration_form[plainPassword][second]']).val()) {
        isValid = false;
        $(form['sonata_user_registration_form[plainPassword][first]']).addClass('alert-error');
        $(form['sonata_user_registration_form[plainPassword][second]']).addClass('alert-error');
        $(form['sonata_user_registration_form[plainPassword][second]']).focus();
        confirm_password.setCustomValidity("Password doesn't match.");
    } else {
        confirm_password.setCustomValidity('');
    }
    if ($("div#register-form form .form-group span.fa.required_check.failure").length > 0) {
        isValid = false;
    }
    return isValid;

};


app.viewingscale = function (map) {

    $("li#viewingscale ul li a").click(function () {
        var scale = $(this).data("zoom");
        var center = $(this).data("center");
        var address = $(this).data("address");

        if (typeof center === 'string') {
            center = center.split(",");
            center = ol.proj.transform([parseFloat(center[0]), parseFloat(center[1])], 'EPSG:4326', 'EPSG:3857');
        }


        if ((center === null || center === undefined || center[0] === 0 || center[0] === '0' || center[1] === 0 || center[1] === '0') && (parseInt(scale) !== 0)) {
            center = map.getView().getCenter();
            //  map.getView().setCenter(center);
            //  map.getView().setZoom(parseInt(scale));
            createSearchFeatureIcon(map, center[0], center[1], address);

            return;
        }

        if (parseInt(scale) === 0 || typeof scale === 'undefined') {

            $.when(app.map2u.activateMapSidebar("feature_information", 'Map bookmark')).then(function () {

                app.map2u.setMapSidebarContent("feature_information", 'useraccount_mapbookmark', '');
            });
            return;

        } else {

            map.getView().setCenter([Number(center[0]), Number(center[1])]);
            map.getView().setZoom(scale);
            createSearchFeatureIcon(map, Number(center[0]), Number(center[1]), address);
        }
    });
};

function createSearchFeatureIcon(map, lng, lat, address, route, text, type) {
    var features = ol3.map2u.userdrawItems.getFeatures();
    for (var i = features.length - 1; i >= 0; i--) {
        if (features[i].get('source') !== undefined && features[i].get('source') === 'searchbox_query') {
            ol3.map2u.userdrawItems.removeFeature(features[i]);
        }
    }



    var feature = new ol.Feature({
        geometry: new ol.geom.Point([parseFloat(lng), parseFloat(lat)]),
        id: 0,
        name: address,
        type: type,
        route: route,
        text: text,
        source: 'searchbox_query'

    });
    var style = [];
    style.push(new ol.style.Style({
        image: new ol.style.Circle({
            stroke: new ol.style.Stroke({
                color: '#0059FF',
                width: 3
            }),
            radius: 20,
        })
    }));
    style = new ol.style.Style({
        image: new ol.style.Circle({
            stroke: new ol.style.Stroke({
                color: '#0059FF',
                width: 3
            }),
            radius: 20,
        })
    });
//    style.push(new ol.style.Style({
//        image: new ol.style.Icon({
//            opacity: 1,
//            scale: 1,
//            //  size:[25,20],
//            src: 'https://openlayers.org/en/v4.0.1/examples/data/icon.png',
//            anchor: [0.5, 46],
//            anchorXUnits: 'fraction',
//            anchorYUnits: 'pixels'
//                    // anchorOrigin: 'bottom-left'
//        })
//    }));

    style = new ol.style.Style({
        image: new ol.style.Photo({
            src: '/bundles/map2uleaflet/images/photo_unavailable_t.png',
            radius: 20,
            crop: true,
            kind: 'anchored',
            shadow: 5,
            fill: new ol.style.Fill({
                color: '#ff9900'
            }),
            stroke: new ol.style.Stroke({width: 3,
                color: '#fff'
            })
        }),
//        text: new ol.style.Text({
//            text: 'New Story',
//            fill: new ol.style.Fill({
//                color: '#f00'
//            }),
//            fontFamily: 'Calibri,sans-serif',
//            fontSize: 12,
//            offsetX: 0,
//            offsetY: -24
//        })
    });
    feature.setStyle(style);

    ol3.map2u.userdrawItems.addFeature(feature);
}