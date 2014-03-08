/**
 * The grid in which summits are displayed
 * @extends Ext.grid.Panel
 */
Ext.define('GeoExt.grid.Watersheds' ,{
    extend: 'Ext.grid.Panel',
   // alias : 'widget.watershedsgrid',
    requires: [
        'GeoExt.selection.FeatureModel',
        'GeoExt.grid.column.Symbolizer',
        'Ext.grid.plugin.CellEditing',
	'Ext.grid.Panel',
        'Ext.form.field.Number'
    ],

    initComponent: function() {
        Ext.apply(this, {
            border: false,
            columns: [
                {
                    header: '',
                    dataIndex: 'symbolizer',
                    menuDisabled: true,
                    sortable: false,
                    xtype: 'gx_symbolizercolumn',
                    width: 30
                },
                {header: 'ID', dataIndex: 'fid', width: 40},
                {header: 'Name', dataIndex: 'name', flex: 4},
                {header: 'Created_at', dataIndex: 'created_at', flex: 3},
                {header: 'Description', dataIndex: 'description', flex: 2}
            ],
            flex: 1,
       //     store: 'Watersheds',
            selType: 'featuremodel',
            plugins: [
                Ext.create('Ext.grid.plugin.CellEditing', {
                    clicksToEdit: 2
                })
            ]
        });
        this.callParent(arguments);
        // store singleton selection model instance
        GeoExt.grid.Watersheds.selectionModel = this.getSelectionModel();
    }
});
