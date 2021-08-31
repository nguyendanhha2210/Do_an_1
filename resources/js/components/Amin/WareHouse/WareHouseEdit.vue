<template>
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading"></header>
        <div class="panel-body">
          <div class="position-center">
            <form role="form" method="POST" @submit.prevent="importAdd()">
              <div class="form-group">
                <label for="exampleInputEmail1">New Type</label>
                <input
                  type="text"
                  name="nameWare"
                  class="form-control"
                  v-validate="'required'"
                  @input="changeInput()"
                  v-model="nameWare"
                />
                <div style="color: red" role="alert">
                  {{ errors.first("nameWare") }}
                </div>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Images</label>
                <div>
                  <img
                    :src="baseUrl + '/uploads/' + fileImageDispaly"
                    width="100px"
                    height="100px"
                    alt=""
                  />
                </div>
              </div>
              <br />

              <div class="form-row">
                <div class="form-group col-md-6 col-lg-5">
                  <label for="inputEmail4">Import Price</label>
                  <input
                    type="text"
                    name="import_price"
                    class="form-control"
                    v-validate="'required'"
                    @input="changeInput()"
                    v-model="warehouseNew.import_price"
                  />
                  <div style="color: red" role="alert">
                    {{ errors.first("import_price") }}
                  </div>
                </div>

                <div class="form-group col-md-3 col-lg-4">
                  <label for="inputPassword4">Old Import Price</label>
                  <input
                    readonly
                    type="number"
                    class="form-control"
                    v-model="importPriceWare"
                  />
                </div>
                <div class="form-group col-md-3 col-lg-3 text-donvi">
                  Đơn vị : VNĐ
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputEmail4">Import Quantity</label>
                  <input
                    type="text"
                    name="import_quantity"
                    class="form-control"
                    v-validate="'required'"
                    @input="changeInput()"
                    v-model="warehouseNew.import_quantity"
                  />
                  <div style="color: red" role="alert">
                    {{ errors.first("import_quantity") }}
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <label for="inputPassword4">Inventory</label>
                  <input
                    readonly
                    type="number"
                    class="form-control"
                    v-model="inventoryWare"
                  />
                </div>
              </div>
              <button type="submit" class="btn btn-info">Import Add</button>
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
        nameWare: {
          required: "* Tên chưa nhập",
        },
        importPriceWareNew: {
          required: "* Giá nhập chưa nhập",
        },
        importQuantityWare: {
          required: "* Số lượng nhập chưa nhập",
        },
      },
    };
    this.$validator.localize("en", messError);
  },
  data() {
    return {
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      csrfToken: Laravel.csrfToken,
      nameWare: this.warehouse.name,
      fileImageDispaly: this.warehouse.images,
      importPriceWare: this.warehouse.import_price,
      inventoryWare: this.warehouse.inventory,

      warehouseNew: {
        import_price: "",
        import_quantity: "",
      },
    };
  },
  props: ["warehouse"],
  mounted() {},
  methods: {
    importAdd: function () {
      let that = this;
      let formData = new FormData();
      formData.append("name", this.nameWare);
      formData.append("images", this.fileImageDispaly);
      formData.append("import_price", this.warehouseNew.import_price);
      formData.append("import_quantity", this.warehouseNew.import_quantity);
      formData.append("inventory", this.inventoryWare);
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          axios
            .post(`warehouse-update`, formData)
            .then((response) => {
              that
                .$swal({
                  title: "Import Add successful!",
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
