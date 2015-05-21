/**
 * The store used for summits
 */
Ext.define('GeoExt.store.ReportBenthicsDate', {
    extend: 'Ext.data.Store',
    model: 'GeoExt.model.ReportBenthicsDate',
    proxy:{
        type:'ajax',
        url:'/en/benthics/samplingdate',
        reader:{
          type:'json',
          root:'data'
        }
    },
    autoLoad: false
});
