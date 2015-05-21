Ext.define('GeoExt.view.Watershedtree',{
	extend:'Ext.tree.Panel', 
	alias : 'widget.watershedtree',
    	requires: ['GeoExt.store.Watershedtree'
        ],
        hideHeaders: true,
	frame:false,
        rootVisible: false,
	border:false,
        autoScroll: true,
        lines: false,
	enableDrop:false,
        useArrows: true,
	listeners: {
		itemdblclick: function(view,record,item,index,event) {
			if(this.walayer != undefined && this.sulayer!= undefined && this.stlayer != undefined && this.selectLayer !=undefined && this.map != undefined)
			{
alert(item.id);
				var id=record.get('id');
				alert(id);
				clearInterval();
   				var selectLayer=this.selectLayer;
				var vParam = id;
				var i = 0;
				var f;
				var url;
				var aParams = vParam.split('/');
				this.selectLayer.removeAllFeatures();
				if(aParams.length == 2)
				{
					var wname=record.get('text').replace(" watershed","");
					f=this.walayer.getFeaturesByAttribute("id",parseInt(aParams[1]));
					if(f&&f[0])
					{
						this.map.zoomToExtent(f[0].geometry.getBounds());
					}					
					url = '/en/watersheds/mapshowstationinfo?name=' + record.get('text')
				}
				if(aParams.length == 3) {

					var swname=record.get('text').replace(" subwatershed","");
					f=this.sulayer.getFeaturesByAttribute("id",parseInt(aParams[2]));
					if(f&&f[0])
					{
						this.map.zoomToExtent(f[0].geometry.getBounds());
					}					
					url = '/en/subwatersheds/mapshowstationinfo?name=' + record.get('text')
				}
				if(aParams.length == 4) {
					f=this.stlayer.getFeaturesByAttribute("id",parseInt(aParams[3]));

					url = '/en/stations/mapshowinfo?name=' + record.get('text')

					if(f&&f[0])
					{
						setInterval(function(){
							if(selectLayer.getVisibility()==true)
							    selectLayer.setVisibility(false);
							else
							    selectLayer.setVisibility(true);
						},2500);
						var map=this.map;
						var conn = new Ext.data.Connection();
						conn.request({
							url : url,
							method : 'GET',
							//params:	{"metaID": metaID, columnName: field},
							success : function(responseObject) {


								createPopup(map,f[0],responseObject.responseText);

							},
							failure : function() {
								Ext.Msg.alert('Status', 'Unable	to show	feature info.');
							}
						});
					}
				}
				if(f&&f[0])
				{
					this.selectLayer.addFeatures([f[0]]);
					this.selectLayer.setVisibility(true);
				}
			}
		},
		itemclick: function(view,record,item,index,event) {
			if(this.walayer != undefined && this.sulayer!= undefined && this.stlayer != undefined && this.selectLayer !=undefined && this.map != undefined)

			{
				var id=record.get('id');
				

				clearInterval();
   				var selectLayer=this.selectLayer;
				var vParam = id;
				var i = 0;
				var f;
				var aParams = vParam.split('/');
				this.selectLayer.removeAllFeatures();
				var showdetails=Ext.getCmp("showdetailinfo_easttab_id");
				var detailPanel;
				if(showdetails&&showdetails.ownerCt)
					detailPanel=showdetails.ownerCt;//.setActiveTab(showdetails);

				if(aParams.length == 2)
				{
					f=this.walayer.getFeaturesByAttribute("id",parseInt(aParams[1]));
				}
				if(aParams.length == 3) {

					f=this.sulayer.getFeaturesByAttribute("id",parseInt(aParams[2]));
				}
				if(aParams.length == 4) {
					f=this.stlayer.getFeaturesByAttribute("id",parseInt(aParams[3]));
					if(f&&f[0])

					setInterval(function(){
						if(selectLayer.getVisibility()==true)
						    selectLayer.setVisibility(false);
						else
						    selectLayer.setVisibility(true);
					},2500);
				}
				if(f&&f[0])
				{
					this.selectLayer.addFeatures([f[0]]);
					this.selectLayer.setVisibility(true);
				}
				if(detailPanel != null && detailPanel != undefined)
				{



					if(detailPanel.collapsed == true)
						detailPanel.expand();

					detailPanel.setActiveTab(showdetails);

					var tab = detailPanel.getActiveTab();
					tab.removeAll();
					var panel = Ext.create('Ext.form.Panel', {
						border : false,
						id : 'showdetailinfo_panel_id',
						autoScroll : true,
						style : 'padding:5px',
						autoLoad : '/en/admin/details?id=' + aParams.length + "&content_id=" + aParams[aParams.length - 1]
					});
					tab.add(panel);
					tab.setTitle(record.get('text'));

				}
			}

//:watershedsvector,sulayer:subwatershedsvector,stlayer:

//			showWatershedDetails(record.get('id'),record.get('text'),stationMarkers);

			//Ext.getCmp("propertygrid_id").setSource(record);
		}
	},
        viewConfig: {
            plugins: [{
                ptype: 'treeviewdragdrop'
            }]
        }
    });

