Ext.define('GeoExt.view.Resetpassword', {
    extend: 'Ext.form.Panel',
    alias: 'widget.resetpasswordform',
    frame: false,
    frame : true,
            width: 290,
    bodyPadding: 5,
    fieldDefaults: {
        labelAlign: 'right',
        labelWidth: 120,
        anchor: '100%'
    },
    items: [{
            xtype: 'textfield',
            name: 'username',
            fieldLabel: 'User Name or Email'
        }],
    buttons: [{
            text: 'Reset Password',
            handler: function() {


                var jsondata = Ext.JSON.encode(this.up('form').getValues(false));

                Ext.Ajax.request({
                    url: '/' + Ext.locale + '/users/resetpassword',
                    params: {
                        user: jsondata
                    },
                    method: 'POST',
                    success: function(response) {
                         var result = Ext.JSON.decode(response.responseText);
                         
                        alert(result.message);
                       
                    },
                    failure: function() {
                       
                    }
                });

            }
       }, {
            text: 'Cancel',
            handler: function() {
                var forgetpassword_win = Ext.getCmp("resetpasswordwin_id");
                if (forgetpassword_win != null) {
                    forgetpassword_win.close();
                }
            }
        }]
});

