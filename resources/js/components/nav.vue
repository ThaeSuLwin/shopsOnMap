<template>
  <nav class="navbar navbar-expand navbar-light navbar-bg">
            <div class="collapse navbar-collapse">
              <ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
              <!-- <router-link :to="{ name: 'ProductIndex' }"  class="nav-item nav-link">Products</router-link> -->
						</li>
<li class="nav-item dropdown">
               <router-link :to="{ name: 'ShopIndex' }"  class="nav-item nav-link">Shops</router-link>
						</li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 {{this.user.name}}
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" @click="logout()">Logout</a>
              </div>
            </li>
             </ul>
            </div>
        </nav>
</template>
<script>
export default {
  name: "Navbar",
  data() {
    return {
      user: ""
    }
  },
  created() {
    let session = this.$session.get('jwt');
    this.user = session.user;
  },
  methods: {
    logout(){
      this.$session.destroy() & 
       this.$router.push({ name: 'Login' })
    }
  }
  }
</script>
