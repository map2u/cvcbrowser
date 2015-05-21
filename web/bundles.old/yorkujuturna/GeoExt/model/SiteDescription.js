/**
 * Model for a SiteDescription
 */
Ext.define('GeoExt.model.SiteDescription', {
    	extend: 'Ext.data.Model',
        fields: [ 
            {name: "id", type: "int"}, 
            {name: "station", type: "string"}, 
            {name: "watershed", type: "string"}, 
            {name: "sampling_date", type: "date"}, 
            {name: "site_length", type: "float"}, 
            {name: "min_width", type: "float"}, 
            {name: "number_of_transects", type: "int"}, 
            {name: "upstream_photo", type: "string"}, 
            {name: "downstream_photo", type: "string"}, 
            {name: "sketch", type: "string"}, 
            {name: "user", type: "string"}, 
            {name: "created_at", type: "date"} ,
            {name: "updated_at", type: "date"} 
        ]

});
