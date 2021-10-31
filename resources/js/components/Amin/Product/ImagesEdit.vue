<template>
  <div class="table-agile-info">
    <div class="row" style="display: grid">
      <form
        class="form-horizontal"
        method="POST"
        action=""
        @submit.prevent="update"
      >
        <div class="border-bottom w-100">
          <div class="form-group row row-container mt-4">
            <div class="col-md-12 ml-2">
              <div
                class="position-relative float-left"
                style="margin-right: 9px"
                v-for="(item, index) in listImages"
                :key="item.id"
              >
                <label :for="`file_img_banner${index}`">
                  <div class="img-drop-box mt-2 mr-2">
                    <img
                      :src="item.is_database ? (baseUrl + '/uploads/products/' + item.src) : item.src"
                      :ref="`imageDisplay${index}`"
                      class="mh-100 mw-100 mx-auto display-block"
                    />
                    <svg
                      width="45"
                      height="45"
                      viewBox="0 0 45 45"
                      style="margin-top: 30px"
                      :ref="`imageIconPlus${index}`"
                      class="display-none"
                    >
                      <use xlink:href="/images/Group_1287.svg#Group_1287"></use>
                    </svg>
                  </div>
                  <input
                    type="file"
                    :id="`file_img_banner${index}`"
                    :ref="`image${index}`"
                    v-on:change="attachImage('image', index)"
                    accept="image/*"
                    style="display: none"
                  />
                </label>
                <a
                  class="btn btn-light icon-close-white display-block"
                  :ref="`imageIconClose${index}`"
                  @click="deleteImage('image', index)"
                >
                </a>
              </div>
              <div class="position-relative float-left">
                <label :for="`file_img_banner${listImages.length}`">
                  <div class="img-drop-box mt-2 mr-2">
                    <img
                      src
                      :ref="`imageDisplay${listImages.length}`"
                      class="mh-100 mw-100 mx-auto"
                    />
                    <svg
                      width="45"
                      height="45"
                      viewBox="0 0 45 45"
                      style="margin-top: 30px"
                      :ref="`imageIconPlus${listImages.length}`"
                    >
                      <use xlink:href="/images/Group_1287.svg#Group_1287"></use>
                    </svg>
                  </div>
                  <input
                    type="file"
                    :id="`file_img_banner${listImages.length}`"
                    :ref="`image${listImages.length}`"
                    v-on:change="attachImage('image', listImages.length)"
                    accept="image/*"
                    style="display: none"
                  />
                </label>
                <a
                  class="btn btn-light icon-close-white display-none"
                  :ref="`imageIconClose${listImages.length}`"
                  @click="deleteImage('image', listImages.length)"
                >
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="text-right mb-2">
          <button class="btn btn-success" type="submit">
            <i style="font-size: 21px" class="fa fa-save"> Save</i>
          </button>
        </div>
      </form>
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

<style lang="scss" scoped>
.td-action {
  display: inline-flex;
}
.btn-success {
  float: right;
  margin-top: 10px;
  margin-right: 5%;
}
</style>

<script>
import Modal from "../../Modal/Modal.vue";
const axios = require("axios").default;
export default {
  data() {
    return {
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      buttonAdd: true,
      productImage: {
        id: "",
        product_id: "",
        url: "",
      },

      listImages: [],
      productImages: this.data,
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
  props: ["data"],
  mounted() {
    this.productImages.forEach((item, index) => {
      this.listImages.push({
        file_id: item.id,
        file: item.url,
        src: item.url,
        is_database: true,
      });
    });
  },
  components: {
    Modal,
  },
  methods: {
    update() {
      let formData = new FormData();
      formData.append("productID", this.productImages[0].product_id);
      this.listImages.forEach((item, index) => {
        if (item.file_id != null) {
          formData.append("images[" + item.file_id + "]", item.file);
        } else {
          formData.append("images[create" + index + "]", item.file);
        }
      });
      axios
        .post(
          `/admin/update-image/${this.productImages[0].product_id}`,
          formData,
          {
            header: {
              "Content-Type": "multipart/form-data",
            },
          }
        )
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
          switch (err.response) {
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
    },

    attachImage(type, value) {
      var file = null;
      if (type == "image") {
        if (value < this.listImages.length) {
          this.listImages[value].file = this.$refs[type + value][0].files[0];
          file = this.$refs[type + value][0].files[0];
          this.$refs[type + value][0].value = "";
        } else {
          this.listImages.push({
            file_id: null,
            file: this.$refs[type + value].files[0],
            src: "",
            is_database: false
          });
          file = this.$refs[type + value].files[0];
          this.$refs[type + value].value = "";
        }
      }
      let reader = new FileReader();
      reader.addEventListener(
        "load",
        function () {
          this.$refs[type + "Display" + value][0].style.setProperty(
            "display",
            "block",
            "important"
          );
          this.$refs[type + "IconClose" + value][0].style.setProperty(
            "display",
            "block",
            "important"
          );
          this.$refs[type + "Display" + value][0].src = reader.result;
          if (type == "image") {
            this.listImages[value].src = reader.result;
          }
          this.$refs[type + "IconPlus" + value][0].style.setProperty(
            "display",
            "none",
            "important"
          );
        }.bind(this),
        false
      );
      reader.readAsDataURL(file);
    },

    deleteImage(type, value) {
      var index = 0;
      if (type == "image") {
        index = this.listImages.length;
        this.listImages.splice(value, 1);
      }
      this.$refs[type + index].value = "";
    },
  },
};
</script>
