/**
 * Model for a SiteDescriptionDetail
 */
Ext.define('GeoExt.model.SiteDescriptionDetail', {
    	extend: 'Ext.data.Model',
        fields: [ 
            {name: "id", type: "int"}, 
            {name: "site_description_id", type: "int"}, 
            {name: "trails", type: "boolean"}, 
            {name: "min_wetted_width", type: "float"}, 
            {name: "wetted_width", type: "float"}, 
            {name: "substrated_condition", type: "string"}, 
            {name: "o_canopy", type: "string"}, 
            {name: "silt", type: "boolean"}, 
            {name: "pebble", type: "boolean"}, 
            {name: "gravel", type: "boolean"}, 
            {name: "cobble", type: "boolean"}, 
            {name: "boulder", type: "boolean"}, 
            {name: "dom_veg_none", type: "string"}, 
            {name: "dom_veg_cultivated", type: "string"}, 
            {name: "dom_veg_meadow", type: "string"}, 
            {name: "dom_veg_scrub", type: "string"}, 
            {name: "dom_veg_forest", type: "string"}, 
            {name: "created_at", type: "date"} ,
            {name: "updated_at", type: "date"} 
        ]

});
