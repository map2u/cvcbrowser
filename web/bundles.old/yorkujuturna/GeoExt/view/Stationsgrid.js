Ext.define('GeoExt.view.Stationsgrid',{
	extend:'Ext.grid.GridPanel', 
	alias : 'widget.stationsgrid',
    	requires: ['GeoExt.store.Stations'],
     //   title: "Stations", 
        id:'stationsgrid_id',
        store:"Stations",
        listeners:{

	  	itemdblclick:function(view,record,item,index,e){
			if(this.layer != undefined && this.selectLayer !=undefined && this.map != undefined)
			{

	  			var f=this.layer.getFeaturesByAttribute("station_name",record.get('station_name'));


				if(f&&f[0])
				{
					var url = '/stations/mapshowinfo?name=' + record.get('station_name')
					var map=this.map;
					var conn = new Ext.data.Connection();
					conn.request({
						url : url,
						method : 'GET',
						//						params:	{"metaID": metaID, columnName: field},
						success : function(responseObject) {
							createPopup(map,f[0],responseObject.responseText);

						},
						failure : function() {
							Ext.Msg.alert('Status', 'Unable	to show	station info.');
						}
					});
				}
			}
		},
	  	itemclick:function(view,record,item,index,e){
			if(this.layer != undefined && this.selectLayer !=undefined && this.map != undefined)
			{
   var selectLayer=this.selectLayer

  var f=		this.layer.getFeaturesByAttribute("station_name",record.get('station_name'));
			if(f&&f[0])
			{

				if(popup)
				{
				   popup.close();
				   popup=null;
				}
				this.selectLayer.removeAllFeatures();

//alert(f[0].geometry.x + "  " + f[0].geometry.y);

				this.map.setCenter(new OpenLayers.LonLat(f[0].geometry.x,f[0].geometry.y));
				this.selectLayer.addFeatures([f[0]]);
				clearInterval();
				setInterval(function(){
					if(selectLayer.getVisibility()==true)
					    selectLayer.setVisibility(false);
					else
					    selectLayer.setVisibility(true);
				},2000);

			}

			}
		},
	  	selectionchange:function(view,selections,options){
		}
	},
    //    sm: new Ext.selection.FeatureModel(), 
     columns: [ 
        {header: "Station Name", dataIndex: "station_name"} ,
        {header: "Watershed", dataIndex: "watershed_name"}, 
        {header: "Subwatershed", dataIndex: "subwatershed_name"}, 
        {header: "Created at", dataIndex: "created_at"} ,
        {header: "Updated at", dataIndex: "updated_at"}
    ] 
    }); 


