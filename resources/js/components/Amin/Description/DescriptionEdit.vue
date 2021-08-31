<template>
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading"></header>
        <div class="panel-body">
          <div class="position-center">
            <form role="form" method="POST" @submit.prevent="editDescription()">
              <div class="form-group">
                <label for="exampleInputEmail1">New Description</label>
                <input
                  type="text"
                  name="nameDescription"
                  class="form-control"
                  v-validate="'required'"
                  v-model="nameDescription"
                />
                <div style="color: red" role="alert">
                  {{ errors.first("nameDescription") }}
                  <!-- Lỗi validate bên vuejs-->
                </div>
                <div style="color: red" v-if="errorBackEnd.description">
                  {{ errorBackEnd.description[0] }}
                  <!-- Lỗi validate bên backend laravel-->
                </div>
              </div>
              <button type="submit" class="btn btn-info">Save</button>
            </form>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
export default {
  created() {
    let messError = {
      custom: {
        nameDescription: {
          required: "* Tên chưa nhập",
        },
      },
    };
    this.$validator.localize("en", messError);
  },
  data() {
    return {
      csrfToken: Laravel.csrfToken,
      nameDescription: this.description.description,
      errorBackEnd: {}, //Lỗi bên backend laravel
    };
  },
  props: ["description"],
  mounted() {},
  methods: {
    editDescription: function () {
      let that = this;
      let formData = new FormData();
      formData.append("description", this.nameDescription);
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          axios
            .post(`description-update`, formData)
            .then((response) => {
              that
                .$swal({
                  title: "Update successful!",
                  icon: "success",
                  confirmButtonColor: "#3085d6",
                  confirmButtonText: "Ok!",
                })
                .then(function (confirm) {
                  location.replace(response.data); //response.data lấy dg dẫn http://127.0.0.1:8000/admin/type  từ response->json bên controller
                  //location.replace("http://127.0.0.1:8000/admin/type");
                });
            })
            .catch((err) => {
              switch (err.response.status) {
                case 422:
                  that.errorBackEnd = err.response.data.errors;
                  break;
                case 404:
                  that
                    .$swal({
                      title: "Error!",
                      icon: "error",
                      confirmButtonText: "Ok",
                    })
                    .then(function (confirm) {});
                  break;
                case 500:
                  that
                    .$swal({
                      title: "Error!",
                      icon: "error",
                      confirmButtonText: "Ok",
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
