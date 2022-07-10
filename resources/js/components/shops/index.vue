<template>
	<div class="container">
		<Navbar/>
		<!-- <h2 class="text-center">Shop List</h2> -->
		<div class="row card">
			<div class="card-header">
				<h4 class="text-center">Shops List</h4>
				<div class="row">
					<div class="col-md-12 mt-2">
						<form @submit.prevent="filtersearch()">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
                                        <label for="">Search with shop name</label>
										<input type="text" class="form-control" v-model="search.name" placeholder="Search by shop name" /> </div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
                                        <label for="">Search with address</label>
										<input type="text" class="form-control" v-model="search.address" placeholder="Search by shop address" /> </div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
                                        <label for="">Search with user id</label>
										<select v-model="search.user_id" class="form-control">
											<option :selected="true" value="">---Select---</option>
											<option v-for="user in users" v-bind:value="user.id"> {{ user.name }} </option>
										</select>
									</div>
								</div>
                                	<div class="col-md-6">
								<div class="form-group">
                                    <label for="">Search with date</label>
									<input type="date" class="form-control" v-model="search.date" placeholder="Search by date" /> </div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
                                    <label for="">Search with latitude</label>
									<input type="text" class="form-control mt-1" placeholder="latitude" v-model="search.lat" /> </div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
                                    <label for="">Search with longitude</label>
									<input type="text" class="form-control mt-1" placeholder="longitude" v-model="search.long" /> </div>
							</div>
						
                            </div>

							<div class="form-group">
								<div class="row m-1">
									<button type="submit" class="btn btn-primary"> Search </button>
								</div>
							</div>
						</form>
					</div>
					<div class="col-md-12 mt-3">
						<router-link :to="{ name: 'ShopCreate' }" class="btn btn-primary  float-right mb-2">Add New</router-link>
						<router-link :to="{ name: 'MapView' }" class="btn btn-info  float-right mx-2 mb-2">View On Map</router-link>
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
								<th scope="col">Hours</th>
								<th scope="col">Address</th>
								<th scope="col">Latitude</th>
								<th scope="col">Longitude</th>
								<th scope="col">Actions</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(shop, key) of shops" v-bind:key="key">
								<td scope="row">{{ key+1 }}</td>
								<td scope="row"> <img v-bind:src="'/shop-images/' + shop.image" alt="shop" style="width:70px; height:70px;"> </td>
								<td scope="row"> {{ shop.name }} </br> <span class="badge badge-primary">{{shop.user ? shop.user.name : ''}}</span> </td>
								<td scope="row">{{ shop.hour }}</td>
								<td scope="row">{{ shop.address }}</td>
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
		Navbar,
	},
	data() {
		return {
			shops: {},
			user: {
				id: "",
			},
			search: {},
			users: [],
		};
	},
	created() {
		let session = this.$session.get("jwt");
		this.user = session.user;
		this.getShops() & this.getUsers();
	},
	methods: {
		getShops() {
				this.axios.get("http://127.0.0.1:8000/api/v1/shops/?userId=" + this.user.id).then((response) => {
					this.shops = response.data;
				});
			},
			getUsers() {
				this.axios.get("http://127.0.0.1:8000/api/v1/auth/users").then((response) => {
					this.users = response.data;
				});
			},
			deleteShop(shopId) {
				this.axios.delete(`http://127.0.0.1:8000/api/v1/shops/${shopId}`).then((response) => {
					let i = this.shops.map((data) => data.id).indexOf(shopId);
					this.shops.splice(i, 1);
				});
			},
			filtersearch() {
				console.log(this.search);
				this.axios.post("http://127.0.0.1:8000/api/v1/shops/filter/?userId="+ this.user.id, this.search).then((response) => {
					this.shops = response.data;
				});
			},
	},
};
</script>