/**
 * The store used for summits
 */
Ext.define('GeoExt.store.User', {
    extend: 'Ext.data.Store',
//    extend: 'GeoExt.data.FeatureStore',
    model: 'GeoExt.model.User',
    proxy:{
        type:'ajax',
        url:'/en/users',
	method:'get',
        reader:{
          type:'json',
          root:'data'
        }
    },
    autoLoad: false
});
