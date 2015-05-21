Ext.define('GeoExt.view.Stationtree',{
	extend:'Ext.tree.Panel', 
	alias : 'widget.stationtree',
    	requires: ['GeoExt.store.Stationtree'
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
		itemdblclick:function(view,record,item,index,event){
//alert(record.get('text'));
//alert("this layer " + this.layer);
//alert("selected " + this.selectLayer);
//alert("map=" + this.map);
			if(this.layer != undefined && this.selectLayer !=undefined && this.map != undefined)
			{
//alert("this.layer" + this.layer);
	   			var selectLayer=this.selectLayer
	  			var f=this.layer.getFeaturesByAttribute("station_name",record.get('text'));

				if(f&&f[0])
				{
					var url = '/en/stations/mapshowinfo?name=' + record.get('text')
					var map=this.map;
					var conn = new Ext.data.Connection();
					conn.request({
						url : url,
						method : 'GET',
						//						params:	{"metaID": metaID, columnName: field},
						success : function(responseObject) {

                                                 //       document.location="wrui://getById?id=" + f[0].attributes.station_name;

							createPopup(map,f[0],responseObject.responseText);

						},
						failure : function() {
							Ext.Msg.alert('Status', 'Unable	to show	station info.');
						}
					});

				}
			}
		},
		itemclick: function(view,record,item,index,event) {
/*Ext.Ajax.request({
	url:"/stations/getFeature",
	success:function(){
	},
        failure:function(){
	},
	params:{name:record.get('text')}
	});

*/
			if(this.layer != undefined && this.selectLayer !=undefined && this.map != undefined)
			{


         //                                             document.location="wrui://getById?id=" + record.get('text');


				if(popup)
				{
				   popup.close();
				   popup=null;
				}

				var vParam=record.get('id');
				var aParams=vParam.split('/');
	   			var selectLayer=this.selectLayer
	  			var f=this.layer.getFeaturesByAttribute("station_name",record.get('text'));

				var showdetails=Ext.getCmp("showdetailinfo_easttab_id");
				var detailPanel;
				if(showdetails&&showdetails.ownerCt)
					detailPanel=showdetails.ownerCt;//.setActiveTab(showdetails);

				if(f&&f[0])
				{

					this.selectLayer.removeAllFeatures();
					this.map.setCenter(new OpenLayers.LonLat(f[0].geometry.x,f[0].geometry.y));
					this.selectLayer.addFeatures([f[0]]);
					selectLayer.setVisibility(true);

					clearInterval();
					setInterval(function(){
						if(selectLayer.getVisibility()==true)
						    selectLayer.setVisibility(false);
						else
						    selectLayer.setVisibility(true);
					},1500);
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
						autoLoad : {url:'/en/admin/details?id=' + 4 + "&content_id=" + aParams[aParams.length-1],msg:'waiting',scripts:true}
					});
					tab.add(panel);
					tab.setTitle(record.get('text'));

				}

			}



		}
	},
        viewConfig: {
            plugins: [{
                ptype: 'treeviewdragdrop'
            }]
        }
    });

