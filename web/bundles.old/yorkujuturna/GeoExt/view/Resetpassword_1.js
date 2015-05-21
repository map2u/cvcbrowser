Ext.define('GeoExt.view.Resetpassword',{
	extend:'Ext.form.Panel',
	alias : 'widget.resetpasswordform',
		frame : false,
		frame : true,
		width : 260,
		bodyPadding : 5,

		fieldDefaults : {
			labelAlign : 'right',
			labelWidth : 90,
			anchor : '100%'
		},

		items : [{
			xtype : 'textfield',
			name : '_username',
			fieldLabel : 'User Name or Email'
		}, {
			xtype : 'textfield',
			name : 'email',
			fieldLabel : 'or	 Email'
		}],
		buttons : [{
			text : 'Reset Password',
			handler : function() {
                            
				if(this.up('form').getForm().isValid()) {
					// get all form data as json format
					var jsondata = Ext.JSON.encode(this.up('form').getForm().getValues(false));
					this.up('form').getForm().submit({
						//pass form data as variable name "data", in action user get the data by params[:data]
						params : {
							data : jsondata
						},
						method : 'POST',
						// use post method to submit login name or e-mail address for reset password, new password will be sent to user by e-mail.
						url : '/users/resetpassword',
						format : 'json',
						timeout:9000,
						waitMsg:'Please wait while processing ...',
 						scope:this,
						success : function(result, request) {
							if(request.response&&request.response.responseText) {

							var results = Ext.JSON.decode(request.response.responseText);
							if(results.success == true) {
								alert(results.message);
							} else {
								alert(results.message);
							}
							}
							else
							{
								alert("Success!");
							}
						},
						failure : function(result, request) {
							if(request.response&&request.response.responseText) {
							var results = Ext.JSON.decode(request.response.responseText);
							if(results.success == true) {
								alert(results.message);
							} else {
								alert(results.message);
							}
							}
							else
							{
								alert("failed!");
							}

						}
					});
				}

			}
		}, {
			text : 'Cancel',
			handler : function() {
				var forgetpassword_win=Ext.getCmp("resetpasswordwin_id");
				if(forgetpassword_win != null) {
					forgetpassword_win.close();
				}
			}
		}]
	});

