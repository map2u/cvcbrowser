Ext.define('GeoExt.view.Stationform',{
	extend:'Ext.form.FormPanel', 
	alias : 'widget.stationform',
    	requires: ['GeoExt.store.Station'
        ],
        hideHeaders: true,
	frame:false,
        rootVisible: false,
	border:false,
        autoScroll: false,
        lines: false,
	enableDrop:false,
        useArrows: true,
      
		url : "/stations/create",
		height : 349,
		width : 365,
		monitorValid : true,
		xtype : 'panel',
		frame : true,
		labelAlign : 'right',
		border : false,
		//layout:'form',
		delay : 50,
		defaults : {
			labelWidth : 150,
			width : 325,
		},
		bodyStyle : 'padding:15px;',
		items : [{
			xtype : 'textfield',
			fieldLabel : 'Station Name',
			style : 'background:#99CCCC',
			name : 'station_name',
			readOnly : true
		}, {
			xtype : 'textfield',
			fieldLabel : 'Nearest	Intersection',
			name : 'nearest_intersection'
		}, {
			xtype : 'textfield',
			fieldLabel : 'Longitude',
			style : 'background:#99CCCC',
			readOnly : true,
			name : 'lng'
		}, {
			xtype : 'textfield',
			fieldLabel : 'Latitude',
			style : 'background:#99CCCC',
			readOnly : true,
			name : 'lat'
		}, {
			xtype : 'textfield',
			fieldLabel : 'Municipality',
			name : 'municipality'
		}, {
			xtype : 'textfield',
			fieldLabel : 'Watershed Name',
			readOnly : true,
			style : 'background:#99CCCC',
			name : 'watershed_name'
		}, {
			xtype : 'textfield',
			fieldLabel : 'Subwatershed Name',
			readOnly : true,
			style : 'background:#99CCCC',
			name : 'subwatershed_name'
		}, {
			xtype : 'hidden',
			name : 'subwatershed_id'
		}, {
			xtype : 'hidden',
			name : 'watershed_id'
		}, {
			xtype : 'textarea',
			fieldLabel : 'Location Description',
			name : 'location_description'
		}],
		dockedItems: [{
 			xtype: 'container',
            		dock: 'bottom',
			items:[{
				text : 'Submit',
			 	xtype: 'button',
				handler : function() {

				var jsondata = Ext.JSON.encode(this.up("form").getForm().getValues(false));
				this.up("form").getForm().submit({
					url:'/stations/create',
					params : {
						data : jsondata
					},
					method : 'POST',
					waitMsg : 'Sending Data ...',
					timeout : 9000,
					format : 'json',
					success : function(result, request) {
						var results = Ext.JSON.decode(request.response.responseText);
						var panel=Ext.getCmp("create_new_station_from_map_id");
						if((results.success == true) && (panel !=null) && (panel.map != null)) {
							var data_result= Ext.JSON.decode(results.data);
							var formPanel=Ext.getCmp("create_new_station_from_map_id");
							formPanel.panelWindow.setTitle("Update station " + data_result.station_name + " data");

							formPanel.getForm().findField('station_name').setValue(data_result.station_name);
							
							layergridpanel["Stations"].store.load();
							alert(results.message + "\nPlease click	the	icon to	input data.");
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
		}, {
			text : 'Reset',
			 xtype: 'button',
			handler : function() {
				if(this.up("form") != null) {
					this.up("form").getForm().reset();
				}

			}
		}, {
			text : 'Cancel',
			 xtype: 'button',
			handler : function() {
				if(this.up("form").panelWindow != null) {
					this.up("form").panelWindow.close();
				}
			}
		}]
	}]
    });

