/**
 * The store used for summits
 */
Ext.define('GeoExt.store.Subwatersheds', {
    extend: 'Ext.data.Store',
//    extend: 'GeoExt.data.FeatureStore',
    model: 'GeoExt.model.Subwatershed',
    proxy:{
        type:'ajax',
        url:'/en/subwatersheds/griddata',
        reader:{
          type:'json',
          root:'subwatersheds'
        }
    },
    autoLoad: false
});
