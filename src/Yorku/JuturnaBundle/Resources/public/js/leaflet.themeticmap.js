
/**
 * <copyright>
 * This file/program is free and open source software released under the GNU General Public
 * License version 3, and is distributed WITHOUT ANY WARRANTY. A copy of the GNU General
 * Public Licence is available at http://www.gnu.org/licenses
 * </copyright>
 *
 * <author>Shuilin (Joseph) Zhao</author>
 * <company>SpEAR Lab, Faculty of Environmental Studies, York University
 * <email>zhaoshuilin2004@yahoo.ca</email>
 * <date>created at 2015/09/24</date>
 * <date>last updated at 2015/09/24</date>
 * <summary>This is a tool for themetic map</summary>
 * <purpose>management of themetic map for logged in user</purpose>
 */

L.MAP2U.themeticmap = function (options) {
    var control = L.control(options);
    var currentTool;
    var toolbuttons = ['polyline', 'polygon', 'rectangle', 'circle'];
    control.onAdd = function (map) {
        var $container = $('<div>')
                .attr('class', 'leaflet-control control-themeticmap');
        var button = $('<a>')
                .attr('class', 'control-button')
                .attr('href', '#')
                .html('<span class="icon themeticmap"></span>')
                .on('click', toggle)
                .appendTo($container);
        this.button = button;
        var $ui = $('<div>')
                .attr('class', 'themeticmap-ui');
        $('<div>')
                .attr('class', 'sidebar_heading')
                .appendTo($ui)
                .append(
                        $('<h4>')
                        .text(I18n.t('javascripts.themeticmap.title')));
        var barContent = $('<div>')
                .attr('class', 'sidebar_content')
                .appendTo($ui);

        var $section = $('<div>')
                .attr('class', 'section')
                .appendTo(barContent);





        options.sidebar.addPane($ui);
        jQuery(window).resize(function () {
            barContent.height($('.leaflet-sidebar.right').height() - 70);
        });
        map.on('zoomend', update);
        function update() {
            var disabled = false;
            button.toggleClass('disabled', disabled).attr('data-original-title', I18n.t(disabled ? 'javascripts.site.measure_disabled_tooltip' :
                    'javascripts.site.themeticmap_tooltip'));
        }
        update();
        function toggle(e) {
            e.stopPropagation();
            e.preventDefault();
            if (!button.hasClass('disabled')) {
                options.sidebar.togglePane($ui, button);
            }
            $('.leaflet-control .control-button').tooltip('hide');
        }

        control.activate = function (e) {
            
            alert("active 2");
            var $ui = $('.themeticmap-ui');
            if (options.sidebar.isVisible() === false || options.sidebar._currentButton !== this.button) {
                control.toggle(e);
                control.showthemeticmapinfo();
            }
        };

        control.showthemeticmapinfo = function () {
            var $ui = $('.themeticmap-ui');
            alert("active");
        };
        return $container[0];
    };
    return control;
};
