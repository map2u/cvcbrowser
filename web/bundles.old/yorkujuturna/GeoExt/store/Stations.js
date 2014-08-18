/**
 * The store used for summits
 */
Ext.define('GeoExt.store.Stations', {
    extend: 'Ext.data.Store',
//    extend: 'GeoExt.data.FeatureStore',
    model: 'GeoExt.model.Station',
    proxy:{
        type:'ajax',
        url:'/en/stations/griddata',
        reader:{
          type:'json',
          root:'stations'
        }
    },
    autoLoad: false
});
