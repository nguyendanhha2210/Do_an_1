<template>
  <div>
    <h2 style="color: white">Change Password</h2>
    <div class="col-12 text-center is-danger" v-if="messageText">
      {{ messageText }}
    </div>
    <div class="col-12 text-center is-danger" v-if="messageText2">
      {{ messageText2 }}
    </div>
    <form
      method="POST"
      ref="loginForm"
      :action="formUrl"
      @submit.prevent="sendMail"
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
        <input
          type="text"
          class="ggg"
          placeholder="Email"
          name="email_address"
          v-validate="'required|email_format|max:255'"
          v-model="email_address"
          @input="changeInput()"
        />
        <div class="input-group is-email" role="alert">
          {{ errors.first("email_address") }}
        </div>
      </div>
      <span><a class="back-login" :href="formLogin">Back to Login</a></span>
      <input type="submit" value="Send Require" name="login" />
    </form>
  </div>
</template>

<style lang="scss" scope>
.forgot {
  background-color: #eeeeee;
  padding: 12px;
  border: 1px solid #dfdfdf;
}

.padding-bottom-3x {
  padding-bottom: 72px !important;
}

.mt-4 {
  background-color: #eeeeee;
}

.btn {
  font-size: 13px;
}

.form-control:focus {
  color: #495057;
  background-color: #fff;
  border-color: #76b7e9;
  outline: 0;
  box-shadow: 0 0 0 0px #28a745;
}

.is-danger {
  color: red !important;
  font-size: 17px;
  text-align: center;
  display: block;
}

.is-email {
  color: red;
  font-size: 17px;
  text-align: center;
  display: block;
}
</style>

<script>
import Vue from "vue";
import axios from "axios";
export default {
  created: function () {
    let messError = {
      custom: {
        email_address: {
          required: "* Email chưa nhập !",
          email_format: "* Email chưa hợp lệ !",
          max: "* Email chỉ gồm 255 kí tự !",
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
      email_address: "",
      email_address: this.oldEmail,
    };
  },
  props: ["formUrl", "message", "message2", "formLogin", "oldEmail"],
  methods: {
    sendMail: function (e) {
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
