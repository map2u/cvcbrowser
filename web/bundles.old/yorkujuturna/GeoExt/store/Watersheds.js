/**
 * The store used for summits
 */
Ext.define('GeoExt.store.Watersheds', {
    extend: 'Ext.data.Store',
//    extend: 'GeoExt.data.FeatureStore',
    model: 'GeoExt.model.Watershed',
    proxy:{
        type:'ajax',
        url:'/en/watersheds/griddata',
        reader:{
          type:'json',
          root:'watersheds'
        }
    },
    autoLoad: false
});
