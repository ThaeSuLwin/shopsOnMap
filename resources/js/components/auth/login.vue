<template>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="alert alert-danger mt-2" role="alert" v-if="errorMsg">
                Login Failed
            </div>
            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form>
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input  type="email" class="form-control" v-model="auth.email">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input  type="password" class="form-control" v-model="auth.password">

                                
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" v-model="auth.remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary w-75" @click.prevent="login()">
                                    Sign In
                                </button>
                                
                            </div>                         
                        </div>
                        <div class="form-group row mb-4">
                        <div class="col-md-8 offset-md-4">
                            <p>Don't have an account?  <router-link :to="{ name: 'Register' }">Sign Up</router-link></p>
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
  name: "Login",
    data() {
            return {
                auth: {},
                errorMsg: false,
            }
        },
        methods: {
            login() {
                console.log(this.auth);
                this.axios.post('http://127.0.0.1:8000/api/v1/auth/login', this.auth
                    )
                    .then(response => {
                        // console.log(response.data)
                        if(response.data.token){
                        this.$session.start() &
                        this.$session.set("jwt", response.data) &
                        this.$router.push({ name: 'ShopIndex' })
                        }
                        else {
                            this.errorMsg = true;
                        }
                    })
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            },
            
        }
}
</script>