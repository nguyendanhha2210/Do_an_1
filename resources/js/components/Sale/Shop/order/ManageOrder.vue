<template>
  <div>
    <section class="shopping-cart spad">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="cart-table">
              <table class="table table-condensed">
                <thead>
                  <tr class="cart_menu">
                    <td>ID</td>
                    <td>Tên người đặt</td>
                    <td>Tên người nhận</td>
                    <td>Tổng tiền</td>
                    <td>Ngày đặt</td>
                    <td>Tình trạng</td>
                    <td>Hiển thị</td>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(order, index) in orders.data" :key="order.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ order.user.name }}</td>
                    <td>{{ order.shipping.name }}</td>
                    <td>{{ order.total_bill }} vnđ</td>
                    <td>{{ order.order_date }}</td>
                    <td v-if="order.order_status == 1">
                      <b style="color: blue">Đang xử lý !</b>
                      <button
                        data-toggle="modal"
                        data-target="#myModal"
                        data-whatever="@getbootstrap"
                        class="btn btn-danger"
                        @click="updateProduct(order.id)"
                      >
                        Hủy Đơn
                      </button>
                    </td>
                    <td v-else-if="order.order_status == 2">
                      <b style="color: blue">Shipper Đang Giao !</b>
                    </td>
                    <td v-else-if="order.order_status == 3">
                      <b style="color: #00cc00">Đã Nhận Hàng !</b>
                      <div class="td-action">
                        <a
                          data-toggle="modal"
                          data-target="#myModalVote"
                          style="
                            font-size: 21px;
                            transform: translate(-26%, -14%);
                          "
                          ><i
                            class="
                              fa fa-pencil-square-o
                              text-success text-active
                            "
                          ></i
                        ></a>
                      </div>
                    </td>
                    <td v-else-if="order.order_status == 4">
                      <b style="color: red">Đã hủy !</b>
                      <button
                        class="btn btn-success button-mualai"
                        @click="muaLai(order.id)"
                      >
                        Mua Lại
                      </button>
                    </td>

                    <td>
                      <a :href="`order-detail/${order.order_code}/view`"
                        ><button class="btn btn-info button-mualai">
                          Order Detail
                        </button></a
                      >
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
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
                  Why do you want to cancel the order?
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
                  role="form"
                  @submit.prevent="cancelOrder()"
                  enctype="multipart/form-data"
                >
                  <div class="form-group">
                    <input
                      type="text"
                      hidden
                      class="form-control"
                      id="exampleInputEmail1"
                      name="id"
                      v-model="order.id"
                    />
                    <label for="exampleInputEmail1">Content</label>
                    <textarea
                      type="text"
                      class="form-control"
                      name="order_destroy"
                      v-validate="'required'"
                      id="message-text"
                      v-model="order.order_destroy"
                    ></textarea>
                    <div style="color: red" role="alert">
                      {{ errors.first("order_destroy") }}
                    </div>
                  </div>

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
         <div
          class="modal fade"
          id="myModalVote"
          tabindex="-1"
          role="dialog"
          aria-labelledby="exampleModalLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                  What are your thoughts on the product?
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
                  role="form"
                  @submit.prevent="cancelOrder()"
                  enctype="multipart/form-data"
                >
                  <div class="form-group">
                    <input
                      type="text"
                      hidden
                      class="form-control"
                      id="exampleInputEmail1"
                      name="id"
                      v-model="order.id"
                    />
                    <label for="exampleInputEmail1">Content</label>
                    <textarea
                      type="text"
                      class="form-control"
                      name="order_destroy"
                      v-validate="'required'"
                      id="message-text"
                      v-model="order.order_destroy"
                    ></textarea>
                    <div style="color: red" role="alert">
                      {{ errors.first("order_destroy") }}
                    </div>
                  </div>

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div v-if="orders != ''">
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
        </div>
        <div v-else class="text-center" style="color: red">
          There is no data !
        </div>
      </div>
    </section>
    <Loader :flag-show="flagShowLoader"></Loader>
  </div>
</template>

<style lang="scss" scoped>
.button-mualai {
  float: initial;
  margin-top: 3px;
  transform: translateY(-4px);
}
</style>

<script>
import Loader from "../../../Common/loader.vue";
import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      orders: [],
      order: {
        id: "",
        customer_id: "",
        shipping_id: "",
        order_code: "",
        order_status: "",
        order_date: "",
        order_destroy: "",
      },

      errorBackEnd: {}, //Lỗi bên backend laravel
      page: 1,
      paginate: 5,
      flagShowLoader: false,
    };
  },
  created() {
    let messError = {
      custom: {
        order_destroy: {
          required: "* Nội dung hủy hàng chưa được nhập !",
        },
      },
    };
    this.$validator.localize("en", messError);
    this.fetchData();
  },
  mounted() {},
  components: {
    Loader,
  },
  methods: {
    fetchData() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .get(`get-order`)
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
                .then(function (confirm) {});
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

    updateProduct(id) {
      this.order.id = id;
    },

    cancelOrder() {
      let that = this;
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          this.$swal({
            title: "Do you want to cancel order ？",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes !",
            cancelButtonText: "No, cancel!",
          }).then((result) => {
            if (result.value) {
              let formData = new FormData();
              formData.append("id", this.order.id);
              formData.append("order_destroy", this.order.order_destroy);

              axios
                .post(`cancel-order`, formData, {
                  headers: {
                    "Content-Type": "multipart/form-data",
                  },
                })
                .then((response) => {
                  that
                    .$swal({
                      title: "Cancel successfully!",
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
        }
      });
    },

    // nhanHang(id) {
    //   let that = this;
    //   axios
    //     .get(`order/${id}/receivedOrder`)
    //     .then((response) => {
    //       that
    //         .$swal({
    //           title: "Thank you for your purchase !",
    //           icon: "success",
    //           confirmButtonText: "OK!",
    //         })
    //         .then(function (confirm) {});
    //       that.fetchData();
    //     })
    //     .catch((error) => {
    //       that.flashMessage.error({
    //         message: "Failure!",
    //         icon: "/backend/icon/error.svg",
    //         blockClass: "text-centet",
    //       });
    //     });
    // },

    muaLai(id) {
      let that = this;
      this.$swal({
        title: "Would you like to repurchase the order ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes !",
        cancelButtonText: "No, cancel!",
      }).then((result) => {
        if (result.value) {
          axios
            .get(`order/${id}/repurchase`)
            .then((response) => {
              that
                .$swal({
                  title: "Repurchase successfully!",
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

