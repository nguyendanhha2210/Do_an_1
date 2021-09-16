<template>
  <div class="pt-3" style="min-height: 100%; position: relative">
    <div
      class="product-show-option"
      style="background-color: #e9edf0; height: 54px"
      v-if="products != ''"
    >
      <div class="row">
        <div
          class="col-lg-2 col-md-2 col-3"
          style="transform: translate(10%, 23%)"
        >
          <select v-model="paginate" class="form-control">
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
          </select>
        </div>

        <div
          class="col-lg-3 col-md-3 col-2"
          style="transform: translate(10%, 23%)"
        >
          <select
            v-model="statusView"
            class="form-control w-sm inline v-middle text-center"
          >
            <option value="0">-- Mới nhất --</option>
            <option value="1">-- Giá tăng dần --</option>
            <option value="2">-- Giá giảm dần --</option>
            <option value="3">-- Tên từ A -> Z --</option>
            <option value="4">-- Tên từ Z -> A --</option>
          </select>
        </div>

        <div class="col-lg-3 col-md-3 col-2"></div>

        <div
          class="col-lg-4 col-md-4 col-5 text-right"
          style="transform: translate(-4%, 23%)"
        >
          <input
            type="text"
            class="form-control"
            v-model="search"
            placeholder="Search"
          />
        </div>
      </div>
    </div>

    <div class="product-list">
      <div class="row">
        <div
          class="col-lg-4 col-sm-6"
          v-for="product in products.data"
          :key="product.id"
        >
          <div class="product-item">
            <div class="pi-pic">
              <img
                style="height: 250px"
                :src="baseUrl + '/uploads/' + product.images"
                alt=""
              />
              <div class="sale pp-sale">Sale</div>
              <div class="icon">
                <a class="btn btn-default" @click="addFavorite(product)"
                  ><i
                    class="icon_heart_alt"
                    style="color: red; font-size: 22px"
                  ></i
                ></a>
              </div>
              <ul>
                <li class="w-icon active">
                  <a @click="addCartProduct(product)" href="#"
                    ><i class="fa fa-shopping-basket"></i
                  ></a>
                </li>
                <li class="quick-view">
                  <a
                    type="button"
                    data-toggle="modal"
                    data-target="#myModal"
                    @click="showQuickView(product)"
                    href="#"
                    >+ Quick View</a
                  >
                </li>

                <li class="w-icon">
                  <a :href="`product-detail/${product.id}`"
                    ><i class="fa fa-eye"></i
                  ></a>
                </li>
              </ul>
            </div>
            <div class="pi-text">
              <div class="catagory-name">{{ product.type.type }}</div>
              <a href="#">
                <h5>{{ product.name }}</h5>
              </a>
              <div class="product-price">
                {{ product.price }}
                <span>$35.00</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      class="loading-more"
      v-if="products != ''"
      style="position: absolute; bottom: 1px; left: 50%; right: 50%"
    >
      <nav aria-label="Page navigation example">
        <paginate
          v-model="page"
          :page-count="parseInt(products.last_page)"
          :page-range="9"
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
    </div>
    <div class="text-center" v-else style="color: red">There is no data !</div>

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
              Product information
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
            <div class="form-group row">
              <label for="staticEmail" class="col-lg-4 col-sm-4 col-form-label"
                >Name Product :
              </label>
              <div class="col-lg-8 col-sm-8">
                <input
                  type="text"
                  readonly
                  class="form-control-plaintext"
                  id="staticEmail"
                  v-model="product.name"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="staticEmail" class="col-lg-4 col-sm-4 col-form-label"
                >Price Product :
              </label>
              <div class="col-lg-8 col-sm-8">
                <input
                  type="text"
                  readonly
                  class="form-control-plaintext"
                  id="staticEmail"
                  v-model="product.price"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="staticEmail" class="col-lg-4 col-sm-4 col-form-label"
                >Content Product :
              </label>
              <div class="col-lg-8 col-sm-8">
                <input
                  type="text"
                  readonly
                  class="form-control-plaintext"
                  id="staticEmail"
                  v-model="product.content"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="staticEmail" class="col-lg-4 col-sm-4 col-form-label"
                >Images Product :
              </label>
              <div class="col-lg-8 col-sm-8">
                <img src ref="fileImageDispaly" width="150px" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <Modal
      v-if="modalShow"
      :type="type"
      :title="title"
      :text="text"
      :confirm="confirm"
      :cancle="cancle"
      :urlConfirm="urlConfirm"
      :urlCancle="urlCancle"
      :modalShow="modalShow"
    ></Modal>
  </div>
</template>
<script>
import Modal from "../../../Modal/Modal.vue";
import Loader from "../../../Common/loader.vue";
import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      products: [],
      product: {
        id: "",
        name: "",
        images: "",
        price: "",
        type_id: "",
        weight_id: "",
        description_id: "",
        content: "",
        status: "",
      },
      page: 1,
      paginate: 9,
      search: "",
      statusView: 0,
      minPrice: 0,
      maxPrice: 100,

      flagShowLoader: false,
      //Modal
      modalShow: false,
      type: "",
      title: "",
      text: "",
      confirm: "",
      cancle: "",
      urlConfirm: "",
      urlCancle: "",
      //Modal
    };
  },
  created() {
    this.fetchData();
  },
  components: {
    Modal,
    Loader,
  },
  mounted() {},
  props: {
    userDetailInfo: {},
  },
  watch: {
    paginate: function (value) {
      this.fetchData();
    },
    search: function (value) {
      this.fetchData();
    },
    statusView: function (value) {
      this.fetchData();
    },
  },
  methods: {
    fetchData() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .get(
          "get-product-shop?page=" +
            that.page +
            "&paginate=" +
            that.paginate +
            "&search=" +
            that.search +
            "&statusView=" +
            that.statusView
        )
        .then(function (response) {
          that.products = response.data;
          // console.log("products", that.products.data);
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
      if (this.products.prev_page_url) {
        this.page--;
        this.fetchData();
      }
    },
    next() {
      if (this.products.next_page_url) {
        this.page++;
        this.fetchData();
      }
    },

    changePage(page) {
      this.page = page;
      this.fetchData();
    },

    showQuickView(product) {
      this.product.id = product.id;
      this.product.name = product.name;
      if (product.images != "") {
        this.$refs.fileImageDispaly.src =
          this.baseUrl + "/uploads/" + product.images;
      }

      this.product.price = product.price;
      this.product.type_id = product.type_id;
      this.product.weight_id = product.weight_id;
      this.product.description_id = product.description_id;
      this.product.content = product.content;
      this.product.status = product.status;
    },

    // addCartProduct(product) {
    //   let that = this;
    //   this.$validator.validateAll().then((valid) => {
    //     if (valid) {
    //       axios
    //         .post(`/add-to-cart`, product)
    //         // console.log(product)
    //         .then((response) => {
    //           (that.type = "success"),
    //             (that.title = ""),
    //             (that.text = "Do you want to continue ?"),
    //             (that.confirm = "Xem tiếp !"),
    //             (that.cancle = "Đi đến giỏ hàng !"),
    //             (that.urlConfirm = ""),
    //             (that.urlCancle = response.data),
    //             (that.modalShow = true);
    //         })
    //         .catch((err) => {
    //           switch (err.response.status) {
    //             case 422:
    //               that.errorBackEnd = err.response.data.errors;
    //               break;
    //             case 404:
    //               that
    //                 .$swal({
    //                   title: "Add Error !",
    //                   icon: "warning",
    //                   confirmButtonText: "Cancle !",
    //                 })
    //                 .then(function (confirm) {});
    //               break;
    //             case 500:
    //               that
    //                 .$swal({
    //                   title: "Add Error !",
    //                   icon: "warning",
    //                   confirmButtonText: "Cancle !",
    //                 })
    //                 .then(function (confirm) {});
    //               break;
    //             default:
    //               break;
    //           }
    //         });
    //     }
    //   });
    // },

    addCartProduct(product) {
      let that = this;
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          axios
            .post(`/add-to-cart`, product)
            .then((response) => {
              this.$swal({
                title: "Add Successfully!",
                icon: "success",
                confirmButtonText: "OK",
              }).then((confirm) => {
                if (confirm.value) {
                  this.$swal({
                    title: "Do you want to continue ？",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Xem tiếp !",
                    cancelButtonText: "Đi đến giỏ hàng !",
                  }).then((result) => {
                    if (result.value) {
                    } else {
                      window.location = this.baseUrl + "/view-cart";
                    }
                  });
                }
              });
            })
            .catch((err) => {
              switch (err.response.status) {
                case 422:
                  that.errorBackEnd = err.response.data.errors;
                  break;
                case 404:
                  that
                    .$swal({
                      title: "Add Error !",
                      icon: "warning",
                      confirmButtonText: "Cancle !",
                    })
                    .then(function (confirm) {});
                  break;
                case 500:
                  that
                    .$swal({
                      title: "Add Error !",
                      icon: "warning",
                      confirmButtonText: "Cancle !",
                    })
                    .then(function (confirm) {});
                  break;
                default:
                  break;
              }
            });
        }
      });
    },

    addFavorite(product) {
      let that = this;
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          axios
            .post(`/add-to-favorite`, product)
            .then((response) => {
              this.$swal({
                title: "Add Successfully!",
                icon: "success",
                confirmButtonText: "OK",
              }).then((confirm) => {});
            })
            .catch((err) => {
              switch (err.response.status) {
                case 422:
                  that.errorBackEnd = err.response.data.errors;
                  break;
                case 404:
                  that
                    .$swal({
                      title: "Add Error !",
                      icon: "warning",
                      confirmButtonText: "Cancle !",
                    })
                    .then(function (confirm) {});
                  break;
                case 500:
                  that
                    .$swal({
                      title: "Add Error !",
                      icon: "warning",
                      confirmButtonText: "Cancle !",
                    })
                    .then(function (confirm) {});
                  break;
                default:
                  break;
              }
            });
        }
      });
    },

    attachFile() {
      this.product.images = this.$refs.fileImage.files[0];
      let reader = new FileReader();
      reader.buttonAddEventListener(
        "load",
        function () {
          this.$refs.fileImageDispaly.src = reader.result;
        }.bind(this),
        false
      );

      reader.readAsDataURL(this.product.images);
    },
  },
};
</script>
