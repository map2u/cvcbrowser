// This is a manifest file that'll be compiled into application.js, which will include all the files
// listed below.
//
// Any JavaScript/Coffee file within this directory, lib/assets/javascripts, vendor/assets/javascripts,
// or vendor/assets/javascripts of plugins, if any, can be referenced here using a relative path.
//
// It's not advisable to add code directly here, but if you do, it'll appear at the bottom of the
// the compiled file.
//
// WARNING: THE FIRST BLANK LINE MARKS THE END OF WHAT'S TO BE PROCESSED, ANY BLANK LINE SHOULD
// GO AFTER THE REQUIRES BELOW.
//
//= require jquery
//= require jquery_ujs
//= require_tree .




/*
 * Copyright (c) 2008-2012 The Open Source Geospatial Foundation
 *
 * Published under the BSD license.
 * See https://github.com/geoext/geoext2/blob/master/license.txt for the full text
 * of the license.
 */

OpenLayers.Renderer.SVG.prototype.createRenderRoot = function() {
var svg = this.nodeFactory(this.container.id + "_svgRoot", "svg");
        svg.style.position = "absolute";
        return svg;
};
        OpenLayers.Map.prototype.getLayerByName = function(name){

if (name === null || String.trim(name) === '')
        return null;
        if (OpenLayers.Map.layers === undefined)
        return null;
        var index = OpenLayers.Map.layers.findBy(function(rec){
return (String.trim(rec.getLayer().name) === String.trim(name));
        });
        if (index !== - 1)
        return OpenLayers.Map.layers[index];
        else
        return null;
};
        OpenLayers.Map.prototype.zoomToMaxExtent = function(){
var bounds = this.maxExtent;
        this.zoomToExtent(bounds);
};

        OpenLayers.Control.GetFeature.prototype.request = function(bounds, options) {

options = options || {};
        var filter = new OpenLayers.Filter.Spatial({
//  type: this.filterType,
type: OpenLayers.Filter.Spatial.INTERSECTS,
        value: bounds.transform(this.internalProjection, this.externalProjection)
        });
        var point = bounds.getCenterLonLat();
        // Set the cursor to "wait" to tell the user we're working.
        OpenLayers.Element.addClass(this.map.viewPortDiv, "olCursorWait");
        var response = this.protocol.read({

maxFeatures: options.single === true ? this.maxFeatures : undefined,
        filter: filter,
        callback: function(result) {



if (result.success()) {
//alert(result.features.length);
if (result.features.length) {


for (var i = 0, len = result.features.length; i < len; ++i) {


result.features[i].geometry.transform(this.externalProjection, this.internalProjection);
        }

if (options.single === true) {
this.selectBestFeature(result.features,
        bounds.getCenterLonLat().transform(this.externalProjection, this.internalProjection), options);
        } else {
this.select(result.features);
        }
} else if (options.hover) {
this.hoverSelect();
        } else {
this.events.triggerEvent("clickout");
        if (this.clickout) {
this.unselectAll();
        }
}
}
// Reset the cursor.
OpenLayers.Element.removeClass(this.map.viewPortDiv, "olCursorWait");
        },
        scope: this
        });
        if (options.hover === true) {
this.hoverResponse = response;
        }
};
        var select, hover, infocontrol, popup;
 
        Ext.application.prototype.
        /* this function only for testing map layer radio button change event */
        Ext.application.prototype.registerRadioEvent = function (node) {
if (!node.hasListener("radiochange")) {
node.on("radiochange", function(node)
        {
        alert(node.text);
                });
        }
};

        /* this is prepared for communicate with java swing, like webrender, right now not be used */
        Ext.application.prototype.fromClientJava = function (data1, data2)
{

//alert("this is from java side info:" + data1 + " ,  " + data2);
//alert(parseFloat(data1));

var point = new OpenLayers.Geometry.Point(parseFloat(data1), parseFloat(data2));
        point.transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913"));
        var attr = {name:"Test point from Java", bar:"foo"};
        var feature = new OpenLayers.Feature.Vector(point, attr);
        mappanel.map.setCenter(new OpenLayers.LonLat(point.x, point.y));
        selected_layer.addFeatures([feature]);
        clearInterval();
        setInterval(function(){
if (selected_layer.getVisibility() === true)
        selected_layer.setVisibility(false);
        else
        selected_layer.setVisibility(true);
}, 2000);
        createPopup(mappanel.map, feature, "This is a new incident point");
}
;


Ext.application.prototype.showInfo = function (evt) {

//e.feature.geometry.transform(this.externalProjection, this.internalProjection);

alert(evt.features.length);
        if (evt.features && evt.features.length) {
selected_layer.destroyFeatures();
        for (var j = 0; j < evt.features.length; j++)
        {
        evt.features[j].geometry.transform(this.externalProjection, this.internalProjection);
                selected_layer.addFeatures([evt.features[j]]);
                }
selected_layer.redraw();
        alert(selected_layer.features[0].geometry);
        } else {
//     document.getElementById('responseText').innerHTML = evt.text;
}

}
// gmap.setCenter( bounds.getCenterLonLat(),10);




//This function for showing system help tab panel, this function will be called by welcome/index.html.erb
        Ext.application.prototype.
//This function for user account management tab panel, this function will be called by welcome/index.html.erb
Ext.application.prototype.
//This function is for user to reset google map range showed, this function will be called by welcome/index.html.erb

Ext.application.prototype.

//This function is for user to show map legend, this function will be called by welcome/index.html.erb
Ext.application.prototype.

// This function is for user select one watershed on watershed list, system will highlight the boundary of the selected watershed
Ext.application.prototype.

// This function is for user select one watershed on watershed list, system will highlight the boundary of the selected watershed
Ext.application.prototype.

// This function is for show or hide subwatershed polygons
Ext.application.prototype.

//This function is for user reset password before login
Ext.application.prototype.
/* zoom map to station */
Ext.application.prototype.
// This function is for logged in user to change password directly throught form.
Ext.application.prototype.

/* show user login window */
Ext.application.prototype.
/* show user registration input in center region tab panel */
Ext.application.prototype.
// Core	code
Ext.application.prototype.getObj = function (oTxt) {
return document.getElementById(oTxt);
}

Ext.application.prototype.toUpper = function (w) {
return (w.charAt(0).toUpperCase() + w.substring(1))
}

Ext.application.prototype.Int = function (n) {
return parseInt(n);
}

// Core	code END

/* used for dropdown box */
Ext.application.prototype.loadOpt = function (oCbo, ary, selVal) {
var key;
        var i = 0;
        removeAllOptions(oCbo);
        for (key in ary) {
oCbo.options[oCbo.options.length] = new Option(toUpper(ary[key]), key);
        oCbo[i].selected = (oCbo.options.value === selVal) ? true : false;
        i++;
        }
}

/* used for dropdown box */
Ext.application.prototype.makeOption = function (obj, text) {
if (obj !== null && obj.options !== null)
        obj.options[obj.options.length] = new Option(text, value)
}

/* used for dropdown box */
Ext.application.prototype.SelectAllOption = function (obj) {
if (obj !== null && obj.options !== null) {
for (i = 0; i < obj.options.length; i++)
        obj.options[i].selected = true;
        }
}

/* used for dropdown box */
Ext.application.prototype.UnselectAllOption = function (obj) {

if (obj !== null && obj.options !== null) {
for (i = 0; i < obj.options.length; i++)
        obj.options[i].selected = false;
        }
}
/* used for dropdown box */
Ext.application.prototype.removeAllOptions = function (oCbo) {
if (oCbo === undefined)
        return;
        for (var i = (oCbo.options.length - 1); i >= 0; i--)
        oCbo.options[i] = null;
        oCbo.selectedIndex = - 1;
}

/* function for display watershed info in detail info tab panel */
Ext.application.prototype.showWatershedDetails = function (id, text, stationMarkers) {
var detailPanel = Ext.getCmp("detail_info_tabpanel");
        detailPanel.setActiveTab(0);
        var vParam = id;
        var i = 0;
        var aParams = vParam.split('/');
        if (aParams.length === 2)
        onSelectWatershed(aParams[aParams.length - 1]);
        if (aParams.length === 3) {
onSelectWatershed(aParams[aParams.length - 2]);
        onSelectSubwatershed(aParams[aParams.length - 1]);
        }
if (aParams.length === 4) {
onSelectWatershed(aParams[aParams.length - 3]);
        onSelectSubwatershed(aParams[aParams.length - 2]);
        onShowStationInfoOnGoogleMap('', text, stationMarkers);
        }

var panel = Ext.create('Ext.form.Panel', {
border : false,
        id : 'detail_info_tabpanel_id',
        autoScroll : true,
        style : 'padding:5px',
        autoLoad : '/' + locale + '/admin/details?id=' + aParams.length + "&content_id=" + aParams[aParams.length - 1]
        });
        if (detailPanel !== null && detailPanel !== undefined && detailPanel.collapsed === true)
        detailPanel.expand();
        if (detailPanel !== null && detailPanel !== undefined)
        detailPanel.setActiveTab(0);
        var tab = detailPanel.getActiveTab();
        tab.setTitle(text);
        tab.removeAll();
        tab.add(panel);
}

Ext.application.prototype.onShowStationInfoOnGoogleMap = function (id, site_idname, stationMarkers)
{
var overlay;
        if (typeof site_idname == 'string')
{

for (var i = 0; i < gmarkers.length; i++)
{
if (typeof gmarkers[i] == 'object')
{
if (gmarkers[i].getIcon().image != '/images/icon/marker.png' && gmarkers[i].getIcon().image != '/images/icon/marker_grey.png' && gmarkers[i].getIcon().image != '/images/icon/marker_blue.png' && gmarkers[i].getIcon().image != '/images/icon/marker_green.png')
{
stationMarkers.each(function(rec){

if (rec.data.id == gmarkers[i].id)
{
if (rec.data.overall_assessment == null)
{
gmarkers[i].setImage("/images/icons/marker_grey.png");
}
else
{
if (rec.data.overall_assessment.toLowerCase() == 'impaired')
{
gmarkers[i].setImage("/images/icons/marker_yellow.png");
}
if (rec.data.overall_assessment.toLowerCase() == 'potentially impaired')
{
gmarkers[i].setImage("/images/icons/marker.png");
}
if (rec.data.overall_assessment.toLowerCase() == 'unimpaired')
{
gmarkers[i].setImage("/images/icons/marker_blue.png");
}
}
}
});
}
if (site_idname == gmarkers[i].getTitle())
{
if ((gmarkers[i].getLatLng().lat() == 0) || (gmarkers[i].getLatLng().lng() == 0))
{
alert("This	station	location is	not	correct!");
        return;
}

overlay = gmarkers[i];
        overlay.openInfoWindowHtml("Loading	details...");
        point = overlay.getLatLng();
        overlay.setImage("http://maps.google.com/mapfiles/marker_greenS.png");
        url = '/stations/gmapshowsiteinfo?id=' + overlay.getTitle() + '&newdata=true&datafromgooglemap=true&upload_x=' + point.lng() + "&upload_y=" + point.lat();
        var conn = new Ext.data.Connection();
        conn.request({
url: url,
        method:	'GET',
        //						params:	{"metaID": metaID, columnName: field},
        success: function(responseObject) {
overlay.openInfoWindowHtml(responseObject.responseText);
},
        failure: function()	{
Ext.Msg.alert('Status', 'Unable	to show	history	at this	time. Please try again later.');
}
});
}
}
}
}

}

/* function for add new station info */
Ext.application.prototype.addNewStation = function (id, lat, lng, frmTitle) {

var newStationPanel = Ext.create("GeoExt.view.Stationform", {id:"create_new_station_from_map_id", map:mappanel.map});
        var newstationwin = new Ext.Window({
title : frmTitle,
        width : 389,
        modal : true,
        bodyStyle : 'padding:5px;',
        height : 395,
        closable : true,
        resizable : false,
        items : [newStationPanel]
        });
        newStationPanel.panelWindow = newstationwin;
        newStationPanel.getForm().load({
url : '/' + locale + "/stations/newstation",
        params : {
lng : lng,
        lat : lat,
        id : id
        },
        root:'data',
        method : "GET",
        waitMsg : 'Geting Data ...',
        success :function(form, action) {
newStationPanel.getForm().setValues(Ext.JSON.decode(action.result.data));
        },
        failure:function(form, action){
alert("Loading Station Data error, please try again!");
        }
});
        var lonlat = new OpenLayers.LonLat(lng, lat);
        lonlat.transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913"))

        var size = new OpenLayers.Size(21, 25);
        var offset = new OpenLayers.Pixel( - (size.w / 2), - size.h);
        var icon = new OpenLayers.Icon('/images/marker_green.png', size, offset);
        markers.clearMarkers();
        var marker = new OpenLayers.Marker(lonlat, icon);
        marker.events.register("click", marker, function(){
alert(marker.lonlat);
        });
        marker.popup = newstationwin;
        markers.addMarker(marker);
        newstationwin.show();
}

/* function for download station data */
Ext.application.prototype.downloadstationdata = function (station_name)
{
/* this function no more be used */

}
/* function for display station info on map */
Ext.application.prototype.onShowStationInfoOnMap = function (id, locale, station_name) {
var overlay;
        var f = selectlayers["Stations"].getFeaturesByAttribute("station_name", station_name);
        if (f && f[0])
        {

        selected_layer.removeAllFeatures();
                selected_layer.addFeatures([f[0]]);
                var url = '/' + locale + '/stations/mapshowinfo?name=' + station_name;
                var map = this.map;
                var conn = new Ext.data.Connection();
                conn.request({
        url : url,
                method : 'GET',
                success : function(responseObject) {
        createPopup(map, f[0], responseObject.responseText);
                },
                failure : function() {
        Ext.Msg.alert('Status', 'Unable	to show	station info.');
                }
        });
                }


}

/* function for searching all group info */
Ext.application.prototype.groupinfosearch = function () {

var bExist = false;
        var centerTabPanel = Ext.getCmp("center_region");
        centerTabPanel.items.each(function(el, ce, index) {
if ((el.title === "Group/School Info") && (bExist === false)) {
bExist = true;
        centerTabPanel.setActiveTab(ce);
        centerTabPanel.getActiveTab(ce).getUpdater().update({
url : '/' + locale + '/admin/groupschool'
        });
        }
});
        if (bExist === false) {
var item = centerTabPanel.add({
title : "Group/School Info",
        conaction : '123456',
        layout : 'fit',
        closable : true,
        autoScroll : true,
        autoLoad : {
url : '/' + locale + '/admin/groupschool',
        script : true
        }
});
        centerTabPanel.setActiveTab(parseInt(centerTabPanel.items.length) - 1);
        }

}


/* function for geo-coding */
Ext.application.prototype.location_search=function () {

var myMap = Ext.getCmp("googlemap");
        if (typeof myMap === 'object') {
if (myMap.getMap() !== null) {
var address_string = Ext.getCmp("address_lookup_text_id");
        if (typeof address_string === 'object') {
var address = address_string.getValue().replace(/^\s+|\s+$/, '');
        if (address !== '') {
if (!myMap.geocoder) {
myMap.geocoder = new GClientGeocoder();
        }
myMap.geocoder.getLocations(address, function(response) {
if (!response || response.Status.code !== 200) {
alert("The address " + address + " not found!");
        } else {
var place = response.Placemark[0];
        var point = new GLatLng(place.Point.coordinates[1], place.Point.coordinates[0]);
        if (position_marker !== null)
        myMap.getMap().removeOverlay(position_marker);
        position_marker = new GMarker(point, {
draggable : true
        });
        myMap.getMap().setCenter(point);
        //	if (myMap.getMap().getZoom() < 13)
        //		myMap.getMap().setZoom(13);
        myMap.getMap().addOverlay(position_marker);
        position_marker.setImage("http://maps.google.com/mapfiles/marker_greenL.png");
        position_marker.openInfoWindowHtml('Address:<br>' + place.address + '<br>Latitude:' + point.lat() + '<br>Longitude:' + point.lng() + '<br><a href="#" onclick="javascript:onZoomToHere(\'' + point.lat() + '\',\'' + point.lng() + '\')"	>Zoom To Here</a>');
        GEvent.clearListeners(position_marker, "dragstart");
        GEvent.clearListeners(position_marker, "dragend");
        GEvent.addListener(position_marker, "dragstart", function() {
myMap.getMap().closeInfoWindow();
        });
        GEvent.addListener(position_marker, "dragend", function() {
point = position_marker.getLatLng();
        position_marker.openInfoWindowHtml("<br>Latitude:" + point.lat() + "<br>Longitude:" + point.lng() + '<br><a href="#"	onclick="javascript:onZoomToHere(\'' + point.lat() + '\',\'' + point.lng() + '\')" >Zoom	To Here</a>');
        });
        }
});
        } else
        alert("address can not be empty!");
        }

}
}

};
        /* function for listing all stations of specific group */
        Ext.application.prototype.showschoolsite = function (station_name, groupname) {
var bExist = false;
        if (groupname === null || groupname === undefined)
        return;
        var centerPanel = Ext.getCmp('center_region');
        var bExist = false;
        centerPanel.items.each(function(el, ce, index) {
if ((el.title === "Group	Name:" + groupname) && (bExist === false)) {
bExist = true;
        centerPanel.setActiveTab(ce);
        var formPanel = centerPanel.getActiveTab(ce);
        formPanel.getUpdater().update({
url : '/' + locale + '/admin/groupdetails?groupname=' + groupname
        });
        }
});
        if (bExist === false) {

centerPanel.add({
id : 'groupsite_id_' + groupname,
        title : "Group Name:" + groupname,
        layout : 'fit',
        autoScroll : true,
        closable : true,
        autoLoad : {
url : '/' + locale + '/admin/groupdetails?groupname=' + groupname,
        script : true
        }
});
        centerPanel.setActiveTab(parseInt(centerPanel.items.length) - 1);
        }
}

/* function for station data download */
Ext.application.prototype.station_datadownload = function (station_name) {
var bExist = false;
        if (station_name === null || station_name === undefined)
        return;
        var centerPanel = Ext.getCmp('center_region');
        var bExist = false;
        centerPanel.items.each(function(el, ce, index) {
if ((el.title === "Station Data Download") && (bExist === false)) {
bExist = true;
        centerPanel.setActiveTab(ce);
        var iframe = centerPanel.getActiveTab(ce);
        iframe.items.items[0].src = '/' + locale + '/downloads/station?id=' + station_name;
        iframe.items.items[0].reload();
        }
});
        if (bExist === false) {
var panel = Ext.create('GeoExt.panel.SimpleIFrame', {border:false, src:'/downloads/station?id=' + station_name});
        centerPanel.add({
id : 'station_data_download_tabpanel_id',
        title : 'Station Data Download',
        layout : 'fit',
        closable : true,
        items : panel
        });
        centerPanel.setActiveTab(parseInt(centerPanel.items.length) - 1);
        }

};
        /* function data selection by date for creating report */
        Ext.application.prototype.sitereport_dateselection = function (station_name) {

var sitedescription_store = Ext.create('Ext.data.Store', {
proxy : {
type : 'ajax',
        url : '/' + locale + '/site_descriptions/datelist?id=' + station_name,
        method : 'GET',
        baseParams : {
tree : true
        },
        reader : {
type : 'json',
        root : 'data'
        }
},
        fields : ['id', 'sampling_date2'],
        root : 'data',
        id : 'id',
        autoLoad : {
scope : this,
        callback : function() {
var comboBox = Ext.getCmp("sitedescription_date_select_id");
        var store = comboBox.store;
        // set the value of the comboBox here
        if (store.getCount() > 0)
        comboBox.setValue(store.getAt(0).get('id'));
        }
}
});
        var benthic_store = Ext.create('Ext.data.Store', {
proxy : {
type : 'ajax',
        url : '/' + locale + '/benthics/datelist?id=' + station_name,
        method : 'GET',
        baseParams : {
tree : true
        },
        reader : {
type : 'json',
        root : 'data'
        }
},
        fields : ['id', 'sampling_date2'],
        root : 'data',
        id : 'id',
        autoLoad : {
scope : this,
        callback : function() {
var comboBox = Ext.getCmp("benthic_date_select_id");
        var store = comboBox.store;
        // set the value of the comboBox here
        if (store.getCount() > 0)
        comboBox.setValue(store.getAt(0).get('id'));
        }
}

});
        // benthic_store.setDefaultSort('sampling_date2','desc');
        var waterchemistry_store = Ext.create('Ext.data.Store', {
proxy : {
type : 'ajax',
        url : '/' + locale + '/water_chemistries/datelist?id=' + station_name,
        method : 'GET',
        baseParams : {
tree : true
        },
        reader : {
type : 'json',
        root : 'data'
        }
},
        fields : ['id', 'sampling_date2'],
        root : 'data',
        id : 'id',
        autoLoad : {
scope : this,
        callback : function() {
var comboBox = Ext.getCmp("waterchemistry_date_select_id");
        var store = comboBox.store;
        // set the value of the comboBox here
        if (store.getCount() > 0)
        comboBox.setValue(store.getAt(0).get('id'));
        }
}

});
        var benthic_comb = new Ext.form.ComboBox({
labelWidth : 210,
        boxMaxWidth : 160,
        border : true,
        triggerAction : 'all',
        valueField : 'id',
        id : 'benthic_date_select_id',
        name : 'benthic_date',
        fieldLabel : 'Benthic Sampling Date',
        forceSelection : true,
        store : benthic_store,
        mode : 'remote',
        value : 'test',
        displayField : 'sampling_date2'

        });
        var dateSelectPanel = Ext.create('Ext.form.FormPanel', {
width : 601,
        frame : false,
        labelWidth : 195,
        border : false,
        height : 380,
        id : 'dateselectpanel_id',
        items : [{
xtype : 'fieldset',
        title : 'Select Sampling Date	for	Creating Report:',
        width : 390,
        height : 137,
        defaults : {
labelWidth : 210,
        boxMaxWidth : 160,
        xtype : 'combo'
        },
        items : [{
border : true,
        queryMode : 'local',
        triggerAction : 'all',
        name : 'description_date',
        id : 'sitedescription_date_select_id',
        valueField : 'id',
        hiddenField : 'id',
        editable : false,
        fieldLabel : 'Site Description Sampling Date',
        forceSelection : true,
        store : sitedescription_store,
        mode : 'local',
        displayField : 'sampling_date2'
        }, benthic_comb, {
border : true,
        triggerAction : 'all',
        id : 'waterchemistry_date_select_id',
        valueField : 'id',
        name : 'waterchemistry_date',
        fieldLabel : 'Water Chemistry Sampling Date',
        forceSelection : true,
        store : waterchemistry_store,
        mode : 'local',
        displayField : 'sampling_date2'
}]

}],
        buttons : [{
text : 'OK',
        handler : function() {
if (report_dateselectwin !== null) {
var newwindow = window.open('/reports/station?id=' + station_name + '&description=' + Ext.getCmp("sitedescription_date_select_id").getValue() + '&benthic=' + Ext.getCmp('benthic_date_select_id').getValue() + '&waterchemistry=' + Ext.getCmp("waterchemistry_date_select_id").getValue(), '_blank', 'toolbar=yes');
        newwindow.focus();
        //newStationPanel.getForm().reset();
        }

}
}, {
text : 'Cancel',
        handler : function() {
if (report_dateselectwin !== null) {
report_dateselectwin.close();
        }
}
}]
        });
        var report_dateselectwin = new Ext.Window({
title : "Please Select Sampling Date",
        width : 405,
        modal : true,
        bodyStyle : 'padding:5px;',
        height : 190,
        layout : 'fit',
        closable : true,
        resizable : false,
        items : [dateSelectPanel]
        });
        report_dateselectwin.show();
        benthic_store.load();
        sitedescription_store.load();
        waterchemistry_store.load();
}

/* function for input site description data */
Ext.application.prototype.onSetSiteDescriptionData = function (descr_id, station_name, near_inter, municipality, minwidth, lat, lng, watershedname, varAction, authen) {
var frmTitle = "";
        if ((descr_id === undefined) || (descr_id === '') || descr_id === null) {
frmTitle = 'Input New Site Description Data';
        } else {
frmTitle = 'Update Site Description Data';
        }

var sitedescriptionstore;
        var sitedescriptionstore = Ext.data.StoreManager.lookup('site-description-details-gridpanel-formstore');
        if (sitedescriptionstore === undefined)
        {
        if ((descr_id === undefined) || (descr_id === '') || descr_id === null) {
        sitedescriptionstore = Ext.create('GeoExt.store.SiteDescriptionDetail',
                {storeId:'site-description-details-gridpanel-formstore',
                        proxy:{
                type:'ajax',
                        url:'/' + locale + '/site_description_details/itemdata',
                        method:'get',
                        params:{id:descr_id},
                        reader:{
                type:'json',
                        root:'data'
                        }
                }
                });
                }
        else
                {
                sitedescriptionstore = Ext.create('GeoExt.store.SiteDescriptionDetail',
                        {storeId:'site-description-details-gridpanel-formstore',
                                proxy:{
                        type:'ajax',
                                url:'/' + locale + '/site_description_details/itemdata',
                                method:'get',
                                reader:{
                        type:'json',
                                root:'data'
                                }
                        }
                        });
                        }
        }

var newdataCardPanel = Ext.create('GeoExt.view.SiteDescriptionform');
        var wform = Ext.getCmp("new_site_description_form_id");
        wform.getForm().findField("id").setValue(descr_id);
        wform.getForm().findField("station_name").setValue(station_name);
        wform.getForm().findField("watershed_name").setValue(watershedname);
        var newsiteinfoinputwin = new Ext.Window({
title : frmTitle,
        width : 760,
        modal : true,
        bodyStyle : 'padding:3px;',
        height : 545,
        layout : 'fit',
        closable : true,
        resizable : false,
        items : [newdataCardPanel]
        });
        newdataCardPanel.panelWindow = newsiteinfoinputwin;
        if ((descr_id === undefined) || (descr_id === '') || descr_id === null) {
newsiteinfoinputwin.show();
        } else {

newdataCardPanel.load({
url : '/' + locale + "/site_descriptions/itemdata",
        params : {
id : descr_id
        },
        method : 'POST',
        waitMsg : 'Geting Data ...',
        success : function() {
newsiteinfoinputwin.show();
        var id = Ext.getCmp("new_site_description_form_id").getForm().findField('id').getValue();
        if (id !== undefined && parseInt(id) > 0)

        var store = Ext.getCmp("site_description_details_form_id").child('gridpanel').store;
        store.load({params:{id:id}});
        Ext.getCmp("site_description_details_form_id").child('gridpanel').getStore().on("load", function(store, records) {

Ext.getCmp("site_description_details_form_id").child('gridpanel').getView().refresh();
        if (records && records[0]) {
Ext.getCmp("site_description_details_form_id").getForm().loadRecord(records[0]);
        }

});
        }
});
        }

}

/* function for input benthic data */
Ext.application.prototype.onSetBenthicData = function (benthic_id, station_name, varAction) {

var frmTitle = "";
        if ((benthic_id === undefined) || (benthic_id === '') || benthic_id === null) {
frmTitle = 'Input	New	Benthic	Sampling Data';
        } else {
frmTitle = 'Update Benthic Sampling Data';
        }

benthicsMainPanel = Ext.create("GeoExt.view.Benthicform");
        benthicsMainPanel.getForm().findField("id").setValue(benthic_id);
        benthicsMainPanel.getForm().findField("station_name").setValue(station_name);
        benthicsWin = new Ext.Window({
title : frmTitle,
        closable : true,
        resizable : false,
        width : 870,
        modal : true,
        height : 550,
        layout : 'fit',
        bodyStyle : 'padding:5px;',
        items : benthicsMainPanel
        });
        benthicsMainPanel.panelWindow = benthicsWin;
        if ((benthic_id === undefined) || (benthic_id === '') || benthic_id === null) {
benthicsWin.show();
        } else {

benthicsMainPanel.getForm().load({
url :  '/' + locale + "/benthics/itemdata",
        params : {
id : benthic_id
        },
        success : benthicsWin.show()
        });
        }

}

/* function for input water chemistry data */
Ext.application.prototype.onSetWaterchemistryData = function (waterchemistry_id, station_name, varAction) {

var frmTitle = "";
        if ((waterchemistry_id === undefined) || (waterchemistry_id === '') || waterchemistry_id === null) {
frmTitle = 'Input New Water Chemistry Sampling Data';
        } else {
frmTitle = 'Update Water Chemistry Sampling Data';
        }

waterchemistryPanel = Ext.create("GeoExt.view.WaterChemistryform");
        waterchemistryPanel.getForm().findField("id").setValue(waterchemistry_id);
        waterchemistryPanel.getForm().findField("station_name").setValue(station_name);
        waterchemistryWin = new Ext.Window({
title : frmTitle,
        closable : true,
        modal : true,
        resizable : false,
        width : 485,
        height : 520,
        layout : 'fit',
        bodyStyle : 'padding:5px;',
        items : waterchemistryPanel
        });
        if ((waterchemistry_id === undefined) || (waterchemistry_id === '') || waterchemistry_id === null) {
waterchemistryWin.show();
        } else {
waterchemistryPanel.load({
url : '/' + locale + "/water_chemistries/itemdata",
        params : {
id : waterchemistry_id
        },
        success : waterchemistryWin.show()
        });
        }
}
/* function for deleting station */
Ext.application.prototype.onDeleteStation = function (id, subwh_id) {
var conn = new Ext.data.Connection();
        conn.request({
url : '/' + locale + "/stations/destroy",
        method : 'POST',
        params : {
id : id
        },
        success : function(responseObject) {
var results = Ext.JSON.decode(responseObject.responseText);
        if (results.success === true) {

alert(results.message);
        var stationPanel = Ext.getCmp("station-list-panel");
        stationPanel.getRootNode().reload();
        var treePanel = Ext.getCmp("tree-panel");
        treePanel.getRootNode().cascade(function(rec) {
siteidname = rec.attributes.id.split("/");
        if (siteidname.length === 4 && parseInt(siteidname[3]) === id) {
rec.remove();
        }
});
        var myMap = Ext.getCmp("googlemap");
        for (var i = 0; i < gmarkers.length; i++) {

if (id === gmarkers[i].id) {
myMap.getMap().removeOverlay(gmarkers[i]);
        }
};
        } else {
alert(results.message);
        }

},
        failure : function() {
Ext.Msg.alert('Status', 'Unable	to delete the data at this time. Please	try	again later.');
        }
});
}
/* function for deleting site description data */
Ext.application.prototype.onDeleteSiteDescription = function (station_name, id) {
var conn = new Ext.data.Connection();
        conn.request({
url : '/' + locale + "/site_descriptions/destroy",
        method : 'POST',
        params : {
id : id
        },
        success : function(responseObject) {
var results = Ext.JSON.decode(responseObject.responseText);
        if (results.success === true) {
alert(results.message);
        var showdetails = Ext.getCmp("showdetailinfo_easttab_id");
        var detailPanel;
        if (showdetails && showdetails.ownerCt)
        detailPanel = showdetails.ownerCt;
        detailPanel.setActiveTab(showdetails);
        var url = Ext.getCmp("showdetailinfo_panel_id").autoLoad;
        var tab = detailPanel.getActiveTab();
        tab.removeAll();
        var panel = Ext.create('Ext.form.Panel', {
border : false,
        id : 'showdetailinfo_panel_id',
        autoScroll : true,
        style : 'padding:5px',
        autoLoad : url
        });
        tab.add(panel);
        } else {
alert(results.message);
        }

},
        failure : function() {
var results = Ext.JSON.decode(responseObject.responseText);
        if (results.success === false) {
alert(results.message);
        } else {
alert("gggg " + results.message);
        }

}
});
}

/* function for deleting benthic data */
Ext.application.prototype.onDeleteBenthic = function (station_name, id) {
var conn = new Ext.data.Connection();
        conn.request({
url : '/' + locale + "/benthics/destroy",
        method : 'POST',
        params : {
id : id
        },
        success : function(responseObject) {
var results = Ext.JSON.decode(responseObject.responseText);
        if (results.success === true) {
alert(results.message);
        var showdetails = Ext.getCmp("showdetailinfo_easttab_id");
        var detailPanel;
        if (showdetails && showdetails.ownerCt)
        detailPanel = showdetails.ownerCt;
        detailPanel.setActiveTab(showdetails);
        var url = Ext.getCmp("showdetailinfo_panel_id").autoLoad;
        var tab = detailPanel.getActiveTab();
        tab.removeAll();
        var panel = Ext.create('Ext.form.Panel', {
border : false,
        id : 'showdetailinfo_panel_id',
        autoScroll : true,
        style : 'padding:5px',
        autoLoad : url
        });
        tab.add(panel);
        } else {
alert(results.message);
        }

},
        failure : function() {
Ext.Msg.alert('Status', 'Unable	to delete the data at this time. Please	try	again later.');
        }
});
}
/* function for deleting wtaerchemistry data */
Ext.application.prototype.onDeleteWaterChemistry = function (station_name, id) {
var conn = new Ext.data.Connection();
        conn.request({
url : '/' + locale + "/water_chemistries/destroy",
        method : 'POST',
        params : {
id : id
        },
        success : function(responseObject) {
var results = Ext.JSON.decode(responseObject.responseText);
        if (results.success === true) {
alert(results.message);
        var showdetails = Ext.getCmp("showdetailinfo_easttab_id");
        var detailPanel;
        if (showdetails && showdetails.ownerCt)
        detailPanel = showdetails.ownerCt;
        detailPanel.setActiveTab(showdetails);
        var url = Ext.getCmp("showdetailinfo_panel_id").autoLoad;
        var tab = detailPanel.getActiveTab();
        tab.removeAll();
        var panel = Ext.create('Ext.form.Panel', {
border : false,
        id : 'showdetailinfo_panel_id',
        autoScroll : true,
        style : 'padding:5px',
        autoLoad : url
        });
        tab.add(panel);
        } else {
alert(results.message);
        }

},
        failure : function() {
Ext.Msg.alert('Status', 'Unable	to delete the data at this time. Please	try again later.');
        }
});
}

/* function for system to manage all site description's pictures */
Ext.application.prototype.Sitedescription_Pictures = function (sitedesc_id) {
var centerPanel = Ext.getCmp('center_region');
        var bExist = false;
        centerPanel.items.each(function(el, ce, index) {
if ((el.title === "Site Description Pictures") && (bExist == false)) {
bExist = true;
        centerPanel.setActiveTab(ce);
        var iframe = centerPanel.getActiveTab(ce);
        iframe.src = '/' + locale + '/sitepictures/index?sitedesc_id=' + sitedesc_id;
        iframe.items.items[0].setSrc('/' + locale + '/sitepictures/index?sitedesc_id=' + sitedesc_id);
        iframe.items.items[0].reload();
        }
});
        if (bExist === false) {
var panel = Ext.create('GeoExt.panel.SimpleIFrame', {
border : false,
        src : '/' + locale + '/sitepictures/index?id=' + sitedesc_id
        });
        centerPanel.add({
id : 'admin_sitedescription_picturers_id',
        title : 'Site Description Pictures',
        layout : 'fit',
        closable : true,
        items : panel
        });
        centerPanel.setActiveTab(parseInt(centerPanel.items.length) - 1);
        centerPanel.setActiveTab(0);
        centerPanel.setActiveTab(parseInt(centerPanel.items.length) - 1);
        }

}
/* function for system to manage all group names */
Ext.application.prototype.GroupnameManagment = function () {
var bExist = false;
        var centerPanel = Ext.getCmp("center_region");
        centerPanel.items.each(function(el, ce, index) {
if ((el.title === "Group Name Management") && (bExist === false)) {
bExist = true;
        centerPanel.setActiveTab(ce);
        var iframe = centerPanel.getActiveTab(ce);
        iframe.items.items[0].setSrc('/' + locale + '/groupnames');
        iframe.items.items[0].reload();
        }
});
        if (bExist === false) {
var panel = Ext.create('GeoExt.panel.SimpleIFrame', {
border : false,
        src : '/' + locale + '/groupnames'
        });
        centerPanel.add({
id : 'admin_groupnamemanagement_id',
        title : 'Group Name Management',
        layout : 'fit',
        closable : true,
        items : panel
        });
        centerPanel.setActiveTab(parseInt(centerPanel.items.length) - 1);
        centerPanel.setActiveTab(0);
        centerPanel.setActiveTab(parseInt(centerPanel.items.length) - 1);
        }
}

/* function for system to manage all subwatershed, not include polygons of subwatershed*/
Ext.application.prototype.SubwatershedManagement = function () {
var bExist = false;
        var centerPanel = Ext.getCmp("center_region");
        centerPanel.items.each(function(el, ce, index) {
if ((el.title === "Subwatershed Management") && (bExist === false)) {
bExist = true;
        centerPanel.setActiveTab(ce);
        var iframe = centerPanel.getActiveTab(ce);
        iframe.items.items[0].setSrc('/' + locale + '/subwatersheds/');
        iframe.items.items[0].reload();
        }
});
        if (bExist === false) {

var panel = Ext.create('GeoExt.panel.SimpleIFrame', {
border : false,
        src : '/' + locale + '/subwatersheds/'
        });
        centerPanel.add({
id : 'admin_subwatershed_management_id',
        title : 'Subwatershed Management',
        layout : 'fit',
        closable : true,
        items : panel
        });
        centerPanel.setActiveTab(parseInt(centerPanel.items.length) - 1);
        centerPanel.setActiveTab(0);
        centerPanel.setActiveTab(parseInt(centerPanel.items.length) - 1);
        }

}
/* function for system to manage all watershed, not include polygons of watershed*/
Ext.application.prototype.WatershedManagement = function () {

var bExist = false;
        var centerPanel = Ext.getCmp("center_region");
        centerPanel.items.each(function(el, ce, index) {
if ((el.title === "Watershed Management") && (bExist === false)) {
bExist = true;
        centerPanel.setActiveTab(ce);
        var iframe = centerPanel.getActiveTab(ce);
        iframe.items.items[0].setSrc('/' + locale + '/watersheds/');
        iframe.items.items[0].reload();
        }
});
        if (bExist === false) {

var panel = Ext.create('GeoExt.panel.SimpleIFrame', {
border : false,
        src : '/' + locale + '/watersheds/'
        });
        centerPanel.add({
id : 'admin_watershed_management_id',
        title : 'Watershed Management',
        layout : 'fit',
        closable : true,
        items : panel
        });
        centerPanel.setActiveTab(parseInt(centerPanel.items.length) - 1);
        centerPanel.setActiveTab(0);
        centerPanel.setActiveTab(parseInt(centerPanel.items.length) - 1);
        }

}

/* function for recalculate benthic data over all assessment */
Ext.application.prototype.ReCalculateOverallAssessment = function () {
var conn = new Ext.data.Connection();
        conn.request({
url : '/' + locale + "/benthics/re_calculate_benthic",
        method : 'POST',
        success : function(responseObject) {
var results = Ext.JSON.decode(responseObject.responseText);
        if (results.success === true) {
alert(results.message);
        } else {
alert(results.message);
        }

},
        failure : function() {
Ext.Msg.alert('Status', 'Unable	to re-calculate	overall	accessment at this time. Please	try	again later.');
        }
});
}
/* function for system to manage system and database backup */
Ext.application.prototype.SystemBackup = function () {

var bExist = false;
        var centerPanel = Ext.getCmp("center_region");
        centerPanel.items.each(function(el, ce, index) {
if ((el.title === "System Backup") && (bExist === false)) {
bExist = true;
        centerPanel.setActiveTab(ce);
        var iframe = centerPanel.getActiveTab(ce);
        iframe.items.items[0].setSrc('/' + locale + '/admin/systembackup');
        iframe.items.items[0].reload();
        }
});
        if (bExist === false) {

var panel = Ext.create('GeoExt.panel.SimpleIFrame', {
border : false,
        src : '/' + locale + '/admin/systembackup'
        });
        centerPanel.add({
id : 'admin_system_backu2p_id',
        title : 'System	Backup',
        layout : 'fit',
        closable : true,
        items : panel
        });
        centerPanel.setActiveTab(parseInt(centerPanel.items.length) - 1);
        centerPanel.setActiveTab(0);
        centerPanel.setActiveTab(parseInt(centerPanel.items.length) - 1);
        }
}

/* function for system to manage subwatersheds polygons */
Ext.application.prototype.SystemWaterhsedsPolygons = function () {

var bExist = false;
        var centerPanel = Ext.getCmp("center_region");
        centerPanel.items.each(function(el, ce, index) {
if ((el.title === "Upload Watersheds Polygons") && (bExist === false)) {
bExist = true;
        centerPanel.setActiveTab(ce);
        var iframe = centerPanel.getActiveTab(ce);
        iframe.items.items[0].setSrc('/' + locale + '/admin/watershedspolygons');
        iframe.items.items[0].reload();
        }
});
        if (bExist === false) {

var panel = Ext.create('GeoExt.panel.SimpleIFrame', {
border : false,
        src : '/' + locale + '/admin/watershedspolygons'
        });
        centerPanel.add({
id : 'admin_watersheds_polygons_id',
        title : 'Upload Watersheds Polygons',
        layout : 'fit',
        closable : true,
        items : panel
        });
        centerPanel.setActiveTab(parseInt(centerPanel.items.length) - 1);
        centerPanel.setActiveTab(0);
        centerPanel.setActiveTab(parseInt(centerPanel.items.length) - 1);
        }

}

/* function for system to manage subwatersheds polygons */
Ext.application.prototype.SystemSubwaterhsedsPolygons = function () {

var bExist = false;
        var centerPanel = Ext.getCmp("center_region");
        centerPanel.items.each(function(el, ce, index) {
if ((el.title === "Upload Subwatersheds Polygons") && (bExist === false)) {
bExist = true;
        centerPanel.setActiveTab(ce);
        var iframe = centerPanel.getActiveTab(ce);
        iframe.items.items[0].setSrc('/' + locale + '/admin/subwatershedspolygons');
        iframe.items.items[0].reload();
        }
});
        if (bExist === false) {

var panel = Ext.create('GeoExt.panel.SimpleIFrame', {
border : false,
        src : '/' + locale + '/admin/subwatershedspolygons'
        });
        centerPanel.add({
id : 'admin_subwatersheds_polygons_id',
        title : 'Upload Subwatersheds Polygons',
        layout : 'fit',
        closable : true,
        items : panel
        });
        centerPanel.setActiveTab(parseInt(centerPanel.items.length) - 1);
        centerPanel.setActiveTab(0);
        centerPanel.setActiveTab(parseInt(centerPanel.items.length) - 1);
        }

}


/* function for creating popup window to show some message */
Ext.application.prototype.createPopup = function (map, feature, htmlcontent)
{
if (feature === undefined || feature === null)
        return;
        var title = "";
        if (feature.attributes.watershed_name)
        title = feature.attributes.watershed_name;
        if (feature.attributes.subwatershed_name)
        title = feature.attributes.subwatershed_name;
        if (feature.attributes.watershed_name)
        title = feature.attributes.station_name;
        if (popup)
        popup.close();
        popup = Ext.create('GeoExt.window.Popup', {
title:title,
        location:feature,
        width:330,
        map:map,
        height:295,
        html:htmlcontent,
        collapsible:false,
        maximizable:false,
        anchorPosition:'auto',
        listeners:{
close:function() {
popup = null;
}
}
});
        popup.on({
close:function(){
if (OpenLayers.Util.indexOf(selected_layer.selectedFeatures, this.feature) > - 1)
{
selectCtrl.unselect(this.feature);
}

}
});
        popup.show();
}

/* hide and show features for flashing feature */
Ext.application.prototype.FlashFeatures = function ()
{
if (e === undefined)
        return;
        if (e.getVisibility() === true)
        e.setVisibility(false);
        else
        e.setVisibility(true);
}
/* show user profile in  center region tab */
Ext.application.prototype.UserProfile = function (id) {

var bExist = false;
        var centerPanel = Ext.getCmp("center_region");
        centerPanel.items.each(function(el, ce, index) {
if ((el.title === "User Profile") && (bExist === false)) {
bExist = true;
        centerPanel.setActiveTab(ce);
        var iframe = centerPanel.getActiveTab(ce);
        iframe.items.items[0].setSrc('/' + locale + '/admin/userprofile?id=' + id);
        iframe.items.items[0].reload();
        }
});
        if (bExist === false) {

var panel = Ext.create('GeoExt.panel.SimpleIFrame', {
border : false,
        src : '/' + locale + '/admin/userprofile?id=' + id
        });
        centerPanel.add({
id : 'admin_system_userprofile_id',
        title : 'User Profile',
        layout : 'fit',
        closable : true,
        items : panel
        });
        centerPanel.setActiveTab(parseInt(centerPanel.items.length) - 1);
        }

}
/* show system parameters in center region tab */
Ext.application.prototype.SystemParams = function () {

var bExist = false;
        var centerPanel = Ext.getCmp("center_region");
        centerPanel.items.each(function(el, ce, index) {
if ((el.title === "System Parameters") && (bExist === false)) {
bExist = true;
        centerPanel.setActiveTab(ce);
        var iframe = centerPanel.getActiveTab(ce);
        iframe.items.items[0].setSrc('/' + locale + '/admin/systemparams');
        iframe.items.items[0].reload();
        }
});
        if (bExist === false) {

var panel = Ext.create('GeoExt.panel.SimpleIFrame', {
border : false,
        src : '/' + locale + '/admin/systemparams'
        });
        centerPanel.add({
id : 'admin_system_params_id',
        title : 'System Parameters',
        layout : 'fit',
        closable : true,
        items : panel
        });
        centerPanel.setActiveTab(parseInt(centerPanel.items.length) - 1);
        }

}
