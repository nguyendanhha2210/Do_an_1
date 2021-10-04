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

                <select
                  v-model="nameCondition"
                  @input="changeInput()"
                  name="nameCondition"
                  class="form-control"
                >
                  <option value="">Select Coupon Condition</option>
                  <option value="1">Giảm %</option>
                  <option value="2">Giảm $</option>
                </select>

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

                <label for="exampleInputEmail1">Start Time </label>
                <date-picker
                  v-model="nameStartDate"
                  type="datetime"
                  class="w100 mr-4"
                  name="nameStartDate"
                  :lang="lang"
                ></date-picker>

                <div style="color: red" role="alert">
                  {{ errors.first("nameStartDate") }}
                </div>
                <div style="color: red" v-if="errorBackEnd.end_date">
                  {{ errorBackEnd.end_date[0] }}
                  <!-- Lỗi validate bên backend laravel-->
                </div>

                <label for="exampleInputEmail1">End Time </label>
                <date-picker
                  v-model="nameEndDate"
                  type="datetime"
                  class="w100 mr-4"
                  name="nameEndDate"
                  :lang="lang"
                ></date-picker>

                <div style="color: red" role="alert">
                  {{ errors.first("nameEndDate") }}
                </div>
                <div style="color: red" v-if="errorBackEnd.end_date">
                  {{ errorBackEnd.end_date[0] }}
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
import moment from 'moment-timezone'
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import "vue2-datepicker/locale/en";
import 'vue2-datepicker/locale/zh-cn';
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
        start_date: {
          required: "* Ngày bắt đầu chưa nhập",
        },
        end_date: {
          required: "* Ngày kết thúc  chưa nhập",
        },
      },
    };
    this.$validator.localize("en", messError);
  },
  data() {
    return {
      lang: 'en',
      csrfToken: Laravel.csrfToken,
      nameName: this.coupon.name,
      nameTime: this.coupon.time,
      nameCondition: this.coupon.condition,
      nameNumber: this.coupon.number,
      nameCode: this.coupon.code,
      nameStartDate: new Date(this.coupon.start_date),
      nameEndDate: new Date(this.coupon.end_date),
      errorBackEnd: {}, //Lỗi bên backend laravel
    };
  },
  props: ["coupon"],
  mounted() {},
  components: {
    DatePicker,
  },
  methods: {
    editCoupon: function () {
      // console.log(this.nameStartDate);
      let that = this;
      let formData = new FormData();
      formData.append("name", this.nameName);
      formData.append("time", this.nameTime);
      formData.append("condition", this.nameCondition);
      formData.append("number", this.nameNumber);
      formData.append("code", this.nameCode);
      formData.append("start_date", moment(this.nameStartDate).tz('Asia/Tokyo').format('YYYY-MM-DD HH:mm:ss'));
      formData.append("end_date", moment(this.nameEndDate).tz('Asia/Tokyo').format('YYYY-MM-DD HH:mm:ss'));
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
