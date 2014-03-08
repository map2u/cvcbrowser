/*

This file is part of Ext JS 4

Copyright (c) 2011 Sencha Inc

Contact:  http://www.sencha.com/contact

GNU General Public License Usage
This file may be used under the terms of the GNU General Public License version 3.0 as published by the Free Software Foundation and appearing in the file LICENSE included in the packaging of this file.  Please review the following information to ensure the GNU General Public License version 3.0 requirements will be met: http://www.gnu.org/copyleft/gpl.html.

If you are unsure which license is appropriate for your use, please contact the sales department at http://www.sencha.com/contact.

*/
Ext.require([
    'Ext.form.*',
    'Ext.Img',
    'Ext.JSON',
    'Ext.tip.QuickTipManager'
]);

Ext.onReady(function() {
    Ext.tip.QuickTipManager.init();

    var formPanel = Ext.widget('form', {
        renderTo: Ext.getBody(),
        frame: true,
        width: 350,
        bodyPadding: 10,
	style:{marginLeft:'auto',marginRight:'auto',marginTop:'15px'},
        bodyBorder: true,
        title: 'Create New Account Request',

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
            name: 'login',
            fieldLabel: 'Login Name',
            allowBlank: false,
            minLength: 6
        }, {
            xtype: 'textfield',
            name: 'email',
            fieldLabel: 'Email Address',
            vtype: 'email',
            allowBlank: false
        }, {
            xtype: 'textfield',
            name: 'first_name',
            fieldLabel: 'First Name',
            allowBlank: false,
            minLength: 2
        }, {
            xtype: 'textfield',
            name: 'last_name',
            fieldLabel: 'Last Name',
            allowBlank: false,
            }, {
            xtype: 'textfield',
            name: 'phone_number',
            fieldLabel: 'Phone Number',
            allowBlank: false,
        }, {
            xtype: 'textfield',
            name: 'address',
            fieldLabel: 'Address',
            allowBlank: false,
        }, {
            xtype: 'textfield',
            name: 'postal_code',
            fieldLabel: 'Postal Code',
            allowBlank: false,
           
        }, {
		xtype:'textarea',
		fieldLabel:'Reason',
		allowBlank:false,
		name:'reason',
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
            boxLabel: 'I have read and accept the <a href="/legal/terms_of_use/" class="terms">Terms of Use</a>.',

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
                tipTpl: Ext.create('Ext.XTemplate', '<ul><tpl for="."><li><span class="field-name">{name}</span>: <span class="error">{error}</span></li></tpl></ul>'),

                getTip: function() {
                    var tip = this.tip;
                    if (!tip) {
                        tip = this.tip = Ext.widget('tooltip', {
                            target: this.el,
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
		     		var jsondata=Ext.JSON.encode(form.getValues(false));
			}
			catch(err)
			{
				Ext.MessageBox.alert(err);
			}
                    	/* Normally we would submit the form to the server here and handle the response... */
                    	form.submit({
				params:{user:jsondata},
				method:'POST',
        	                clientValidation: true,
        	                url: '/users/create',
        	                success: function(form, action) {
					var result=Ext.JSON.decode(action.response.responseText);
					Ext.Msg.alert('Summit Request','Success');
                           //...
        	                },
        	                failure: function(form, action) {
					var result=Ext.JSON.decode(action.response.responseText);
					Ext.Msg.alert('Summit Request',result.message);
        	                    //...
        	                }
        	            });
                   
                      //  Ext.Msg.alert('Submitted Values', form.getValues(true));
                    }
                }
            }]
        }]
    });

});

