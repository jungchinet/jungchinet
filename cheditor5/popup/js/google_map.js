// ================================================================
//                       CHEditor 5
// ----------------------------------------------------------------
// Homepage: http://www.chcode.com
// Copyright (c) 1997-2011 CHSOFT
// ================================================================
var button = [
    { alt : "", img : 'submit.gif', cmd : doSubmit },
    { alt : "", img : 'cancel.gif', cmd : popupClose }
];

var oEditor = null;
var centerLat = 0;
var centerLng = 0;
var latlng = 0;
var setZoom = 14;
var marker_lat = 0;
var marker_lng = 0;
var currentName = { '지도' : 'map',
                '중첩' : 'hybrid',
                '위성' : 'satellite',
                '지형' : 'satellite' };
var mapType;
var map;
var mapWidth = 512;
var mapHeight = 320;
var panorama;
var panoramaVisible = false;

function init(dialog) {
    oEditor = this;
    oEditor.dialog = dialog;

    var dlg = new Dialog(oEditor);
    dlg.showButton(button);

    var buttonUrl = oEditor.config.iconPath + 'button/map_address.gif';
    var search = new Image();
    search.src = buttonUrl;
    search.onclick = function() { searchAddress(); };
    search.className = 'button';
    document.getElementById('map_search').appendChild(search);
    dlg.setDialogHeight();

}

function doSubmit() {
    var mapImg = new Image();
    if (marker_lat == 0) marker_lat = centerLat;
    if (marker_lng == 0) marker_lng = centerLng;

    mapImg.setAttribute('width', mapWidth);
    mapImg.setAttribute('height',mapHeight);
    mapImg.style.border = '1px #000 solid';

    if (panoramaVisible) {
        var panoramaPitch = panorama.getPov().pitch;
        var panoramaHeading = panorama.getPov().heading;
        var panoramaZoom = panorama.getPov().zoom;
        var panoramaPosition = panorama.getPosition();

        mapImg.src = "http://maps.googleapis.com/maps/api/streetview?location=" + panoramaPosition +
            "&pitch=" + panoramaPitch +
            "&heading=" + panoramaHeading +
            "&size=" + mapWidth + 'x' + mapHeight +
            "&zoom=" + panoramaZoom +
            "&sensor=false";
    }
    else {
        mapImg.src = "http://maps.google.com/maps/api/staticmap?center=" + centerLat + ',' + centerLng +
            "&zoom=" + setZoom +
            "&size=" + mapWidth + 'x' + mapHeight +
            "&maptype=" + currentName[mapType] +
            "&markers=" + marker_lat + ',' + marker_lng +
            "&sensor=false" + "&language=ko";
    }

    oEditor.insertHtmlPopup(mapImg);
    oEditor.insertHtmlPopup(document.createElement('br'));
    oEditor.setImageEvent(true);
    popupClose();
}

function searchAddress() {
    var address = document.getElementById('fm_address').value;
    var geocoder = new google.maps.Geocoder();
    var results, status;
    var marker = new google.maps.Marker({ 'map': map, 'draggable': true });

    geocoder.geocode( {'address' : address},
            function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    centerLat = results[0].geometry.location.lat();
                    centerLng = results[0].geometry.location.lng();
                    latlng = new google.maps.LatLng(centerLat, centerLng);
                    //marker.setPosition(results[0].geometry.location);
                    map.setCenter(latlng);
                    map.setZoom(setZoom);
                }
            } );
}

function initMap(zoom) {
    zoom = zoom ? zoom : setZoom;
    var mapOptions = {
        zoom: zoom,
        panControl: true,
        zoomControl: true,
        scaleControl: true,
        center: new google.maps.LatLng(37.566, 126.977),
        disableDefaultUI: false,
        streetViewControl: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP };

    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

    google.maps.event.addListener(map, 'dragend', function() {
            centerLat = map.getCenter().lat();
            centerLng = map.getCenter().lng();
    });

    google.maps.event.addListener(map, 'maptypeid_changed', function() {
            mapType = map.getMapTypeId();
    });

    google.maps.event.addListener(map, 'zoom_changed', function() {
            setZoom = map.getZoom();
    });

    panorama = map.getStreetView();
    google.maps.event.addListener(panorama, 'visible_changed', function() {
        panoramaVisible = panorama.getVisible();
    });
}

function popupClose() {
    oEditor.popupWinClose();
}
