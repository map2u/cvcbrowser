/**
 * Model for a SiteDescriptionDetail
 */
Ext.define('GeoExt.model.Benthic', {
    	extend: 'Ext.data.Model',
        fields: [ 
            {name: "id", type: "int"}, 
            {name: "sampling_date", type: "date"}, 
            {name: "amp", type: "int"}, 
            {name: "ani", type: "int"}, 
            {name: "cer", type: "int"}, 
            {name: "chi", type: "int"}, 

            {name: "coe", type: "int"}, 
            {name: "bee", type: "int"}, 
            {name: "cuc", type: "int"}, 
            {name: "mis", type: "int"}, 

            {name: "eph", type: "int"}, 
            {name: "gas", type: "int"}, 
            {name: "hem", type: "int"}, 
            {name: "hir", type: "int"}, 

            {name: "dec", type: "int"}, 
            {name: "iso", type: "int"}, 
            {name: "lep", type: "int"}, 
            {name: "meg", type: "int"}, 

            {name: "nem", type: "int"}, 
            {name: "oli", type: "int"}, 
            {name: "pel", type: "int"}, 
            {name: "ple", type: "int"}, 

            {name: "sim", type: "int"}, 
            {name: "tab", type: "int"}, 
            {name: "tip", type: "int"}, 
            {name: "tri", type: "int"}, 

            {name: "tro", type: "int"}, 
            {name: "tur", type: "int"}, 
            {name: "zyg", type: "int"}, 
            {name: "aca", type: "int"}, 

            {name: "col", type: "int"}, 
            {name: "dip", type: "int"}, 
            {name: "pal", type: "int"}, 
            {name: "tba", type: "int"}, 

            {name: "tub", type: "int"}, 
            {name: "uniden", type: "int"}, 
            {name: "groupname_id", type: "int"}, 
            {name: "station_name", type: "string"}, 

            {name: "location_of_identification", type: "string"}, 
            {name: "condition_of_sample", type: "string"}, 
            {name: "assisted_observation", type: "string"}, 
            {name: "collection_method", type: "string"}, 
            {name: "collection_method_desc", type: "string"}, 
            {name: "created_at", type: "date"}, 
            {name: "updated_at", type: "date"}, 
            {name: "groupname_id", type: "int"}, 
            {name: "created_at", type: "date"} ,
            {name: "updated_at", type: "date"} 
       ]
});
