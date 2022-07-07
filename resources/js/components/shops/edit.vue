<template>
    <div class="container">
        <h2 class="text-center">Update Shop</h2>
        <div class="row">
            <div class="col-md-12">
                <router-link :to="{ name: 'ShopIndex' }" class="btn btn-primary btn-sm float-right mb-2">Back</router-link>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="shop.name">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea type="text" rows="2" class="form-control" v-model="shop.description"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Latitude</label>
                        <input type="number" class="form-control" v-model="shop.latitude">
                    </div>
                    <div class="form-group">
                        <label>Longitude</label>
                        <input type="number" class="form-control" v-model="shop.longitude">
                    </div>
                    <button type="button" class="btn btn-primary" @click="updateShop()"> Update </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                shop: {}
            }
        },
        mounted() {
            this.editShop(this.$route.params.shopId);
        },
        methods: {
            editShop(shopId) {
                this.axios.get(`http://127.0.0.1:8000/api/v1/shops/${shopId}`)
                   .then((res) => {
                       this.shop = res.data;
                   });
            },
            updateShop() {
                this.axios
                    .patch(`http://127.0.0.1:8000/api/v1/shops/${this.$route.params.shopId}`, this.shop)
                    .then((res) => {
                        this.$router.push({ name: 'ShopIndex' });
                    });
            }
        }
    }
</script>