/**
 * The store used for summits
 */
Ext.define('GeoExt.store.SiteDescription', {
    extend: 'Ext.data.Store',
//    extend: 'GeoExt.data.FeatureStore',
    model: 'GeoExt.model.SiteDescription',
    proxy:{
        type:'ajax',
        url:'/en/site_descriptions',
	method:'get',
        reader:{
          type:'json',
          root:'data'
        }
    },
    autoLoad: false
});
