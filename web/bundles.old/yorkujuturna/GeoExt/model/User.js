/**
 * Model for a summit
 */
Ext.define('GeoExt.model.User', {
    extend: 'Ext.data.Model',
        fields: [ 
		{name:'id',type:'integer'},
		{name:'username',type:'string'},
		{name:'first_name',type:'string'},
		{name:'last_name',type:'string'},
		{name:'email',type:'string'},
		{name:'phone_number',type:'string'},
		{name:'reason',type:'string'},
		{name:'address',type:'string'},
		{name:'postal_code',type:'string'},
		{name:'created_at',type:'datetime'},
		{name:'updated_at',type:'datetime'},
		{name:'status',type:'string'},
		{name:'reason',type:'string'},
		{name:'groupname_id',type:'int'},
		{name:'role_id',type:'int'}
        ]
});
