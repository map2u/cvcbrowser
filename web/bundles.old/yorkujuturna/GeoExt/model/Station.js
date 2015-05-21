/**
 * Model for a summit
 */
Ext.define('GeoExt.model.Station', {
    extend: 'Ext.data.Model',
  /*  fields: [
        {
            name: 'symbolizer',
            convert: function(v, r) {
                return r.raw.layer.styleMap.createSymbolizer(r.raw, 'default');
            }
        },
        {
            name: 'fid',
            convert: function(value, record) {
                // record.raw a OpenLayers.Feature.Vector instance
                if (record.raw instanceof OpenLayers.Feature.Vector) {
                    return record.raw.fid;
                } else {
                    return "This is not a Feature";
                }
            }
        },
        {
            name: 'title',
            convert: function(value, record) {
                return record.get("name") + " - " + record.get("created_at");
            }
        },
        {name: 'name', type: 'string'}

  nearest_intersection text,
  location_description text,
  municipality character varying(40),
  watershed_id integer NOT NULL,
  subwatershed_id integer NOT NULL,
  the_geom geometry,
  "name" character varying(40),
  created_at timestamp without time zone,
  updated_at timestamp without time zone,
  user_id integer,
  overall_assessment character varying(20),



 ]*/
        fields: [ 
            {name: "id", type: "int"}, 
            {name: "station_name", type: "string"}, 
            {name: "watershed_name", type: "string"}, 
            {name: "subwatershed_name", type: "string"}, 
            {name: "watershed_id", type: "int"}, 
            {name: "subwatershed_id", type: "int"}, 
            {name: "user_id", type: "int"}, 
	    {name: "nearest_intersection",type:"string"},
  	    {name: "location_description",type:"string"},
  	    {name: "municipality",type:"string"},
  	    {name: "lat",type:"float"},
  	    {name: "lng",type:"float"},
            {name: "created_at", type: "date",dateFormat: 'Y-m-d H:i:s'} ,
            {name: "updated_at", type: "date",dateFormat: 'Y-m-d H:i:s'} 
        ]

});
