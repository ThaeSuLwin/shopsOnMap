<template>
  <div class="container">
    <Navbar />
    <div class="card">
      <div class="card-header">
        <h5 class="text-center">Shop Edit Form</h5>
      </div>
      <div class="card-body">
        <form @submit.prevent="updateShop()" enctype="multipart/form-data">
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" v-model="shop.name" />
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea
              type="text"
              rows="2"
              class="form-control"
              v-model="shop.description"
            ></textarea>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <label>Latitude</label>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Enter latitude"
                  v-model="shop.latitude"
                />
              </div>
              <div class="col-md-6">
                <label>Longitude</label>
                <input
                  type="text"
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
                  :style="{
                    'background-image': `url(${previewImage})`,
                  }"
                  @click="selectImage"
                ></div>
              </div>
            </div>
          </div>
          <div class="d-flex flex-row-reverse">
            <router-link :to="{ name: 'ShopIndex' }" class="btn btn-secondary"
              >Back</router-link
            >
            <button type="submit" class="btn btn-primary mx-2">
              Update Changes
            </button>
          </div>
        </form>
      </div>
    </div>
    <!-- <h2 class="text-center">Update Shop</h2>
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
        </div> -->
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
        // user_id: "",
        // name: "",
        // description: "",
        // latitude: "",
        // longitude: "",
        // image: "",
      },
    };
  },
  mounted() {
    this.editShop(this.$route.params.id);
  },
  methods: {
    editShop(id) {
      this.axios.get(`http://127.0.0.1:8000/api/v1/shops/${id}`).then((res) => {
        this.shop = res.data;
        if (res.data.image !== null) {
          this.previewImage = "/shop-images/" + res.data.image;
        }
      });
    },
    updateShop() {
      const config = {
        headers: { "Content-Type": "multipart/form-data" },
      };
      let formData = new FormData();
      formData.append("image", this.shop.image);
      formData.append("name", this.shop.name);
      formData.append("description", this.shop.description);
      formData.append("latitude", this.shop.latitude);
      formData.append("longitude", this.shop.longitude);
      formData.append("user_id", this.shop.user_id);
      formData.append("_method", "put");
    //   console.log(formData.get("image"));
      this.axios
        .post(
          "http://127.0.0.1:8000/api/v1/shops/" + this.$route.params.id,
          formData,config
        )
        .then((res) => {
            this.$router.push({ name: "ShopIndex" });
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