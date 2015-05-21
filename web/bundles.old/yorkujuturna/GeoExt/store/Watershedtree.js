/**
 * The store used for summits
 */
Ext.define('GeoExt.store.Watershedtree', {
    extend: 'Ext.data.TreeStore',
//    extend: 'GeoExt.data.FeatureStore',
    model: 'GeoExt.model.Watershedtree',
    proxy:{
        type:'ajax',
        url:'/en/watersheds/treelist',
        reader:{
          type:'json',
          root:'data'
        }
    },
    autoLoad: false
});
