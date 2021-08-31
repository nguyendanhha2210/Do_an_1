<template>
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading"></header>
        <div class="panel-body">
          <div class="position-center">
            <form role="form" method="POST" @submit.prevent="editCoupon()">
              <div class="form-group">
                <label for="exampleInputEmail1">New Name</label>
                <input
                  type="text"
                  name="nameName"
                  class="form-control"
                  v-validate="'required'"
                  v-model="nameName"
                />
                <div style="color: red" role="alert">
                  {{ errors.first("nameName") }}
                  <!-- Lỗi validate bên vuejs-->
                </div>
                <div style="color: red" v-if="errorBackEnd.name">
                  {{ errorBackEnd.name[0] }}
                  <!-- Lỗi validate bên backend laravel-->
                </div>
                <label for="exampleInputEmail1">New Desc</label>
                <input
                  type="text"
                  name="nameDesc"
                  class="form-control"
                  v-validate="'required'"
                  v-model="nameDesc"
                />
                <div style="color: red" role="alert">
                  {{ errors.first("nameDesc") }}
                  <!-- Lỗi validate bên vuejs-->
                </div>
                <div style="color: red" v-if="errorBackEnd.desc">
                  {{ errorBackEnd.desc[0] }}
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
        name: {
          required: "* Tên chưa nhập",
        },
        desc: {
          required: "* Mô tả chưa nhập",
        },
      },
    };
    this.$validator.localize("en", messError);
  },
  data() {
    return {
      csrfToken: Laravel.csrfToken,
      nameName: this.category.name,
      nameDesc: this.category.desc,
      errorBackEnd: {}, //Lỗi bên backend laravel
    };
  },
  props: ["category"],
  mounted() {},
  methods: {
    editCoupon: function () {
      let that = this;
      let formData = new FormData();
      formData.append("name", this.nameName);
      formData.append("desc", this.nameDesc);
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          axios
            .post(`category-post-update`, formData)
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
