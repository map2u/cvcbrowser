
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
 * <summary>This is a tool for map content query</summary>
 * <purpose>query map content</purpose>
 */

L.MAP2U.query = function (options) {
    var control = L.control(options);

    control.onAdd = function (map) {
        var $container = $('<div>')
                .attr('class', 'control-query');

        var link = $('<a>')
                .attr('class', 'control-button')
                .attr('href', '#')
                .html('<span class="icon query"></span>')
                .appendTo($container);

        map.on('zoomend', update);

        update();

        function update() {
            var disabled = map.getZoom() < 12;
            link
                    .toggleClass('disabled', disabled)
                    .attr('data-original-title', I18n.t(disabled ?
                            'javascripts.site.query_disabled_tooltip' :
                            'javascripts.site.query_tooltip'));
        }

        return $container[0];
    };

    return control;
};
