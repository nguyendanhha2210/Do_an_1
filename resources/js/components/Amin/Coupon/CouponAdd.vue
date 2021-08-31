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

                <label for="exampleInputEmail1">Coupon Time </label>
                <input
                  type="text"
                  name="time"
                  class="form-control"
                  v-validate="'required'"
                  @input="changeInput()"
                  v-model="data.time"
                />
                <div style="color: red" role="alert">
                  {{ errors.first("time") }}
                  <!-- Lỗi validate bên vuejs-->
                </div>
                <div style="color: red" v-if="errorBackEnd.time">
                  {{ errorBackEnd.time[0] }}
                  <!-- Lỗi validate bên backend laravel-->
                </div>
                <label for="exampleInputEmail1">Coupon Condition </label>

                <input
                  type="text"
                  name="condition"
                  class="form-control"
                  v-validate="'required'"
                  @input="changeInput()"
                  v-model="data.condition"
                />
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
export default {
  data() {
    return {
      data: {
        name: "",
        time: "",
        condition: "",
        number: "",
        code: "",
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
    };
  },
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
  mounted() {},
  components: {
    Modal,
  },
  methods: {
    changeInput() {
      this.errorBackEnd = []; //Khi thay đổi trong input thì biến đổi về rỗng
    },

    addCoupon() {
      let that = this;
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          axios
            .post("coupon-add", this.data)
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
              this.data.time = "";
              this.data.condition = "";
              this.data.number = "";
              this.data.code = "";
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
