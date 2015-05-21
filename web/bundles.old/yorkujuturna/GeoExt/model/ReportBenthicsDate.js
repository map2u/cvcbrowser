/**
 * Model for a select report date of benthics
 */
Ext.define('GeoExt.model.ReportBenthicsDate', {
    extend: 'Ext.data.Model',
        fields: [ 
            {name: "id", type: "int"}, 
            {name: "sampling_date", type: "date"}
        ]
});
