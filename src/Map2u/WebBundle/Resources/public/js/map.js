/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

OpenLayers.Map.prototype.zoomToMaxExtent = function() {
    var bounds = this.maxExtent;
    this.zoomToExtent(bounds);
};

OpenLayers.Renderer.SVG.prototype.createRenderRoot = function() {
    var svg = this.nodeFactory(this.container.id + "_svgRoot", "svg");
    svg.style.position = "absolute";
    return svg;
};


OpenLayers.IMAGE_RELOAD_ATTEMPTS = 3;
OpenLayers.Util.onImageLoadErrorColor = 1;
OpenLayers.Util.onImageLoadErrorColor = "transparent";
OpenLayers.ProxyHost = "/cgi-bin/proxy.cgi?url=";

var map2u_webbundle = (function($) {
    'use strict';
    var app = {
        is_mobile: /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent),
        current_modal: false,
        infinite_scroll: false,
        am: false,
        um: false,
        map: null,
        mapeditor: null,
        init: function(options) {
            //    OpenLayers.ImgPath = "/images/";
            var format = 'image/png';
            var defStyle = {strokeColor: "red", strokeOpacity: "0.7", strokeWidth: 3, fillColor: "blue", cursor: "pointer"};
            var sty = OpenLayers.Util.applyDefaults(defStyle, OpenLayers.Feature.Vector.style["default"]);
            var sm = new OpenLayers.StyleMap({
                'default': sty,
                'select': {pointRadius: 20, strokeOpacity: "0.5", strokeColor: "red", fillColor: "blue"}
            });
            var bounds = new OpenLayers.Bounds(
                    -95.15600126025657, 41.676949299431165,
                    -74.32038159526957, 56.85903628757211
                    ).transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913"));

            var map = new OpenLayers.Map({
                div: new OpenLayers.Util.getElement("map2uweb_map"),
                allOverlays: false
            });
            if (OpenLayers.Util.getElement("webgismap_layerSwitcher"))
            {
                var layerSwitcher = new OpenLayers.Editor.Control.LayerSwitcherRadio(
                        {
                            'div': new OpenLayers.Util.getElement("webgismap_layerSwitcher")
                        });
                map.addControl(layerSwitcher);
            }
            app.map = map;
            if (options.baseLayer)
            {
                switch (options.baseLayer)
                {
                    case 'OSM':
                        app.addOSMBaselayers();
                        break;
                    case 'BING':
                        app.addBingBaselayers();
                        break;
                    case 'GOOGLE':
                        app.addGoogleBaselayers();
                        break;
                    default:
                        app.addOSMBaselayers();
                        break;
                }
            }
            else
            {
                app.addOSMBaselayers();
            }
            map.maxExtent = bounds;
            map.numZoomLevels = 9;
            map.units = 'm';
            map.projection = new OpenLayers.Projection("EPSG:900913");
            map.displayProjection = new OpenLayers.Projection("EPSG:4326");
//            app.addEditor(map);
            map.zoomToMaxExtent();
        },
        addOSMBaselayers: function() {
            var osm = new OpenLayers.Layer.OSM('Open Street Map');
            osm.isBaseLayer = true;
            app.map.addLayers([osm]);

        },
        addBingBaselayers: function() {
            var apiKey = "AqTGBsziZHIJYYxgivLBf0hVdrAk9mWO5cQcb8Yux8sW5M8c8opEC2lZqKR1ZZXf";
            var bingmap = new OpenLayers.Layer.Bing({
                name: "Road",
                key: apiKey,
                //       yx : {'EPSG:4326' : true},
                //     projection:new OpenLayers.Projection("EPSG:4326"),
                //   type: "Road",numZoomLevels:10,maxResolution: 76.43702827453613,minZoomLevel:4
                type: "Road",
                numZoomLevels: 10,
                maxResolution: 17578.125, isBaseLayer: true});
            bingmap.isBaseLayer = true;
            app.map.addLayers([bingmap]);

        },
        addGoogleBaselayers: function() {


            var gsat = new OpenLayers.Layer.Google("Google Satellite",
                    {type: google.maps.MapTypeId.SATELLITE, visibility: false, numZoomLevels: 15, minZoomLevel: 5},
            {sigleTile: false, isBaseLayer: true, buffer: 0}
            );
            var gter = new OpenLayers.Layer.Google("Google Terrain",
                    {type: google.maps.MapTypeId.TERRAIN, visibility: false, numZoomLevels: 11, minZoomLevel: 5},
            {sigleTile: false, isBaseLayer: true, buffer: 0}
            );

            var ghyb = new OpenLayers.Layer.Google("Google Hybrid",
                    {type: google.maps.MapTypeId.HYBRID, visibility: false, numZoomLevels: 15, minZoomLevel: 5},
            {sigleTile: false, isBaseLayer: true, buffer: 0}
            );
            var gstr = new OpenLayers.Layer.Google("Google Streets",
                    {visibility: false, numZoomLevels: 15, minZoomLevel: 5},
            {sigleTile: false, isBaseLayer: true, buffer: 0}
            );
            app.map.addLayers([gstr, gsat, gter, ghyb]);
        },
        postSLD: function() {
            var sld = 'define your SLD here';

            sld = sld + '<ogc:Filter>';
            sld = sld + '<ogc:PropertyIsEqualsTo>';
            sld = sld + '<ogc:Function name="in3">';
            sld = sld + '<ogc:PropertyName>first_name</ogc:PropertyName>';
            sld = sld + '<ogc:Literal>Paul</ogc:Literal>';
            sld = sld + '<ogc:Literal>Mary</ogc:Literal>';
            sld = sld + '<ogc:Literal>Luke</ogc:Literal>';
            sld = sld + '</ogc:Function>';
            sld = sld + '<ogc:Literal>true</ogc:Literal>';
            sld = sld + '</ogc:PropertyIsEqualsTo>';
            sld = sld + '</ogc:Filter>';

            wms = new OpenLayers.Layer.WMS.Post(
                    "name",
                    "http://localhost:8080/geoserver/wms",
                    {
                        'layers': 'myNs:layername',
                        format: 'image/jpeg',
                        sld_body: sld
                    },
            {
                unsupportedBrowsers: []
            }
            );
        },
        addEditor: function(map) {
            var mapeditor = new OpenLayers.Editor(map,
                    {
                        autoActivate: true,
                        saveState: true,
                        activeControls:
                                ['Navigation', 'Separator', 'DragFeature', 'SelectFeature',
                                    'Separator', 'DrawHole', 'ModifyFeature', 'Separator'],
                        featureTypes:
                                ['regular', 'polygon', 'path', 'point']
                    });
            app.mapeditor = mapeditor;
            app.mapeditor.startEditMode();
        }

    };
    $(function() {
        //  if (OpenLayers.Util.getElement("map2uweb_map"))
        //    app.init();
    });
    return app;
}(jQuery));

