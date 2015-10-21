/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function initMapDraw(map) {
    var drawnItems = new L.FeatureGroup();
    $(drawnItems).attr({"id": 'user_draw_features'});

    map.addLayer(drawnItems);
    map.drawnItems = drawnItems;
    var drawControl = new L.Control.Draw({
        position: 'topleft',
        draw: {
            rectangle: {
                shapeOptions: {
                    color: '#0000FF',
                    weight: 3
                }
            },
            polyline: {
                shapeOptions: {
                    color: '#0000FF',
                    weight: 3
                }
            },
            polygon: {
                shapeOptions: {
                    color: '#0000FF',
                    weight: 3
                },
                allowIntersection: false
            },
            circle: {
                shapeOptions: {
                    color: '#0000FF',
                    weight: 3
                }
            }
        },
        edit: {
            featureGroup: drawnItems
        }
    });

    map.drawControl = drawControl;
    map.addControl(drawControl);

    map.on('draw:created', function (e) {
        var type = e.layerType, layer = e.layer;

        layer.id = 0;
        layer.type = type;
        layer.saved = false;
        var radius = 0;
        var layers = this.drawnItems.getLayers();

        for (var i = 0; i < layers.length; i++) {

            if (layers[i].saved === false) {

                this.drawnItems.removeLayer(layers[i]);
            }
        }
        this.drawnItems.addLayer(layer);
        layer.index = this.drawnItems.getLayers().length - 1;
        var viewtype = $("div.leaflet-control-container .leaflet-sidebar.left #sidebar-left").data("viewtype");

        if (viewtype)
        {
            switch (viewtype) {
                case 'stories':
                    createStoryDraw(map, e);
                    return;
                default:
                    break;
            }
            ;

        }
        alert(type);
        if (type === 'circle')
        {
            radius = layer._mRadius.toFixed(0);
        }

        //   alert(JSON.stringify(layer.toGeoJSON()));
        layer.on('click', function (e) {
            alert(this.id);
            var feature = e.target;
            if (map.drawControl._toolbars.edit._activeMode === null) {
                var highlight = {
                    'color': '#333333',
                    'weight': 2,
                    'opacity': 1
                };
                if (feature.selected === false || feature.selected === undefined) {
                    if (feature.setStyle)
                        feature.setStyle(highlight);
                    feature.selected = true;
                    if (document.getElementById('geometries_selected')) {
                        var selectBoxOption = document.createElement("option");//create new option 
                        selectBoxOption.value = feature.id;//set option value 
                        selectBoxOption.text = feature.name;//set option display text 
                        document.getElementById('geometries_selected').add(selectBoxOption, null);
                    }
                }
                else
                {
                    if (feature.setStyle)
                        feature.setStyle({'color': "blue", 'weight': 5, 'opacity': 0.6});
                    feature.selected = false;
                    $("#geometries_selected option[value='" + feature.id + "']").each(function () {
                        $(this).remove();
                    });
                }













            }
            else if (map.drawControl._toolbars.edit._activeMode && map.drawControl._toolbars.edit._activeMode.handler.type === 'edit') {

                var radius = 0;
                if (e.target.type === 'circle')
                {
                    radius = e.target._mRadius;
                }
                $.ajax({
                    url: Routing.generate('draw_' + e.target.type, {'_locale': window.locale}),
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


        if ($('body.sonata-bc #ajax-dialog').length === 0) {


            $('<div class="modal fade" id="ajax-dialog" z-index="-1" data-backdrop="false" data-backdrop="static" data-keyboard="false" role="dialog"></div>').appendTo('body');
        } else {
            $('body.sonata-bc #ajax-dialog').html('');
        }



        $.ajax({
            url: Routing.generate('draw_' + layer.type, {'_locale': window.locale}),
            method: 'GET',
            data: {
                id: 0,
                name: layer.name,
                radius: radius,
                index: layer.index
            },
            success: function (response) {
                $(response).appendTo($('body.sonata-bc #ajax-dialog'));

                $('body.sonata-bc #ajax-dialog').modal('show');
                $('body.sonata-bc #ajax-dialog').draggable();
                //  alert(JSON.stringify(html));
            }
        });

        $('body.sonata-bc #ajax-dialog').on('hidden.bs.modal', function (e) {
            // do something...
            //   alert(drawnItems.getLayers()[drawnItems.getLayers().length - 1].id);

            if (drawnItems.getLayers()[drawnItems.getLayers().length - 1].id === 0)
            {
                drawnItems.removeLayer(drawnItems.getLayers()[drawnItems.getLayers().length - 1]);
            }
            $('body.sonata-bc #ajax-dialog').remove();
        });


        $('#ajax-dialog').on('hide.bs.modal', function (e) {

        });
        if (type === 'marker') {
            // Do marker specific actions
        }
//var item=drawnItems.getLayers();
//var itemgeojson=item[0].toGeoJSON();
//itemgeojson.properties.id=layer.id;
//itemgeojson.properties.name=layer.name;
//alert(layer._mRadius);
//
//alert(JSON.stringify(itemgeojson));
//alert(JSON.stringify(layer));
        // Do whatever else you need to. (save to db, add to map etc)
        // map.addLayer(layer);
    });

    map.on('draw:drawstop', function (e) {

        $(".sonata-bc div#map_draw_select_pane").hide();

    });
    map.on('draw:editstop', function (e) {

        $(".sonata-bc div#map_draw_select_pane").hide();

    });
    map.on('draw:edited', function (e) {
        var layers = e.layers;

        layers.eachLayer(function (layer) {
            if (confirm("Modify my draw geometry id:" + layer.id + ",name:" + layer.name + "?"))
            {

                var itemgeojson = layer.toGeoJSON();
                var radius = 0;
                if (layer._mRadius !== undefined)
                    radius = layer._mRadius;
                $.ajax({
                    url: Routing.generate('draw_save', {'_locale': window.locale}),
                    method: 'POST',
                    data: {
                        id: layer.id,
                        name: layer.name,
                        feature: itemgeojson,
                        type: layer.type,
                        radius: radius
                    },
                    success: function (response) {
                        var results = JSON.parse(response);
                        if (results.success === false)
                            alert(results.message);
                        else {


                            //    alert("Geometry has been successfully updated!");
                        }
                    }
                });
            }
        });
    });

    map.on('draw:deleted', function (e) {
        var layers = e.layers;
        layers.eachLayer(function (layer) {
            if (layer.name === 'Searched Icon' && layer.id === 0 && layer.source === 'searchbox_query') {
                drawnItems.removeLayer(layer);
            } else {
                if (confirm("Delete my draw item id:" + layer.id + ",name:" + layer.name + "?"))
                {

                    $.ajax({
                        url: Routing.generate('draw_delete', {'_locale': window.locale}),
                        method: 'POST',
                        data: {
                            id: layer.id
                        },
                        success: function (response) {
                            var result = JSON.parse(response);
                            if (result.success === true) {

                                $("#geometries_select option[value='" + layer.id + "']").each(function () {
                                    $(this).remove();
                                });
                                $("#geometries_selected option[value='" + layer.id + "']").each(function () {
                                    $(this).remove();
                                });
                            }
                            else
                                alert(result.message);
                            //  alert(JSON.stringify(html));
                        }
                    });
                }
            }
        });

    });

}
function createStoryDraw(map, e) {
    var radius = 0;
    var type = e.layerType;
    var layer = e.layer;
    layer.type = "stories";
    layer.saved = false;
    layer.id = 0;

    if (type === 'circle')
    {
        radius = e.layer._mRadius;
    }
    $.ajax({
        url: Routing.generate('draw_createstory', {'_locale': window.locale}),
        method: 'GET',
        data: {
            id: e.target.id,
            name: e.target.name,
            radius: radius,
            index: e.target.index
        },
        success: function (response) {

            $("div.leaflet-control-container .leaflet-sidebar.left #sidebar-left #sidebar_content").html("");
            $(response).appendTo($("div.leaflet-control-container .leaflet-sidebar.left #sidebar-left #sidebar_content"));
            if (layer._latlng) {
                $("div.leaflet-control-container .leaflet-sidebar.left #sidebar-left #sidebar_content input[type='hidden'][name='lat']").val(layer._latlng.lat);
                $("div.leaflet-control-container .leaflet-sidebar.left #sidebar-left #sidebar_content input[type='hidden'][name='lng']").val(layer._latlng.lng);
            }
            $("div.leaflet-control-container .leaflet-sidebar.left #sidebar-left #sidebar_content input[type='hidden'][name='radius']").val(radius);
            $("div.leaflet-control-container .leaflet-sidebar.left #sidebar-left #sidebar_content input[type='hidden'][name='the_geom']").val(JSON.stringify(layer.toGeoJSON()).replace(/"/g, "'"));
            $("div.leaflet-control-container .leaflet-sidebar.left #sidebar-left #sidebar_content input[type='hidden'][name='type']").val(type);
        }
    });
}
function removeMapDraw(map) {
    if (map.drawControl) {
        map.drawControl.removeFrom(map);
        map.drawControl = null;
    }
    if (map.drawnItems) {
        map.removeLayer(map.drawnItems);
        map.drawnItems = null;
    }
    map.off('draw:created');
    map.off('draw:drawstop');
    map.off('draw:editstop');
    map.off('draw:deleted');
}

function MapMeasurement(button, map) {
    if ($(button).hasClass("active")) {
        $("div.leaflet-draw.leaflet-control").hide();
        removeMapDraw(map);
        $("div.leaflet-measurement.leaflet-control").show();
        initMeasurement(map);
    }
    else {
        $("div.leaflet-measurement.leaflet-control").hide();
        removeMapMeasurement(map);
        if ($("div#sidebar-left.leaflet-control").data("viewtype") === 'stories') {
            $("div.leaflet-draw.leaflet-control").show();
            initMapDraw(map);
        }
    }
}

function removeMapMeasurement(map) {
    $("div.mapmeasurement-control.leaflet-control").hide();
}

function initMeasurement(map) {
    $("div.mapmeasurement-control.leaflet-control").removeClass("hidden");
    $("div.mapmeasurement-control.leaflet-control").show();
}


function measureArea(map, type) {
    var stopclick = false; //to prevent more than one click listener

    var tool;
    setNewMeasurement(type);
    if ($(".leaflet-sidebar #sidebar-left #sidebar_content div.measure_result").length === 0) {
        $(".leaflet-sidebar #sidebar-left #sidebar_content").html("");
        $('<div class="title"><h4>Measure ' + type + ':</h4></div>').appendTo($(".leaflet-sidebar #sidebar-left #sidebar_content"));

        $('<div class="measure_result">').appendTo($(".leaflet-sidebar #sidebar-left #sidebar_content"));
    }
    else {
        $(".leaflet-sidebar #sidebar-left #sidebar_content .title h4").html('Measure ' + type);
    }
    $(".leaflet-sidebar #sidebar-left #sidebar_content div.measure_result").html("");

    if (map.tool) {
        map.tool.disable();

        delete map.tool;
    }
    if (type === 'polygon') {
        tool = new L.Draw.Polygon(map, {
            showArea: true,
            allowIntersection: false,
            shapeOptions: {
                color: '#0000FF'
            },
            repeatMode: true
        });


    }
    if (type === 'polyline') {
        tool = new L.Draw.Polyline(map,
                {
                    shapeOptions: {
                        color: '#0000FF',
                        weight: 3
                    },
                    repeatMode: true
                }

        );

    }
    if (type === 'rectangle') {
        tool = new L.Draw.Rectangle(map, {
            shapeOptions: {
                color: '#0000FF',
                weight: 3
            },
            showArea: true,
            repeatMode: true
        });

    }
    if (type === 'circle') {
        tool = new L.Draw.Circle(map, {
            shapeOptions: {
                color: '#0000FF',
                weight: 3
            },
            showArea: true,
            repeatMode: true
        });

    }

    tool.enable();

    tool.type = type;
    map.tool = tool;
    if (!map.drawnItems) {
        var drawnItems = new L.FeatureGroup();
        $(drawnItems).attr({"id": 'user_draw_features'});
        map.addLayer(drawnItems);
        map.drawnItems = drawnItems;
    }
    //user affordance
    //      $("div.measure_result").html(messages.beginmeasure);
    //listeners active during drawing
    function measuremove(e) {

        if (stopclick === false)
            return;
        var latlng = e.latlng;


        if (map.tool) {
            map.tool._onMouseMove(e);
            switch (map.tool.type) {
                case 'polygon':
                    measurepolygon(map.tool, latlng);
                    break;
                case 'polyline':
                    measurepolyline(map.tool, latlng);
                    break;
                case 'rectangle':
                    measurerectangle(map.tool, latlng);
                    break;
                case 'circle':
                    measurecircle(map.tool, latlng);
                    break;
            }
        }
    }
    ;
    function measurestart() {
        if (stopclick === false) {
            stopclick = true;
        
            map.on('draw:created', function (e) {

                //  var drawnItems = new L.FeatureGroup();
                stopclick = false;
                var type = e.layerType, layer = e.layer;

                layer.id = "measure_layer";
                layer.type = type;
                var layers = this.drawnItems.getLayers();
                for (var i = 0; i < layers.length; i++) {

                    if (layers[i].id === "measure_layer") {

                        this.drawnItems.removeLayer(layers[i]);
                    }
                }
                this.drawnItems.addLayer(layer);
                $("form#save_measurement_to_account button").removeAttr('disabled');
            });
        }
        ;
    }
    function measureclick(e) {
        if (stopclick === false) {
            measurestart();
        }
        var latlng = e.latlng;

        if (map.tool) {


            switch (map.tool.type) {
                case 'polygon':

                    break;
                case 'polyline':
                    if (stopclick === true) {
                        for (var i = 0; i < map.tool._poly.getLatLngs().length; i++) {
                            // alert(latlng.distanceTo(currentTool._poly.getLatLngs()[i]));
                        }

                        if (map.tool._markers.length === 1) {
                            $(".leaflet-sidebar #sidebar-left #sidebar_content div.measure_result").html("");

                            $("div.leaflet-marker-icon.leaflet-div-icon.leaflet-editing-icon:first").css("background-color", 'green');
                        }
                    }
                    break;
                case 'rectangle':

                    break;
                case 'circle':

                    break;
            }
        }
        measuremove(e);
    }
    function measurestop() {
        stopclick = false;

    }

    map.off('draw:created');

    map.off("draw:drawstart");
    map.on("draw:drawstart", measurestart);
    //     map.off("draw:drawstop");
    //     map.on("draw:drawstop", measurestop);
//            map.off('mousemove');
    map.on('mousemove', measuremove);
    map.off('click');
    map.on('click', measureclick);
    function   measurepolyline(currentTool, latlng) {
        var tips = '';
        var distance = 0;

        if (currentTool._poly.getLatLngs().length > 0 && stopclick === true) {

            var last_distance = latlng.distanceTo(currentTool._poly.getLatLngs()[currentTool._poly.getLatLngs().length - 1]).toFixed(3)
            tips = tips + last_distance + "M<br><br>";
            for (var i = 0; i < currentTool._poly.getLatLngs().length; i++) {
                tips = tips + currentTool._poly.getLatLngs()[i].lat.toFixed(3) + ", " + currentTool._poly.getLatLngs()[i].lng.toFixed(3);

                if (i > 0 && i < currentTool._poly.getLatLngs().length) {
                    distance = parseFloat(distance) + parseFloat(currentTool._poly.getLatLngs()[i - 1].distanceTo(currentTool._poly.getLatLngs()[i]));
                    tips = tips + ", " + currentTool._poly.getLatLngs()[i - 1].distanceTo(currentTool._poly.getLatLngs()[i]).toFixed(3) + "M, " + distance.toFixed(3) + "M";
                }
                tips = tips + "<br>";
            }
            $(".leaflet-sidebar #sidebar-left #sidebar_content div.measure_result").html(tips);

        }


    }
    function   measurepolygon(currentTool, latlng) {
        if (currentTool._poly.getLatLngs().length > 2) {

            var latLngs = [];
            for (var i = 0; i < currentTool._poly.getLatLngs().length; i++) {
                latLngs.push(currentTool._poly.getLatLngs()[i]);

            }
            var area1 = L.GeometryUtil.geodesicArea(latLngs);

            area1 = L.GeometryUtil.readableArea(area1.toFixed(3), currentTool.options.metric);
            latLngs.push(latlng);
            var area2 = L.GeometryUtil.geodesicArea(latLngs);

            area2 = L.GeometryUtil.readableArea(area2.toFixed(3), currentTool.options.metric);

            $(".leaflet-sidebar #sidebar-left #sidebar_content div.measure_result").html("Current Area with moving point:" + area2 + "<br><br>Drawn Area:" + area1);
        }

    }
    function   measurerectangle(currentTool, latlng) {

        var showArea = currentTool.options.showArea,
                useMetric = currentTool.options.metric,
                width, height, latlngs;


        currentTool._tooltip.updatePosition(latlng);
        if (currentTool._isDrawing && showArea) {
            currentTool._drawShape(latlng);

            latlngs = currentTool._shape._latlngs;
            currentTool._area = L.GeometryUtil.geodesicArea(latlngs);

            currentTool._tooltip.updateContent({
                text: currentTool._endLabelText,
                subtext: '' + L.GeometryUtil.readableArea(currentTool._area, currentTool.options.metric)
            });
            var subtext = L.GeometryUtil.readableArea(currentTool._area, currentTool.options.metric);
            $(".leaflet-sidebar #sidebar-left #sidebar_content div.measure_result").html("Area:" + subtext);
        }
//        var latLngs = currentTool._shape.getLatLngs();
//        var area = L.GeometryUtil.geodesicArea(latLngs);

    }
    function   measurecircle(currentTool, latlng) {
        if (currentTool._shape) {
            var radius = currentTool._shape.getRadius();
            currentTool._area = Math.PI * radius * radius;
            var subtext = L.GeometryUtil.readableArea(currentTool._area, currentTool.options.metric);
            $(".leaflet-sidebar #sidebar-left #sidebar_content div.measure_result").html("Radius:" + radius.toFixed(2) + "M<br>Area:" + subtext);
        }
    }


}

function showMeasureHistory() {

    $.ajax({
        url: Routing.generate('measure_index', {'_locale': window.locale}),
        method: 'GET',
        success: function (response) {

            $(".leaflet-sidebar #sidebar-left #sidebar_content").html(response);
        }
    });
}

function setNewMeasurement(type) {

    $.ajax({
        url: Routing.generate('measure_new', {'_locale': window.locale}),
        data: {'type': type},
        method: 'GET',
        success: function (response) {

            $(".leaflet-sidebar #sidebar-left #sidebar_content").html(response);
        }
    });
}