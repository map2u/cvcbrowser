/*

This file is part of Ext JS 4

Copyright (c) 2011 Sencha Inc

Contact:  http://www.sencha.com/contact

GNU General Public License Usage
This file may be used under the terms of the GNU General Public License version 3.0 as published by the Free Software Foundation and appearing in the file LICENSE included in the packaging of this file.  Please review the following information to ensure the GNU General Public License version 3.0 requirements will be met: http://www.gnu.org/copyleft/gpl.html.

If you are unsure which license is appropriate for your use, please contact the sales department at http://www.sencha.com/contact.

*/
Ext.require([
    'Ext.form.*',
    'Ext.data.*',
    'Ext.grid.Panel',
    'Ext.layout.container.Column'
]);


Ext.onReady(function(){

    Ext.QuickTips.init();

    var bd = Ext.getBody();

    // sample static data for the store
    var myData = [
        ['3m Co',                               71.72, 0.02,  0.03,  '9/1 12:00am'],
        ['Alcoa Inc',                           29.01, 0.42,  1.47,  '9/1 12:00am'],
        ['Altria Group Inc',                    83.81, 0.28,  0.34,  '9/1 12:00am'],
        ['American Express Company',            52.55, 0.01,  0.02,  '9/1 12:00am'],
        ['American International Group, Inc.',  64.13, 0.31,  0.49,  '9/1 12:00am'],
        ['AT&T Inc.',                           31.61, -0.48, -1.54, '9/1 12:00am'],
        ['Boeing Co.',                          75.43, 0.53,  0.71,  '9/1 12:00am'],
        ['Caterpillar Inc.',                    67.27, 0.92,  1.39,  '9/1 12:00am'],
        ['Citigroup, Inc.',                     49.37, 0.02,  0.04,  '9/1 12:00am'],
        ['E.I. du Pont de Nemours and Company', 40.48, 0.51,  1.28,  '9/1 12:00am'],
        ['Exxon Mobil Corp',                    68.1,  -0.43, -0.64, '9/1 12:00am'],
        ['General Electric Company',            34.14, -0.08, -0.23, '9/1 12:00am'],
        ['General Motors Corporation',          30.27, 1.09,  3.74,  '9/1 12:00am'],
        ['Hewlett-Packard Co.',                 36.53, -0.03, -0.08, '9/1 12:00am'],
        ['Honeywell Intl Inc',                  38.77, 0.05,  0.13,  '9/1 12:00am'],
        ['Intel Corporation',                   19.88, 0.31,  1.58,  '9/1 12:00am'],
        ['International Business Machines',     81.41, 0.44,  0.54,  '9/1 12:00am'],
        ['Johnson & Johnson',                   64.72, 0.06,  0.09,  '9/1 12:00am'],
        ['JP Morgan & Chase & Co',              45.73, 0.07,  0.15,  '9/1 12:00am'],
        ['McDonald\'s Corporation',             36.76, 0.86,  2.40,  '9/1 12:00am'],
        ['Merck & Co., Inc.',                   40.96, 0.41,  1.01,  '9/1 12:00am'],
        ['Microsoft Corporation',               25.84, 0.14,  0.54,  '9/1 12:00am'],
        ['Pfizer Inc',                          27.96, 0.4,   1.45,  '9/1 12:00am'],
        ['The Coca-Cola Company',               45.07, 0.26,  0.58,  '9/1 12:00am'],
        ['The Home Depot, Inc.',                34.64, 0.35,  1.02,  '9/1 12:00am'],
        ['The Procter & Gamble Company',        61.91, 0.01,  0.02,  '9/1 12:00am'],
        ['United Technologies Corporation',     63.26, 0.55,  0.88,  '9/1 12:00am'],
        ['Verizon Communications',              35.57, 0.39,  1.11,  '9/1 12:00am'],
        ['Wal-Mart Stores, Inc.',               45.45, 0.73,  1.63,  '9/1 12:00am']
    ];

     Ext.regModel('User',{fields:[
				{name:'id',type:'integer'},
				{name:'login',type:'string'},
				{name:'first_name',type:'string'},
				{name:'last_name',type:'string'},
				{name:'email',type:'string'},
				{name:'address',type:'string'},
				{name:'postal_code',type:'string'},
				{name:'created_at',type:'date'},
				{name:'status',type:'string'},
				{name:'reason',type:'string'},
				{name:'role_id',type:'int'}]
				});

    var userds = Ext.create('Ext.data.Store', {
		model:'User',
		proxy: {
 			type:'ajax',
			url:'/users',
			method:'get',
			reader:{
				type:'json',
				root:'data'
			},
			autoLoad: true
		}
    		});
    var ds = Ext.create('Ext.data.ArrayStore', {
        fields: [
            {name: 'company'},
            {name: 'price',      type: 'float'},
            {name: 'change',     type: 'float'},
            {name: 'pctChange',  type: 'float'},
            {name: 'lastChange', type: 'date', dateFormat: 'n/j h:ia'},
            // Rating dependent upon performance 0 = best, 2 = worst
            {name: 'rating', type: 'int', convert: function(value, record) {
                var pct = record.get('pctChange');
                if (pct < 0) return 2;
                if (pct < 1) return 1;
                return 0;
            }}
        ],
        data: myData
    });


    // example of custom renderer function
    function change(val){
        if(val > 0){
            return '<span style="color:green;">' + val + '</span>';
        }else if(val < 0){
            return '<span style="color:red;">' + val + '</span>';
        }
        return val;
    }
    // example of custom renderer function
    function pctChange(val){
        if(val > 0){
            return '<span style="color:green;">' + val + '%</span>';
        }else if(val < 0){
            return '<span style="color:red;">' + val + '%</span>';
        }
        return val;
    }
    
    // render rating as "A", "B" or "C" depending upon numeric value.
    function rating(v) {
        if (v == 0) return "A";
        if (v == 1) return "B";
        if (v == 2) return "C";
    }


  //  bd.createChild({tag: 'h2', html: 'Using a Grid with a Form'});

    /*
     * Here is where we create the Form
     */
    var gridForm = Ext.create('Ext.form.Panel', {
        id: 'useraccount-management-form',
        frame: true,
        title: 'User Account Management',
        bodyPadding: 5,
	style:{marginLeft:'auto',marginRight:'auto',marginTop:'15px'},
        height: 450,
	width:700,
        layout: 'column',    // Specifies that the items will now be arranged in columns
	tools:[{id:'refresh',name:'refresh',iconCls:'refresh',handler:function(){ userds.load(); }},
		{id:'user_account_management_close',text:'Close',iconCls:'close',handler:function(){
			// close user account management window
			gridForm.close();

		}}
		],
        fieldDefaults: {
            labelAlign: 'left',
            msgTarget: 'side'
        },

        items: [{
            columnWidth: 0.60,
            xtype: 'gridpanel',
            store: userds,
            height: 405,
            title:'',

            columns: [
                {
                    id       :'login',
                    text   : 'Login Name',
             //       flex: 1,
                    width    : 95,
                    sortable : true,
                    dataIndex: 'login'
                },
                {
                    text   : 'Email',
                    width    : 95,
                    sortable : true,
                    dataIndex: 'email'
                },
                {
                    text   : 'First Name',
                    width    : 75,
                    sortable : true,
                    dataIndex: 'first_name'
                },
                {
                    text   : 'Last Name',
                    width    : 75,
                    sortable : true,
                    dataIndex: 'last_name'
                },
                {
                    text   : 'Address',
                    width    : 145,
                    sortable : true,
//                    renderer : Ext.util.Format.dateRenderer('m/d/Y'),
                    dataIndex: 'address'
                },
                {
                    text: 'Postal Code',
                    width: 70,
                    sortable: true,
                    dataIndex: 'postal_code'
                },
                {
                    text: 'Created At',
                    width: 320,
                    sortable: true,
                    dataIndex: 'created_at'
                },
                {
                    text: 'Status',
                    width: 60,
                    sortable: true,
                    dataIndex: 'status'
                }
            ],

            listeners: {
                selectionchange: function(model, records) {
                    if (records[0]) {
                        this.up('form').getForm().loadRecord(records[0]);
                    }
                }
            }
        }, {
            columnWidth: 0.4,
            margin: '0 0 0 10',
            xtype: 'fieldset',
	
	    height:405,
            title:'User Account Details:',
            defaults: {
                width: 240,
		labelAlign:'right',
                labelWidth: 90
            },
            defaultType: 'textfield',
            items: [{
                fieldLabel: 'ID#',
		readOnly:true,
                name: 'id'
            },{
                fieldLabel: 'Login Name',
		readOnly:true,
                name: 'login'
            },{
                fieldLabel: 'Email',
                name: 'email'
            },{
                fieldLabel: 'First Name',
                name: 'first_name'
            },{
                fieldLabel: 'Last Name',
                name: 'last_name'
            },{
                fieldLabel: 'Address',
                name: 'address'
            },{
                fieldLabel: 'Postal Code',
                name: 'postal_code'
            },{
                fieldLabel: 'Created At',
		readOnly:true,
                name: 'created_at'
            },{
                xtype: 'combo',
		triggerAction:'all',
                fieldLabel: 'Status',
		valueField:'id',
		displayField:'label',
		store: new Ext.data.SimpleStore({fields:['id','label'],
						data:[['pending','pending'],['passive','passive'],['approved','approved'],['active','active'],['suspended','suspended'],['deleted','deleted']
						]
			}),
		forceSelection:true,
	//	readOnly:true,
		editable:false,
		mode:'local',
                name: 'status'
            },{
            //    xtype: 'datefield',
                fieldLabel: 'New Password',
                name: 'newpassword'
            },{
                xtype: 'combo',
                fieldLabel: 'User Role',
		triggerAction:'all',
		valueField:'id',
		displayField:'name',
		store: Ext.create('Ext.data.Store',{ 
				proxy: {
				    type: 'ajax',
				    url: '/admin/roles',
				    method:'GET',
				    reader: {
					type: 'json',
					root: 'data',
				    }
				},
				fields:['id',
					'name'],
				root:'data',
				id:'id',
				autoLoad:true}),
		forceSelection:true,
		editable:false,
		mode:'local',
                name: 'role_id'
            },{
                xtype: 'container',
		style:'padding-left:55px;padding-top:30px',
		items:[{text:'Add New',xtype:'button',handler:function() {
			gridForm.child('gridpanel').store.add(new User({status:'pending'}));
			gridForm.getForm().findField('login').setReadOnly(false);
			gridForm.child('gridpanel').getSelectionModel().select(gridForm.child('gridpanel').store.getCount()-1);
			}
		},{text:'Update',xtype:'button',handler:function(){
//alert(gridForm);
//alert(gridForm.child('fieldset'));
//alert(gridForm.getForm().getValues(false));
						if ((gridForm.getForm() != null)&&(gridForm.getForm().isValid()))
						{ 
//alert(gridForm.getForm().getValues(false));
						var jsondata=Ext.JSON.encode(gridForm.getForm().getValues(false));
						gridForm.getForm().submit({
								params:{data:jsondata},
								method:'POST',
								url:'/users/update',
								format:'json',
								timeout:300000,
								waitMsg:'Please wait while processing the account info.',
								success:function(result,request) 
								{
									var results=Ext.JSON.decode(request.response.responseText);

									if(results.success==true)
									{

										userds.load();
									   	alert(results.message);
										gridForm.getForm().findField('login').setReadOnly(true);
										gridForm.child('gridpanel').store.load();
									   //	alert(results.message);
									}
									else
									{
									   alert(results.message);
									}
								},
								failure:function(result,request)
								{
									var results=Ext.JSON.decode(request.response.responseText);
									if(results.success==true)
									{
									   alert(results.message);
									}
									else
									{
									   alert(results.message);
									}
								}
							});
						}
			}
		},{text:'Delete',xtype:'button',handler:function() {

				Ext.MessageBox.confirm('Delete the selected user account?','Are you sure that you want to delete the selected user account?',function(btn){

if(btn=='yes')
{
						if ((gridForm.getForm() != null)&&(gridForm.getForm().isValid()))
						{ 
//alert(gridForm.getForm().getValues(false));
						var jsondata=Ext.JSON.encode(gridForm.getForm().getValues(false));

						gridForm.getForm().submit({
								params:{user:jsondata},
								method:'POST',
								url:'/users/destroy',
								format:'json',
								success:function(result,request) 
								{
									var results=Ext.JSON.decode(request.response.responseText);
									if(results.success==true || results.success=='true' )
									{
										userds.load();
									   	alert(results.message);
									}
									else
									{
									   	alert(results.message);
									}
								},
								failure:function(result,request)
								{
									var results=Ext.JSON.decode(request.response.responseText);

									if(results.success==true)
									{
									   alert(results.message);
									}
									else
									{
									   alert(results.message);
									}
								}
							});

					}
				}
			});

			}
		}]
            }]
        }],
        renderTo: bd,
		
    });
    userds.on('load',function(){
 	gridForm.child('gridpanel').getSelectionModel().select(0);
    });
    userds.load();

});
