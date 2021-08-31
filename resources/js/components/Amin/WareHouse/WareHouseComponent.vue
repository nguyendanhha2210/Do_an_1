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

      <div class="table-responsive">
        <table class="table table-striped b-t b-light text-center">
          <thead>
            <tr>
              <th>STT</th>
              <th>Name</th>
              <th>Images</th>
              <th>Import Price</th>
              <th>Import Quantity</th>
              <th>Inventory</th>
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
                  :src="baseUrl + '/uploads/' + warehouse.images"
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
                  <a :href="`warehouse/${warehouse.id}/edit`">
                    <button class="btn btn-warning mr-1" type="button">
                      Import Add
                    </button></a
                  >
                </div>
              </td>
              <td v-else></td>
            </tr>
          </transition-group>
        </table>
      </div>
    </div>
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
  props: ["formAdd"],
  mounted() {},
  components: {
    Modal,
    Loader,
  },
  methods: {
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
            that.statusImport
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
  },
};
</script>
