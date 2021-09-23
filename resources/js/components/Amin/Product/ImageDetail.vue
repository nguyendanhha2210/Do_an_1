<template>
  <div class="table-agile-info">
    <div class="row">
         <div class="border-bottom w-100">
            <div class="form-group row row-container mb-0 pd-tb-20">
              <label
                class="col-md-3 col-form-label row-title pt-0 pb-0"
                for="text-input"
                >カルーセル画像</label
              >
              <div class="col-md-9">
                <div class="image-thumbnail mt-8-sp mr-2" v-if="productImage.length == 0">
                  <img src="/images/no-image-found-360x250.png" class="w-100 h-100" alt="" />
                </div>
                <div class="image-thumbnail mt-8-sp mr-2 float-left" v-else v-for="item in productImage" :key="item.id">
                  <img class="w-50 h-50" :src="baseUrl + '/uploads/products/' + item.url ? item.url : '/images/no-image-found-360x250.png'" alt="" />
                </div>
              </div>
            </div>
          </div>

      <!-- <form
        class="form-horizontal"
        method="POST"
        action=""
        @submit.prevent="AddProductImage()"
      >
        <div class="col-md-12 px-0">
          <div
            class="position-relative float-left"
            style="margin-right: 10px"
            v-for="(item, index) in listImages"
            :key="item.id"
          >
            <label :for="`file_img_banner${index}`">
              <div class="img-drop-box mt-2 mr-2">
                <img
                  :src="item.src"
                  :ref="`imageDisplay${index}`"
                  class="mh-100 mw-100 mx-auto display-block"
                />
                <svg
                  width="45"
                  height="45"
                  viewBox="0 0 45 45"
                  style="margin-top: 30px"
                  :ref="`imageIconPlus${index}`"
                  class="display-none"
                >
                  <use xlink:href="/images/Group_1287.svg#Group_1287"></use>
                </svg>
              </div>
              <input
                type="file"
                :id="`file_img_banner${index}`"
                :ref="`image${index}`"
                v-on:change="attachImage('image', index)"
                accept="image/*"
                style="display: none"
              />
            </label>
            <a
              class="btn btn-light icon-close-white display-block"
              :ref="`imageIconClose${index}`"
              @click="deleteImage('image', index)"
            >
            </a>
          </div>
          <div class="position-relative float-left">
            <label :for="`file_img_banner${listImages.length}`">
              <div class="img-drop-box mt-2 mr-2">
                <img
                  src
                  :ref="`imageDisplay${listImages.length}`"
                  class="mh-100 mw-100 mx-auto"
                />
                <svg
                  width="45"
                  height="45"
                  viewBox="0 0 45 45"
                  style="margin-top: 30px"
                  :ref="`imageIconPlus${listImages.length}`"
                >
                  <use xlink:href="/images/Group_1287.svg#Group_1287"></use>
                </svg>
              </div>
              <input
                type="file"
                :id="`file_img_banner${listImages.length}`"
                :ref="`image${listImages.length}`"
                v-on:change="attachImage('image', listImages.length)"
                accept="image/*"
                style="display: none"
              />
            </label>
            <a
              class="btn btn-light icon-close-white display-none"
              :ref="`imageIconClose${listImages.length}`"
              @click="deleteImage('image', listImages.length)"
            >
            </a>
          </div>
        </div>

        <div class="row" style="margin-right: 3px">
          <div class="col-md-12">
            <button class="btn btn-success" type="submit">Save</button>
          </div>
        </div>
      </form> -->

      <!-- <div class="table-responsive">
        <table class="table table-striped b-t b-light text-center">
          <thead>
            <tr>
              <th scope="col">STT</th>
              <th scope="col">Product ID</th>
              <th scope="col">Images 1</th>
              <th scope="col">Images 2</th>
              <th scope="col">Images 3</th>
              <th scope="col">Images 4</th>
              <th>Action</th>
            </tr>
          </thead>
          <transition-group name="slide-fade" tag="tbody">
            <tr
              v-for="(productImage, index) in productImages"
              :key="productImage.id"
            >
              <th scope="row">{{ index + 1 }}</th>
              <td>
                {{ productImage.product_id }}
              </td>
              <td>
                <img
                  :src="baseUrl + '/uploads/' + productImage.url"
                  width="50px"
                  height="50px"
                  alt=""
                />
              </td>
            </tr>
          </transition-group>
        </table>
      </div> -->
    </div>
    <loader :flag-show="flagShowLoader"></loader>
  </div>
</template>

<style lang="scss" scoped>
.td-action {
  display: inline-flex;
}
.btn-success {
  float: right;
  margin-top: 10px;
  margin-right: 5%;
}
</style>

<script>
import Loader from "../../Common/loader.vue";
const axios = require("axios").default;
export default {
  data() {
    return {
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      buttonAdd: true,
      productImages: [],
      productImage: {
        id: "",
        product_id: "",
        url: "",
      },
      listImages: [],

      edit: false,
      flagShowLoader: false,

      productImage: this.data
    };
  },
  props: ["data"],

  created() {
  
  },
  mounted() {
    // console.log("ABC",this.productIdP)
  },
  components: {
    Loader,
  },
  methods: {
    AddProductImage() {
      let that = this;
      this.$validator.validateAll().then((valid) => {
        // console.log("id", that.productImage.image_1);
        let formData = new FormData();
        formData.append("productId", this.productIdP);
        this.listImages.forEach((item) => {
          formData.append("images[]", item.file);
        });
        axios
          .post(`/admin/product-image/save`, formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((response) => {
            that.fetchData();
            that
              .$swal({
                title: "Update success!",
                icon: "success",
                confirmButtonText: "Yes !",
                confirmButtonColor: "#3085d6",
              })
              .then(function (confirm) {
                if (confirm.isConfirmed) {
                  that.buttonAdd = true;
                  (window.location = response.data),
                    (that.product = {
                      name: "",
                      images: "",
                      price: "",
                      type_id: "",
                      weight_id: "",
                      description_id: "",
                      content: "",
                      status: "",
                    });
                } else {
                }
              });
          })
          .catch((err) => {
            switch (err.response.status) {
              case 422:
                that.errorBackEnd = err.response.data.errors;
                break;
              case 500:
                that
                  .$swal({
                    title: "Update Failure Data!",
                    icon: "error",
                    confirmButtonText: "Ok",
                  })
                  .then(function (confirm) {});
                break;
              default:
                break;
            }
          });
      });
    },

    fetchData() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .get(`get-image`)
        .then(function (response) {
          that.productImages = response.data;
          that.flagShowLoader = false;
        })
        .catch((err) => {
          switch (err.response.status) {
            case 404:
              that
                .$swal({
                  title: "Error loading data !",
                  icon: "warning",
                  confirmButtonText: "Ok",
                })
                .then(function (confirm) {});
              break;
            default:
              break;
          }
        });
    },

    attachImage(type, value) {
      var file = null;
      if (type == "image") {
        if (value < this.listImages.length) {
          this.listImages[value].file = this.$refs[type + value][0].files[0];
          file = this.$refs[type + value][0].files[0];
          this.$refs[type + value][0].value = "";
        } else {
          this.listImages.push({
            file_id: null,
            file: this.$refs[type + value].files[0],
            src: "",
          });
          file = this.$refs[type + value].files[0];
          this.$refs[type + value].value = "";
        }
      }
      if (type == "album") {
        if (value < this.listAlbums.length) {
          this.listAlbums[value].file = this.$refs[type + value][0].files[0];
          file = this.$refs[type + value][0].files[0];
          this.$refs[type + value][0].value = "";
        } else {
          this.listAlbums.push({
            file_id: null,
            file: this.$refs[type + value].files[0],
          });
          file = this.$refs[type + value].files[0];
          this.$refs[type + value].value = "";
        }
      }
      let reader = new FileReader();
      reader.addEventListener(
        "load",
        function () {
          this.$refs[type + "Display" + value][0].style.setProperty(
            "display",
            "block",
            "important"
          );
          this.$refs[type + "IconClose" + value][0].style.setProperty(
            "display",
            "block",
            "important"
          );
          this.$refs[type + "Display" + value][0].src = reader.result;
          if (type == "album") {
            this.listAlbums[value].src = reader.result;
          }
          if (type == "image") {
            this.listImages[value].src = reader.result;
          }
          this.$refs[type + "IconPlus" + value][0].style.setProperty(
            "display",
            "none",
            "important"
          );
        }.bind(this),
        false
      );
      reader.readAsDataURL(file);
      console.log(this.listImages);
    },

    deleteImage(type, value) {
      var index = 0;
      if (type == "image") {
        index = this.listImages.length;
        this.listImages.splice(value, 1);
      }
      if (type == "album") {
        index = this.listAlbums.length;
        this.listAlbums.splice(value, 1);
      }
      this.$refs[type + index].value = "";
    },
  },
};
</script>
