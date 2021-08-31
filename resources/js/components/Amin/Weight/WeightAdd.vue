<template>
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading"></header>
        <div class="panel-body">
          <div class="position-center">
            <form
              role="form"
              @submit.prevent="addWeight"
              method="POST"
              ref="addWeightForm"
              :action="weightAdd"
              enctype="multipart/form-data"
            >
              <input type="hidden" :value="csrfToken" name="_token" />
              <div class="form-group">
                <label for="exampleInputEmail1">Weight Name</label>
                <input
                  type="text"
                  name="weight"
                  class="form-control"
                  v-validate="'required'"
                  v-model="weight.weight"
                />
                <div style="color: red" role="alert">
                  {{ errors.first("weight") }}
                  <!-- Lỗi validate bên vuejs-->
                </div>
                <div style="color: red" v-if="errorBackEnd.weight">
                  {{ errorBackEnd.weight[0] }}
                  <!-- Lỗi validate bên backend laravel-->
                </div>
              </div>
              <button type="submit" class="btn btn-info">Add</button>
            </form>
          </div>
        </div>
      </section>
    </div>
    <Loader :flag-show="flagShowLoader"></Loader>
    <FlashMessage :position="'left bottom'"></FlashMessage>
  </div>
</template>

<script>
import Loader from "../../Common/loader.vue";
import Vue from "vue";
import axios from "axios";
export default {
  created() {
    let messError = {
      custom: {
        weight: {
          required: "* Tên chưa nhập",
        },
      },
    };
    this.$validator.localize("en", messError);
  },
  data() {
    return {
      csrfToken: Laravel.csrfToken,
      weight: {
        weight: "",
      },
      errorBackEnd: {}, //Lỗi bên backend laravel
      flagShowLoader: false,
    };
  },
  props: ["weightAdd"],
  mounted() {},
  computed: {
    Loader,
  },
  methods: {
    addWeight: function (e) {
      e.preventDefault();
      let that = this;
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          that.$refs.addWeightForm.submit();
          this.$swal({
            title: "Add successfully!",
            icon: "success",
            confirmButtonText: "OK",
          }).then(function (confirm) {
          });
        }
      });
    },
  },
};
</script>
