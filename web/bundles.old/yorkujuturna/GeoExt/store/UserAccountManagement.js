/**
 * The store used for summits
 */
Ext.define('GeoExt.store.UserAccountManagement', {
    extend: 'Ext.data.Store',
//    extend: 'GeoExt.data.FeatureStore',
    model: 'GeoExt.model.User',
    proxy:{
        type:'ajax',
        url:'/' + Ext.locale +'/users',
	actionMethods:{
		create:'POST',
		read:'GET',
		update:'POST',
		destroy:'POST'
	},
        reader:{
          type:'json',
          root:'data'
        },
        writer:{
          type:'json',
          root:'data'
	}
    },
    autoLoad: false
});
