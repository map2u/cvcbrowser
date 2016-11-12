/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
    if (typeof app === 'undefined') {
        app = {};

    }

    app.updateHelpFileContent = function (item) {

        var files = item.files;
        if (typeof files === 'undefined' || files === null || files.length === 0) {
            return;
        }

        if (files.length > 1) {
            alert("Only support one help file.");
            return;
        }


        var ext = files[0].name.substring(files[0].name.lastIndexOf('.') + 1);
        if (ext !== 'html')
        {
            return;
        }
        var reader = new FileReader();
        reader.onload = function (progressEvent) {
            var result = this.result;
            var doc = $(item).parents("div.sonata-ba-collapsed-fields").find('iframe.cke_wysiwyg_frame')[0].contentWindow.document;
            var $body = $('body', doc);
            $body.html(result);
        };

        reader.readAsText(files[0]);

    };
});