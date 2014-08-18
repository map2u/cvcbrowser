/**
 * The store used for summits
 */
Ext.define('GeoExt.store.ReportSiteDescriptionDate', {
    extend: 'Ext.data.Store',
    model: 'GeoExt.model.ReportSiteDescriptionDate',
    proxy:{
        type:'ajax',
        url:'/en/sitedescriptions/samplingdate',
        reader:{
          type:'json',
          root:'data'
        }
    },
    autoLoad: false
});
