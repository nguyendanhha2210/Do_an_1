<template>
  <div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading"></div>
      <div class="row w3-res-tb">
        <div for="paginate" class="col-lg-2 col-md-2 col-sm-3 col-3">
          <select v-model="paginate" class="form-control w-sm inline v-middle">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
          </select>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-5 col-5">
          <a class="btn btn-success button-nhaphang" :href="formAdd"
            >Import Goods</a
          >
        </div>

        <div class="col-lg-3 col-md-5 col-sm-5 col-4">
          <select
            v-model="statusImport"
            class="form-control w-sm inline v-middle"
          >
            <option value="1">Permitted goods</option>
            <option value="2">Entered</option>
            <option value="3">Excel Import</option>
            <option value="">Full</option>
          </select>
        </div>

        <div class="col-lg-1 col-md-2 col-sm-2 col-2 text-date-warehouse">
          <b>Date:</b>
        </div>

        <div class="col-lg-2 col-md-10 col-sm-3 col-8 input-search">
          <input
            type="text"
            class="form-control"
            v-model="search"
            placeholder="Search"
          />
        </div>
      </div>
      <div class="col-md-4 col-12 mt-1" style="float: left">
        <form role="form" @submit.prevent="importCSV()" multiple="multiple">
          <div class="form-group" style="float: left; width: 204px">
            <input type="file" name="file" accept=".xlsx" />
          </div>
          <button type="submit" class="btn btn-info">Import</button>
        </form>
      </div>

      <div class="table-responsive">
        <table class="table table-striped b-t b-light text-center">
          <thead>
            <tr>
              <th>STT</th>
              <th>Name</th>
              <th>Images</th>
              <th scope="col" class="text-center">
                <a href="#" @click.prevent="change_sort('import_price')"
                  >Import Price</a
                >
                <span
                  v-if="
                    sort_direction == 'desc' && sort_field == 'import_price	'
                  "
                  >&uarr;</span
                >
                <span
                  v-if="sort_direction == 'asc' && sort_field == 'import_price	'"
                  >&darr;</span
                >
              </th>
              <th scope="col" class="text-center">
                <a href="#" @click.prevent="change_sort('import_quantity')"
                  >Import Quantity</a
                >
                <span
                  v-if="
                    sort_direction == 'desc' && sort_field == 'import_quantity	'
                  "
                  >&uarr;</span
                >
                <span
                  v-if="
                    sort_direction == 'asc' && sort_field == 'import_quantity	'
                  "
                  >&darr;</span
                >
              </th>
              <th scope="col" class="text-center">
                <a href="#" @click.prevent="change_sort('inventory')"
                  >Inventory</a
                >
                <span
                  v-if="sort_direction == 'desc' && sort_field == 'inventory'"
                  >&uarr;</span
                >
                <span
                  v-if="sort_direction == 'asc' && sort_field == 'inventory'"
                  >&darr;</span
                >
              </th>
              <th>Import Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <transition-group type="slide-fade" tag="tbody">
            <tr
              v-for="(warehouse, index) in warehouses.data"
              :key="warehouse.id"
            >
              <th scope="row">{{ index + 1 }}</th>
              <td>
                {{ warehouse.name }}
              </td>
              <td>
                <img
                  :src="baseUrl + '/uploads/products/' + warehouse.images"
                  width="50px"
                  height="50px"
                  alt=""
                />
              </td>
              <td>
                {{ warehouse.import_price }}
              </td>
              <td>
                {{ warehouse.import_quantity }}
              </td>
              <td>
                {{ warehouse.inventory }}
              </td>
              <td>
                {{ warehouse.import_date }}
              </td>
              <td v-if="warehouse.status == 1">
                <div class="td-action">
                  <a
                    :href="`warehouse/${warehouse.id}/edit`"
                    style="font-size: 21px; transform: translate(-26%, -14%)"
                    ><i
                      class="fa fa-pencil-square-o text-success text-active"
                    ></i
                  ></a>
                </div>
              </td>
              <td v-else-if="warehouse.status == 3">
                <div class="td-action">
                  <a
                    data-toggle="modal"
                    data-target="#myModal"
                    @click="updateWarehouse(warehouse)"
                    style="font-size: 21px; transform: translate(-26%, -14%)"
                    ><i
                      class="fa fa-pencil-square-o text-success text-active"
                    ></i
                  ></a>
                </div>
              </td>
              <td v-else></td>
            </tr>
          </transition-group>
        </table>
      </div>
    </div>

    <div
      class="modal fade"
      id="myModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Import product information
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form
              @submit.prevent="addImage"
              enctype="multipart/form-data"
              method="POST"
              ref="addForm"
            >
              <input type="hidden" name="productId" :value="warehouse.id" />

              <input type="hidden" :value="csrfToken" name="_token" />

              <div class="form-group">
                <label for="exampleInputEmail1">Name Product</label>
                <input
                  readonly
                  type="text"
                  name="name"
                  class="form-control"
                  id="exampleInputEmail1"
                  v-model="warehouse.name"
                />
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
                      v-validate="'image_format'"
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
                <div style="color: red" v-if="errorBackEnd.images">
                  {{ errorBackEnd.images[0] }}
                </div>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Import Price</label>
                <input
                  readonly
                  type="text"
                  name="import_price"
                  class="form-control"
                  id="exampleInputEmail1"
                  v-model="warehouse.import_price"
                />
              </div>

              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-dismiss="modal"
                >
                  Close
                </button>
                <button class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div v-if="warehouses != ''">
      <nav aria-label="Page navigation example">
        <paginate
          v-model="page"
          :page-count="parseInt(warehouses.last_page)"
          :page-range="5"
          :margin-pages="2"
          :click-handler="changePage"
          :prev-text="'<<'"
          :next-text="'>>'"
          :container-class="'pagination justify-content-center'"
          :page-class="'page-item'"
          :prev-class="'page-item'"
          :next-class="'page-item'"
          :page-link-class="'page-link bg-info text-light'"
          :next-link-class="'page-link bg-info text-light'"
          :prev-link-class="'page-link bg-info text-light'"
        >
        </paginate>
      </nav>
    </div>
    <div class="text-center" v-else style="color: red">There is no data !</div>
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
    <Loader :flag-show="flagShowLoader"></Loader>
    <FlashMessage :position="'left bottom'"></FlashMessage>
  </div>
</template>

<style lang="scss" scoped>
.td-action {
  display: inline-flex;
}
.btn-success {
  float: right;
  margin-top: 10px;
  margin-right: 7%;
}
</style>

<script>
import Loader from "../../Common/loader.vue";
import Modal from "../../Modal/Modal.vue";
import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      csrfToken: Laravel.csrfToken,
      warehouses: [],
      warehouse: {
        id: "",
        name: "",
        images: "",
        import_price: "",
        import_quantity: "",
        inventory: "",
        import_date: "",
      },

      errorBackEnd: {}, //Lỗi bên backend laravel
      page: 1,
      paginate: 5,
      search: "",
      statusImport: 1,
      flagShowLoader: false,
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

      sort_direction: "desc",
      sort_field: "created_at",
    };
  },
  created() {
    this.fetchData();
  },
  watch: {
    paginate: function (value) {
      this.fetchData();
    },
    search: function (value) {
      this.fetchData();
    },
    statusImport: function (value) {
      this.fetchData();
    },
  },
  props: ["formAdd", "formUrl"],
  mounted() {},
  components: {
    Modal,
    Loader,
  },
  methods: {
    change_sort(field) {
      if (this.sort_field == field) {
        this.sort_direction = this.sort_direction == "asc" ? "desc" : "asc";
      } else {
        this.sort_field = field;
      }
      this.fetchData(1);
    },
    fetchData() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .get(
          "get-warehouse?page=" +
            that.page +
            "&paginate=" +
            that.paginate +
            "&search=" +
            that.search +
            "&statusImport=" +
            that.statusImport +
            "&sort_direction=" +
            that.sort_direction +
            "&sort_field=" +
            that.sort_field
        )
        .then(function (response) {
          that.warehouses = response.data; //show data ra
          that.flagShowLoader = false;
        })
        .catch((err) => {
          switch (err.response.status) {
            case 500:
              that
                .$swal({
                  title: "Error loading data !",
                  icon: "warning",
                  confirmButtonText: "Ok",
                })
                .then(function (confirm) {});
              break;
            default:
              break;
          }
        });
    },

    prev() {
      if (this.warehouses.prev_page_url) {
        this.page--;
        this.fetchData();
      }
    },
    next() {
      if (this.warehouses.next_page_url) {
        this.page++;
        this.fetchData();
      }
    },

    changePage(page) {
      this.page = page;
      this.fetchData();
    },

    importCSV() {
      let that = this;
      let formData = new FormData();
      var file = document.querySelector("input[type=file]").files[0];
      formData.append("file", file);
      axios
        .post("import-product-csv", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          this.$swal({
            title: "Import successfully!",
            icon: "success",
            confirmButtonText: "OK!",
          });
          that.fetchData();
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

    updateWarehouse(warehouse) {
      this.warehouse.id = warehouse.id;
      this.warehouse.name = warehouse.name;
      if (warehouse.images != "") {
        this.$refs.imageDispaly.src =
          this.baseUrl + "/uploads/products/" + warehouse.images;
        this.$refs.imageDispaly.style.display = "block";
        this.$refs.iconClose.style.display = "block";
        this.$refs.iconFile.style.display = "none";
      }
      this.warehouse.import_price = warehouse.import_price;
    },

    addImage: function (e) {
      e.preventDefault();
      let that = this;
      let formData = new FormData(this.$refs.addForm);
      axios
        .post(`/admin/warehouse/excel-import-image`, formData, {
          header: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          this.$swal({
            title: "Update Successfully!",
            icon: "success",
            confirmButtonText: "OK",
          }).then(function (confirm) {
            window.location.href = "/admin/warehouse";
          });
        });
    },
  },
};
</script>
