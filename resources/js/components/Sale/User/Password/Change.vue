<template>
  <div>
    <h2 style="color: white">Change Password</h2>
    <form
      method="POST"
      ref="changePasswordForm"
      :action="formUrl"
      @submit.prevent="changePassword"
      autocomplete="off"
    >
      <div class="row">
        <div class="col-12 text-center is-danger" v-if="messageText">
          {{ messageText }}
        </div>
      </div>
      <div class="row">
        <div class="col-12 text-center is-danger" v-if="messageText2">
          {{ messageText2 }}
        </div>
      </div>

      <input type="hidden" :value="csrfToken" name="_token" />
      <input type="hidden" :value="token" name="reset_password_token" />

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
            v-model="password_confirm"
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
            v-model="password_confirm"
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

      <span><a class="back-login" :href="formLogin">Back to Login</a></span>
      <h6><a class="forgot-password" :href="formForgot">Forgot Password</a></h6>
      <div class="clearfix"></div>
      <input type="submit" value="Change Password" name="login" />
    </form>
  </div>
</template>

<style lang="scss" scope>
.forgot-password {
  display: block;
}
.is-danger {
  color: yellow !important;
  font-size: 17px;
}
</style>

<script>
const axios = require("axios").default;
export default {
  created() {
    let messError = {
      custom: {
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
      messageText: this.message,
      messageText2: this.message2,
      password: "",
      password_confirm: "",
      token: this.tokenUrl,

      passwordHidden: {
        default: false,
        type: Boolean,
      },
      passwordConfirmHidden: {
        default: false,
        type: Boolean,
      },
    };
  },
  props: [
    "formUrl",
    "tokenUrl",
    "message",
    "message2",
    "formForgot",
    "formLogin",
  ],
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

    changePassword(e) {
      e.preventDefault();

      let that = this;
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          that.$refs.changePasswordForm.submit();
        }
      });
    },

    changeInput() {
      this.messageText = "";
    },
  },
};
</script> 