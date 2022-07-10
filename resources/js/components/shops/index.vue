<template>

    <div class="container">
       <Navbar/>
        <!-- <h2 class="text-center">Shop List</h2> -->
        
        <div class="row card">
            <div class="card-header">
                <h4 class="text-center">Shops List</h4>
                <div class="row">
            <div class="col-md-12">
                <router-link :to="{ name: 'ShopCreate' }" class="btn btn-primary btn-sm float-right mb-2">Add New</router-link>
                <router-link :to="{ name: 'MapView' }" class="btn btn-info btn-sm float-right mx-2 mb-2">View On Map</router-link>
            </div>
        </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-primary">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Latitude</th>
                        <th scope="col">Longitude</th>
                        <th scope="col">Actions</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(shop, key) of shops" v-bind:key="key">
                            <td scope="row">{{ key+1 }}</td>
                            <td scope="row">
                                <img v-bind:src="'/shop-images/' + shop.image"  alt="shop" style="width:100px; height:100px;">
                            </td>
                            <td scope="row">
                                {{ shop.name }}
                                </br>
                               <span class="badge badge-primary">{{shop.user.name}}</span> 
                            </td>
                            <td scope="row">{{ shop.description }}</td>
                            <td scope="row">{{ shop.latitude }} </td>
                            <td scope="row">{{shop.longitude }}</td>
                            <td scope="row">
                                <div class="d-flex flex-row">
                                     <router-link class="btn btn-success btn-sm mx-2" :to="{ name: 'ShopEdit', params: { id: shop.id }}">Edit</router-link>
    
                                    <button class="btn btn-danger btn-sm" @click="deleteShop(shop.id)">Delete</button>
                                </div>
                            </td>
                           
                        </tr>
                    </tbody>
                </table>
                </div>
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
                shops: {},
                user: {
                    id: ''
                },
            }
        },
        
        created() {
            let session = this.$session.get('jwt');
            this.user = session.user;
            
            this.getShops();
        },
        methods: {
            getShops() {
              this.axios.get('http://127.0.0.1:8000/api/v1/shops/?userId='+this.user.id)
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