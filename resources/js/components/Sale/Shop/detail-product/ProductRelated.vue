<template>
  <div>
    <div class="container ml-2">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-title mb-0">
            <h2 class="pt-2" style="font-size: 25px">Related Products</h2>
          </div>
        </div>
      </div>
      <a :href="`${product.id}`">
        <div class="row" style="background-color: #e9edf0; margin-bottom: 15px">
          <div
            class="col-lg-2 col-sm-6 pl-0"
            v-for="product in products"
            :key="product.id"
          >
            <div class="product-item div-hover" style="background-color: white">
              <div class="pi-pic">
                <img
                  style="height: 250px"
                  :src="baseUrl + '/uploads/products/' + product.images"
                  alt=""
                />
                <div class="sale">Sale</div>
                <ul>
                  <!-- <li class="w-icon active">
                  <a href="#" @click="addCartProduct(product)"
                    ><i class="fa fa-shopping-basket"></i
                  ></a>
                </li> -->
                  <li class="quick-view">
                    <a
                      type="button"
                      data-toggle="modal"
                      data-target="#myModal"
                      @click="showQuickView(product)"
                      href="#"
                      style="background-color: darkolivegreen; color: white"
                      >+ Quick View</a
                    >
                  </li>
                  <!-- <li class="w-icon">
                  <a :href="`${product.id}`"><i class="fa fa-eye"></i></a>
                </li> -->
                </ul>
              </div>
              <div
                class="pi-text"
                style="
                  padding-top: 19px !important;
                  border: 0.5px solid #e9edf0;
                "
              >
                <a
                  href="#"
                  style="transform: translate(0%, -34%); font-size: 21px"
                >
                  <h5 style="">
                    {{ product.name }}
                  </h5>
                </a>
                <div style="color: red; transform: translate(-27%, 53%)">
                  <u
                    style="
                      font-size: 13px;
                      display: -webkit-inline-box;
                      transform: translate(0%, -13%);
                    "
                    >đ</u
                  >
                  <span style="font-size: 19px">{{
                    formatPrice(product.price)
                  }}</span>
                </div>
                <div
                  class="da-ban"
                  style="
                    transform: translate(26%, -42%);
                    font-size: 14px;
                    color: dimgray;
                  "
                >
                  <span>Đã bán {{ product.product_sold }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </a>
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
import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      related: this.relatedProduct,

      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      products: [],
      product: {
        id: "",
        name: "",
        images: "",
        price: "",
        type_id: "",
        description_id: "",
        content: "",
        status: "",
      },
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
  created() {},
  components: {
    Modal,
  },
  props: ["relatedProduct"],
  mounted() {
    this.fetchData();
  },
  methods: {
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    fetchData() {
      let that = this;
      axios
        .get(`/get-related-product/${this.related.id}`)
        .then(function (response) {
          console.log(response);
          that.products = response.data; //show data ra
        })
        .catch((err) => {
          switch (err.response.status) {
            case 500:
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

    showQuickView(product) {
      this.product.id = product.id;
      this.product.name = product.name;
      if (product.images != "") {
        this.$refs.fileImageDispaly.src =
          this.baseUrl + "/uploads/products/" + product.images;
      }

      this.product.price = product.price;
      this.product.type_id = product.type_id;
      this.product.description_id = product.description_id;
      this.product.content = product.content;
      this.product.status = product.status;
    },

    addCartProduct(product) {
      let that = this;
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          axios
            .post(`/add-to-cart`, product)
            .then((response) => {
              (that.type = "success"),
                (that.title = ""),
                (that.text = "Do you want to continue ?"),
                (that.confirm = "Xem tiếp !"),
                (that.cancle = "Đi đến giỏ hàng !"),
                (that.urlConfirm = ""),
                (that.urlCancle = response.data), //lấy url từ respon->json() bên controller
                (that.modalShow = true); //gọi modal thêm thành công ra
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
  },
};
</script>