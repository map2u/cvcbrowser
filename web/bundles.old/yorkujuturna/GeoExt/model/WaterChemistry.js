/**
 * Model for a SiteDescriptionDetail
 */
Ext.define('GeoExt.model.WaterChemistry', {
    	extend: 'Ext.data.Model',
        fields: [ 
            {name: "id", type: "int"}, 
            {name: "sampling_date", type: "date"}, 
            {name: "ph_level", type: "float"}, 
            {name: "ph_inst_name", type: "string"}, 
            {name: "ph_inst_mod", type: "string"}, 
            {name: "water_temperature", type: "float"}, 
            {name: "water_temp_inst_name", type: "string"}, 
            {name: "water_temp_inst_mod", type: "string"}, 
            {name: "dissolved_oxygen", type: "float"}, 
            {name: "dissolved_oxygen_inst_name", type: "string"}, 
            {name: "dissolved_oxygen_inst_mod", type: "string"}, 
            {name: "conductivity", type: "float"}, 
            {name: "conductivity_inst_name", type: "string"}, 
            {name: "conductivity_inst_mod", type: "string"}, 
            {name: "user_id", type: "int"}, 
            {name: "station_id", type: "int"}, 
            {name: "groupname_id", type: "int"}, 
            {name: "created_at", type: "date"} ,
            {name: "updated_at", type: "date"} 
        ]

});
