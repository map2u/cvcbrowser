/**
 * Model for a summit
 */
Ext.define('GeoExt.model.Station', {
    extend: 'Ext.data.Model',
        fields: [ 
	/*	{
		    name: 'symbolizer',
		    convert: function(v, r) {
			if(r && r.raw && r.raw.layer instanceof OpenLayers.Layer)
			        return r.raw.layer.styleMap.createSymbolizer(r.raw, 'default');
			else
				return 'error';
		    }
		},*/

	/*	{
		    name: 'fid',
		    convert: function(value, record) {
		        // record.raw a OpenLayers.Feature.Vector instance
		        if (record.raw instanceof OpenLayers.Feature.Vector) {
		            return record.raw.fid;
		        } else {
		            return "This is not a Feature";
		        }
		    }
		},*/

		{name: "id", type: "int"}, 
		{name: "name", type: "string"}, 
		{
		    name: 'lat',
		    convert: function(value, record) {
		        // record.raw a OpenLayers.Feature.Vector instance
		        if (record.raw instanceof OpenLayers.Feature.Vector &&
		            record.raw.geometry instanceof OpenLayers.Geometry.Point) {
		            return record.raw.geometry.y;
		        } else {
		            return "This is not a Feature or geometry is wrong type";
		        }
		    }
		},
		{
		    name: 'lon',
		    convert: function(value, record) {
		        // record.raw a OpenLayers.Feature.Vector instance
		        if (record.raw instanceof OpenLayers.Feature.Vector) {
		            return record.raw.geometry.x;
		        } else {
		            return "This is not a Feature or geometry is wrong type";
		        }
		    }
		},
		{name: "watershed", type: "string"}, 
		{name: "subwatershed", type: "string"}, 
		{name: "created_at", type: "date"} ,
		{name: "updated_at", type: "date"} 
        ]

});

