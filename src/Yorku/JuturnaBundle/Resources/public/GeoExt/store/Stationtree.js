/**
 * The store used for summits
 */
Ext.define('GeoExt.store.Stationtree', {
    extend: 'Ext.data.TreeStore',
    model: 'GeoExt.model.Stationtree',
    proxy:{
        type:'ajax',
        url:'/en/stations/treelist',
        reader:{
          type:'json',
          root:'data'
        }
    },
    autoLoad: false
});
