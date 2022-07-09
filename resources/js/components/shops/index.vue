<template>

    <div class="container">
       <Navbar/>
        <h2 class="text-center">Shop List</h2>
        <div class="row">
            <div class="col-md-12">
                <router-link :to="{ name: 'ShopCreate' }" class="btn btn-primary btn-sm float-right mb-2">Add New</router-link>
                <router-link :to="{ name: 'MapView' }" class="btn btn-info btn-sm float-right mx-2 mb-2">View On Map</router-link>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
              
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(shop, key) of shops" v-bind:key="key">
                            <td>{{ key+1 }}</td>
                            <td>{{ shop.name }}</td>
                            <td>{{ shop.description }}</td>
                            <td>{{ shop.latitude }}</td>
                             <td>{{shop.longitude }}</td>
                            <td>
                                <router-link class="btn btn-success btn-sm" :to="{ name: 'ShopEdit', params: { shopId: shop.id }}">Edit</router-link>
                                <button class="btn btn-danger btn-sm" @click="deleteShop(shop.id)">Delete</button>
                            </td>
                            <td>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from "../nav.vue";
    export default {
        components: {
            Navbar
        },
        data() {
            return {
                shops: {}
            }
        },
        
        created() {
            this.getShops();
        },
        methods: {
            getShops() {
              this.axios.get('http://127.0.0.1:8000/api/v1/shops')
                  .then(response => {
                      this.shops = response.data;
                  });
            },
            deleteShop(shopId) {
                this.axios
                    .delete(`http://127.0.0.1:8000/api/v1/shops/${shopId}`)
                    .then(response => {
                        let i = this.shops.map(data => data.id).indexOf(shopId);
                        this.shops.splice(i, 1)
                    });
            }
        }
    }
</script>