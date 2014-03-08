/**
 * @copyright  2011 geOps
 * @license    https://github.com/geops/ole/blob/master/license.txt
 * @link       https://github.com/geops/ole
 */

OpenLayers.Editor.Control.SearchFeatureInfo = OpenLayers.Class(OpenLayers.Editor.Control, {

    proxy: null,

    title: OpenLayers.i18n('oleSearchFeatureInfo'),

    initialize: function(layer, options) {

        OpenLayers.Editor.Control.prototype.initialize.apply(this, options);
        this.layer=layer;
        this.events.register('activate', this, this.Search);
        this.title = OpenLayers.i18n('oleSearchFeatureInfo');

        this.displayClass = "oleControlDisabled " + this.displayClass;

    },

    test: function() {
        if (this.layer.features.length < 1) {
            this.deactivate();
        }
    },

    /**
     * Method: split Features
     */
    Search: function() {
         this.deactivate();
    },

    CLASS_NAME: 'OpenLayers.Editor.Control.SearchFeatureInfo'
});