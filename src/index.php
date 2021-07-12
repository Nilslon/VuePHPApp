<!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PHP Vue Bike Stations</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css">
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
  <style>
    .map {
      height: 100vh; 
      width: 100vw; 
    }
    .number-icon {
      background-image: url("marker-icon.png");
      text-align:center;
      color:White;    
    }
  </style>
 </head>
 <body>
    <div id="vueapp">
      <div id="map" class="map"></div>
    </div>
  </div>
 </body>
</html>

<script>

var application = new Vue({
 el:'#vueapp',
 data:{
  stations: [],
  myModel:false,
  map: null,
  tileLayer: null,
  layers: [],
  bikeNumbersDict: {},
 },
 mounted() {
    this.initMap();
  },
 methods:{
  initMap() {
    this.map = L.map('map').setView([51.47760675318881, 11.98426919260097], 15);
    this.tileLayer = L.tileLayer(
        'https://cartodb-basemaps-{s}.global.ssl.fastly.net/rastertiles/voyager/{z}/{x}/{y}.png',
        {
            maxZoom: 18,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, &copy; <a href="https://carto.com/attribution">CARTO</a>',
        }
    );
    this.tileLayer.addTo(this.map);
    },
    sleep:function(ms) {
  return new Promise((resolve) => {
    setTimeout(resolve, ms);
  });
},
  async fetchAllStations(){
   await axios.post('action.php', {
    action:'fetchallstations'
        }).then(function(response){
    application.stations = response.data;
   });
   this.initLayers();
  
  },
 async fetchAllBikes(){
    await axios.post('action.php', {
    action:'fetchallbikes'
   }).then(function(response){
    response.data.forEach((bike) => {
        if(application.bikeNumbersDict[bike.station] != null)
        {
          application.bikeNumbersDict[bike.station] += 1;
        }
        else {
          application.bikeNumbersDict[bike.station] = 1;
        }

      });
   });
  },

  async waitForFetch() {
    await this.fetchAllBikes();
    await this.fetchAllStations();
    this.initLayers();
  },

  initLayers() {
      application.stations.forEach((station) => {
        var numberIcon = L.divIcon({
          className: "number-icon",
          iconSize: [25, 41],
          iconAnchor: [10, 44],
          popupAnchor: [3, -40],
          html: application.bikeNumbersDict[station.id]
        });
        station.leafletObject = L.marker([station.x, station.y], {
          icon: numberIcon}), 
        station.leafletObject.addTo(this.map)
    .bindPopup(station.name + ": \n This Station has " + application.bikeNumbersDict[station.id] + " bikes");
    });  
 },


},
 created:function(){
  this.waitForFetch();
    
 }
});
</script>