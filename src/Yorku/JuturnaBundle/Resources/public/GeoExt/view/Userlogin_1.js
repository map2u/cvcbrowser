Ext.define('GeoExt.view.Userlogin',{
	extend:'Ext.form.Panel',
	alias : 'widget.userloginform',
		frame : false,
		width : 260,
		windowCt: 'hhundefined',
		bodyPadding : '15px',
		fieldDefaults : {
			labelAlign : 'right',
			labelWidth : 90,
			anchor : '100%'
		},

		items : [{
			xtype : 'textfield',
			name : 'username',
			allowBlank : false,
			fieldLabel : 'User Name'
		}, {
			xtype : 'textfield',
			name : 'password',
			inputType : 'password',
			allowBlank : false,
			fieldLabel : 'Password'
		}, {
			xtype : 'checkboxfield',
			name : 'remember_me',
			fieldLabel : '',
			labelSeparator : '',
			hideEmptyLabel : false,
			boxLabel : 'Remember me'
		}],
		buttons : [{
			text : 'OK',
			handler : function() {
				if((this.up('form').getForm().isValid())) {
					var jsondata = Ext.JSON.encode(this.up('form').getValues(false));
					this.up('form').getForm().submit({
						params : {
							data : jsondata
						},
						method : 'POST',
						url : '/' + Ext.locale + '/login',
						format : 'json',
						success : function(result, request) {
							var results = Ext.JSON.decode(request.response.responseText);
							if(results.success == true) {
								window.location.href = "/";
								alert(results.message);
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
			text : 'Cancel',
			handler : function() {
				if(Ext.getCmp("userloginform_id")) {
				
                                         Ext.getCmp("userloginform_id").destroy();
				}
			}
		}]
	});

