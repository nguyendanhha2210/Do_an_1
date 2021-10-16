<template>
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading"></header>
        <div class="panel-body">
          <div class="position-center">
            <form role="form" @submit.prevent="addCoupon()">
              <div class="form-group">
                <label for="exampleInputEmail1">Coupon Name </label>
                <input
                  type="text"
                  name="name"
                  class="form-control"
                  v-validate="'required'"
                  @input="changeInput()"
                  v-model="data.name"
                />
                <div style="color: red" role="alert">
                  {{ errors.first("name") }}
                  <!-- Lỗi validate bên vuejs-->
                </div>
                <div style="color: red" v-if="errorBackEnd.name">
                  {{ errorBackEnd.name[0] }}
                  <!-- Lỗi validate bên backend laravel-->
                </div>

                <label for="exampleInputEmail1">Coupon Condition </label>
                <select
                  v-model="data.condition"
                  @input="changeInput()"
                  name="condition"
                  class="form-control"
                >
                  <option value="">Select Coupon Condition</option>
                  <option value="1">Giảm %</option>
                  <option value="2">Giảm $</option>
                </select>

                <div style="color: red" role="alert">
                  {{ errors.first("condition") }}
                  <!-- Lỗi validate bên vuejs-->
                </div>
                <div style="color: red" v-if="errorBackEnd.condition">
                  {{ errorBackEnd.condition[0] }}
                  <!-- Lỗi validate bên backend laravel-->
                </div>
                <label for="exampleInputEmail1">Coupon Number </label>

                <input
                  type="text"
                  name="number"
                  class="form-control"
                  v-validate="'required'"
                  @input="changeInput()"
                  v-model="data.number"
                />
                <div style="color: red" role="alert">
                  {{ errors.first("number") }}
                  <!-- Lỗi validate bên vuejs-->
                </div>
                <div style="color: red" v-if="errorBackEnd.number">
                  {{ errorBackEnd.number[0] }}
                  <!-- Lỗi validate bên backend laravel-->
                </div>

                <label for="exampleInputEmail1">Coupon Code </label>
                <input
                  type="text"
                  name="code"
                  class="form-control"
                  v-validate="'required'"
                  @input="changeInput()"
                  v-model="data.code"
                />
                <div style="color: red" role="alert">
                  {{ errors.first("code") }}
                  <!-- Lỗi validate bên vuejs-->
                </div>
                <div style="color: red" v-if="errorBackEnd.code">
                  {{ errorBackEnd.code[0] }}
                  <!-- Lỗi validate bên backend laravel-->
                </div>

                <label for="exampleInputEmail1">Start Time </label>
                <date-picker
                  v-model="data.start_date"
                  type="datetime"
                  class="w100"
                  style="width: 180px"
                  :lang="lang"
                ></date-picker>

                <div style="color: red" role="alert">
                  {{ errors.first("start_date") }}
                </div>
                <div style="color: red" v-if="errorBackEnd.end_date">
                  {{ errorBackEnd.end_date[0] }}
                </div>

                <label for="exampleInputEmail1">End Time </label>
                <date-picker
                  v-model="data.end_date"
                  type="datetime"
                  class="w100 pl-2"
                  style="width: 189px"
                  :lang="lang"
                ></date-picker>

                <div style="color: red" role="alert">
                  {{ errors.first("end_date") }}
                </div>
                <div style="color: red" v-if="errorBackEnd.end_date">
                  {{ errorBackEnd.end_date[0] }}
                </div>
              </div>
              <button type="submit" class="btn btn-info">Add</button>
            </form>
          </div>
        </div>
      </section>
    </div>
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
import moment from "moment-timezone";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import "vue2-datepicker/locale/en";
export default {
  data() {
    return {
      data: {
        name: "",
        condition: "",
        number: "",
        code: "",
        start_date: "",
        end_date: "",
      },
      errorBackEnd: {}, //Lỗi bên backend laravel
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
      lang: "en",
    };
  },
  created() {
    let messError = {
      custom: {
        name: {
          required: "* Tên chưa nhập",
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
  mounted() {},
  components: {
    Modal,
    DatePicker,
  },
  methods: {
    changeInput() {
      this.errorBackEnd = []; //Khi thay đổi trong input thì biến đổi về rỗng
    },

    addCoupon() {
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          let that = this;
          let formData = new FormData();
          formData.append("name", this.data.name);
          formData.append("condition", this.data.condition);
          formData.append("number", this.data.number);
          formData.append("code", this.data.code);
          formData.append(
            "start_date",
            moment(this.data.start_date)
              .tz("Asia/Ho_Chi_Minh")
              .format("YYYY-MM-DD HH:mm:ss")
          );
          formData.append(
            "end_date",
            moment(this.data.end_date)
              .tz("Asia/Ho_Chi_Minh")
              .format("YYYY-MM-DD HH:mm:ss")
          );
          axios
            .post("coupon-show", formData)
            .then((response) => {
              (this.type = "success"),
                (this.title = "Saved"),
                (this.text = "Do you want to continue ?"),
                (this.confirm = "Yes !"),
                (this.cancle = "Back to List !"),
                (this.urlConfirm = ""),
                (this.urlCancle = response.data), //lấy url từ respon->json() bên controller
                (this.modalShow = true); //gọi modal thêm thành công ra
              this.data.name = "";
              this.data.condition = "";
              this.data.number = "";
              this.data.code = "";
              this.data.start_date = "";
              this.data.end_date = "";
            })
            .catch((err) => {
              switch (err.response.status) {
                case 422:
                  this.errorBackEnd = err.response.data.errors;
                  break;
                case 404:
                  that
                    .$swal({
                      title: "Add Error !",
                      icon: "warning",
                      confirmButtonText: "Cancle !",
                    })
                    .then(function (confirm) {});
                  break;
                case 500:
                  that
                    .$swal({
                      title: "Add Error !",
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
