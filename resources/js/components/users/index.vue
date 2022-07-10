<template>

    <div class="container">
       <Navbar/>
        <!-- <h2 class="text-center">Shop List</h2> -->
        
        <div class="row card">
            <div class="card-header">
                <h4 class="text-center">User List</h4>
                <div class="row">
            <div class="col-md-12">
                <router-link :to="{ name: 'UserCreate' }" class="btn btn-primary btn-sm float-right mb-2">Add New</router-link>
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
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Actions</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, key) of users" v-bind:key="key">
                            <td scope="row">{{ key+1 }}</td>
                            <td scope="row">
                                <img v-bind:src="'/user-images/' + user.image"  alt="user" style="width:70px; height:70px;">
                            </td>
                            <td scope="row">
                                {{ user.name }}
                              
                            </td>
                            <td scope="row">{{ user.email }}</td>
                            <td scope="row">{{ user.role ? user.role.name : '' }}</td>
                            <td scope="row">
                                <div class="d-flex flex-row">
                                    <router-link class="btn btn-info btn-sm mx-2" :to="{ name: 'ChangePassword', params: { id: user.id }}" v-if="login_user.id == user.id || login_user.role === 1">Change Password</router-link>
                                     <router-link class="btn btn-success btn-sm mx-2" :to="{ name: 'UserEdit', params: { id: user.id }}" v-if="login_user.id == user.id || login_user.role === 1">Edit</router-link>

                                    <button class="btn btn-danger btn-sm" @click="deleteUser(user.id)">Delete</button>
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
                users: {},
                login_user: {
                    id: "",
                    role: ""
                }
            }
        },
        
        created() {
            let session = this.$session.get('jwt');
            this.login_user = session.user;
            console.log(this.login_user.role)
            
            this.getShops();
        },
        methods: {
            getShops() {
              this.axios.get('http://127.0.0.1:8000/api/v1/users')
                  .then(response => {
                      this.users = response.data;
                  });
            },
            deleteUser(userId) {
                this.axios
                    .delete(`http://127.0.0.1:8000/api/v1/users/${userId}`)
                    .then(response => {
                        let i = this.users.map(data => data.id).indexOf(userId);
                        this.users.splice(i, 1)
                    });
            }
        }
    }
</script>