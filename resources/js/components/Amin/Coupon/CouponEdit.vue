<template>
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading"></header>
        <div class="panel-body">
          <div class="position-center">
            <form role="form" method="POST" @submit.prevent="editCoupon()">
              <div class="form-group">
                <label for="exampleInputEmail1">New Coupon</label>
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
                <label for="exampleInputEmail1">New Time</label>
                <input
                  type="text"
                  name="nameTime"
                  class="form-control"
                  v-validate="'required'"
                  v-model="nameTime"
                />
                <div style="color: red" role="alert">
                  {{ errors.first("nameTime") }}
                  <!-- Lỗi validate bên vuejs-->
                </div>
                <div style="color: red" v-if="errorBackEnd.time">
                  {{ errorBackEnd.time[0] }}
                  <!-- Lỗi validate bên backend laravel-->
                </div>
                <label for="exampleInputEmail1">New Condition</label>

                <input
                  type="text"
                  name="nameCondition"
                  class="form-control"
                  v-validate="'required'"
                  v-model="nameCondition"
                />
                <div style="color: red" role="alert">
                  {{ errors.first("nameCondition") }}
                  <!-- Lỗi validate bên vuejs-->
                </div>
                <div style="color: red" v-if="errorBackEnd.condition">
                  {{ errorBackEnd.condition[0] }}
                  <!-- Lỗi validate bên backend laravel-->
                </div>
                <label for="exampleInputEmail1">New Number</label>

                <input
                  type="text"
                  name="nameNumber"
                  class="form-control"
                  v-validate="'required'"
                  v-model="nameNumber"
                />
                <div style="color: red" role="alert">
                  {{ errors.first("nameNumber") }}
                  <!-- Lỗi validate bên vuejs-->
                </div>
                <div style="color: red" v-if="errorBackEnd.number">
                  {{ errorBackEnd.number[0] }}
                  <!-- Lỗi validate bên backend laravel-->
                </div>
                <label for="exampleInputEmail1">New Code</label>

                <input
                  type="text"
                  name="nameCode"
                  class="form-control"
                  v-validate="'required'"
                  v-model="nameCode"
                />
                <div style="color: red" role="alert">
                  {{ errors.first("nameCode") }}
                  <!-- Lỗi validate bên vuejs-->
                </div>
                <div style="color: red" v-if="errorBackEnd.code">
                  {{ errorBackEnd.code[0] }}
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
        time: {
          required: "* Time chưa nhập",
        },
        condition: {
          required: "* condition chưa nhập",
        },
        number: {
          required: "* number chưa nhập",
        },
        code: {
          required: "* code chưa nhập",
        },
      },
    };
    this.$validator.localize("en", messError);
  },
  data() {
    return {
      csrfToken: Laravel.csrfToken,
      nameName: this.coupon.name,
      nameTime: this.coupon.time,
      nameCondition: this.coupon.condition,
      nameNumber: this.coupon.number,
      nameCode: this.coupon.code,
      errorBackEnd: {}, //Lỗi bên backend laravel
    };
  },
  props: ["coupon"],
  mounted() {},
  methods: {
    editCoupon: function () {
      let that = this;
      let formData = new FormData();
      formData.append("name", this.nameName);
      formData.append("time", this.nameTime);
      formData.append("condition", this.nameCondition);
      formData.append("number", this.nameNumber);
      formData.append("code", this.nameCode);
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          axios
            .post(`coupon-update`, formData)
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
