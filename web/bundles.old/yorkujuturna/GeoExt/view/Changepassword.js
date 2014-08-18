Ext.define('GeoExt.view.Changepassword',{
	extend:'Ext.form.Panel',
	alias : 'widget.changepasswordform',
		frame : false,
		width : 330,
		bodyPadding : 5,

		fieldDefaults : {
			labelAlign : 'right',
			labelWidth : 140,
			anchor : '100%'
		},

		items : [{
			xtype : 'hidden',
			name : 'id',
			value:'user_id'
		},{
			xtype : 'textfield',
			name : 'oldpassword',
			inputType : 'password',
			allowBlank : false,
			fieldLabel : 'Current Password'
		}, {
			xtype : 'textfield',
			inputType : 'password',
			allowBlank : false,
			name : 'password',
			fieldLabel : 'New Password'
		}, {
			xtype : 'textfield',
			inputType : 'password',
			allowBlank : false,
			name : 'password_confirmation',
			fieldLabel : 'Password Confirmation'
		}],
		buttons : [{
			text : 'Change Password',
			handler : function() {
				if(this.up('form').getForm().isValid()) {
					var jsondata = Ext.JSON.encode(this.up('form').getForm().getValues(false));
					this.up('form').getForm().submit({
						params : {
							user : jsondata
						},
						method : 'POST',
						// for user to change password, system will check user old password first.
						url : '/' + Ext.locale + '/users/changepassword',
						format : 'json',
						timeout:9000,
						waitMsg:'Please wait while processing ...',
						success : function(result, request) {
							var results = Ext.JSON.decode(request.response.responseText);
							if(results.success == true) {
								alert(results.message);
							} else {
								alert(results.password);
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
            			var changepassword_win=Ext.getCmp("changepasswordwin_id");
				if(changepassword_win != null) {
					changepassword_win.close();
				}
			}
		}]
	});

