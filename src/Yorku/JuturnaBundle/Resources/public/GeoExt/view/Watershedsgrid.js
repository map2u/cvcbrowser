Ext.define('GeoExt.view.Watershedsgrid',{
	extend:'Ext.grid.GridPanel', 
	alias : 'widget.watershedsgrid',
    	requires: ['GeoExt.store.Watersheds'],
//        title: "Watersheds", 
        id:'watershedsgrid_id',
        store:"Watersheds",
        listeners:{
	  	itemclick:function(view,record,item,index,e){
			if(this.layer != undefined && this.selectLayer !=undefined && this.map != undefined)
			{



	   			var selectLayer=this.selectLayer
	  			var f=this.layer.getFeaturesByAttribute("watershed_name",record.get('watershed_name'));


				if(f&&f[0])
				{


					this.selectLayer.removeAllFeatures();
					//this.map.setCenter(new OpenLayers.LonLat(f[0].geometry.x,f[0].geometry.y));
					if(popup)
					{
					   popup.close();
					   popup=null;
					}

					selectLayer.addFeatures(f[0]);
					selectLayer.setVisibility(true);
					clearInterval();
				/*	setInterval(function(){
						if(selectLayer.getVisibility()==true)
						    selectLayer.setVisibility(false);
						else
						    selectLayer.setVisibility(true);
						//selectLayer.redraw();
					},3000);*/
				}
			}
		},
	  	itemdblclick:function(view,record,item,index,e){
			if(this.layer != undefined && this.selectLayer !=undefined && this.map != undefined)
			{

	  			var f=this.layer.getFeaturesByAttribute("watershed_name",record.get('watershed_name'));


				if(f&&f[0])
				{
					var url = '/watersheds/mapshowinfo?name=' + record.get('watershed_name')
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
	  	selectionchange:function(view,selections,options){
		}
	},

   //     sm: new Ext.selection.FeatureModel(), 
     columns: [ 
        {header: "Name", dataIndex: "watershed_name"} ,
        {header: "Letter ID", dataIndex: "watershed_letter_id"} ,
        {header: "Description", dataIndex: "description"}, 
        {header: "Created at", dataIndex: "created_at"} ,
        {header: "Updated at", dataIndex: "updated_at"}
    ] 
    }); 

