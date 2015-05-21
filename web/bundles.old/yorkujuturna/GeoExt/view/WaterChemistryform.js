Ext.define('GeoExt.view.WaterChemistryform',{
	extend:'Ext.form.FormPanel', 
	alias : 'widget.waterchemistryform',
    	requires: ['GeoExt.store.WaterChemistry'
        ],
        hideHeaders: true,
	id:'waterchemistryform_data_id',
	//frame:false,
        rootVisible: false,
	border:false,
        autoScroll: false,
        lines: false,
	enableDrop:false,
        useArrows: true,
      
		width : 470,
		bodyStyle : 'padding:5px;padding-left:40px;',
		height : 485,
		items : [{
			xtype : 'fieldset',
			bodyStyle : 'padding:5px;',
			title : 'Water Chemistry Data',
			width : 405,
			defaults : {
				labelWidth : 220
			},
			height : 420,
			items : [{
				xtype : 'textfield',
				fieldLabel : 'Station Name',
				style : 'background:#99CCCC',
				readOnly : true,
				name : 'station_name'
			}, {
				fieldLabel : 'Sampling Date',
				xtype : 'datefield',
				value : new Date(),
				name : 'sampling_date'
			}, {
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
				name : 'id',
			}, {

				xtype : 'textfield',
				fieldLabel : 'pH Level',
				name : 'ph_level'
			}, {
				xtype : 'textfield',
				fieldLabel : 'Instrument Name',
				name : 'ph_inst_name'
			}, {
				xtype : 'textfield',
				fieldLabel : 'Instrument Model',
				name : 'ph_inst_mod'
			}, {
				xtype : 'textfield',
				fieldLabel : 'Water Temperature (C)',
				name : 'water_temperature'
			}, {
				xtype : 'textfield',
				fieldLabel : 'Instrument Name',
				name : 'water_temp_inst_name'
			}, {
				xtype : 'textfield',
				fieldLabel : 'Instrument Model',
				name : 'water_temp_inst_mod'
			}, {
				xtype : 'textfield',
				fieldLabel : 'Dissolved Oxygen(ppm)',
				name : 'dissolved_oxygen'
			}, {
				xtype : 'textfield',
				fieldLabel : 'Instrument Name',
				name : 'dissolved_oxygen_inst_name'
			}, {
				xtype : 'textfield',
				fieldLabel : 'Instrument Model',
				name : 'dissolved_oxygen_inst_mod'
			}, {
				xtype : 'textfield',
				fieldLabel : 'Conductivity (uS/cm)',
				name : 'conductivity'
			}, {
				xtype : 'textfield',
				fieldLabel : 'Instrument Name',
				name : 'conductivity_inst_name'
			}, {
				xtype : 'textfield',
				fieldLabel : 'Instrument Model',
				name : 'conductivity_inst_mod'
			}]
		}],

		buttons : [{
			id : 'waterchemistry_newdata_sinput_lableinfo_id',
			xtype : 'label',
			text : "Water chemistry data not yet submitted."
		}, '-', {
			id : 'waterchemistry_newdata_ainput_submit',
			text : 'Submit',
			handler : function() {

				if(this.up("form") != null) {
					var jsondata = Ext.JSON.encode(this.up("form").getForm().getValues(false));
					varAction="create";
					
					this.up("form").getForm().submit({
						url : '/water_chemistries/create',

						params : {
							data : jsondata
						},
						method : 'POST',
						waitMsg : 'Sending Data ...',
						timeout : 90000,
						format : 'json',
						success : function(result, request) {
							var results = Ext.JSON.decode(request.response.responseText);
							if(results.success == true) {
								alert(results.message);
								Ext.getCmp('waterchemistry_newdata_sinput_lableinfo_id').setText('Water chemistry data submitted.');
								Ext.getCmp('waterchemistry_newdata_ainput_submit').setText('Update');

								Ext.getCmp("waterchemistryform_data_id").getForm().findField('id').setValue(results.data.id);



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

							} else {
								alert(results.message);
							}
						},
						failure : function(result, request) {
							var results = Ext.JSON.decode(request.response.responseText);
							if(results.success == true) {
								alert(results.message);
							} else {
								alert(results.message);
							}
						}
					});

				}

			}
		}, {
			text : 'Reset',
			handler : function() {
				if(waterchemistryPanel != null) {
					waterchemistryPanel.getForm().reset();
				}

			}
		}, {
			text : 'Cancel',
			handler : function() {
				if(waterchemistryWin != null) {
					waterchemistryWin.close();
				}
			}
		}]
    });

