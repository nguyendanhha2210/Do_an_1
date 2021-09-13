<template>
  <div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading"></div>
      <div
        class="modal fade"
        id="myModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                Import product information
              </h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form
                @submit.prevent="AddProductImage()"
                enctype="multipart/form-data"
              >
                <div class="form-row">
                  <input type="text" v-model="productImage.product_id" hidden />
                  <div class="form-group col-md-6 text-center">
                    <label for="exampleInputEmail1 ">Image 1</label>
                    <div class="position-relative d-inline-block">
                      <label for="file_img_banner1">
                        <div class="img-drop-box mt-2 mr-2">
                          <img src ref="imageDispaly_1" class="img-thumbnail" />
                          <svg
                            width="45"
                            height="45"
                            viewBox="0 0 45 45"
                            style="
                              margin-top: 52px;
                              margin-left: 38%;
                              margin-right: 38%;
                            "
                            ref="iconFile_1"
                          >
                            <use
                              xlink:href="/images/Group_1287.svg#Group_1287"
                            ></use>
                          </svg>
                        </div>
                        <input
                          type="file"
                          id="file_img_banner1"
                          v-validate="'required'"
                          name="image_1"
                          ref="image_1"
                          v-on:change="attachImage_1"
                          accept="image_1/*"
                        />
                      </label>
                      <a
                        class="btn btn-light icon-close-white display-none"
                        style="background-color: black; border-radius: 91%"
                        ref="iconClose_1"
                        @click="deleteImage_1"
                      ></a>
                    </div>
                    <div style="color: red" role="alert">
                      {{ errors.first("image_1") }}
                    </div>
                  </div>

                  <div class="form-group col-md-6 text-center">
                    <label for="exampleInputEmail1 ">Image 2</label>
                    <div class="position-relative d-inline-block">
                      <label for="file_img_banner2">
                        <div class="img-drop-box mt-2 mr-2">
                          <img src ref="imageDispaly_2" class="img-thumbnail" />
                          <svg
                            width="45"
                            height="45"
                            viewBox="0 0 45 45"
                            style="
                              margin-top: 52px;
                              margin-left: 38%;
                              margin-right: 38%;
                            "
                            ref="iconFile_2"
                          >
                            <use
                              xlink:href="/images/Group_1287.svg#Group_1287"
                            ></use>
                          </svg>
                        </div>
                        <input
                          type="file"
                          id="file_img_banner2"
                          v-validate="'required'"
                          name="image_2"
                          ref="image_2"
                          v-on:change="attachImage_2"
                          accept="image_2/*"
                          style="display: none"
                        />
                      </label>
                      <a
                        class="btn btn-light icon-close-white display-none"
                        style="background-color: black; border-radius: 91%"
                        ref="iconClose_2"
                        @click="deleteImage_2"
                      ></a>
                    </div>
                    <div style="color: red" role="alert">
                      {{ errors.first("image_2") }}
                    </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6 text-center">
                    <label for="exampleInputEmail1 ">Image 3</label>
                    <div class="position-relative d-inline-block">
                      <label for="file_img_banner3">
                        <div class="img-drop-box mt-2 mr-2">
                          <img src ref="imageDispaly_3" class="img-thumbnail" />
                          <svg
                            width="45"
                            height="45"
                            viewBox="0 0 45 45"
                            style="
                              margin-top: 52px;
                              margin-left: 38%;
                              margin-right: 38%;
                            "
                            ref="iconFile_3"
                          >
                            <use
                              xlink:href="/images/Group_1287.svg#Group_1287"
                            ></use>
                          </svg>
                        </div>
                        <input
                          type="file"
                          id="file_img_banner3"
                          v-validate="'required'"
                          name="image_3"
                          ref="image_3"
                          v-on:change="attachImage_3"
                          accept="image_3/*"
                          style="display: none"
                        />
                      </label>
                      <a
                        class="btn btn-light icon-close-white display-none"
                        style="background-color: black; border-radius: 91%"
                        ref="iconClose_3"
                        @click="deleteImage_3"
                      ></a>
                    </div>
                    <div style="color: red" role="alert">
                      {{ errors.first("image_3") }}
                    </div>
                  </div>

                  <div class="form-group col-md-6 text-center">
                    <label for="exampleInputEmail1 ">Image 2</label>
                    <div class="position-relative d-inline-block">
                      <label for="file_img_banner4">
                        <div class="img-drop-box mt-2 mr-2">
                          <img src ref="imageDispaly_4" class="img-thumbnail" />
                          <svg
                            width="45"
                            height="45"
                            viewBox="0 0 45 45"
                            style="
                              margin-top: 52px;
                              margin-left: 38%;
                              margin-right: 38%;
                            "
                            ref="iconFile_4"
                          >
                            <use
                              xlink:href="/images/Group_1287.svg#Group_1287"
                            ></use>
                          </svg>
                        </div>
                        <input
                          type="file"
                          id="file_img_banner4"
                          v-validate="'required'"
                          name="image_4"
                          ref="image_4"
                          v-on:change="attachImage_4"
                          accept="image_4/*"
                          style="display: none"
                        />
                      </label>
                      <a
                        class="btn btn-light icon-close-white display-none"
                        style="background-color: black; border-radius: 91%"
                        ref="iconClose_4"
                        @click="deleteImage_4"
                      ></a>
                    </div>
                    <div style="color: red" role="alert">
                      {{ errors.first("image_4") }}
                    </div>
                  </div>
                </div>

                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                  >
                    Close
                  </button>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="table-responsive">
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
                  :src="baseUrl + '/uploads/' + productImage.image_1"
                  width="50px"
                  height="50px"
                  alt=""
                />
              </td>
              <td>
                <img
                  :src="baseUrl + '/uploads/' + productImage.image_2"
                  width="50px"
                  height="50px"
                  alt=""
                />
              </td>
              <td>
                <img
                  :src="baseUrl + '/uploads/' + productImage.image_3"
                  width="50px"
                  height="50px"
                  alt=""
                />
              </td>
              <td>
                <img
                  :src="baseUrl + '/uploads/' + productImage.image_4"
                  width="50px"
                  height="50px"
                  alt=""
                />
              </td>
              <td>
                <div class="td-action">
                  <a
                    data-toggle="modal"
                    data-target="#myModal"
                    @click="
                      updateProductImage(productImage),
                        ((buttonAdd = false), (edit = true))
                    "
                    style="font-size: 21px; transform: translate(-26%, -14%)"
                    ><i
                      style="color: green"
                      class="fa fa-plus"
                      aria-hidden="true"
                    ></i
                  ></a>
                </div>
              </td>
            </tr>
          </transition-group>
        </table>
      </div>
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
        image_1: "",
        image_2: "",
        image_3: "",
        image_4: "",
      },
      edit: false,
      flagShowLoader: false,
    };
  },
  created() {
    let messError = {
      custom: {
        image_1: {
          required: "* Ảnh  chưa chọn",
        },
        image_2: {
          required: "* Ảnh  chưa chọn",
        },
        image_3: {
          required: "* Ảnh chưa chọn",
        },
        image_4: {
          required: "* Ảnh chưa chọn",
        },
      },
    };
    this.$validator.localize("en", messError);
    this.fetchData();
  },
  mounted() {},
  components: {
    Loader,
  },
  methods: {
    AddProductImage() {
      let that = this;
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          if (this.edit == false) {
          } else {
            console.log("id", that.productImage.image_1);
            let formData = new FormData();
            formData.append("image_1", that.productImage.image_1);
            formData.append("image_2", that.productImage.image_2);
            formData.append("image_3", that.productImage.image_3);
            formData.append("image_4", that.productImage.image_4);
            axios
              .post(
                `/admin/product-image/${that.productImage.product_id}/update`,
                formData,
                {
                  headers: {
                    "Content-Type": "multipart/form-data",
                  },
                }
              )
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
          }
        }
      });
    },

    fetchData() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .get(`get-image`)
        .then(function (response) {
          // console.log(response.data.id)
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

    updateProductImage(productImage) {
      this.productImage.product_id = productImage.product_id;
      if (productImage.image_1 != "") {
        this.$refs.imageDispaly_1.src =
          this.baseUrl + "/uploads/" + productImage.image_1;
        this.$refs.imageDispaly_1.style.display = "block";
        this.$refs.iconClose_1.style.display = "block";
        this.$refs.iconFile_1.style.display = "none";
      }

      if (productImage.image_2 != "") {
        this.$refs.imageDispaly_2.src =
          this.baseUrl + "/uploads/" + productImage.image_2;
        this.$refs.imageDispaly_2.style.display = "block";
        this.$refs.iconClose_2.style.display = "block";
        this.$refs.iconFile_2.style.display = "none";
      }

      if (productImage.image_3 != "") {
        this.$refs.imageDispaly_3.src =
          this.baseUrl + "/uploads/" + productImage.image_3;
        this.$refs.imageDispaly_3.style.display = "block";
        this.$refs.iconClose_3.style.display = "block";
        this.$refs.iconFile_3.style.display = "none";
      }

      if (productImage.image_4 != "") {
        this.$refs.imageDispaly_4.src =
          this.baseUrl + "/uploads/" + productImage.image_4;
        this.$refs.imageDispaly_4.style.display = "block";
        this.$refs.iconClose_4.style.display = "block";
        this.$refs.iconFile_4.style.display = "none";
      }
    },

    attachImage_1() {
      this.productImage.image_1 = this.$refs.image_1.files[0];
      let reader_1 = new FileReader();
      reader_1.addEventListener(
        "load",
        function () {
          this.$refs.imageDispaly_1.style.display = "block";
          this.$refs.iconClose_1.style.display = "block";
          this.$refs.imageDispaly_1.src = reader_1.result;
          this.$refs.iconFile_1.style.display = "none";
        }.bind(this),
        false
      );
      reader_1.readAsDataURL(this.productImage.image_1);
    },
    deleteImage_1() {
      this.productImage.image_1 = "";
      this.$refs.imageDispaly_1.style.display = "none";
      this.$refs.iconClose_1.style.display = "none";
      this.$refs.image_1.value = "";
      this.$refs.iconFile_1.style.display = "block";
    },

    attachImage_2() {
      this.productImage.image_2 = this.$refs.image_2.files[0];
      console.log(this.$refs.image_2.files[0]);
      let reader_2 = new FileReader();
      reader_2.addEventListener(
        "load",
        function () {
          this.$refs.imageDispaly_2.style.display = "block";
          this.$refs.iconClose_2.style.display = "block";
          this.$refs.imageDispaly_2.src = reader_2.result;
          this.$refs.iconFile_2.style.display = "none";
        }.bind(this),
        false
      );
      reader_2.readAsDataURL(this.productImage.image_2);
    },
    deleteImage_2() {
      this.productImage.image_2 = "";
      this.$refs.imageDispaly_2.style.display = "none";
      this.$refs.iconClose_2.style.display = "none";
      this.$refs.image_2.value = "";
      this.$refs.iconFile_2.style.display = "block";
    },

    attachImage_3() {
      this.productImage.image_3 = this.$refs.image_3.files[0];
      console.log(this.$refs.image_3.files[0]);
      let reader_3 = new FileReader();
      reader_3.addEventListener(
        "load",
        function () {
          this.$refs.imageDispaly_3.style.display = "block";
          this.$refs.iconClose_3.style.display = "block";
          this.$refs.imageDispaly_3.src = reader_3.result;
          this.$refs.iconFile_3.style.display = "none";
        }.bind(this),
        false
      );
      reader_3.readAsDataURL(this.productImage.image_3);
    },
    deleteImage_3() {
      this.productImage.image_3 = "";
      this.$refs.imageDispaly_3.style.display = "none";
      this.$refs.iconClose_3.style.display = "none";
      this.$refs.image_3.value = "";
      this.$refs.iconFile_3.style.display = "block";
    },

    attachImage_4() {
      this.productImage.image_4 = this.$refs.image_4.files[0];
      console.log(this.$refs.image_4.files[0]);
      let reader_4 = new FileReader();
      reader_4.addEventListener(
        "load",
        function () {
          this.$refs.imageDispaly_4.style.display = "block";
          this.$refs.iconClose_4.style.display = "block";
          this.$refs.imageDispaly_4.src = reader_4.result;
          this.$refs.iconFile_4.style.display = "none";
        }.bind(this),
        false
      );
      reader_4.readAsDataURL(this.productImage.image_4);
    },
    deleteImage_4() {
      this.productImage.image_4 = "";
      this.$refs.imageDispaly_4.style.display = "none";
      this.$refs.iconClose_4.style.display = "none";
      this.$refs.image_4.value = "";
      this.$refs.iconFile_4.style.display = "block";
    },
  },
};
</script>
