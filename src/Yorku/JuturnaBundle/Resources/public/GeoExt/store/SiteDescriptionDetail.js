/**
 * The store used for summits
 */
Ext.define('GeoExt.store.SiteDescriptionDetail', {
    extend: 'Ext.data.Store',
//    extend: 'GeoExt.data.FeatureStore',
    model: 'GeoExt.model.SiteDescriptionDetail',
    proxy:{
        type:'ajax',
        url:'/en/site_description_details/itemdata',
        
	method:'get',
        reader:{
          type:'json',
          root:'data'
        }
    },
    autoLoad: false
});
