<template>
  <div class="container">
    <Navbar />
    <!-- <ul>
      <li
        v-for="(marker, index) in markers"
        :key="index"
        @click="displayTooltip(index)"
      >
        {{ marker.name }}
      </li>
    </ul> -->
    <div class="card" style="float:right;">
      <div class="card-header text-center">
        Search Shops
      </div>
    <div class="card-body">
      <form @submit.prevent="filtersearch()" >
      <div class="form-group">
        <input
          type="text"
          class="form-control"
          v-model="search.name"
          placeholder="Search by shop name"
        />
      </div>
      <div class="form-group">
        <!-- <input type="text"  class="form-control" name="elevation" placeholder="Search by user name"> -->
        
        <select v-model="search.user_id" class="form-control">
          <option :selected="true" value="">---Select---</option>
          <option v-for="user in users" v-bind:value="user.id">
            {{ user.name }}
          </option>
        </select>
      </div>
      <div class="form-group">
        <div class="row">
          <div class="col-md-6">
            <input
              type="text"
              class="form-control mt-1"
              placeholder="latitude"
              v-model="search.lat"
            />
          </div>
          <div class="col-md-6">
            <input
              type="text"
              class="form-control mt-1"
              placeholder="longitude"
              v-model="search.long"
            />
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="row m-1">
          
            <button type="submit" class="btn btn-primary w-100">Search</button>
          
        </div>
      </div>
    </form>
    </div>
</div>
      <l-map :zoom="zoom" :center="center" style="height: 100%; width: 50%">
      <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
      <l-marker
        v-for="(marker, index) in markers"
        :key="index"
        ref="markersRef"
        :lat-lng="marker.position"
      >
        <l-tooltip>
          {{ marker.name }}
        </l-tooltip>
        <l-popup>
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-6">
                 <img v-bind:src="'/shop-images/'+marker.image" alt="" style="width:50px; height:50px;"></img>
              </div>
              <div class="col-md-6">
                 <h4 class="">{{marker.name}}</h4>
              </div>
              <div class="col-md-12">
                 <p> {{ marker.description }}</p>
              </div>
            </div>

          </div>
         
         
          
          
       
        
        
          
          </l-popup>
        <!-- l-popup :content="marker.name"/ -->
      </l-marker>
    </l-map>
    
    </div>

</template>

<script>
import { LMap, LTileLayer, LMarker, LTooltip, LPopup } from "vue2-leaflet";
import L from "leaflet";
import "leaflet/dist/leaflet.css";
import Navbar from "../nav.vue";

L.Icon.Default.imagePath = "https://unpkg.com/leaflet@1.3.4/dist/images/";

export default {
  name: "MyMap",
  components: {
    "l-map": LMap,
    "l-tile-layer": LTileLayer,
    "l-marker": LMarker,
    "l-tooltip": LTooltip,
    "l-popup": LPopup,
    Navbar,
  },
  data() {
    return {
      zoom: 10,
      maxZoom: 18,
      center: { lat: 16.8389525, lng: 95.901376 },
      url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
      attribution: "Shops On Map",
      markers: [],
      markerObjects: null,
      users: [],
      search: {},
    };
  },
  created: function () {
    this.getShops() & this.getUsers();
  },
  methods: {
    getShops() {
      this.axios
        .get("http://127.0.0.1:8000/api/v1/shops/map-view")
        .then((response) => {
          console.log(response.data.data);
          this.markers = response.data.data;
        });
    },
    getUsers() {
      this.axios
        .get("http://127.0.0.1:8000/api/v1/auth/users")
        .then((response) => {
          // console.log(response.data);
          this.users = response.data;
        });
    },
    displayTooltip(selectedIndex) {
      for (let markerObject of this.markerObjects) {
        markerObject.closeTooltip();
      }
      this.markerObjects[selectedIndex].toggleTooltip();
    },

    filtersearch() {
      console.log(this.search);
      this.axios
        .post("http://127.0.0.1:8000/api/v1/shops/search", this.search)
        .then((response) => {
          
          this.markers = response.data.data;
        });
    },
    clearSearch() {
      this.search = "";
      this.getShops();
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
  height: 90%;
  /* float: left; */
}
li {
  cursor: pointer;
}
</style>
