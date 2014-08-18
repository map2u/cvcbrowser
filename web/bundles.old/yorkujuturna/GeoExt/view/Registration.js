Ext.define('GeoExt.view.Registration', {
    extend: 'Ext.form.Panel',
    alias: 'widget.registrationform',
    requires: [
//	    'Ext.panel.Panel',
//	    'Ext.XTemplate'
//	    'Ext.Img',
//	    'Ext.JSON',
//	    'Ext.tip.QuickTipManager'
    ],
    frame: false,
    width: 330,
    bodyPadding: 10,
    style: {marginLeft: 'auto', padding: '5px', marginRight: 'auto', marginTop: '5px'},
    bodyBorder: true,
    //    title: 'Create New Account Request',

    defaults: {
        anchor: '100%'
    },
    fieldDefaults: {
        labelAlign: 'right',
        msgTarget: 'none',
        invalidCls: '' //unset the invalidCls so individual fields do not get styled as invalid
    },
    /*
     * Listen for validity change on the entire form and update the combined error icon
     */
    listeners: {
        fieldvaliditychange: function() {
            this.updateErrorState();
        },
        fielderrorchange: function() {
            this.updateErrorState();
        },
        destroy: function() {
            var errorPanel = Ext.getCmp('registration_error_tooltip_id');
            if (errorPanel)
                errorPanel.destroy();
        }
    },
    updateErrorState: function() {
        var me = this,
                errorCmp, fields, errors;

        if (me.hasBeenDirty || me.getForm().isDirty()) { //prevents showing global error when form first loads
            errorCmp = me.down('#formErrorState');
            fields = me.getForm().getFields();
            errors = [];
            fields.each(function(field) {
                Ext.Array.forEach(field.getErrors(), function(error) {
                    errors.push({name: field.getFieldLabel(), error: error});
                });
            });
            errorCmp.setErrors(errors);
            me.hasBeenDirty = true;
        }
    },
    items: [{
            xtype: 'textfield',
            name: 'username',
            fieldLabel: 'User Name',
            allowBlank: false,
     //       value: 'zhaoshuilin',
            minLength: 6
        }, {
            xtype: 'textfield',
            name: 'email',
            fieldLabel: 'Email Address',
            vtype: 'email',
    //        value: 'zhaoshuilin2004@yahoo.ca',
            allowBlank: false
        }, {
            xtype: 'textfield',
            name: 'first_name',
            fieldLabel: 'First Name',
       //     value: 'Joseph',
            allowBlank: false,
            minLength: 2
        }, {
            xtype: 'textfield',
            name: 'last_name',
      //      value: 'Zhao',
            fieldLabel: 'Last Name',
            allowBlank: false,
        }, {
            xtype: 'textfield',
            name: 'phone_number',
     //       value: '416-704-9247',
            fieldLabel: 'Phone Number',
            allowBlank: false,
        }, {
            xtype: 'textfield',
            name: 'address',
     //       value: '8 horizon cres',
            fieldLabel: 'Address',
            allowBlank: false,
        }, {
            xtype: 'textfield',
            name: 'postal_code',
      //      value: 'M1T 2G3',
            fieldLabel: 'Postal Code',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: 'Reason',
    //        value: ' for test',
            allowBlank: false,
            name: 'reason',
        },
        /*
         * Terms of Use acceptance checkbox. Two things are special about this:
         * 1) The boxLabel contains a HTML link to the Terms of Use page; a special click listener opens this
         *    page in a modal Ext window for convenient viewing, and the Decline and Accept buttons in the window
         *    update the checkbox's state automatically.
         * 2) This checkbox is required, i.e. the form will not be able to be submitted unless the user has
         *    checked the box. Ext does not have this type of validation built in for checkboxes, so we add a
         *    custom getErrors method implementation.
         */
        {
            xtype: 'checkboxfield',
            name: 'acceptterms',
            fieldLabel: 'Terms of Use',
            hideLabel: true,
            style: 'margin-top:15px',
            boxLabel: 'I have read and accept the <a href="/admin/terms_of_use" class="terms">Terms of Use</a>.',
            // Listener to open the Terms of Use page link in a modal window
            listeners: {
                click: {
                    element: 'boxLabelEl',
                    fn: function(e) {
                        var target = e.getTarget('.terms'),
                                win;
                        if (target) {
                            win = Ext.widget('window', {
                                title: 'Terms of Use',
                                modal: true,
                                html: '<iframe src="' + target.href + '" width="450" height="380" style="border:0"></iframe>',
                                buttons: [{
                                        text: 'Decline',
                                        handler: function() {
                                            this.up('window').close();
                                            formPanel.down('[name=acceptterms]').setValue(false);
                                        }
                                    }, {
                                        text: 'Accept',
                                        handler: function() {
                                            this.up('window').close();
                                            formPanel.down('[name=acceptterms]').setValue(true);
                                        }
                                    }]
                            });
                            win.show();
                            e.preventDefault();
                        }
                    }
                }
            },
            // Custom validation logic - requires the checkbox to be checked
            getErrors: function() {
                return this.getValue() ? [] : ['You must accept the Terms of Use']
            }
        }],
    dockedItems: [{
            xtype: 'container',
            dock: 'bottom',
            layout: {
                type: 'hbox',
                align: 'middle'
            },
            padding: '10 10 5',
            items: [{
                    xtype: 'component',
                    id: 'formErrorState',
                    baseCls: 'form-error-state',
                    flex: 1,
                    validText: 'Form is valid',
                    invalidText: 'Form has errors',
                    tipTpl: '', //Ext.create('Ext.XTemplate', '<ul><tpl for="."><li><span class="field-name">{name}</span>: <span class="error">{error}</span></li></tpl></ul>'),

                    getTip: function() {
                        var tip = this.tip;
                        if (!tip) {
                            tip = this.tip = Ext.widget('tooltip', {
                                target: this.el,
                                id: 'registration_error_tooltip_id',
                                title: 'Error Details:',
                                autoHide: false,
                                anchor: 'top',
                                mouseOffset: [-11, -2],
                                closable: true,
                                constrainPosition: false,
                                cls: 'errors-tip'
                            });
                            tip.show();
                        }
                        return tip;
                    },
                    setErrors: function(errors) {
                        var me = this,
                                baseCls = me.baseCls,
                                tip = me.getTip();

                        errors = Ext.Array.from(errors);

                        // Update CSS class and tooltip content
                        if (errors.length) {
                            me.addCls(baseCls + '-invalid');
                            me.removeCls(baseCls + '-valid');
                            me.update(me.invalidText);
                            tip.setDisabled(false);
                            tip.update(me.tipTpl.apply(errors));
                        } else {
                            me.addCls(baseCls + '-valid');
                            me.removeCls(baseCls + '-invalid');
                            me.update(me.validText);
                            tip.setDisabled(true);
                            tip.hide();
                        }
                    }
                }, {
                    xtype: 'button',
                    formBind: true,
                    disabled: true,
                    text: 'Submit Request',
                    width: 140,
                    handler: function() {
                        var form = this.up('form').getForm();

                        if (form.isValid()) {
                            try {
                                var jsondata = Ext.JSON.encode(form.getValues(false));
                            }
                            catch (err)
                            {
                                Ext.MessageBox.alert(err);
                            }
                            /* Normally we would submit the form to the server here and handle the response... */
                            form.submit({
                                params: {user: jsondata},
                                method: 'POST',
                                clientValidation: true,
                                url: '/' + Ext.locale + '/users/createaccount',
                                success: function(form, action) {
                                   var result = Ext.JSON.decode(action.response.responseText);
                                    if (result.success == true)
                                    {
                                        Ext.Msg.alert('Summit Request', 'Successful registed!');
                                    }
                                    else
                                    {
                                        Ext.Msg.alert('Summit Request', result.message);
                                    }
                                    //...
                                },
                                failure: function(form, action) {
alert(action.response);
                                    var result = Ext.JSON.decode(action.response.responseText);
                                    Ext.Msg.alert('Summit Request', result.message);
                                    //...
                                }
                            });

                            //  Ext.Msg.alert('Submitted Values', form.getValues(true));
                        }
                    }
                }]
        }]
});

