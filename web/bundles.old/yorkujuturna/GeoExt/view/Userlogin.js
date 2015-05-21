Ext.define('GeoExt.view.Userlogin', {
    extend: 'Ext.form.Panel',
    alias: 'widget.userloginform',
    frame: false,
    width: 260,
    windowCt: 'hhundefined',
    bodyPadding: '15px',
    fieldDefaults: {
        labelAlign: 'right',
        labelWidth: 90,
        anchor: '100%'
    },
    items: [{
            xtype: 'textfield',
            name: '_username',
            allowBlank: false,
            fieldLabel: 'User Name'
        }, {
            xtype: 'textfield',
            name: '_password',
            inputType: 'password',
            allowBlank: false,
            fieldLabel: 'Password'
        }, {
            xtype: 'checkboxfield',
            name: '_remember_me',
            fieldLabel: '',
            labelSeparator: '',
            hideEmptyLabel: false,
            boxLabel: 'Remember me'
        }, {
            xtype: 'hidden',
            name: '_csrf_token',
            value:''
        }],
    buttons: [{
            text: 'OK',
            formBind: true,
            handler: function() {
                var data = this.up('form').getValues(false);
                
//this.up('form').getForm().findField('username').setReadOnly(true);

                Ext.Ajax.request({
                    url: '/' + Ext.locale + '/login_check',
                    params: {
                        _username: data._username,
                        _password: data._password,
                        _remember_me: data._remember_me
                        
                    },
                    method: 'POST',
                    success: function(response) {
                        var results = Ext.JSON.decode(response.responseText);
			if(results.success == true) {
				window.location.href = "/";
			} else {
				alert(results.message);
			}
                    },
                    failure: function() {
                        alert("fffff");
                    }
                });
            }
        },
        {text: 'Cancel',
            handler: function() {
                if (Ext.getCmp("userloginform_id")) {

                    Ext.getCmp("userloginform_id").destroy();
                }
            }
        }]
});

