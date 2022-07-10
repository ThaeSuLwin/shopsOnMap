<template>
  <div class="container">
    <Navbar />
    <div class="card">
      <div class="card-header">
        <h5 class="text-center">User Edit Form</h5>
      </div>
      <div class="card-body">
        <form @submit.prevent="updateUser()" enctype="multipart/form-data">
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" v-model="user.name" />
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" v-model="user.email" />
          </div>
          <div class="form-group">
            <label>Role</label>
            <select v-model="user.role" class="form-control" required>
                <option :selected="true" value="">---Select---</option>
                <option v-for="role in roles" v-bind:value="role.id">
                  {{ role.name }}
                </option>
              </select>
          </div>
          
          <div class="form-group">
            <label for="">Image</label>
            <div class="row">
              <div class="col-md-3 mt-5">
                <input
                  ref="fileInput"
                  class="form-control"
                  type="file"
                  @input="pickFile"
                />
              </div>
              <div class="col-md-6">
                <div
                  class="imagePreviewWrapper"
                  :style="{
                    'background-image': `url(${previewImage})`,
                  }"
                  @click="selectImage"
                ></div>
              </div>
            </div>
          </div>
          <div class="d-flex flex-row-reverse">
            <router-link :to="{ name: 'UserIndex' }" class="btn btn-secondary"
              >Back</router-link
            >
            <button type="submit" class="btn btn-primary mx-2">
              Update Changes
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
      previewImage: "/images/404-square.jpg",
      user: {
        name: "",
        email: "",
        role: "",
        image: "",
      },
      roles: []
    };
  },
  created ()
  {
     this.axios.get('http://127.0.0.1:8000/api/v1/roles')
                  .then(response => {
                      this.roles = response.data;
                  });
  },
  mounted() {
    this.editUser(this.$route.params.id);
  },
  methods: {
    editUser(id) {
      this.axios.get(`http://127.0.0.1:8000/api/v1/users/${id}`).then((res) => {
        this.user = res.data;
        console.log(res.data)
        if (res.data.image != null) {
          this.previewImage = "/user-images/" + res.data.image;
        }
        
      });
    },
    updateUser() {
      const config = {
        headers: { "Content-Type": "multipart/form-data" },
      };
      let formData = new FormData();
      formData.append("image", this.user.image);
      formData.append("name", this.user.name);
      formData.append("email", this.user.email);
      formData.append("role", this.user.role);
      formData.append("_method", "put");
    //   console.log(formData.get("image"));
      this.axios
        .post(
          "http://127.0.0.1:8000/api/v1/users/" + this.$route.params.id,
          formData,config
        )
        .then((res) => {
            this.$router.push({ name: "UserIndex" });
        //   console.log(res);
        });
    },
    selectImage() {
      this.$refs.fileInput.click();
    },
    pickFile() {
      let input = this.$refs.fileInput;
      let file = input.files;
      if (file && file[0]) {
        let reader = new FileReader();
        reader.onload = (e) => {
          this.previewImage = e.target.result;
        };
        reader.readAsDataURL(file[0]);
        this.$emit("input", file[0]);
        // console.log(this.$refs.fileInput.value)
        this.user.image = file[0];
      }
    },
  },
};
</script>
<style scoped lang="scss">
.imagePreviewWrapper {
  width: 150px;
  height: 150px;
  display: block;
  cursor: pointer;
  // margin: 0 auto 30px;
  background-size: cover;
  background-position: center center;
}
</style>