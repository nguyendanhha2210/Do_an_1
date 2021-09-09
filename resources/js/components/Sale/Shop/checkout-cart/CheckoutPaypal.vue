<template>
  <div>
    <h4>Thông tin nhận hàng</h4>
    <div class="row">
      <form role="form" @submit.prevent="checkOut()">
        <div class="col-lg-12 col-xl-12">
          <input
            v-if="statusInput == true"
            style="width: 395px"
            type="text"
            name="name"
            placeholder="Họ và tên người nhận ..."
            v-validate="'required'"
            @input="changeInput()"
            v-model="shipping.name"
          />
          <div style="color: red" role="alert">
            {{ errors.first("name") }}
          </div>
          <input
            v-if="statusInput == false"
            readonly
            style="width: 395px"
            type="text"
            v-model="shipping.name"
          />
          <input
            v-if="statusInput == true"
            type="text"
            name="email"
            placeholder="Email người nhận ..."
            v-validate="'required|email_format|max:255'"
            @input="changeInput()"
            v-model="shipping.email"
          />
          <div style="color: red" role="alert">
            {{ errors.first("email") }}
          </div>
          <input
            v-if="statusInput == false"
            readonly
            type="email"
            v-model="shipping.email"
          />

          <input
            v-if="statusInput == true"
            type="text"
            name="address"
            placeholder="Địa chỉ gửi hàng ..."
            v-validate="'required'"
            @input="changeInput()"
            v-model="shipping.address"
          />
          <div style="color: red" role="alert">
            {{ errors.first("address") }}
          </div>
          <input
            v-if="statusInput == false"
            readonly
            type="text"
            v-model="shipping.address"
          />

          <input
            v-if="statusInput == true"
            type="text"
            name="phone"
            placeholder="Số điện thoại ..."
            v-validate="'required|number_phone'"
            @input="changeInput()"
            v-model="shipping.phone"
          />
          <div style="color: red" role="alert">
            {{ errors.first("phone") }}
          </div>
          <input
            v-if="statusInput == false"
            readonly
            type="text"
            v-model="shipping.phone"
          />

          <button
            v-if="statusInput == true"
            type="submit"
            class="btn btn-info"
            style="width: 100%"
          >
            Xác nhận đơn hàng
          </button>
        </div>
      </form>
      <div class="text-center">
        <div id="paypal-button"></div>
        <input type="hidden" id="vnd_to_usd" v-model="this.totalAfter" />
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
      errorBackEnd: {}, //Lỗi bên backend laravel

      shipping: {
        name: "",
        email: "",
        address: "",
        phone: "",
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
      statusInput: true,
    };
  },
  created() {
    let messError = {
      custom: {
        name: {
          required: "* Tên chưa nhập",
        },
        email: {
          required: "* Emaill chưa nhập",
          max: "* Tối đa 255 kí tự",
          email_format: "* Phải thuộc kiểu email",
        },
        address: {
          required: "* Địa chỉ chưa nhập",
        },
        phone: {
          required: "* Điện thoại chưa nhập",
          number_phone: "* Điện thoại chưa hợp lệ",
        },
      },
    };
    this.$validator.localize("en", messError);
  },
  components: {
    Modal,
  },
  props: ["totalAfter"],

  methods: {
    changeInput() {
      this.errorBackEnd = []; //Khi thay đổi trong input thì biến đổi về rỗng
    },

    // checkOut() {
    //   let that = this;
    //   this.statusInput == true,
    //     this.$validator.validateAll().then((valid) => {
    //       if (valid) {
    //         axios
    //           .post(`/sale/order-confirm`, that.shipping)
    //           .then((response) => {
    //             that.statusInput = false;

    //             var usd = document.getElementById("vnd_to_usd").value;
    //             paypal.Button.render(
    //               {
    //                 env: "sandbox",
    //                 client: {
    //                   sandbox:
    //                     "AZhnH9YyXLDcOgwS8-PQduz5Ytt5rZLXrgfLk0N8xrxfmtHb4MgLXjchaZGPJhebU1hN8Tp5ofs7M4f4",
    //                   production: "demo_production_client_id",
    //                 },
    //                 locale: "en_US",
    //                 style: {
    //                   size: "small",
    //                   color: "gold",
    //                   shape: "pill",
    //                 },
    //                 commit: true,
    //                 payment: function (data, actions) {
    //                   return actions.payment.create({
    //                     transactions: [
    //                       {
    //                         amount: {
    //                           total: `${usd}`,
    //                           currency: "USD",
    //                         },
    //                       },
    //                     ],
    //                   });
    //                 },
    //                 onAuthorize: function (data, actions) {
    //                   return actions.payment.execute().then(function () {
    //                     that.$validator.validateAll().then((valid) => {
    //                       if (valid) {
    //                         axios
    //                           .post(`/sale/checkout-cart`, that.shipping)
    //                           .then((response) => {
    //                             that
    //                               .$swal({
    //                                 title: "Thành Công !",
    //                                 icon: "success",
    //                                 confirmButtonText: "Ok",
    //                               })
    //                               .then(function (confirm) {
    //                                 window.location.href = "/";
    //                               });
    //                           });
    //                       }
    //                     });
    //                   });
    //                 },
    //               },
    //               "#paypal-button"
    //             );
    //           })
    //           .catch((error) => {
    //             that.flashMessage.error({
    //               message: "Purchase Failure!",
    //               icon: "/backend/icon/error.svg",
    //               blockClass: "text-centet",
    //             });
    //           });
    //       }
    //     });
    // },

    checkOut() {
      let that = this;
      this.statusInput == true,
        this.$validator.validateAll().then((valid) => {
          if (valid) {
            that.statusInput = false;
            // Paypal
            var usd = document.getElementById("vnd_to_usd").value;
            paypal.Button.render(
              {
                env: "sandbox",
                client: {
                  sandbox:
                    "AZhnH9YyXLDcOgwS8-PQduz5Ytt5rZLXrgfLk0N8xrxfmtHb4MgLXjchaZGPJhebU1hN8Tp5ofs7M4f4",
                  production: "demo_production_client_id",
                },
                locale: "en_US",
                style: {
                  size: "small",
                  color: "gold",
                  shape: "pill",
                },
                commit: true,
                payment: function (data, actions) {
                  return actions.payment.create({
                    transactions: [
                      {
                        amount: {
                          total: `${usd}`,
                          currency: "USD",
                        },
                      },
                    ],
                  });
                },
                onAuthorize: function (data, actions) {
                  return actions.payment.execute().then(function () {
                    that.$validator.validateAll().then((valid) => {
                      if (valid) {
                        axios
                          .post(`/sale/checkout-cart`, that.shipping)
                          .then((response) => {
                            that
                              .$swal({
                                title: "Thành Công !",
                                icon: "success",
                                confirmButtonText: "Ok",
                              })
                              .then(function (confirm) {
                                window.location.href = "sale/manage-order";
                              });
                          });
                      }
                    });
                  });
                },
              },
              "#paypal-button"
            );
            // Paypal
          }
        });
    },
  },
};
</script>