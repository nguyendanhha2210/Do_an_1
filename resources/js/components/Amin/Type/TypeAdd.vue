<template>
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading"></header>
        <div class="panel-body">
          <div class="position-center">
            <form role="form" @submit.prevent="addType()">
              <div class="form-group">
                <label for="exampleInputEmail1">Type Name </label>
                <input
                  type="text"
                  name="type"
                  class="form-control"
                  v-validate="'required'"
                  @input="changeInput()"
                  v-model="data.type"
                />
                <div style="color: red" role="alert">
                  {{ errors.first("type") }}
                  <!-- Lỗi validate bên vuejs-->
                </div>
                <div style="color: red" v-if="errorBackEnd.type">
                  {{ errorBackEnd.type[0] }}
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
        type: "",
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
        type: {
          required: "* Tên chưa nhập",
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

    addType() {
      let that = this;
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          axios
            .post("type-add", this.data)
            .then((response) => {
              (this.type = "success"),
                (this.title = "Saved"),
                (this.text = "Do you want to continue ?"),
                (this.confirm = "Yes !"),
                (this.cancle = "Back to List !"),
                (this.urlConfirm = ""),
                (this.urlCancle = response.data), //lấy url từ respon->json() bên controller
                (this.modalShow = true); //gọi modal thêm thành công ra
              this.data.type = "";
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