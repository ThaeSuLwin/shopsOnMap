<template>
  <div class="container">
    <ul>
      <li
        v-for="(marker, index) in markers"
        :key="index"
        @click="displayTooltip(index)"
      >
        {{ marker.name }}
      </li>
    </ul>

    <l-map :zoom="zoom" :center="center" style="height: 100%; width:100%">
      <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
      <l-marker
        v-for="(marker, index) in markers"
        :key="index"
        ref="markersRef"
        :lat-lng="marker.position"
      >
      <l-tooltip>
       {{marker.name}}
        
        </l-tooltip>
        <!-- <l-popup>{{marker.name}}</l-popup> -->
        <!-- l-popup :content="marker.name"/ -->
      </l-marker>
    </l-map>
  </div>
</template>

<script>
import { LMap, LTileLayer, LMarker, LTooltip, LPopup } from "vue2-leaflet";
import L from "leaflet";
import "leaflet/dist/leaflet.css";

L.Icon.Default.imagePath = "https://unpkg.com/leaflet@1.3.4/dist/images/";

export default {
  name: "MyMap",
  components: {
    "l-map": LMap,
    "l-tile-layer": LTileLayer,
    "l-marker": LMarker,
    "l-tooltip": LTooltip,
    "l-popup": LPopup,
  },
  data() {
    return {
      zoom: 10,
      center: { lat: 16.8389525, lng: 95.901376 },
      url: "http://{s}.tile.osm.org/{z}/{x}/{y}.png",

      markers: [],
      markerObjects: null,

  
    };
  },
  created: function () {
          this.getShops();
        },

  mounted: function () {
    this.$nextTick(() => {
      this.markerObjects = this.$refs.markersRef.map((ref) => ref.mapObject);
    });
    
  },

  methods: {
    getShops() {
              this.axios.get('http://127.0.0.1:8000/api/v1/shops/map-view')
                  .then(response => {
                   
                      this.markers = response.data.data;
                      
                  });
            },
    displayTooltip(selectedIndex) {
      for (let markerObject of this.markerObjects) {
        markerObject.closeTooltip();
      }
      this.markerObjects[selectedIndex].toggleTooltip();
    },
  },
};
</script>




<style>
html,
body,
#app,
div.container {
  width: 100%;
  height: 100%;
  top: 50%;
  left: 50%;
  
    
}
li {
  cursor: pointer;
}
</style>
