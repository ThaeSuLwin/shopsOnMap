<template>
  <div class="container">
    <Navbar />
    <div class="card">
      <div class="card-header">
        <h5 class="text-center">User Password Change Form</h5>
      </div>
      <div class="card-body">
        <form @submit.prevent="updateUser()">
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" v-model="user.name" readonly/>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" v-model="user.email" readonly />
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" v-model="user.password" />
          </div>
        
          <div class="d-flex flex-row-reverse">
            <router-link :to="{ name: 'UserIndex' }" class="btn btn-secondary"
              >Back</router-link
            >
            <button type="submit" class="btn btn-primary mx-2">
              Change Password
            </button>
          </div>
        </form>
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
      user: {
        name: "",
        email: "",
      },
     
    };
  },
  mounted() {
    this.editUser(this.$route.params.id);
  },
  methods: {
    editUser(id) {
      this.axios.get(`http://127.0.0.1:8000/api/v1/users/${id}`).then((res) => {
        this.user = res.data;
        
      });
    },
    updateUser() {
     
      this.axios
        .post(
          "http://127.0.0.1:8000/api/v1/users/password/" + this.$route.params.id,
          this.user
        )
        .then((res) => {
            this.$router.push({ name: "UserIndex" });
        //   console.log(res);
        });
    },
    
  },
};
</script>
