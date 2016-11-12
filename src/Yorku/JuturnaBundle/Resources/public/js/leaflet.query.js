
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
                .attr('class', 'leaflet-control control-query');

        var link = $('<a>')
                .attr('class', 'control-button')
                .attr('href', '#')
                .html('<span class="icon query"></span>')
                .on('click', toggle)
                .appendTo($container)
                ;
        //    this.button = link;
        var $ui = $('<div>')
                .attr('class', 'query-ui');
        $('<div>')
                .attr('class', 'sidebar_heading')
                .appendTo($ui)
                .append(
                        $('<h4>')
                        .text(I18n.t('javascripts.query.title')));
        var barContent = $('<div>')
                .attr('class', 'sidebar_content')
                .appendTo($ui);

        var $section = $('<div>')
                .attr('class', 'section')
                .appendTo(barContent);
        var printMapButton = $("<button>")
                .attr('value', 'Output PDF')
                .attr('class', 'btn btn-default btn-sm')
                .html("Output PDF")
                .on('click', app.OutputPDF)
                .appendTo($section);
//        $('<div id="map_printimage_id" style="width:300px;height:250px;border:1px solid black;border-radius:5px;">')
//                
//                .appendTo($section);
        options.sidebar.addPane($ui);
//        jQuery(window).resize(function () {
//            barContent.height($('.leaflet-sidebar.right').height() - 70);
//        });


        map.on('zoomend', update);



        function update() {
            var disabled = map.getZoom() <= 5;
            link
                    .toggleClass('disabled', disabled)
                    .attr('data-original-title', I18n.t(disabled ?
                            'javascripts.site.query_disabled_tooltip' :
                            'javascripts.site.query_tooltip'));
        }

        update();
        function toggle(e) {

            if (e) {
                e.stopPropagation();
                e.preventDefault();
            }
            if (!link.hasClass('disabled')) {
                options.sidebar.togglePane($ui, link);
                if (link.hasClass('active')) {
                    //  RefreshContent();
                   // alert("active 2222");
                }
            }


            $('.leaflet-control .control-button').tooltip('hide');
        }
        control.toggle = toggle;
        control.activate = function (e) {

            alert("active 2");
            var $ui = $('.query-ui');
            if (options.sidebar.isVisible() === false || options.sidebar._currentButton !== this.button) {
                control.toggle(e);

            }
        };
        return $container[0];
    };

    return control;
};
