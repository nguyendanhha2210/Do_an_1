<template>
  <div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading"></div>
      <div class="row w3-res-tb">
        <div for="paginate" class="col-md-3 col-sm-2 col-3">
          <select v-model="paginate" class="form-control w-sm inline v-middle">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
          </select>
        </div>
        <div class="col-md-4 col-sm-5 col-4">
          <select
            v-model="statusOrder"
            class="form-control w-sm inline v-middle"
          >
            <option value="0">Status Order</option>
            <option value="1">Ordered</option>
            <option value="2">Shipping</option>
            <option value="3">Success</option>
            <option value="4">Failure</option>
          </select>
        </div>

        <div class="col-md-1 col-sm-2 col-1">
          <b class="text-date">Date:</b>
        </div>

        <div class="col-md-4 col-sm-3 col-4 input-search">
          <input
            type="text"
            class="form-control"
            v-model="search"
            placeholder="Search"
          />
        </div>
      </div>

      <div class="table-responsive">
        <table
          class="table table-striped b-t b-light text-center"
          style="margin-top: 15px"
        >
          <thead>
            <tr>
              <th>STT</th>
              <th>Đơn Hàng</th>
              <th>Người Nhận</th>
              <th>SĐT</th>
              <th>Địa Chỉ</th>
              <th>Ngày Đặt</th>
              <th>Trạng Thái</th>
              <th style="width: 20%">Action</th>
            </tr>
          </thead>
          <transition-group type="slide-fade" tag="tbody">
            <tr v-for="(data, index) in orders.data" :key="data.id">
              <th scope="row">{{ index + 1 }}</th>
              <td>
                {{ data.order_code }}
              </td>
              <td>
                {{ data.shipping.name }}
              </td>
              <td>
                {{ data.shipping.phone }}
              </td>
              <td>
                {{ data.shipping.address }}
              </td>
              <td>
                {{ data.order_date }}
              </td>
              <td v-if="data.order_status == 2">
                <b style="color: #ffcc00">Cần Giao</b> <br />
                <button
                  class="btn btn-success button-mualai"
                  @click="daGiao(data.id)"
                >
                  Giao Xong
                </button>
              </td>
              <td v-else-if="data.order_status == 3">
                <b style="color: #00cc00">SUCCESS</b>
              </td>
              <td v-else-if="data.order_status == 5">
                <b style="color: blue">Đã Chuyển</b>
              </td>
              <td>
                <div class="td-action">
                  <a :href="`order/${data.order_code}/detail`">
                    <button class="btn btn-warning mr-1" type="button">
                      Order Detail
                    </button></a
                  >
                </div>
              </td>
            </tr>
          </transition-group>
        </table>
      </div>
    </div>
    <nav aria-label="Page navigation example">
      <paginate
        v-model="page"
        :page-count="parseInt(orders.last_page)"
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
      orders: [],
      order: {
        customer_id: "",
        shipping_id: "",
        order_code: "",
        order_status: "",
        order_datepe: "",
      },
      errorBackEnd: {}, //Lỗi bên backend laravel
      page: 1,
      paginate: 5,
      statusOrder: 0,
      search: "",
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
    statusOrder: function (value) {
      this.fetchData();
    },
  },
  props: ["addForm"],
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
          "get-order?page=" +
            that.page +
            "&paginate=" +
            that.paginate +
            "&search=" +
            that.search +
            "&statusOrder=" +
            that.statusOrder
        )
        .then(function (response) {
          that.orders = response.data; //show data ra
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
                .then(function (confirm) {
                  that.flagShowLoader = false;
                });
              break;
            default:
              break;
          }
        });
    },

    prev() {
      if (this.orders.prev_page_url) {
        this.page--;
        this.fetchData();
      }
    },
    next() {
      if (this.orders.next_page_url) {
        this.page++;
        this.fetchData();
      }
    },

    changePage(page) {
      this.page = page;
      this.fetchData();
    },

    daGiao(id) {
      let that = this;
      this.$swal({
        title: "Bạn đã gửi hàng thành công ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes !",
        cancelButtonText: "No !",
      }).then((result) => {
        if (result.value) {
          axios
            .get(`order/${id}/delivered`)
            .then((response) => {
              that
                .$swal({
                  title: "Successful Delivery!",
                  icon: "success",
                  confirmButtonText: "OK!",
                })
                .then(function (confirm) {});
              that.fetchData();
            })
            .catch((error) => {
              that.flashMessage.error({
                message: "Cancel Failure!",
                icon: "/backend/icon/error.svg",
                blockClass: "text-centet",
              });
            });
        }
      });
    },
  },
};
</script>
