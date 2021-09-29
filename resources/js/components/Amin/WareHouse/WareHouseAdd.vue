<template>
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading"></header>
        <div class="panel-body">
          <div class="position-center">
            <form
              role="form"
              @submit.prevent="ImportGoods()"
              enctype="multipart/form-data"
            >
              <div class="form-group">
                <label for="exampleInputEmail1">Name Product</label>
                <input
                  type="text"
                  name="name"
                  class="form-control"
                  v-validate="'required'"
                  @input="changeInput()"
                  v-model="warehouse.name"
                />
                <div style="color: red" role="alert">
                  {{ errors.first("name") }}
                </div>
              </div>

              <div class="form-group">
                <div class="position-relative d-inline-block">
                  <label for="file_img_banner1">
                    <div class="img-drop-box mt-2 mr-2">
                      <img src ref="imageDispaly" class="img-thumbnail" />
                      <svg
                        width="45"
                        height="45"
                        viewBox="0 0 45 45"
                        style="
                          margin-top: 52px;
                          margin-left: 38%;
                          margin-right: 38%;
                        "
                        ref="iconFile"
                      >
                        <use
                          xlink:href="/images/Group_1287.svg#Group_1287"
                        ></use>
                      </svg>
                    </div>
                    <input
                      type="file"
                      id="file_img_banner1"
                      v-validate="'required'"
                      name="images"
                      ref="image"
                      v-on:change="attachImage"
                      accept="image/*"
                    />
                  </label>
                  <a
                    class="btn btn-light icon-close-white display-none"
                    style="background-color: black; border-radius: 91%"
                    ref="iconClose"
                    @click="deleteImage"
                  ></a>
                </div>
                <div style="color: red" role="alert">
                  {{ errors.first("images") }}
                </div>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Import Price</label>
                <input
                  type="text"
                  name="import_price"
                  class="form-control"
                  v-validate="'required'"
                  @input="changeInput()"
                  v-model="warehouse.import_price"
                />
                <div style="color: red" role="alert">
                  {{ errors.first("import_price") }}
                </div>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Import Quantity </label>
                <input
                  type="text"
                  name="import_quantity"
                  class="form-control"
                  v-validate="'required'"
                  @input="changeInput()"
                  v-model="warehouse.import_quantity"
                />
                <div style="color: red" role="alert">
                  {{ errors.first("import_quantity") }}
                </div>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Inventory</label>
                <input
                  readonly
                  type="number"
                  min="0"
                  name="inventory"
                  class="form-control"
                  v-model="warehouse.inventory"
                />
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
      warehouse: {
        name: "",
        images: "",
        import_price: "",
        import_quantity: "",
        inventory: "",
      },
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
        images: {
          required: "* Ảnh chưa nhập",
        },
        import_price: {
          required: "* Giá nhập chưa nhập",
        },
        import_quantity: {
          required: "* Số lượng nhập chưa nhập",
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
    attachFile() {
      this.warehouse.images = this.$refs.fileImage.files[0];
      let reader = new FileReader();
      reader.buttonAddEventListener(
        "load",
        function () {
          this.$refs.fileImageDispaly.src = reader.result;
        }.bind(this),
        false
      );

      reader.readAsDataURL(this.warehouse.images);
    },
    changeInput() {
      this.errorBackEnd = []; //Khi thay đổi trong input thì biến đổi về rỗng
    },

    ImportGoods() {
      let that = this;
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          let that = this;
          let formData = new FormData();
          formData.append("name", this.warehouse.name);
          formData.append("images", this.warehouse.images);
          formData.append("import_price", this.warehouse.import_price);
          formData.append("import_quantity", this.warehouse.import_quantity);
          formData.append("inventory", this.warehouse.inventory);
          axios
            .post(`warehouse-add`, formData, {
              headers: {
                "Content-Type": "multipart/form-data",
              },
            })
            .then((response) => {
              (this.type = "success"),
                (this.title = "Saved"),
                (this.text = "Do you want to continue ?"),
                (this.confirm = "Yes !"),
                (this.cancle = "Back to List !"),
                (this.urlConfirm = ""),
                (this.urlCancle = response.data), //lấy url từ respon->json() bên controller
                (this.modalShow = true); //gọi modal thêm thành công ra
              that.warehouse = {
                name: "",
                images: "",
                import_price: "",
                import_quantity: "",
                inventory: "",
              };
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

    attachImage() {
      this.warehouse.images = this.$refs.image.files[0];
      let reader = new FileReader();
      reader.addEventListener(
        "load",
        function () {
          this.$refs.imageDispaly.style.display = "block";
          this.$refs.iconClose.style.display = "block";
          this.$refs.imageDispaly.src = reader.result;
          this.$refs.iconFile.style.display = "none";
        }.bind(this),
        false
      );
      reader.readAsDataURL(this.warehouse.images);
    },
    deleteImage() {
      this.warehouse.images = "";
      this.$refs.imageDispaly.style.display = "none";
      this.$refs.iconClose.style.display = "none";
      this.$refs.image.value = "";
      this.$refs.iconFile.style.display = "block";
    },
  },
};
</script>
