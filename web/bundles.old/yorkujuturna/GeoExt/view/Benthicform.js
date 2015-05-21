Ext.define('GeoExt.view.Benthicform',{
	extend:'Ext.form.FormPanel', 
	alias : 'widget.benthicform',
    	requires: ['GeoExt.store.Benthic'
        ],
        hideHeaders: true,
	id:'benthicform_data_id',
	border:false,
        autoScroll: false,
	layout : 'column',


		frame : true,
		width : 850,
		height : 504,
		bodyStyle : 'padding:5px;',
		items : [{
				frame : true,
				bodyStyle : 'padding:2px;',
				width : 415,
				xtype : 'fieldset',
				title : 'Collections:',
				items:[{

					layout : 'column',
					border : false,
					width : 400,
					defaults : {
						xtype : 'label',
						frame : true,
						border : false
					},
					items : [{
						width : 150,
						style : 'text-align:center;border-bottom:1px solid grey;',
						text : 'Name'
					}, {
						Width : 40,
						style : 'text-align:left;border-bottom:1px solid grey;',
						text : ' Count'

					}, {
						width : 150,
						style : 'text-align:center;border-bottom:1px solid grey;',
						text : 'Name'
					}, {
						Width : 40,
						style : 'text-align:left;border-bottom:1px solid grey;',
						text : ' Count'

					}]


				},{
					xtype:'form',
					width:392,
					height:400,
					autoScroll:true,
					items:[{

						layout : 'column',
						border : false,
						items : [{
							width : 182,
							border : false,
							defaults : {
								xtype : 'textfield',
								labelAlign : 'right',
								width : 180,
								labelWidth : 147
							},
							items : [{
								fieldLabel : 'Coelenterata(Hydras)',
								name : 'aca'
							},{
								fieldLabel : 'Amphipoda (Scuds)',
								name : 'amp'
							}, {
								fieldLabel : 'Anisoptera (Dragonflies)',
								name : 'ani'
							},{
								fieldLabel : 'Beetles (coleopltera)',
								name : 'bee'
							}, {
								fieldLabel : 'Ceratopogonidae	(No-see-ums)',
								name : 'cer'
							}, {
								fieldLabel : 'Chironomidae (Midges)',
								name : 'chi'
							}, {
								fieldLabel : 'Beetles(Coleoptera)',
								name : 'col'
							}, {
								fieldLabel : 'Cuclidae (Mosquitos)',
								name : 'cuc'
							}, {
								fieldLabel : 'Decapoda(Crayfish)',
								name : 'dec'
							}, {
								fieldLabel : 'Misc. Diptera (Misc. True Flies)',
								name : 'dip'
							}, {
								fieldLabel : 'Ephemeroptera(Mayflies)',
								name : 'eph'
							}, {
								fieldLabel : 'Gastropoda (Snails,	Limpets)',
								name : 'gas'
							}, {
								fieldLabel : 'Hemiptera(True Bugs)',
								name : 'hem'
							}, {
								fieldLabel : 'Hirudnea(Leeches)',
								name : 'hir'
							}, {
								fieldLabel : 'Isopoda	(Sow Bugs)',
								name : 'iso'
							}, {
								fieldLabel : 'misc. diptera (misc. true flies)',
								name : 'mis'
							}]
						}, {
							labelAlign : 'right',
							width : 182,
							border : false,
							defaults : {
								xtype : 'textfield',
								labelAlign : 'right',
								width : 180,
								labelWidth : 147
							},

							items : [{
								xtype : 'textfield',
								fieldLabel : 'Lepidoptera (Aquatic Moths)',
								name : 'lep'
							}, {
								xtype : 'textfield',
								fieldLabel : 'Megaloptera (Fishflies,	Alderflies)',
								name : 'meg'
							}, {
								xtype : 'textfield',
								fieldLabel : 'Nematoda(Roundworms)',
								name : 'nem'
							}, {
								xtype : 'textfield',
								fieldLabel : 'Oligochaeta (Aquatic Earthworms)',
								name : 'oli'
							}, {
								xtype : 'textfield',
								fieldLabel : 'Pelecypoda(Clams)',
								name : 'pal'
							}, {
								xtype : 'textfield',
								fieldLabel : 'Plecoptera (Stonesflies)',
								name : 'ple'
							}, {
								xtype : 'textfield',
								fieldLabel : 'Tabanidae (horse and deer flies)',
								name : 'tab'
							}, {
								xtype : 'textfield',
								fieldLabel : 'Tipulidae (Craneflies)',
								name : 'tip'
							}, {
								xtype : 'textfield',
								fieldLabel : 'Trichoptera(Caddisflies)',
								name : 'tri'
							}, {
								xtype : 'textfield',
								fieldLabel : 'Trombidiformes-Hydracarina (Mites)',
								name : 'tro'
							}, {
								xtype : 'textfield',
								fieldLabel : 'Turbellaria (Flatworms)',
								name : 'tur'
							}, {
								xtype : 'textfield',
								fieldLabel : 'Zygoptera(Damselflies)',
								name : 'zyg'
							}, {
								xtype : 'textfield',
								fieldLabel : 'Unidentified',
								name : 'uniden'
							}, {
								xtype : 'textfield',
								fieldLabel : 'Simuliidae (Blackflies)',
								name : 'sim'
							}]
						}]
					}]
				}]
			}
			,{
				bodyStyle : 'padding:5px;',
				width : 410,
				frame : true,
				items:[{
					xtype : 'fieldset',
					frame : true,
					width : 390,
					height : 190,
					defaults : {
						labelWidth : 160,
						labelAlign : 'right'
					},
					title : 'Identification Method:',
					items : [{
						xtype : 'textfield',
						fieldLabel : 'Station Name',
						//value : station_name,
						readOnly : true,
						style : 'background:#99CCCC',
						name : 'station_name'
					} ,{
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
					//	value : benthic_id
					}, {
						border : false,
						xtype : 'radiogroup',
						fieldLabel : 'Location of identification',
						//name:'iden_identification_location',
						defaults : {
							xtype : 'radio',
							width : 95
						},
						items : [{
							boxLabel : 'Field',
							inputValue : 'Field',
							name : 'location_of_identification'
						}, {
							boxLabel : 'Lab',
							inputValue : 'Lab',
							name : 'location_of_identification'
						}]
					}, {
						border : false,
						xtype : 'radiogroup',
						fieldLabel : 'Condition of sample',
						//name:'iden_sample_condition',
						defaults : {
							xtype : 'radio'
						},
						items : [{
							boxLabel : 'Live',
							inputValue : 'Live',
							value : 'Live',
							name : 'condition_of_sample'
						}, {
							boxLabel : 'Preserved',
							inputValue : 'Preserved',
							value : 'Preserved',
							name : 'condition_of_sample'
						}]
					}, {
						border : false,
						xtype : 'radiogroup',
						fieldLabel : 'Assisted observation',
						//name:'iden_assisted_observation',
						defaults : {
							xtype : 'radio'
						},
						items : [{
							boxLabel : 'Microscope',
							inputValue : 'Microscope',
							name : 'assisted_observation'
						}, {
							boxLabel : 'Hand Lens',
							inputValue : 'Hand_lens',
							name : 'assisted_observation'
						}]
			
					}]
				},{
					xtype : 'fieldset',
					title : 'Collection Method:',
					height : 190,
					width : 390,
					labelAlign : 'right',
					defaults : {
						labelWidth : 205
					},
					items : [{
							xtype : 'combo',
							mode : 'local',
							store :  new Ext.data.SimpleStore({fields : ['id', 'methods'],data : [['0', 'Kick and Sweep'], ['1', 'Travelling Kick and Sweep'], ['2', 'Travelling Kick and Sweep-trnsects']]}),
							displayField : 'methods',
							fieldLabel : 'Collection Method',
							triggerAction : 'all',
							forceSelection : true,
							editable : false,
							value : 'Kick	and	Sweep',
							lazyRender : true,
							name : 'collection_method'
						}, {
							xtype : 'textarea',
							fieldLabel : 'Collection Method Description',
							name : 'collection_method_desc'
						}, {
							fieldLabel : 'Sampling Date',
							xtype : 'datefield',
							value : new Date(),
							name : 'sampling_date'
					}]
				
				}]
				
			
			}
		],
		buttons : [{
			id : 'benthic_newdata_ainput_lableinfo_id',
			xtype : 'label',
			text : "Benthic	data not yet submitted."
		}, '-', {
			id : 'benthic_newdata_ainput_submit',
			text : 'Submit',
			handler : function() {
				if(this.up("form") != null) {
					var jsondata = Ext.JSON.encode(this.up("form").getForm().getValues(false));
					// alert(benthicsMainPanel.getForm().url);
					// alert(jsondata);
					if(this.up("form").getForm().isValid()) {
						this.up("form").getForm().submit({
							params : {
								data : jsondata
							},
							method : 'POST',
							url : '/benthics/create',
							waitMsg : 'Sending Data ...',
							timeout : 90000,
							format : 'json',
							success : function(result, request) {
								var results = Ext.JSON.decode(request.response.responseText);
								if(results.success == true) {

									Ext.getCmp('benthic_newdata_ainput_lableinfo_id').setText('Benthic data	submitted.');
									Ext.getCmp('benthic_newdata_ainput_submit').setText('Update');
									Ext.getCmp('benthicform_data_id').getForm().findField('id').setValue(results.data.id);
									alert(results.message);


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
					} else {
						alert("Some items are invalid");
					}
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

