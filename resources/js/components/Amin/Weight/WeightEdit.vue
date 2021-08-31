<template>
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading"></header>
        <div class="panel-body">
          <div class="position-center">
            <form
              role="form"
              @submit.prevent="editWeight"
              method="POST"
              ref="editWeightForm"
              :action="weightUpdate"
              enctype="multipart/form-data"
            >
              <input type="hidden" :value="csrfToken" name="_token" />
              <div class="form-group">
                <label for="exampleInputEmail1">New Weight</label>
                <input
                  type="text"
                  name="nameWeight"
                  class="form-control"
                  v-validate="'required'"
                  v-model="nameWeight"
                />
                <div style="color: red" role="alert">
                  {{ errors.first("nameWeight") }}
                  <!-- Lỗi validate bên vuejs-->
                </div>
                <div style="color: red" v-if="errorBackEnd.weight">
                  {{ errorBackEnd.weight[0] }}
                  <!-- Lỗi validate bên backend laravel-->
                </div>
              </div>
              <button type="submit" class="btn btn-info">Update</button>
            </form>
          </div>
        </div>
      </section>
    </div>
    <FlashMessage :position="'left bottom'"></FlashMessage>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
export default {
  created() {
    let messError = {
      custom: {
        nameWeight: {
          required: "* Tên chưa nhập",
        },
      },
    };
    this.$validator.localize("en", messError);
  },
  data() {
    return {
      csrfToken: Laravel.csrfToken,
      nameWeight: this.data.weight,
      errorBackEnd: {}, //Lỗi bên backend laravel
    };
  },
  props: ["weightUpdate", "data"],
  mounted() {},
  methods: {
    editWeight: function (e) {
      e.preventDefault();
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          this.$refs.editWeightForm.submit();
        }
      });
    },
  },
};
</script>
