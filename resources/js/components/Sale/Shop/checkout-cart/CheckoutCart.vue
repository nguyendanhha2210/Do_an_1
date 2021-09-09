<template>
  <div>
    <h4>Thông tin nhận hàng</h4>
    <div class="row">
      <form role="form" @submit.prevent="checkOut()">
        <div class="col-lg-12 col-xl-12">
          <input
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

          <div style="color: red" v-if="errorBackEnd.name">
            {{ errorBackEnd.name[0] }}
          </div>

          <input
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

          <div style="color: red" v-if="errorBackEnd.email">
            {{ errorBackEnd.email[0] }}
          </div>

          <input
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
          <div style="color: red" v-if="errorBackEnd.address">
            {{ errorBackEnd.address[0] }}
          </div>

          <input
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
          <div style="color: red" v-if="errorBackEnd.phone">
            {{ errorBackEnd.phone[0] }}
          </div>

          <button type="submit" class="btn btn-info" style="width: 100%">
            Xác nhận đơn hàng
          </button>
        </div>
      </form>
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
  mounted() {},

  methods: {
    changeInput() {
      this.errorBackEnd = []; //Khi thay đổi trong input thì biến đổi về rỗng
    },

    checkOut() {
      let that = this;
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          that
            .$swal({
              title: "Do you want to pay ?",
              icon: "question",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Yes",
              cancelButtonText: "No, cancel",
            })
            .then((result) => {
              if (result.value) {
                axios
                  .post(`/sale/checkout-cart`, that.shipping)
                  .then((response) => {
                    (this.type = "success"),
                      (this.title = "Saved"),
                      (this.text = ""),
                      (this.confirm = "Yes"),
                      (this.cancle = "Cancle"),
                      (this.urlConfirm = response.data),
                      (this.urlCancle = ""), //lấy url từ respon->json() bên controller
                      (this.modalShow = true); //gọi modal thêm thành công ra
                  })
                  .catch((error) => {
                    that.flashMessage.error({
                      message: "Purchase Failure!",
                      icon: "/backend/icon/error.svg",
                      blockClass: "text-centet",
                    });
                  });
              }
            });
        }
      });
    },
  },
};
</script>