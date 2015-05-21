/**
 * Model for a summit
 */
Ext.define('GeoExt.model.Watershed', {
    extend: 'Ext.data.Model',
/*    fields: [
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
 ]*/
        fields: [ 
            {name: "id", type: "int"}, 
            {name: "watershed_name", type: "string"}, 
            {name: "watershed_letter_id", type: "string"}, 
            {name: "description", type: "string"}, 
            {name: "created_at", type: "date",dateFormat: 'Y-m-d H:i:s'} ,
            {name: "updated_at", type: "date",dateFormat: 'Y-m-d H:i:s'} 
        ]

});
