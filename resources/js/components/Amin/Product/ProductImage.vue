<template>
  <div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading"></div>
      <div class="row w3-res-tb">
        <div for="paginate" class="col-md-3 col-sm-2 col-4">
          <select v-model="paginate" class="form-control w-sm inline v-middle">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
          </select>
        </div>
        <div class="col-md-4 col-sm-7 col-3" style="float: left">
          <!-- <button
            style="background-color: green; color: white; height: 36px"
            type="button"
            class="btn btn-sm"
            data-toggle="modal"
            data-target="#myModal"
            data-whatever="@getbootstrap"
            v-if="buttonAdd"
            @click="edit = false"
          >
            Add New
          </button> -->
        </div>
        <div class="col-md-5 col-sm-3 col-5" style="float: right">
          <input
            type="text"
            class="form-control"
            v-model="search"
            placeholder="Search"
          />
        </div>
      </div>

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
                  <div class="form-group col-md-6 text-center">
                    <label for="exampleInputEmail1 ">Image 1</label>
                    <div>
                      <img
                        src
                        ref="fileImageDispaly_1"
                        width="200px"
                        height="200px"
                      />
                    </div>
                    <input
                      @change="attachFile_1"
                      type="file"
                      class="form-control"
                      id="exampleInputEmail1"
                      ref="fileImage"
                      name="image_1"
                    />
                    <div style="color: red" role="alert">
                      {{ errors.first("image_1") }}
                    </div>
                  </div>

                  <div class="form-group col-md-6 text-center">
                    <label for="exampleInputEmail1">Image 2</label>
                    <div>
                      <img
                        src
                        ref="fileImageDispaly_2"
                        width="200px"
                        height="200px"
                      />
                    </div>
                    <input
                      @change="attachFile_2"
                      type="file"
                      class="form-control"
                      id="exampleInputEmail1"
                      ref="fileImage"
                      name="image_2"
                    />
                    <div style="color: red" role="alert">
                      {{ errors.first("image_2") }}
                    </div>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6 text-center">
                    <label for="exampleInputEmail1">Image 3</label>
                    <div>
                      <img
                        src
                        ref="fileImageDispaly_3"
                        width="200px"
                        height="200px"
                      />
                    </div>
                    <input
                      @change="attachFile_3"
                      type="file"
                      class="form-control"
                      id="exampleInputEmail1"
                      ref="fileImage"
                      name="image_3"
                    />
                    <div style="color: red" role="alert">
                      {{ errors.first("image_3") }}
                    </div>
                  </div>

                  <div class="form-group col-md-6 text-center">
                    <label for="exampleInputEmail1">Image 4</label>
                    <div>
                      <img
                        src
                        ref="fileImageDispaly_4"
                        width="200px"
                        height="200px"
                      />
                    </div>
                    <input
                      @change="attachFile_4"
                      type="file"
                      class="form-control"
                      id="exampleInputEmail1"
                      ref="fileImage"
                      name="image_4"
                    />
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
              v-for="(productImage, index) in productImages.data"
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
                  <button
                    type="button"
                    class="btn btn-warning mr-1"
                    data-toggle="modal"
                    data-target="#myModal"
                    @click="
                      updateProductImage(productImage),
                        ((buttonAdd = false), (edit = true))
                    "
                  >
                    Add Photo
                  </button>

                  <!-- <button
                    type="button"
                    class="btn btn-danger"
                    @click="deleteProduct(product.id)"
                  >
                    Delete
                  </button> -->
                </div>
              </td>
            </tr>
          </transition-group>
        </table>
      </div>
    </div>

    <nav aria-label="Page navigation example">
      <paginate
        v-model="page"
        :page-count="parseInt(productImages.last_page)"
        :page-range="5"
        :margin-pages="2"
        :click-handler="changePage"
        :prev-text="'<<'"
        :next-text="'>>'"
        :container-class="'pagination justify-content-center'"
        :page-class="'page-item'"
        :prev-class="'page-item'"
        :next-class="'page-item'"
        :page-link-class="'page-link bg-info text-light'"
        :next-link-class="'page-link bg-info text-light'"
        :prev-link-class="'page-link bg-info text-light'"
      >
      </paginate>
    </nav>
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
      page: 1,
      paginate: 5,
      search: "",
      flagShowLoader: false,
    };
  },
  created() {
    let messError = {
      custom: {
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
  watch: {
    paginate: function (value) {
      this.fetchData();
    },
    search: function (value) {
      this.fetchData();
    },
  },
  methods: {
    attachFile_1() {
      this.productImage.image_1 = this.$refs.fileImage_1.files[0];
      let reader = new FileReader();
      reader.buttonAddEventListener(
        "load",
        function () {
          this.$refs.fileImageDispaly_1.src = reader.result;
        }.bind(this),
        false
      );

      reader.readAsDataURL(this.productImage.image_1);
    },
    attachFile_2() {
      this.productImage.image_2 = this.$refs.fileImage_2.files[0];
      let reader = new FileReader();
      reader.buttonAddEventListener(
        "load",
        function () {
          this.$refs.fileImageDispaly_1.src = reader.result;
        }.bind(this),
        false
      );

      reader.readAsDataURL(this.productImage.image_2);
    },
    attachFile_3() {
      this.productImage.image_3 = this.$refs.fileImage_2.files[0];
      let reader = new FileReader();
      reader.buttonAddEventListener(
        "load",
        function () {
          this.$refs.fileImageDispaly_3.src = reader.result;
        }.bind(this),
        false
      );

      reader.readAsDataURL(this.productImage.image_3);
    },
    attachFile_4() {
      this.productImage.image_4 = this.$refs.fileImage_3.files[0];
      let reader = new FileReader();
      reader.buttonAddEventListener(
        "load",
        function () {
          this.$refs.fileImageDispaly_4.src = reader.result;
        }.bind(this),
        false
      );

      reader.readAsDataURL(this.productImage.image_4);
    },

    AddProductImage() {
      let that = this;
      if (this.edit == false) {
      } else {
        console.log("id", this.productImage.image_1);
        let formData = new FormData();
        formData.append("image_1", this.productImage.image_1);
        formData.append("image_2", this.productImage.image_2);
        formData.append("image_3", this.productImage.image_3);
        formData.append("image_4", this.productImage.image_4);
        axios
          .post(`product-image/${this.productImage.id}/update`, formData, {
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
      }
    },

    fetchData() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .get(
          "get-product-image?page=" +
            that.page +
            "&paginate=" +
            that.paginate +
            "&search=" +
            that.search
        )
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

    prev() {
      if (this.productImages.prev_page_url) {
        this.page--;
        this.fetchData();
      }
    },
    next() {
      if (this.productImages.next_page_url) {
        this.page++;
        this.fetchData();
      }
    },

    changePage(page) {
      this.page = page;
      this.fetchData();
    },

    updateProductImage(productImage) {
      this.productImage.product_id = productImage.product_id;
      if (productImage.image_1 != "") {
        this.$refs.fileImageDispaly_1.src =
          this.baseUrl + "/uploads/" + productImage.image_1;
      }
      if (productImage.image_2 != "") {
        this.$refs.fileImageDispaly_2.src =
          this.baseUrl + "/uploads/" + productImage.image_2;
      }
      if (productImage.image_3 != "") {
        this.$refs.fileImageDispaly_3.src =
          this.baseUrl + "/uploads/" + productImage.image_3;
      }
      if (productImage.image_4 != "") {
        this.$refs.fileImageDispaly_4.src =
          this.baseUrl + "/uploads/" + productImage.image_4;
      }
    },
  },
};
</script>
