/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


var abmglobal = (function($) {
    'use strict';
    var app = {
        is_mobile: /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent),
        current_modal: false,
        mini_cart: false,
        my_cart: false,
        infinite_scroll: false,
        slide_show: false,
        am: false,
        um: false,
        init: function() {
           
            app.am = new app.ajaxManager();
            $('iframe').each(function() {
                if ($(this).attr('src')) {
                    var url = $(this).attr('src'),
                            ch = '?';
                    if (url.indexOf('?') != -1) {
                        ch = '&';
                    }
                    $(this).attr('src', url + ch + 'wmode=transparent');
                }
            });

            // active state
            var path = window.location.pathname.split('/'),
            login_dropdown = new app.loginDropdown();
            app.logout();

        },
        ajaxManager: function() {
            var self = this,
                    requests = [],
                    last = false;
            self.request = false;
            self.addReq = function(opt, low_priority) {
                if (typeof low_priority !== 'undefined' && low_priority) {
                    requests.push(opt);
                } else {
                    requests.unshift(opt);
                }
            };
            self.removeReq = function(opt) {
                if ($.inArray(opt, requests) !== -1) {
                    requests.splice($.inArray(opt, requests), 1);
                }
            };
            self.doLast = function(opt) {
                last = opt;
            };
            self.run = function(item) {
                if (requests.length || typeof item !== 'undefined' || last) {
                    if (typeof item == 'undefined') {
                        item = requests.shift();
                    }

                    if (typeof item == 'undefined') {
                        if (!last) {
                            return;
                        }
                        item = last;
                        last = false;
                    }

                    var original_success = item.complete,
                            original_error = item.error;

                    item.complete = function() {
                        if (typeof original_success === 'function')
                            original_success();
                        self.run(requests.shift());
                    };
                    item.error = function(request, status, error) {
                        if (typeof original_error === 'function')
                            original_error();
                        $.ajax({
                            url: '',
                            dataType: 'json',
                            type: 'post',
                            data: {
                                url: location.href,
                                subject: 'AJAX error requesting ' + item.url + ' (' + request.status + ')',
                                params: JSON.stringify((typeof item.data === 'object') ? item.data : {}),
                                body: error
                            }
                        });
                    };

                    self.request = $.ajax(item);
                } else {
                    self.tid = setTimeout(function() {
                        self.run();
                    }, 500);
                }
            },
                    self.stop = function() {
                requests = [];
                if (self.request)
                    self.request.abort();
                clearTimeout(this.tid);
            };
            self.reset = function() {
                self.stop();
                self.run();
            }
            self.run();
        },
        loginDropdown: function() {
            var self = this,
                    focusing = false,
                    in_box = true,
                    tabbed = false,
                    timeout = null,
                    base_forgot_password_url = $('#forgot-password-link').attr('href');
            self.logging_in = false;
            self.autoFocus = function() {
                $('.login-dropdown').find('input:first').focus().select();
            };
            self.show = function() {
                $('.menu-wrapper').hide();
                $('.cart-dropdown').hide();
                $('.login-dropdown').stop(true, true).fadeIn(150);
            };
            self.hide = function() {
                if (focusing || self.logging_in || in_box) {
                    return;
                }
                $('.login-dropdown').stop(true, true).delay(500).fadeOut(250, function() {
                    $('.login-dropdown .message').hide();
                });
            };
            $(document).on('mouseenter', '.login', function() {
                in_box = true;
                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    self.show();
                }, 100);
            }).on('mouseleave', '.login', function() {
                in_box = false;
                clearTimeout(timeout);
                self.hide();
            }).on('keyup', '#login-username', function() {
                $('#forgot-password-link').attr('href', base_forgot_password_url + 'email/' + $(this).val());
            });
            $('.login-dropdown').find('input').keydown(function(e) {
                if (e.which === 9) {
                    tabbed = true;
                }
            }).focus(function() {
                focusing = true;
                tabbed = false;
            }).blur(function() {
                focusing = false;
                if (!in_box && !tabbed) {
                    self.hide();
                }
            });
            $('input[name="q"]').on('focus click', function() {
                $('.login-dropdown').stop(true, true).hide();
            });
            $('#login-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                if (form.validationEngine('validate')) {

                    self.logging_in = true;
                    form.find('#login-loading').show();
                    app.am.addReq({
                        url: '/' + _locale + '/login_check',
                        data: form.serialize(),
                        success: function(response) {

                            if (response.status === 'ok') {
                                window.location.reload(true);
                            } else {
                                form.find('#login-loading').hide();
                                self.logging_in = false;
                                $('.login-dropdown .message').html(response.message).show().fadeOut(200, function() {
                                    $(this).fadeIn(200, function() {
                                        $(this).fadeOut(200, function() {
                                            $(this).fadeIn(200);
                                        });
                                    });
                                });
                                self.show();
                                setTimeout(function() {
                                    self.hide();
                                }, 2000);
                            }
                        },
                        failure: function(response) {
                            alert("fal=" + response);
                        },
                        type: 'post',
                        dataType: 'json'
                    });
                }
            });
        },
        logout: function() {
            var self = this;
            self.planB = function() {
                window.location = $('#logout-link').attr('href');
            };
            $('#logout-link').on('click', function(e) {
                e.preventDefault();
                app.am.addReq({
                    url: $(this).attr('href'),
                    data: {
                        is_ajax: 1
                    },
                    success: function(response) {
                        if (response && response.status === 'ok') {
                            window.location.reload(true);
                        } else {
                            self.planB();
                        }
                    },
                    error: function() {
                        self.planB();
                    },
                    dataType: 'json'
                });
                return false;
            });
        }


    };
    $(function() {
        app.init();
    });
    return app;
}(jQuery));