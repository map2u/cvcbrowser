/**
 * Model for a summit
 */
Ext.define('GeoExt.model.Stationree', {
    extend: 'Ext.data.Model',
        fields: [ 
            {name: "id", type: "string"}, 
            {name: "text", type: "string"},
            {name: "leaf", type: "string"},
            {name: "cls", type: "string"},
        ]

});
