
/**
 * <copyright>
 * This file/program is free and open source software released under the GNU General Public
 * License version 3, and is distributed WITHOUT ANY WARRANTY. A copy of the GNU General
 * Public Licence is available at http://www.gnu.org/licenses
 * </copyright>
 *
 * <author>Shuilin (Joseph) Zhao</author>
 * <company>SpEAR Lab, Faculty of Environmental Studies, York University
 * <email>zhaoshuilin2004@yahoo.ca</email>
 * <date>created at 2015/09/24</date>
 * <date>last updated at 2015/09/24</date>
 * <summary>This is a tool for map measurement</summary>
 * <purpose>measure map linar length and area</purpose>
 */

L.MAP2U.measure = function (options) {
    var control = L.control(options);
    var currentTool;
    var toolbuttons = ['polyline', 'polygon', 'rectangle', 'circle'];
    control.onAdd = function (map) {
        var $container = $('<div>')
                .attr('class', 'leaflet-control control-measure');
        var button = $('<a>')
                .attr('class', 'control-button')
                .attr('href', '#')
                .html('<span class="icon measure"></span>')
                .on('click', toggle)
                .appendTo($container);
        this.button = button;
        var $ui = $('<div>')
                .attr('class', 'measure-ui');
        $('<div>')
                .attr('class', 'sidebar_heading')
                .appendTo($ui)
                .append(
                        $('<h4>')
                        .text(I18n.t('javascripts.measure.title')));
        var barContent = $('<div>')
                .attr('class', 'sidebar_content')
                .appendTo($ui);
        var $section = $('<div>')
                .attr('class', 'section')
                .appendTo(barContent);
        var list = $('<ul>')
                .attr("class", "leaflet-measure-toolbar")
                .appendTo($section);
        toolbuttons.forEach(function (tool_name) {
            var item = $('<li>')
                    //   .attr("class", "leaflet-measure-actions")
                    .css("display", "inline-block")
                    .attr('value', tool_name)
                    .appendTo(list);
//      var div = $('<div>')
//        .appendTo(item);

//      map.whenReady(function() {
//        var miniMap = L.map(div[0], {attributionControl: false, zoomControl: false})
//          .addLayer(new layer.constructor());
//
//        miniMap.dragging.disable();
//        miniMap.touchZoom.disable();
//        miniMap.doubleClickZoom.disable();
//        miniMap.scrollWheelZoom.disable();
//
//        $ui
//          .on('show', shown)
//          .on('hide', hide);
//
//        function shown() {
//          miniMap.invalidateSize();
//          setView({animate: false});
//          map.on('moveend', moved);
//        }
//
//        function hide() {
//          map.off('moveend', moved);
//        }
//
//        function moved() {
//          setView();
//        }
//
//        function setView(options) {
//          miniMap.setView(map.getCenter(), Math.max(map.getZoom() - 2, 0), options);
//        }
//      });


            var button = $('<button>')
                    .attr('type', 'button')
                    .attr('class', "leaflet-measure-" + tool_name)

                    .appendTo(item);

            item.on('click', function () {
                if ($(this).find("button").hasClass('checked')) {
                    $(this).find("button").toggleClass('checked');
                    map.off("clickasurestart");
                    map.off("mousemoveasuremove");
                    map.off("draw:drawstopasurestop");
                    if (currentTool) {
                        currentTool.disable();
                        delete currentTool;
                    }
                }
                else {
                    $(".leaflet-measure-toolbar button").removeClass("checked");
                    $(this).find("button").toggleClass('checked');

                    //   alert($(this).attr('value'));
                    measureArea($(this).attr('value'));
                }
            });
        });
        var measurediv = $('<div>')
                .attr('class', 'measure_result')
                .appendTo($(barContent));


        options.sidebar.addPane($ui);
        jQuery(window).resize(function () {
            barContent.height($('.leaflet-sidebar.right').height() - 70);
        });
        map.on('zoomend', update);
        function update() {
            var disabled = false;
            button.toggleClass('disabled', disabled).attr('data-original-title', I18n.t(disabled ? 'javascripts.site.measure_disabled_tooltip' :
                    'javascripts.site.measure_tooltip'));
        }
        update();
        function toggle(e) {
            e.stopPropagation();
            e.preventDefault();
            if (!button.hasClass('disabled')) {
                options.sidebar.togglePane($ui, button);
            }
            $('.leaflet-control .control-button').tooltip('hide');
        }



        function measureArea(type) {
            var stopclick = false; //to prevent more than one click listener
            if (currentTool) {
                currentTool.disable();
                delete currentTool;
            }
            var tool;

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
            currentTool = tool;
            currentTool.type = type;
            //user affordance
            //      $("div.measure_result").html(messages.beginmeasure);
            //listeners active during drawing
            function measuremove(e) {
                var latlng = e.latlng;


                if (currentTool) {
                    currentTool._onMouseMove(e);
                    switch (currentTool.type) {
                        case 'polygon':
                            measurepolygon(currentTool, latlng);
                            break;
                        case 'polyline':
                            measurepolyline(currentTool, latlng);
                            break;
                        case 'rectangle':
                            measurerectangle(currentTool, latlng);
                            break;
                        case 'circle':
                            measurecircle(currentTool, latlng);
                            break;
                    }
                }
            }
            ;
            function measurestart() {
                if (stopclick === false) {
                    stopclick = true;
                    //   $("div.measure_result").html("");
                    //    $("button[name=measureArea] span").html(messages.area);
                    //   map.on("mousemove", measuremove);
                    //  map.on("draw:drawstop", measurestop);
                    map.on('draw:created', function (e) {

                        var drawnItems = new L.FeatureGroup();

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
                    });
                }
                ;
            }
            function measureclick(e) {
                var latlng = e.latlng;

                if (currentTool) {


                    switch (currentTool.type) {
                        case 'polygon':

                            break;
                        case 'polyline':
                            for (var i = 0; i < currentTool._poly.getLatLngs().length; i++) {
                                // alert(latlng.distanceTo(currentTool._poly.getLatLngs()[i]));
                            }

                            if (currentTool._markers.length === 1) {
                                $("div.measure_result").html("");
                                $("div.leaflet-marker-icon.leaflet-div-icon.leaflet-editing-icon:first").css("background-color", 'green');
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
                //reset button
                //    $("button[name=measureArea] span").html(messages.measureArea);
                //remove listeners
                //   map.off("clickasurestart");

                //   map.off("mousemove");
                //   map.off("draw:drawstop");
                // map.off('draw:created');
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
                if (currentTool._poly.getLatLngs().length > 0) {

                    var last_distance = latlng.distanceTo(currentTool._poly.getLatLngs()[currentTool._poly.getLatLngs().length - 1]).toFixed(3)
                    tips = tips + last_distance + "<br><br>";
                    for (var i = 0; i < currentTool._poly.getLatLngs().length; i++) {
                        tips = tips + currentTool._poly.getLatLngs()[i].lat.toFixed(3) + "," + currentTool._poly.getLatLngs()[i].lng.toFixed(3);

                        if (i > 0 && i < currentTool._poly.getLatLngs().length) {
                            distance = parseFloat(distance) + parseFloat(currentTool._poly.getLatLngs()[i - 1].distanceTo(currentTool._poly.getLatLngs()[i]));
                            tips = tips + "," + currentTool._poly.getLatLngs()[i - 1].distanceTo(currentTool._poly.getLatLngs()[i]).toFixed(3) + "," + distance.toFixed(3);
                        }
                        tips = tips + "<br>";
                    }

                }
                $("div.measure_result").html(tips);


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

                    $("div.measure_result").html(area2 + "<br><br>" + area1);
                }

            }
            function   measurerectangle(currentTool, latlng) {
                var latLngs = currentTool._shape.getLatLngs();
                var area = L.GeometryUtil.geodesicArea(latLngs);
                var subtext = L.GeometryUtil.readableArea(area, currentTool.options.metric);
                $("div.measure_result").html(subtext);
            }
            function   measurecircle(currentTool, latlng) {

            }
        }


        ;
        control.activate = function (e) {
            var $ui = $('.measure-ui');
            if (options.sidebar.isVisible() === false || options.sidebar._currentButton !== this.button)
                control.toggle(e);
        };
        return $container[0];
    };
    return control;
};
