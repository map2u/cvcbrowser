Ext.define('GeoExt.view.SiteDescriptionform',{
	extend:'Ext.form.FormPanel', 
	alias : 'widget.sitedescriptionform',
    	requires: ['GeoExt.store.SiteDescription'
        ],
//		url : '/site_descriptions/' + create,
		autoHeight : true,
		activeItem : 0,
		id : 'newdatacardpanel_id',
		fileUpload : true,
		multipart : true,
		enctype : 'multipart/form',
	//	enctype : 'multipart/form-data',
		layout : 'column',
		frame : true,
		border : false,
		items : [{
          			xtype:'form',
				id:'new_site_description_form_id',
				bodyStyle : 'padding-right:5px;',
				width : 325,
				frame : true,
				items : [{
					xtype : 'fieldset',
					frame : true,
					defaults : {
						border : false,
						labelWidth : 130,
						width : 285
					},
					title : 'Site Description',
					width : 315,
					height : 320,
					items : [{
						xtype : 'textfield',
						fieldLabel : 'Station Name',
						name : 'station_name',
						style : 'background:#99CCCC',
						allowBlank : false,
				//		value : station_name,
						readOnly : true,
						msgTarget : 'side'
					},{
						xtype: 'combo',
						fieldLabel: 'Group Name',
						triggerAction:'all',
						valueField:'id',
						displayField:'group_name',
						store: Ext.create('Ext.data.Store',{ 
								proxy: {
								    type: 'ajax',
								    url: '/groupnames/combobox',
								    method:'GET',
								    reader: {
									type: 'json',
									root: 'data',
								    }
								},
								fields:['id',
									'group_name'],
								root:'data',
								id:'id',
								autoLoad:true}),
						forceSelection:true,
						editable:false,
						mode:'local',
						name: 'groupname_id'
					}, {
						xtype : 'hidden',
						name : 'id'
					}, {
						xtype : 'textfield',
						fieldLabel : 'Watershed',
						allowBlank : false,
						emptyText : 'Enter Watershed Name',
						readOnly : true,
						style : 'background:#99CCCC',
						name : 'watershed_name',
						msgTarget : 'side'
					}, {
						xtype : 'datefield',
						fieldLabel : 'Sampling Date',
						allowBlank : false,
						emptyText : 'Select Sampling Date',
						value : new Date(),
						name : 'sampling_date',
						msgTarget : 'side'
					}, {
						xtype : 'label',
						text : ' '
					}, {
						xtype : 'textfield',
						fieldLabel : 'Site Length',
						emptyText : 'Enter site length',
						name : 'site_length',
						msgTarget : 'side'
					}, {
						xtype : 'textfield',
						fieldLabel : 'Min Width',
						emptyText : 'Enter minimam width',
						name : 'min_width',
						msgTarget : 'side'

					}, {
						xtype : 'numberfield',
						fieldLabel : 'Number of Transects',
						emptyText : 'Enter number of transects',
						name : 'numberof_transects',
						allowDecimals : false,
						allowNegative : false,
						maxValue : 10,
						minValue : 1,
						allowBlank : false,
						msgTarget : 'side'
					},
					{
						xtype : 'textarea',
						fieldLabel : 'Description',
						height:65,
						name : 'description'
					}]
				},{
					xtype : 'fieldset',
					frame : true,
					defaults : {
						border : false,
						labelWidth : 130,
						width : 285
					},
					title : 'Site Pictures',
					width : 315,
					height : 115,
					items:[{
						xtype : 'filefield',
						fieldLabel : 'Upstream photo',
						name : 'upstream_photo',
						msgTarget : 'side'
					}, {
						xtype : 'filefield',
						fieldLabel : 'Downstream photo',
						name : 'downstream_photo',
						msgTarget : 'side'
					}, {
						xtype : 'filefield',
						fieldLabel : 'Sketch',
						name : 'sketch',
						msgTarget : 'side'
					}]			
				}]
				
			},{
			    xtype:'form',
			    id:'site_description_details_form_id',
			    bodyStyle : 'padding-left:5px;',
			    items:[{
				    xtype: 'gridpanel',
				    id :'site_description_details_gridpanel_form_id',
				    store:Ext.data.StoreManager.lookup('site-description-details-gridpanel-formstore'),
				    height: 195,
				    width:395,
				    title:'',
					defaults : {
						width : 95
					},

				    columns: [
							
					{ 
						text : 'Wetted Width',
						dataIndex:'wetted_width'
					},
					{
					  
					    text   : 'Silt/Sand',
					//    flex: 1,
					   // width    : 125,
					    sortable : true,
					    dataIndex: 'silt'
					},
					{
					    text   : 'Pebble',
					   // width    : 125,
					    sortable : true,
					    dataIndex: 'pebble'
					},
					{
					    text   : 'Gravel',
					    width    : 75,
					    sortable : true,
					    dataIndex: 'gravel'
					},
					{
					    text   : 'Cobble',
					    //width    : 75,
					    sortable : true,
					    dataIndex: 'cobble'
					},
					{
					    text   : 'Boulder',
					    //width    : 145,
					    sortable : true,
					    dataIndex: 'boulder'
					},
					{
					    text   : 'Forest Cover',
					    width    : 145,
					    sortable : true,
			//                    renderer : Ext.util.Format.dateRenderer('m/d/Y'),
					    dataIndex: 'o_canopy'
					},
					{
					    text: 'None',
					   // width: 70,
					    sortable: true,
					    dataIndex: 'dom_veg_none'
					},
					{
					    text: 'Cultivated',
					    //width: 320,
					    sortable: true,
					    dataIndex: 'dom_veg_cultivated'
					},
					{
					    text: 'Meadow',
					    //width: 60,
					    sortable: true,
					    dataIndex: 'dom_veg_meadow'
					},{
					    text: 'Scrub',
					   // width: 60,
					    sortable: true,
					    dataIndex: 'dom_veg_scrub'
					},{
					    text: 'Forest',
					  //  width: 60,
					    sortable: true,
					    dataIndex: 'dom_veg_forest'
					}
				    ],

				    listeners: {
					selectionchange: function(model, records) {
					    if (records[0]) {
						this.up('form').getForm().loadRecord(records[0]);
					    }
					}
				    }
				},{


					layout : 'column',
					border : false,
					bodyStyle:'margin-top:10px;',
					width : 395,
					defaults : {
						xtype : 'label',
						frame : true,
						border : false
					},
					items : [{
					xtype : 'fieldset',
					title : 'Dominant Vegetation Type:',
					height : 230,
					width : 190,
					labelAlign : 'right',
					defaults : {
						labelWidth : 95
					},
					items : [{
							xtype : 'combo',
							mode : 'local',
							store :  new Ext.data.SimpleStore({fields : ['id', 'methods'],data : [['N/A', 'N/A'], ['L', 'L'], ['R', 'R'], ['Both', 'Both']]}),
							displayField : 'methods',
							width:165,
							fieldLabel : 'None',
							triggerAction : 'all',
							forceSelection : true,
							editable : false,
							lazyRender : true,
							name : 'dom_veg_none'
						}, {
							xtype : 'combo',
							mode : 'local',
							width:165,
							store :  new Ext.data.SimpleStore({fields : ['id', 'methods'],data : [['N/A', 'N/A'], ['L', 'L'], ['R', 'R'], ['Both', 'Both']]}),
							displayField : 'methods',
							fieldLabel : 'Cultivated',
							triggerAction : 'all',
							forceSelection : true,
							editable : false,
							lazyRender : true,
							name : 'dom_veg_cultivated'
						}, {
							xtype : 'combo',
							mode : 'local',
							width:165,
							store :  new Ext.data.SimpleStore({fields : ['id', 'methods'],data : [['N/A', 'N/A'], ['L', 'L'], ['R', 'R'], ['Both', 'Both']]}),
							displayField : 'methods',
							fieldLabel : 'Meadow',
							triggerAction : 'all',
							forceSelection : true,
							editable : false,
							lazyRender : true,
							name : 'dom_veg_meadow'
						}, {
							xtype : 'combo',
							mode : 'local',
							width:165,
							store :  new Ext.data.SimpleStore({fields : ['id', 'methods'],data : [['N/A', 'N/A'], ['L', 'L'], ['R', 'R'], ['Both', 'Both']]}),
							displayField : 'methods',
							fieldLabel : 'Scrub',
							triggerAction : 'all',
							forceSelection : true,
							editable : false,
							lazyRender : true,
							name : 'dom_veg_scrub'
						}, {
							xtype : 'combo',
							mode : 'local',
							width:165,
							store :  new Ext.data.SimpleStore({fields : ['id', 'methods'],data : [['N/A', 'N/A'], ['L', 'L'], ['R', 'R'], ['Both', 'Both']]}),
							displayField : 'methods',
							fieldLabel : 'Forest',
							triggerAction : 'all',
							forceSelection : true,
							editable : false,
							lazyRender : true,
							name : 'dom_veg_forest'
					}]
				


					},{
					
					xtype : 'fieldset',
					title : 'Dominant Substrate Type:',
					height : 230,
					width : 190,
					labelAlign : 'right',
					defaults : {
						labelWidth : 95
					},
					items : [{ 
								inputValue:true,
								xtype:'textfield',
								fieldLabel : 'Wetted Width',
								name:'wetted_width'
							},{ 

								inputValue:true,
								xtype:'checkbox',
								fieldLabel : 'Silt/Sand',
								name:'silt'
							},{ 
								xtype:'checkbox',
								inputValue:true,
								fieldLabel : 'Pebble',
								name:'pebble'
							},{ 
								xtype:'checkbox',
								fieldLabel : 'Gravel',
								inputValue:true,
								name:'gravel'
							},{ 
								xtype:'checkbox',
								fieldLabel : 'Cobble',
								inputValue:true,
								name:'cobble'
							},{ 
								xtype:'checkbox',
								fieldLabel : 'Boulder',
								inputValue:true,
								name:'boulder'
							},{ 
								xtype:'hiddenfield',
								//fieldLabel : 'Silt/Sand',
								name:'id'
							},{ 
								xtype:'hiddenfield',
								//fieldLabel : 'Silt/Sand',
								name:'site_description_id'
							},{
								xtype : 'combo',
								mode : 'local',
								store :  new Ext.data.SimpleStore({fields : ['id', 'methods'],data : [['0', 'Not Measured'], ['1', '1-25%'], ['2', '26-50%'], ['3', '51-75%'], ['4', '>75%']]}),
								displayField : 'methods',
								fieldLabel : 'Forest Cover',
								triggerAction : 'all',
								forceSelection : true,
								editable : false,
								width:165,
								lazyRender : true,
								name : 'o_canopy'
						}]
				

				}]
			},{
				xtype: 'container',
				style:'padding-left:55px;padding-top:5px',
				items:[{text:'Add New',xtype:'button',handler:function() {
				var id=Ext.getCmp("new_site_description_form_id").getForm().findField('id').getValue();
				if(id==undefined || id==null || id=="")
				{
					alert("Sorry, before you have submitted the site description data,\nYou can not add any transects data.");
					return;
				}

				var numberof_transects=Ext.getCmp("new_site_description_form_id").getForm().findField('numberof_transects').getValue();
				if(numberof_transects==undefined || numberof_transects==null || numberof_transects=="")
				{
					alert("Before you add transects data, \nyou have to set transetc number.");
					return;
				}

				if(id !=undefined && id !="" && parseInt(id)>0&&numberof_transects!=undefined&&parseInt(numberof_transects)>0)
				{
alert(numberof_transects);

//alert(Ext.getCmp("site_description_details_form_id").child('gridpanel').store);

//alert(Ext.getCmp("site_description_details_form_id").getForm().findField("id").getValue());

//alert(Ext.getCmp("site_description_details_form_id").getForm().findField("site_description_id").getValue());
			
Ext.getCmp("site_description_details_form_id").child('gridpanel').store.add(Ext.create("GeoExt.model.SiteDescriptionDetail"));

//alert("site desc iod=" + Ext.getCmp("site_description_details_form_id").getForm().findField("site_description_id").getValue());
		//	Ext.getCmp("site_description_details_form_id").getForm().findField('username').setReadOnly(false);
			Ext.getCmp("site_description_details_form_id").child('gridpanel').getSelectionModel().select(Ext.getCmp("site_description_details_form_id").child('gridpanel').store.getCount()-1);
			
var siteid=Ext.getCmp("new_site_description_form_id").getForm().findField('id').getValue();
Ext.getCmp("site_description_details_form_id").getForm().findField("site_description_id").setValue(siteid);

					
				}




//					Ext.getCmp("useraccount-management-form").child('gridpanel').store.add(new GeoExt.model.User({status:'pending'}));
//					Ext.getCmp("useraccount-management-form").getForm().findField('username').setReadOnly(false);
//					Ext.getCmp("useraccount-management-form").child('gridpanel').getSelectionModel().select(Ext.getCmp("useraccount-management-form").child('gridpanel').store.getCount()-1);
					}
				},{text:'Update',xtype:'button',handler:function(){

					var details_form=Ext.getCmp("site_description_details_form_id").getForm();
					var valid = details_form.isValid();
					if(valid == false) {
						alert("You missed some fields that must	have data there,\nPlease check form again!");
						return false;
					}

					var siteid=Ext.getCmp("new_site_description_form_id").getForm().findField('id').getValue();
					details_form.findField("site_description_id").setValue(siteid);


					


					var jsondata = Ext.JSON.encode(details_form.getValues(false));
				    //    alert(jsondata);
					Ext.getCmp("site_description_details_form_id").getForm().submit({
						params : {
							data : jsondata
						},
						method : 'POST',
						url : '/site_description_details/create',
						waitMsg : 'sending data...',
						format : 'json',
						success : function(result, request) {
//alert(request.response.responseText);
							var results = Ext.JSON.decode(request.response.responseText);
							alert(results.message);

							//	Ext.getCmp('site_description_newdata_sinput_lableinfo_id').setText('Site description data submitted.');
							//	Ext.getCmp('newsitedesc-move-submit').setText('Update');

//alert(results.data.id);
	var siteid=Ext.getCmp("new_site_description_form_id").getForm().findField('id').getValue();
	Ext.getCmp("site_description_details_form_id").getForm().findField('id').setValue(results.data.id);
	var store=Ext.getCmp("site_description_details_form_id").child('gridpanel').getStore();
	//alert("store=" + store.proxy.url);

	Ext.getCmp("site_description_details_form_id").child('gridpanel').getStore().load({params:{id:siteid}});
	//alert("store2=" + store.proxy.url);

	Ext.getCmp("site_description_details_form_id").child('gridpanel').getView().refresh();
	//alert("store3=" + store.proxy.url);

						}
					});





						
					}
				},{text:'Delete',xtype:'button',handler:function() {



				var details_form=Ext.getCmp("site_description_details_form_id").getForm();

				var siteid=Ext.getCmp("new_site_description_form_id").getForm().findField('id').getValue();

				var id=details_form.findField("id").getValue();	
				if(id == undefined || parseInt(id) <= 0)
                                {

					Ext.getCmp("site_description_details_form_id").child('gridpanel').getStore().load({params:{id:siteid}});
				}
				else
				{
					Ext.getCmp("site_description_details_form_id").getForm().submit({
						params : {
							id: id
						},
						method : 'POST',
						url : '/site_description_details/destroy',
						waitMsg : 'sending data...',
						format : 'json',
						success : function(result, request) {
							var results = Ext.JSON.decode(request.response.responseText);
							alert(results.message);

			Ext.getCmp("site_description_details_form_id").child('gridpanel').getStore().load({params:{id:siteid}});
			Ext.getCmp("site_description_details_form_id").child('gridpanel').getView().refresh();



						},
						failure:function(result,request)
						{
							var results=Ext.JSON.decode(request.response.responseText);

							   alert(results.message);
						}
					});

					}
				}
				}]
	
			}]

		}],
		buttons : [{
			id : 'site_description_newdata_sinput_lableinfo_id',
			xtype : 'label',
			text : "Site description data not yet submitted."
		}, '-', 
		{
			id : 'newsitedesc-move-submit',
			text : 'Submit',
			//disabled : true,
			handler : function() {
				if(Ext.getCmp("new_site_description_form_id") != null) {
					var valid = Ext.getCmp("new_site_description_form_id").getForm().isValid();
					if(valid == false) {
						alert("You missed some fields that must	have data there,\nPlease check form again!");
						return false;
					}

					var jsondata = Ext.JSON.encode(Ext.getCmp("new_site_description_form_id").getForm().getValues(false));
					alert(jsondata);
					Ext.getCmp("new_site_description_form_id").getForm().submit({
						params : {
							data : jsondata
						},
						method : 'POST',
						url : '/site_descriptions/create',
						waitMsg : 'sending data...',
						format : 'json',
						success : function(result, request) {
//alert(request.response.responseText);
							var results = Ext.JSON.decode(request.response.responseText);
							alert(results.message);

								Ext.getCmp('site_description_newdata_sinput_lableinfo_id').setText('Site description data submitted.');
								Ext.getCmp('newsitedesc-move-submit').setText('Update');

//alert(results.data.id);

								Ext.getCmp("newdatacardpanel_id").getForm().findField('id').setValue(results.data.id);



								var showdetails=Ext.getCmp("showdetailinfo_easttab_id");
								var detailPanel;
								if(showdetails&&showdetails.ownerCt)
									detailPanel=showdetails.ownerCt;


								detailPanel.setActiveTab(showdetails);
								var url=Ext.getCmp("showdetailinfo_panel_id").autoLoad;
								var tab = detailPanel.getActiveTab();
								tab.removeAll();
								var panel = Ext.create('Ext.form.Panel', {
									border : false,
									id : 'showdetailinfo_panel_id',
									autoScroll : true,
									style : 'padding:5px',
									autoLoad : url
								});
								tab.add(panel);	


/*
							var url = Ext.getCmp("detail_info_tabpanel_id").autoLoad;
							var detailPanel = Ext.getCmp("detail_info_tabpanel");
							detailPanel.setActiveTab(0);
							var tab = detailPanel.getActiveTab();
							tab.removeAll();

							var panel = Ext.create('Ext.form.Panel', {
								border : false,
								id : 'detail_info_tabpanel_id',
								autoScroll : true,
								style : 'padding:5px',
								autoLoad : url
							});
							tab.add(panel);
*/
						},
						failure : function(result, request) {
							var results = Ext.JSON.decode(request.response.responseText);
							alert(results.message);

						}
					});

				}

			}
		}, {
			text : 'Reset',
			handler : function() {
				if(this.up("form") != null) {
					this.up("form").getForm().reset();
				}

			}
		}, {
			text : 'Cancel',
			handler : function() {
				if(this.up("form").panelWindow != null) {
					this.up("form").panelWindow.close();
				}
			}
		}]
    });

