<template>
  <div class="col-12">
    <div class="row">
      <div class="col-lg-12">
        <div class="section-title mb-0">
          <h2 class="pt-2" style="font-size: 25px">Compare Products</h2>
        </div>
      </div>
    </div>
    <div class="row" style="background-color: #e9edf0; margin-bottom: 15px">
      <div
        class="col-lg-3 col-sm-6 pr-1 pl-1"
        v-for="product in products"
        :key="product.id"
      >
        <a :href="`${product.id}`">
          <div
            class="product-item"
            style="background-color: white; border: 1px solid #78a4c5"
          >
            <div class="div-hover">
              <div class="pi-pic">
                <img
                  style="height: 250px"
                  :src="baseUrl + '/uploads/products/' + product.images"
                  alt=""
                />
                <div class="sale">Sale</div>
                <ul>
                  <!-- <li class="w-icon active">
                  <a @click="addCartProduct(product)" href="#"
                    ><i class="fa fa-shopping-basket"></i
                  ></a>
                </li> -->
                  <!-- <li class="quick-view">
                    <a
                      type="button"
                      data-toggle="modal"
                      data-target="#myModal"
                      @click="showQuickView(product)"
                      href="#"
                      style="background-color: darkolivegreen; color: white"
                      >+ Quick View</a
                    >
                  </li> -->
                </ul>
              </div>
              <div
                class="pi-text"
                style="padding-top: 0px !important; border: 0.5px solid #e9edf0"
              >
                <h5
                  class="border-bottom pb-2 pt-2"
                  style="font-size: 18px; background-color: #eaeaea"
                >
                  {{ product.name }}
                </h5>
                <div
                  class="text-center border-bottom pb-2"
                  style="display: -webkit-inline-box"
                >
                  <star-rating
                    read-only
                    :star-size="15"
                    :increment="0.1"
                    :rating="Number(product.star_vote)"
                  ></star-rating>
                </div>
                <h5
                  class="border-bottom pb-2 pt-2"
                  style="font-size: 21px; color: red; background-color: #eaeaea"
                >
                  {{ formatPrice(product.price) }} đ
                </h5>

                <div
                  class="da-ban pb-2 pt-2"
                  style="font-size: 14px; color: dimgray"
                >
                  <b class="">Đã bán {{ product.product_sold }}</b>
                </div>
              </div>
            </div>
          </div>
        </a>
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
import StarRating from "vue-star-rating";
import Modal from "../../../Modal/Modal.vue";
import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      compare: this.compareProduct,

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
    StarRating,
  },
  props: ["compareProduct"],
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
        .get(`/get-compare-product/${this.compare.id}`)
        .then(function (response) {
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

    // showQuickView(product) {
    //   this.product.id = product.id;
    //   this.product.name = product.name;
    //   if (product.images != "") {
    //     this.$refs.fileImageDispaly.src =
    //       this.baseUrl + "/uploads/products/" + product.images;
    //   }

    //   this.product.price = product.price;
    //   this.product.type_id = product.type_id;
    //   this.product.description_id = product.description_id;
    //   this.product.content = product.content;
    //   this.product.status = product.status;
    // },

    // addCartProduct(product) {
    //   let that = this;
    //   this.$validator.validateAll().then((valid) => {
    //     if (valid) {
    //       axios
    //         .post(`/add-to-cart`, product)
    //         .then((response) => {
    //           (that.type = "success"),
    //             (that.title = ""),
    //             (that.text = "Do you want to continue ?"),
    //             (that.confirm = "Xem tiếp !"),
    //             (that.cancle = "Đi đến giỏ hàng !"),
    //             (that.urlConfirm = ""),
    //             (that.urlCancle = response.data), //lấy url từ respon->json() bên controller
    //             (that.modalShow = true); //gọi modal thêm thành công ra
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
  },
};
</script>