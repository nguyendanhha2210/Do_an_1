<template>
  <div>
    <h2 style="color: white">Sign In Ship</h2>
    <form
      method="POST"
      ref="loginForm"
      :action="formUrl"
      @submit.prevent="login"
      autocomplete="off"
    >
      <input type="hidden" :value="csrfToken" name="_token" />
      <div class="row">
        <div class="col-12 text-center is-danger" v-if="messageText">
          {{ messageText }}
        </div>
      </div>
      <input
        type="text"
        class="ggg"
        placeholder="Email address"
        name="email"
        v-validate="'required|email_format'"
        v-model="loginIdValue"
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
            v-validate="'required'"
            v-model="loginPasssword"
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
            v-validate="'required'"
            v-model="loginPasssword"
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
      <span><input type="checkbox" />Remember Me</span>
      <h6><a :href="forgotPasswordUrl">Forgot Password?</a></h6>
      <div class="clearfix"></div>
      <input type="submit" value="Sign In" name="login" />
    </form>
  </div>
</template>

<style lang="scss" scope>
.forgot-password {
  display: block;
}
.is-danger {
  color: red;
  font-size: 17px;
}
</style>

<script>
const axios = require("axios").default;
export default {
  created() {
    let messError = {
      custom: {
        email: {
          required: "* Email chưa nhập !",
          email_format: "* Email chưa hợp lệ !",
        },
        password: {
          required: "* Mật khẩu chưa được nhập !",
        },
      },
    };
    this.$validator.localize("en", messError);
  },
  data() {
    return {
      csrfToken: Laravel.csrfToken,
      loginIdValue: this.oldEmail,
      messageText: this.message,
      loginPasssword: this.oldPassword,
      passwordHidden: {
        default: false,
        type: Boolean,
      },
    };
  },
  props: ["formUrl", "forgotPasswordUrl", "message", "oldEmail", "oldPassword"],
  methods: {
    hidePassword() {
      this.passwordHidden = true;
    },
    showPassword() {
      this.passwordHidden = false;
    },
    login: function (e) {
      e.preventDefault();
      let that = this;
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          that.$refs.loginForm.submit();
        }
      });
    },
    changeInput() {
      this.messageText = "";
    },
  },
};
</script> 