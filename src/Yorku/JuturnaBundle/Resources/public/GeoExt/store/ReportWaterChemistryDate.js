/**
 * The store used for summits
 */
Ext.define('GeoExt.store.ReportWaterChemistryDate', {
    extend: 'Ext.data.Store',
    model: 'GeoExt.model.ReportWaterChemistryDate',
    proxy:{
        type:'ajax',
        url:'/en/water_chemistries/samplingdate',
        reader:{
          type:'json',
          root:'data'
        }
    },
    autoLoad: false
});
