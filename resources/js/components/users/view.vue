<template>
  <div class="container">
    <Navbar />
  
      <div class="row card">
        <div class="card-header">
          <h5 class="text-center">User Details Form</h5>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-md-4 offset-2">
            <img v-bind:src="'/user-images/'+ user.image" alt="" style="width:100px; height:100px;">
            </div>
            <div class="col-md-6">
              <p>Name: {{user.name}}</p>
              <p>Email : {{user.email}}</p>
              <p>Role : {{user.role ? user.role.name : ''}}</p>
            </div>
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
      previewImage: "/images/404-square.jpg",
      user: {
        name: "",
        email: "",
        role: "",
        image: "",
      },
      // roles: []
    };
  },
  mounted() {
    this.userDetail(this.$route.params.id);
  },
  methods: {
    userDetail(id)
    {
       this.axios.get('http://127.0.0.1:8000/api/v1/users/detail/'+id)
                  .then(response => {
                      this.user = response.data;
                      console.log(response)
                  });
    }
  }
 
    
  
}
</script>