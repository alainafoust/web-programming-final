//the various variables needed to make our map work
var map;
var marker;
var infowindow;
var messagewindow;
var markerWindow;

var form;
var node;

var message;
var msgNode;

//labels the saved markers via their type
var customLabel = {
    Retail: {
      label: 'R'
    },
    Florist: {
        label: 'F'
    },
    Nursery: {
       label: 'N' 
    },
    Farm: {
        label: 'F'
    },
    Garden: {
        label: 'G'
    }
};

//function used to create our map
function initMap(){
    var pgh = {lat: 40.4350925, lng: -79.9649998};

    map = new google.maps.Map(document.getElementById('map'), {
        center: pgh,
        zoom: 12,
        disableDoubleClickZoom:true,
        scrollwheel: false,
        mapTypeId: 'roadmap'
    });

    //create the search box
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    //bias the SearchBox results towards the current map's viewport

    map.addListener('bounds_changed', function(){
        searchBox.setBounds(map.getBounds());
    });

    var markers = [];

    //event fires when user selects a prediction, retrieves more details about the place
    searchBox.addListener('places_changed', function(){
        var places = searchBox.getPlaces();

        if(places.length == 0){
            return;
        }
        //clears out old markers (not sure about this...)
        markers.forEach(function(marker){
            marker.setMap(null);
        });
        markers = [];

        //for each place, get some stuff
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place){
            if(!place.geometry){
                console.log("Returned place contains no geometry");
                return;
            }

            if(place.geometry.viewport){
                //only geocodes have viewport
                bounds.union(place.geometry.viewport);
            }
            else{
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });

    //BEGIN CODE FOR SHOWING SAVED MARKERS ON PAGE LOAD

    //the InfoWindow for the saved markers
    markerWindow = new google.maps.InfoWindow;

    //xml file code
    downloadUrl('get_markers.php', function(data){
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName('marker');
        Array.prototype.forEach.call(markers, function(markerElem){
            var id = markerElem.getAttribute('id');
            var name = markerElem.getAttribute('marker_name');
            var description = markerElem.getAttribute('description');
            var type = markerElem.getAttribute('marker_type');
            var point = new google.maps.LatLng(
                parseFloat(markerElem.getAttribute('lat')),
                parseFloat(markerElem.getAttribute('lng'))
            );

            var markerWinContent = document.createElement('div');
            var strong = document.createElement('strong');
            strong.textContent = name
            markerWinContent.appendChild(strong);
            markerWinContent.appendChild(document.createElement('br'));

            var text = document.createElement('text');
            text.textContent = description
            markerWinContent.appendChild(text);
            var icon = customLabel[type] || {};
            var marker = new google.maps.Marker({
                map: map,
                position: point,
                label: icon.label
            });
            marker.addListener('click', function(){
                markerWindow.setContent(markerWinContent);
                markerWindow.open(map, marker);
            });
        });
    });

    //the beginning of our javascript to add markers on click, fill out a form, and add them to the db
    infowindow = new google.maps.InfoWindow({}),
        form = '<div id="form">' +
                    'Name: <input type="text" id="name">&nbsp;' +
                    'Description: <input type="text" id="description">&nbsp;' +
                    'Type: ' +
                        '<select id="type">' + 
                            '<option value="Retail" selected>Retail</option>' +
                            '<option value="Florist">Florist</option>' +
                            '<option value="Nursery">Nursery</option>' +
                            '<option value="Farm">Farm</option>' +
                            '<option value="Garden">Garden</option>' +
                        '</select>&nbsp;' +
                    '<button onclick="saveData()">Save</button>' +
                '</div>';
        node = document.createElement('div'),
            content;

        node.innerHTML = form;
        content = node.firstChild
        infowindow.setContent(content);

    messagewindow = new google.maps.InfoWindow({}),
        message = '<div id="message">Success!</div>';
        msgNode = document.createElement('div'),
        content;

        msgNode.innerHTML = message;
        content = msgNode.firstChild
        messagewindow.setContent(content);

    google.maps.event.addListener(map, 'click', function(event) {

        marker = new google.maps.Marker({
            position: event.latLng,
            map: map
        });

        google.maps.event.addListener(marker, 'click', function(){

            infowindow.open(map, marker);
        });
    }); 

}

//function to add the new marked to the database
function saveData(){
    //our form data
    var name = encodeURI(document.getElementById("name").value);
    var desc = encodeURI(document.getElementById("description").value);
    var type = document.getElementById("type").value;
    //map data - the marker's location
    var latlng = marker.getPosition();
    //document to be used in ajax
    var url = "map_data.php?" + "name=" + name + "&desc=" + desc + "&type=" + type + "&lat=" + latlng.lat() + "&lng=" + latlng.lng();

    //document.write(vars);

    var request = window.ActiveXObject ?
        new ActiveXObject('Microsoft.XMLHTTP') :
        new XMLHttpRequest;

    request.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            //show the user the success msg
            infowindow.close();
            messagewindow.open(map, marker);
            //show me the sucess msg from the php file
            var return_data = request.responseText;
            document.getElementById("status").innerHTML = return_data;
        }
    };

    request.open("GET", url, true);
    request.send();
}

//get our markers on the running of the initMap() function
function downloadUrl(url, callback){
    //choose the obj based on the browser
    var request = window.ActiveXObject ?
        new ActiveXObject('Microsoft.XMLHTTP') :
        new XMLHttpRequest;

    request.onreadystatechange = function(){
        if(request.readyState == 4){
            request.onreadystatechange = doNothing;
            callback(request, request.status);
        }
    };
    request.open("GET", url, true);
    request.send(null); 
}

function doNothing(){

}