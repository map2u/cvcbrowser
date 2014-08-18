Ext.define('GeoExt.view.Subwatershedsgrid',{
	extend:'Ext.grid.GridPanel', 
//	alias : 'widget.subwatershedsgrid',
//    	requires: ['GeoExt.store.Subwatersheds'],
//        title: "Subwatersheds", 
        id:'subwatershedsgrid_id',
	map:'',
        store:'Subwatersheds',
        listeners:{
	  	itemdblclick:function(view,record,item,index,e){
			if(this.layer != undefined && this.selectLayer !=undefined && this.map != undefined)
			{

	  			var f=this.layer.getFeaturesByAttribute("subwatershed_name",record.get('subwatershed_name'));


				if(f&&f[0])
				{
					var url = '/subwatersheds/mapshowinfo?name=' + record.get('subwatershed_name')
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
							Ext.Msg.alert('Status', 'Unable	to show	subwatersheds info.');
						}
					});
				}
			}
		},
	  	itemclick:function(view,record,item,index,e){
			if(this.layer != undefined && this.selectLayer !=undefined && this.map != undefined)
			{
   				var selectLayer=this.selectLayer

				// close popup window
				if(popup)
				{
				   popup.close();
				   popup=null;
				}

  				var f=this.layer.getFeaturesByAttribute("subwatershed_name",record.get('subwatershed_name'));
				if(f)
				{

					this.selectLayer.removeAllFeatures();
				//	this.map.setCenter(new OpenLayers.LonLat(f[0].geometry.x,f[0].geometry.y));
					this.selectLayer.addFeatures([f[0]]);

				/*	clearInterval();
				/*	setInterval(function(){
						if(selectLayer.getVisibility()==true)
						    selectLayer.setVisibility(false);
						else
						    selectLayer.setVisibility(true);
						//selectLayer.redraw();
					},2500);
				*/

				}

			}
		},
	  	selectionchange:function(view,selections,options){
		}
	},

   //    sm: new Ext.grid.RowSelectionModel({singleSelect:true}), 
     columns: [ 
        {header: "name", dataIndex: "subwatershed_name"} ,
        {header: "Watershed", dataIndex: "watershed_name"} ,
        {header: "description", dataIndex: "description"}, 
        {header: "created_at", dataIndex: "created_at"} ,
        {header: "updated_at", dataIndex: "updated_at"}
    ] 
    }); 

