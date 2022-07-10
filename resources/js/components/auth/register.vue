<template>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Register</div>

                <div class="card-body">
                    <form @submit.prevent="register()">
                        
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" v-model="auth.name" value="" >

                              
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" v-model="auth.email" value="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" v-model="auth.password">

                                
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary w-75">
                                    Sign Up
                                </button>

                                
                            </div>
                        </div>
                         <div class="form-group row mb-4">
                        <div class="col-md-8 offset-md-4">
                            <p>Already have an account?  <router-link :to="{ name: 'Login' }">Sign In</router-link></p>
                            </div>

                        </div>

                        

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


</template>
<script> 
export default {
  name: "Register",
    data() {
            return {
                auth: {}
            }
        },
        methods: {
            register() {
                this.axios.post('http://127.0.0.1:8000/api/v1/auth/register', this.auth)
                    .then(response => (
                        this.$router.push({ name: 'Login' })
                    ))
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            }
        }
}
</script>