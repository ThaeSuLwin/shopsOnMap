<template>
  <div class="container">
    <Navbar />

    <!-- <div class="row">
      <div class="col-md-12">
        <router-link
          :to="{ name: 'ShopIndex' }"
          class="btn btn-primary btn-sm float-right mb-2"
          >Back</router-link
        >
      </div>
    </div> -->
    <form  @submit.prevent="createShop()" enctype="multipart/form-data">
      <div class="row card">
        <div class="card-header">
          <h5 class="text-center">Shop Create Form</h5>
        </div>

        <div class="card-body">
          <div class="form-group">
            <!-- <label>User</label> -->
            <input type="hidden" class="form-control" v-model="shop.user_id" />
          </div>
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" placeholder="Enter shop's name" v-model="shop.name" />
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea
              type="text"
              rows="2"
              class="form-control"
              placeholder="Enter shop's description"
              v-model="shop.description"
            ></textarea>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <label>Latitude</label>
                <input
                  type="number"
                  class="form-control"
                  placeholder="Enter latitude"
                  v-model="shop.latitude"
                />
              </div>
              <div class="col-md-6">
                <label>Longitude</label>
                <input
                  type="number"
                  class="form-control"
                  placeholder="Enter longitude"
                  v-model="shop.longitude"
                />
              </div>
            </div>
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
                  :style="{ 'background-image': `url(${previewImage})` }"
                  @click="selectImage"
                ></div>
              </div>
            </div>
          </div>
          <div class="d-flex flex-row-reverse">
          <router-link
            :to="{ name: 'ShopIndex' }"
            class="btn btn-secondary "
            >Back</router-link
          >
          <button
            type="submit"
            class="btn btn-primary mx-2 "
           
          >
            Save Changes
          </button>
        </div>
        </div>

        
      </div>
    </form>
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
      shop: {
        user_id: "",
        name: "",
        description: "",
        latitude: "",
        longitude: "",
        image: "",
      },
    };
  },
  created() {
    let session = this.$session.get("jwt");
    this.shop.user_id = session.user.id;
  },
  methods: {
    createShop() {
      const config = {
        headers: { 'content-type': 'multipart/form-data' }
        }
        let formData = new FormData();
        formData.append('image', this.shop.image)
        formData.append('name', this.shop.name)
        formData.append('description', this.shop.description)
        formData.append('latitude', this.shop.latitude)
        formData.append('longitude', this.shop.longitude)
        formData.append('user_id', this.shop.user_id)
        console.log(formData.get('image'))
      this.axios
        .post("http://127.0.0.1:8000/api/v1/shops", formData,config)
        .then((response) => 
        console.log(response) )
        // this.$router.push({ name: "ShopIndex" }))
        .catch((err) => console.log(err))
        .finally(() => (this.loading = false));
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
        this.shop.image = file[0];
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