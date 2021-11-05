<template>
  <div>
    <h2>Register Now</h2>
    <div style="color: red; text-align: center" v-if="errorBackEnd">
      {{ errorBackEnd }}
    </div>
    <form method="POST" @submit.prevent="register">
      <input type="hidden" :value="csrfToken" name="_token" />
      <div class="row">
        <div class="col-12 text-center is-danger" v-if="messageText">
          {{ messageText }}
        </div>
      </div>
      <input
        type="text"
        class="ggg"
        placeholder="Name"
        name="name"
        v-validate="'required'"
        @input="changeInput()"
        v-model="user.name"
      />
      <div class="text-center is-danger" role="alert">
        {{ errors.first("name") }}
      </div>

      <input
        type="text"
        class="ggg"
        placeholder="Phone"
        name="phone"
        v-validate="'required|number_phone'"
        @input="changeInput()"
        v-model="user.phone"
      />
      <div class="text-center is-danger" role="alert">
        {{ errors.first("phone") }}
      </div>

      <input
        type="email"
        class="ggg"
        placeholder="E-MAIL"
        name="email"
        v-validate="'required|email_format'"
        v-model="user.email"
        @input="changeInput()"
      />
      <div class="text-center is-danger" role="alert">
        {{ errors.first("email") }}
      </div>

      <div class="eye-input">
        <div v-if="!passwordHidden">
          <input
            type="text"
            class="ggg"
            placeholder="Password"
            name="password"
            v-validate="'required|min:8|max:15'"
            v-model="password"
            @input="changeInput()"
          /><svg
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            class="bi bi-eye"
            viewBox="0 0 16 16"
            @click="hidePassword"
          >
            <path
              d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"
            />
            <path
              d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"
            />
          </svg>
        </div>
        <div v-if="passwordHidden">
          <input
            type="password"
            class="ggg"
            placeholder="Password"
            name="password"
            v-validate="'required|min:8|max:15'"
            ref="password"
            v-model="password"
            @input="changeInput()"
          /><svg
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            class="bi bi-eye"
            viewBox="0 0 16 16"
            @click="showPassword"
          >
            <path
              d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"
            />
            <path
              d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"
            />
          </svg>
        </div>
      </div>
      <div class="text-center is-danger" role="alert">
        {{ errors.first("password") }}
      </div>

      <div class="eye-input">
        <div v-if="!passwordConfirmHidden">
          <input
            type="text"
            class="ggg"
            placeholder="Password Confirm"
            name="password_confirm"
            v-validate="'required|confirmed:password'"
            v-model="user.password_confirm"
            @input="changeInput()"
          /><svg
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            class="bi bi-eye"
            viewBox="0 0 16 16"
            @click="hidePasswordConfirm"
          >
            <path
              d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"
            />
            <path
              d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"
            />
          </svg>
        </div>
        <div v-if="passwordConfirmHidden">
          <input
            type="password"
            class="ggg"
            placeholder="Password Confirm"
            name="password_confirm"
            v-validate="'required|confirmed:password'"
            v-model="user.password_confirm"
            @input="changeInput()"
          /><svg
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            class="bi bi-eye"
            viewBox="0 0 16 16"
            @click="showPasswordConfirm"
          >
            <path
              d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"
            />
            <path
              d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"
            />
          </svg>
        </div>
      </div>
      <div class="text-center is-danger" role="alert">
        {{ errors.first("password_confirm") }}
      </div>

      <h4>
        <input type="checkbox" @click="confirmService" />I agree to the Terms of
        Service and Privacy Policy
      </h4>

      <div class="clearfix"></div>
      <input v-if="checker" type="submit" value="submit" name="register" />
    </form>
    <p>Already Registered.<a :href="formLogin">Login</a></p>
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
import Modal from "../../Modal/Modal.vue";
import Vue from "vue";
import axios from "axios";
export default {
  created() {
    let messError = {
      custom: {
        name: {
          required: "* Name chưa nhập !",
        },
        phone: {
          required: "* Phone chưa nhập !",
          number_phone: "* Phone chưa hợp lệ !",
        },
        email: {
          required: "* Email chưa nhập !",
          email_format: "* Email chưa hợp lệ !",
        },
        password: {
          required: "* Mật khẩu chưa được điển !",
          min: "* Mật khẩu ít nhất trên 8 kí tự !",
          max: "* Mật khẩu tối đa dưới 15 kí tự !",
        },
        password_confirm: {
          required: "* Mật khẩu xác nhận chưa được điển !",
          confirmed: "* Mật khẩu xác nhận chưa đúng !",
        },
      },
    };
    this.$validator.localize("en", messError);
  },
  data() {
    return {
      csrfToken: Laravel.csrfToken,
      user: {
        name: "",
        phone: "",
        email: "",
        password_confirm: "",
      },

      errorBackEnd: "",

      password: "",
      token: this.tokenUrl,
      messageText: this.message,

      checker: false,

      passwordHidden: {
        default: false,
        type: Boolean,
      },
      passwordConfirmHidden: {
        default: false,
        type: Boolean,
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
  props: ["formLogin", "message"],
  components: {
    Modal,
  },
  methods: {
    hidePassword() {
      this.passwordHidden = true;
    },
    showPassword() {
      this.passwordHidden = false;
    },
    hidePasswordConfirm() {
      this.passwordConfirmHidden = true;
    },
    showPasswordConfirm() {
      this.passwordConfirmHidden = false;
    },

    confirmService() {
      this.checker = !this.checker;
    },

    changeInput() {
      this.messageText = "";
    },

    register() {
      let that = this;
      let formData = new FormData();
      formData.append("name", this.user.name);
      formData.append("phone", this.user.phone);
      formData.append("email", this.user.email);
      formData.append("password_confirm", this.user.password_confirm);
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          axios
            .post(`/register`, formData)
            .then((response) => {
              (this.type = "success"),
                (this.title = response.data.message),
                (this.confirm = "Go to gmail !"),
                (this.cancle = "Back to Login !"),
                (this.urlConfirm = "https://mail.google.com/mail/u/0/#inbox"),
                (this.urlCancle = response.data.urlLogin),
                (this.modalShow = true);
            })
            .catch((err) => {
              switch (err.response.status) {
                case 422:
                  that.errorBackEnd = err.response.data.errors.email;
                  break;
                case 404:
                  that
                    .$swal({
                      title: "Register Error !",
                      icon: "warning",
                      confirmButtonText: "Cancle !",
                    })
                    .then(function (confirm) {});
                  break;
                case 500:
                  that
                    .$swal({
                      title: "Register Error !",
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