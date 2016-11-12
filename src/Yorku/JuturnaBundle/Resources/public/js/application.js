// This is a manifest file that'll be compiled into application.js, which will include all the files
// listed below.
//
// Any JavaScript/Coffee file within this directory, lib/assets/javascripts, vendor/assets/javascripts,
// or vendor/assets/javascripts of plugins, if any, can be referenced here using a relative path.
//
// It's not advisable to add code directly here, but if you do, it'll appear at the bottom of the
// the compiled file.
//
// WARNING: THE FIRST BLANK LINE MARKS THE END OF WHAT'S TO BE PROCESSED, ANY BLANK LINE SHOULD
// GO AFTER THE REQUIRES BELOW.
//
//= require jquery
//= require jquery_ujs
//= require_tree .




/*
 * Copyright (c) 2008-2012 The Open Source Geospatial Foundation
 *
 * Published under the BSD license.
 * See https://github.com/geoext/geoext2/blob/master/license.txt for the full text
 * of the license.
 */
if (typeof app === 'undefined') {
    app = {};
}

app.OutputPDF = function () {
//    leafletImage(window.map, function (err, canvas) {
//        // now you have canvas
//        // example thing to do with that canvas:
//        var img = document.createElement('img');
//        var dimensions = window.map.getSize();
//        img.width = dimensions.x;
//        img.height = dimensions.y;
//        img.src = canvas.toDataURL();
//        document.getElementById('map_printimage_id').innerHTML = '';
//        document.getElementById('map_printimage_id').appendChild(img);
//    });
//$("div.leaflet-control-container div.leaflet-sidebar").hide();// 

//    if ($("div.leaflet-control-container div.leaflet-sidebar .leftsidebar-close-control").is(":visible") === false) {
//
//        window.leftSidebar.hide();
//        $("div.leaflet-control-container div.leaflet-sidebar .leftsidebar-close-control").removeClass("hidden");
//        $("div.leaflet-control-container div.leaflet-sidebar .leftsidebar-close-control").show();
//    }// 
//    $("div.leaflet-control-container div.leaflet-sidebar").attr("data-html2canvas-ignore", true);// 
//    $("div.leaflet-control-container .leaflet-top.leaflet-right").attr("data-html2canvas-ignore", true);// 
//    $("div.leaflet-control-container .leaflet-bottom.leaflet-right").attr("data-html2canvas-ignore", true);// 
//    $("div.leaflet-control-container .leaflet-bottom.leaflet-left .leaflet-control-mouseposition").attr("data-html2canvas-ignore", true);// 
//    $("div.leaflet-control-container .maptoolbar-control.leaflet-control").attr("data-html2canvas-ignore", true);// 

    function exportMap() {

        var mapPane = $(".leaflet-map-pane")[0];
        var mapTransform = mapPane.style.transform.split(",");
        var mapX = parseFloat(mapTransform[0].split("(")[1].replace("px", ""));
        var mapY = parseFloat(mapTransform[1].replace("px", ""));
        mapPane.style.transform = "";
        mapPane.style.left = mapX + "px";
        mapPane.style.top = mapY + "px";

        var myTiles = $("img.leaflet-tile");
        var tilesLeft = [];
        var tilesRight = [];
        var tilesTop = [];
        var tileMethod = [];
        for (var i = 0; i < myTiles.length; i++) {
            if (myTiles[i].style.left !== "") {
                tilesLeft.push(parseFloat(myTiles[i].style.left.replace("px", "")));
                tilesTop.push(parseFloat(myTiles[i].style.top.replace("px", "")));
                tileMethod[i] = "left";
            } else if (myTiles[i].style.transform !== "") {
                var tileTransform = myTiles[i].style.transform.split(",");
                tilesLeft[i] = parseFloat(tileTransform[0].split("(")[1].replace("px", ""));
                tilesTop[i] = parseFloat(tileTransform[1].replace("px", ""));
                myTiles[i].style.transform = "";
                tileMethod[i] = "transform";
            } else {
                tilesLeft[i] = 0;
                tilesRight[i] = 0;
                tileMethod[i] = "neither";
            }
            myTiles[i].style.left = (tilesLeft[i]) + "px";
            myTiles[i].style.top = (tilesTop[i]) + "px";
        }

        var myDivicons = $(".leaflet-marker-icon");
        var dx = [];
        var dy = [];
        for (var i = 0; i < myDivicons.length; i++) {
            var curTransform = myDivicons[i].style.transform;
            if (curTransform !== '') {
                var splitTransform = curTransform.split(",");
                dx.push(parseFloat(splitTransform[0].split("(")[1].replace("px", "")));
                dy.push(parseFloat(splitTransform[1].replace("px", "")));
                myDivicons[i].style.transform = "";
                myDivicons[i].style.left = dx[i] + "px";
                myDivicons[i].style.top = dy[i] + "px";
            }
        }

        var mapWidth = parseFloat($("#leafmap").css("width").replace("px", ""));
        var mapHeight = parseFloat($("#leafmap").css("height").replace("px", ""));

        var linesLayer = $("svg.leaflet-zoom-animated")[0];
        var oldLinesWidth = linesLayer.getAttribute("width");
        var oldLinesHeight = linesLayer.getAttribute("height");
        var oldViewbox = linesLayer.getAttribute("viewBox");
        linesLayer.setAttribute("width", mapWidth);
        linesLayer.setAttribute("height", mapHeight);
        linesLayer.setAttribute("viewBox", "0 0 " + mapWidth + " " + mapHeight);
        var linesTransform = linesLayer.style.transform.split(",");
        var linesX = parseFloat(linesTransform[0].split("(")[1].replace("px", ""));
        var linesY = parseFloat(linesTransform[1].replace("px", ""));
        linesLayer.style.transform = "";
        linesLayer.style.left = "";
        linesLayer.style.top = "";

        var hideLayer = $("svg.leaflet-zoom-hide")[0];
        var oldHideWidth = hideLayer.getAttribute("width");
        var oldHideHeight = hideLayer.getAttribute("height");
        hideLayer.setAttribute("width", mapWidth);
        hideLayer.setAttribute("height", mapHeight);

        //get transform value
        var image = html2canvas($("#leafmap")[0], {
            allowTaint: false,
            logging: true,
            useCORS: true,
            background: "#E8F0F6",
            onrendered: function (canvas) {

                var a = document.createElement('a');
                //a.download = name;
                var dataUrl = canvas.toDataURL('image/png');
                if (a.download !== undefined) {
                    a.setAttribute("href", dataUrl);
                    a.setAttribute("download", "sample");
                } else if (navigator.msSaveBlob) {
                    a.addEventListener("click", function (event) {
                        var blob = dataURItoBlob(dataUrl);
                        navigator.msSaveBlob(blob, "sample" + '.png');
                    }, false);
                    a.setAttribute("onmouseover", "");
                    a.setAttribute("style", "cursor: pointer; cursor: hand;");
                }

                document.body.appendChild(a);
                a.click();


            },
            width: 800,
            height: 450
        });

        for (var i = 0; i < myTiles.length; i++) {
            if (tileMethod[i] === "left") {
                myTiles[i].style.left = (tilesLeft[i]) + "px";
                myTiles[i].style.top = (tilesTop[i]) + "px";
            } else if (tileMethod[i] === "transform") {
                myTiles[i].style.left = "";
                myTiles[i].style.top = "";
                myTiles[i].style.transform = "translate(" + tilesLeft[i] + "px, " + tilesTop[i] + "px)";
            } else {
                myTiles[i].style.left = "0px";
                myTiles[i].style.top = "0px";
                myTiles[i].style.transform = "translate(0px, 0px)";
            }
        }
        for (var i = 0; i < myDivicons.length; i++) {
            myDivicons[i].style.transform = "translate(" + dx[i] + "px, " + dy[i] + "px)";
            myDivicons[i].style.left = "0px";
            myDivicons[i].style.top = "0px";
        }
        linesLayer.style.transform = "translate(" + (linesX) + "px," + (linesY) + "px)";
        linesLayer.setAttribute("viewBox", oldViewbox);
        linesLayer.setAttribute("width", oldLinesWidth);
        linesLayer.setAttribute("height", oldLinesHeight);

        hideLayer.setAttribute("width", oldHideWidth);
        hideLayer.setAttribute("height", oldHideHeight);

        mapPane.style.transform = "translate(" + (mapX) + "px," + (mapY) + "px)";
        mapPane.style.left = "";
        mapPane.style.top = "";
        return image;
    }
    ;






    function dataURItoBlob(dataURI) {
        var byteString;
        if (dataURI.split(',')[0].indexOf('base64') >= 0)
            byteString = atob(dataURI.split(',')[1]);
        else
            byteString = unescape(dataURI.split(',')[1]);
        var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
        var ia = new Uint8Array(byteString.length);
        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }
        return new Blob([ia], {type: mimeString});
    }



    function svgToCanvas(targetElem) {
        var nodesToRecover = [];
        var nodesToRemove = [];

        var images = targetElem.find('img');
        for (var i = 0; i < images.length; i++) {
            images[i].setAttribute('crossOrigin', 'anonymous');
            images[i].src = images[i].src;
        }

        var svgElems = targetElem.find("svg");
        alert(svgElems.length);
        for (var i = 0; i < svgElems.length; i++) {
            var node = svgElems[i];
            var parentNode = node.parentNode;
            var svg = parentNode.innerHTML;

            var canvas = document.createElement('canvas');

            canvg(canvas, svg);

            nodesToRecover.push({
                parent: parentNode,
                child: node
            });
            parentNode.removeChild(node);

            nodesToRemove.push({
                parent: parentNode,
                child: canvas
            });

            parentNode.appendChild(canvas);
        }

        var width = targetElem.width(); //这是我们准备画的div
        var height = targetElem.height();

        html2canvas(targetElem, {
            logging: true,
            userCORS: true,
            onrendered: function (canvas) {
                var context = canvas.getContext('2d');


                for (i = 0; i < images.length; i++) {
                    if (typeof images[i] != 'undefined') {
                        context.drawImage(images[i],
                                images[i].style.left.slice(0, -2), // slice off 'px' from end of str
                                images[i].style.top.slice(0, -2),
                                images[i].clientWidth,
                                images[i].clientHeight
                                );
                    }
                }
                window.open(canvas.toDataURL());

                $.map(nodesToRemove, function (node) {
                    node.parent.removeChild(node.child);
                });
                $.map(nodesToRecover, function (node) {
                    node.parent.appendChild(node.child);
                });
            }
        });
    }
    exportMap();
    // svgToCanvas($("#leafmap"));
}
;
