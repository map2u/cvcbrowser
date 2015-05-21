/**
 * The store used for summits
 */
Ext.define('GeoExt.store.Benthic', {
    extend: 'Ext.data.Store',
    model: 'GeoExt.model.Benthic',
    proxy:{
        type:'ajax',
        url:'/en/benthics/newdata',
        reader:{
          type:'json',
          root:'data'
        }
    },
    autoLoad: false
});
