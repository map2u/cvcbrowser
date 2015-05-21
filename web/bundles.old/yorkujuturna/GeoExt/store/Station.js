/**
 * The store used for summits
 */
Ext.define('GeoExt.store.Station', {
    extend: 'Ext.data.Store',
//    extend: 'GeoExt.data.FeatureStore',
    model: 'GeoExt.model.Station',
    proxy:{
        type:'ajax',
        url:'/en/stations/newstation',
        reader:{
          type:'json',
          root:'station'
        }
    },
    autoLoad: false
});
