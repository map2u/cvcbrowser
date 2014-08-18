/**
 * The store used for summits
 */
Ext.define('GeoExt.store.WaterChemistry', {
    extend: 'Ext.data.Store',
//    extend: 'GeoExt.data.FeatureStore',
    model: 'GeoExt.model.WaterChemistry',
    proxy:{
        type:'ajax',
        url:'/en/water_chemistries/newdata',
        reader:{
          type:'json',
          root:'data'
        }
    },
    autoLoad: false
});
