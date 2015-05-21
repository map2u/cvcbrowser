Ext.define('GeoExt.view.UserAccountManagement', {
    extend: 'Ext.form.Panel',
    alias: 'widget.useraccountmanagement',
    id: 'useraccount-management-form',
    frame: true,
    border: false,
    //     title: 'User Account Management',
    bodyPadding: 5,
    //style:{marginLeft:'auto',marginRight:'auto',marginTop:'5px'},
    height: 495,
    width: 730,
    layout: 'column', // Specifies that the items will now be arranged in columns
    fieldDefaults: {
        labelAlign: 'left',
        msgTarget: 'side'
    },
    items: [{
            columnWidth: 0.60,
            xtype: 'gridpanel',
            store: Ext.data.StoreManager.lookup('useraccount-management-formstore'),
            height: 475,
            title: '',
            columns: [
                {
                    id: 'useraccountmanagementform_id',
                    text: 'User Name',
                    flex: 1,
                    width: 125,
                    sortable: true,
                    dataIndex: 'username'
                },
                {
                    text: 'Email',
                    width: 125,
                    sortable: true,
                    dataIndex: 'email'
                },
                {
                    text: 'First Name',
                    width: 75,
                    sortable: true,
                    dataIndex: 'first_name'
                },
                {
                    text: 'Last Name',
                    width: 75,
                    sortable: true,
                    dataIndex: 'last_name'
                },
                {
                    text: 'Phone Number',
                    width: 145,
                    sortable: true,
                    dataIndex: 'phone_number'
                },
                {
                    text: 'Address',
                    width: 145,
                    sortable: true,
                    dataIndex: 'address'
                },
                {
                    text: 'Postal Code',
                    width: 70,
                    sortable: true,
                    dataIndex: 'postal_code'
                },
                {
                    text: 'Created At',
                    width: 320,
                    sortable: true,
                    dataIndex: 'created_at'
                },
                {
                    text: 'Updated At',
                    width: 320,
                    sortable: true,
                    dataIndex: 'updated_at'
                },
                {
                    text: 'Status',
                    width: 60,
                    sortable: true,
                    dataIndex: 'status'
                }
            ],
            listeners: {
                selectionchange: function(model, records) {
                    if (records[0]) {
                        this.up('form').getForm().loadRecord(records[0]);
                    }
                }
            }
        }, {
            columnWidth: 0.4,
            margin: '0 0 0 10',
            xtype: 'fieldset',
            height: 475,
            title: 'User Account Details:',
            defaults: {
                width: 265,
                labelAlign: 'right',
                labelWidth: 110
            },
            defaultType: 'textfield',
            items: [{
                    fieldLabel: 'ID#',
                    readOnly: true,
                    name: 'id'
                }, {
                    fieldLabel: 'User Name',
                    readOnly: true,
                    name: 'username'
                }, {
                    fieldLabel: 'Email',
                    name: 'email'
                }, {
                    fieldLabel: 'First Name',
                    name: 'first_name'
                }, {
                    fieldLabel: 'Last Name',
                    name: 'last_name'
                }, {
                    fieldLabel: 'Phone Number',
                    name: 'phone_number'
                }, {
                    fieldLabel: 'Address',
                    name: 'address'
                }, {
                    fieldLabel: 'Postal Code',
                    name: 'postal_code'
                }, {
                    fieldLabel: 'Created At',
                    readOnly: true,
                    name: 'created_at'
                }, {
                    xtype: 'combo',
                    triggerAction: 'all',
                    fieldLabel: 'Status',
                    valueField: 'id',
                    displayField: 'label',
                    store: new Ext.data.SimpleStore({fields: ['id', 'label'],
                        data: [['pending', 'pending'], ['passive', 'passive'], ['approved', 'approved'], ['active', 'active'], ['suspended', 'suspended'], ['deleted', 'deleted']
                        ]
                    }),
                    forceSelection: true,
                    //	readOnly:true,
                    editable: false,
                    mode: 'local',
                    name: 'status'
                }, {
                    xtype: 'textarea',
                    fieldLabel: 'Reason',
                    height: 50,
                    autoScroll: true,
                    name: 'reason'
                }, {
                    fieldLabel: 'New Password',
                    name: 'newpassword'
                }, {
                    xtype: 'combo',
                    fieldLabel: 'Group Name',
                    triggerAction: 'all',
                    valueField: 'id',
                    displayField: 'group_name',
                    store: Ext.create('Ext.data.Store', {
                        proxy: {
                            type: 'ajax',
                            url: '/' + Ext.locale + '/groupnames/combobox',
                            method: 'GET',
                            reader: {
                                type: 'json',
                                root: 'data',
                            }
                        },
                        fields: ['id',
                            'group_name'],
                        root: 'data',
                        id: 'id',
                        autoLoad: true}),
                    forceSelection: true,
                    editable: false,
                    mode: 'local',
                    name: 'groupname_id'
                }, {
                    xtype: 'combo',
                    fieldLabel: 'User Role',
                    triggerAction: 'all',
                    valueField: 'id',
                    displayField: 'name',
                    store: Ext.create('Ext.data.Store', {
                        proxy: {
                            type: 'ajax',
                            url: '/' + Ext.locale + '/users/roles',
                            method: 'GET',
                            reader: {
                                type: 'json',
                                root: 'data',
                            }
                        },
                        fields: ['id',
                            'name'],
                        root: 'data',
                        id: 'id',
                        autoLoad: true}),
                    forceSelection: true,
                    editable: false,
                    mode: 'local',
                    name: 'role_id'
                }, {
                    xtype: 'container',
                    style: 'padding-left:55px;padding-top:10px',
                    items: [{text: 'Add New', xtype: 'button', handler: function() {
                                Ext.getCmp("useraccount-management-form").child('gridpanel').store.add(new GeoExt.model.User({status: 'pending'}));
                                Ext.getCmp("useraccount-management-form").getForm().findField('username').setReadOnly(false);
                                Ext.getCmp("useraccount-management-form").child('gridpanel').getSelectionModel().select(Ext.getCmp("useraccount-management-form").child('gridpanel').store.getCount() - 1);
                            }
                        }, {text: 'Update', xtype: 'button', handler: function() {
//alert(gridForm);
//alert(gridForm.child('fieldset'));
//alert(gridForm.getForm().getValues(false));



                                if ((this.up('form').getForm() != null) && (this.up('form').getForm().isValid()))
                                {
//alert(this.up('form').getForm().getValues(false));
//alert("store=" + Ext.getCmp("useraccount-management-form").child('gridpanel').store);
                                    var jsondata = Ext.JSON.encode(this.up('form').getForm().getValues(false));
                                    this.up('form').getForm().submit({
                                        params: {data: jsondata},
                                        method: 'POST',
                                        url: '/' + Ext.locale + '/users/accountupdate',
                                        format: 'json',
                                        timeout: 300000,
                                        waitMsg: 'Please wait while processing the account info.',
                                        success: function(result, request)
                                        {
                                            var results = Ext.JSON.decode(request.response.responseText);

                                            if (results.success == true)
                                            {


                                                Ext.getCmp("useraccount-management-form").child('gridpanel').store.load();

                                                alert(results.message);
                                                Ext.getCmp("useraccount-management-form").getForm().findField('username').setReadOnly(true);

//										this.up('form').getForm().findField('username').setReadOnly(true);
                                                //this.up('form').child('gridpanel').store.load();
                                                //	alert(results.message);
                                            }
                                            else
                                            {
                                                alert(results.message);
                                            }
                                        },
                                        failure: function(result, request)
                                        {
                                            var results = Ext.JSON.decode(request.response.responseText);
                                            if (results.success == true)
                                            {
                                                alert(results.message);
                                            }
                                            else
                                            {
                                                alert(results.message);
                                            }
                                        }
                                    });
                                }
                            }
                        }, {text: 'Delete', xtype: 'button', handler: function() {

                                if ((this.up('form').getForm() != null) && (this.up('form').getForm().isValid()))
                                {
                                    Ext.MessageBox.confirm('Delete the selected user account?', 'Are you sure that you want to delete the selected user account?', function(btn) {

                                        if (btn == 'yes')
                                        {
//alert(gridForm.getForm().getValues(false));
                                            var jsondata = Ext.JSON.encode(Ext.getCmp("useraccount-management-form").getForm().getValues(false));
                                            Ext.getCmp("useraccount-management-form").getForm().submit({
                                                params: {id: jsondata.id},
                                                method: 'POST',
                                                url: '/' + Ext.locale + '/users/destroy',
                                                format: 'json',
                                                success: function(result, request)
                                                {
                                                    var results = Ext.JSON.decode(request.response.responseText);
                                                    if (results.success == true || results.success == 'true')
                                                    {
                                                        alert(results.message);
                                                        Ext.getCmp("useraccount-management-form").child('gridpanel').store.load();

                                                    }
                                                    else
                                                    {
                                                        alert(results.message);
                                                    }
                                                },
                                                failure: function(result, request)
                                                {
                                                    var results = Ext.JSON.decode(request.response.responseText);

                                                    if (results.success == true)
                                                    {
                                                        alert(results.message);
                                                    }
                                                    else
                                                    {
                                                        alert(results.message);
                                                    }
                                                }
                                            });

                                        }
                                    });
                                }


                            }
                        }]
                }]
        }]
});

