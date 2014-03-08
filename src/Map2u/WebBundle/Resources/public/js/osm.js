/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


OSM = {
//<% if defined?(PIWIK) %>
//  PIWIK:                 <%= PIWIK.to_json %>,
//<% end %>

//  MAX_REQUEST_AREA:      <%= MAX_REQUEST_AREA.to_json %>,
//  SERVER_URL:            <%= SERVER_URL.to_json %>,
//  API_VERSION:           <%= API_VERSION.to_json %>,
//  STATUS:                <%= STATUS.to_json %>,
//  MAX_NOTE_REQUEST_AREA: <%= MAX_NOTE_REQUEST_AREA.to_json %>,

  apiUrl: function (object) {
    var url = "/api/" + OSM.API_VERSION + "/" + object.type + "/" + object.id;

    if (object.type === "way" || object.type === "relation") {
      url += "/full";
    } else if (object.version) {
      url += "/" + object.version;
    }

    return url;
  },

  params: function(search) {
    var params = {};

    search = (search || window.location.search).replace('?', '').split(/&|;/);

    for (var i = 0; i < search.length; ++i) {
      var pair = search[i],
        j = pair.indexOf('='),
        key = pair.slice(0, j),
        val = pair.slice(++j);
      params[key] = decodeURIComponent(val);
    }

    return params;
  },

  mapParams: function (search) {
    var params = OSM.params(search), mapParams = {}, loc, match;

    if (params.mlon && params.mlat) {
      mapParams.marker = true;
      mapParams.mlon = parseFloat(params.mlon);
      mapParams.mlat = parseFloat(params.mlat);
    }

    // Old-style object parameters; still in use for edit links e.g. /edit?way=1234
    if (params.node) {
      mapParams.object = {type: 'node', id: parseInt(params.node)};
    } else if (params.way) {
      mapParams.object = {type: 'way', id: parseInt(params.way)};
    } else if (params.relation) {
      mapParams.object = {type: 'relation', id: parseInt(params.relation)};
    }

    var hash = OSM.parseHash(location.hash);

    // Decide on a map starting position. Various ways of doing this.
    if (hash.center) {
      mapParams.lon = hash.center.lng;
      mapParams.lat = hash.center.lat;
      mapParams.zoom = hash.zoom;
    } else if (params.bbox) {
      var bbox = params.bbox.split(',');
      mapParams.bounds = L.latLngBounds(
        [parseFloat(bbox[1]), parseFloat(bbox[0])],
        [parseFloat(bbox[3]), parseFloat(bbox[2])]);
    } else if (params.minlon && params.minlat && params.maxlon && params.maxlat) {
      mapParams.bounds = L.latLngBounds(
        [parseFloat(params.minlat), parseFloat(params.minlon)],
        [parseFloat(params.maxlat), parseFloat(params.maxlon)]);
    } else if (params.lon && params.lat) {
      mapParams.lon = parseFloat(params.lon);
      mapParams.lat = parseFloat(params.lat);
      mapParams.zoom = parseInt(params.zoom || 5);
    } else if (params.mlon && params.mlat) {
      mapParams.lon = parseFloat(params.mlon);
      mapParams.lat = parseFloat(params.mlat);
      mapParams.zoom = parseInt(params.zoom || 12);
    } else if (loc = $.cookie('_osm_location')) {
      loc = loc.split("|");
      mapParams.lon = parseFloat(loc[0]);
      mapParams.lat = parseFloat(loc[1]);
      mapParams.zoom = parseInt(loc[2]);
    } else if (OSM.home) {
      mapParams.lon = OSM.home.lon;
      mapParams.lat = OSM.home.lat;
      mapParams.zoom = 10;
    } else if (OSM.location) {
      mapParams.bounds = L.latLngBounds(
        [OSM.location.minlat,
         OSM.location.minlon],
        [OSM.location.maxlat,
         OSM.location.maxlon]);
    } else {
      mapParams.lon = -0.1;
      mapParams.lat = 51.5;
      mapParams.zoom = parseInt(params.zoom || 5);
    }

    mapParams.layers = hash.layers || (loc && loc[3]) || '';

    var scale = parseFloat(params.scale);
    if (scale > 0) {
      mapParams.zoom = Math.log(360.0 / (scale * 512.0)) / Math.log(2.0);
    }

    return mapParams;
  },

  parseHash: function(hash) {
    var args = {};

    var i = hash.indexOf('#');
    if (i < 0) {
      return args;
    }

    hash = querystring.parse(hash.substr(i + 1));

    var map = (hash.map || '').split('/'),
      zoom = parseInt(map[0], 10),
      lat = parseFloat(map[1]),
      lon = parseFloat(map[2]);

    if (!isNaN(zoom) && !isNaN(lat) && !isNaN(lon)) {
      args.center = new L.LatLng(lat, lon);
      args.zoom = zoom;
    }

    if (hash.layers) {
      args.layers = hash.layers;
    }

    return args;
  },

  formatHash: function(args) {
    var center, zoom, layers;

    if (args instanceof L.Map) {
      center = args.getCenter();
      zoom = args.getZoom();
      layers = args.getLayersCode();
    } else {
      center = args.center || L.latLng(args.lat, args.lon);
      zoom = args.zoom;
      layers = args.layers || '';
    }

    center = center.wrap();
    layers = layers.replace('M', '');

    var precision = OSM.zoomPrecision(zoom),
      hash = '#map=' + zoom +
        '/' + center.lat.toFixed(precision) +
        '/' + center.lng.toFixed(precision);

    if (layers) {
      hash += '&layers=' + layers;
    }

    return hash;
  },

  zoomPrecision: function(zoom) {
    return Math.max(0, Math.ceil(Math.log(zoom) / Math.LN2));
  },

  locationCookie: function(map) {
    var center = map.getCenter().wrap(),
      zoom = map.getZoom(),
      precision = OSM.zoomPrecision(zoom);
    return [center.lng.toFixed(precision), center.lat.toFixed(precision), zoom, map.getLayersCode()].join('|');
  }
};