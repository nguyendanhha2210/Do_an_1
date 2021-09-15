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
                    <td>Orderer</td>
                    <td>Receivern</td>
                    <td>Total Money</td>
                    <td>Order Date</td>
                    <td>Status</td>
                    <td></td>
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
                      <b style="color: blue">Đang xử lý !</b><br>
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
                      <b style="color: #00cc00">Đã Nhận Hàng !</b> <br />
                      <a
                        data-toggle="modal"
                        data-target="#myModalVote"
                        @click="voteProduct(order)"
                        ><button class="btn btn-warning">Evaluate</button></a
                      >
                    </td>
                    <td v-else-if="order.order_status == 4">
                      <b style="color: red">Đã hủy !</b> <br>
                      <button
                        class="btn btn-success button-mualai"
                        @click="muaLai(order.id)"
                      >
                        Mua Lại
                      </button>
                    </td>

                    <td>
                      <a :href="`order-detail/${order.order_code}/view`">
                        <i
                          class="fa fa-pencil-square-o text-success text-active"
                          style="font-size: 25px"
                        >
                        </i>
                      </a>
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
                  @submit.prevent="customerReviews()"
                  enctype="multipart/form-data"
                >
                  <div class="form-group">
                    <input
                    hidden
                      type="text"
                      class="form-control"
                      id="exampleInputEmail1"
                      name="id"
                      v-model="evaluate.id"
                    />
                    <div style="margin: auto; display: table">
                      <star-rating
                        :star-size="45"
                        :increment="0.5"
                        v-model="evaluate.star_vote"
                      ></star-rating>
                      <input
                      hidden
                        type="text"
                        name="star_vote"
                        v-model="evaluate.star_vote"
                      />
                    </div>
                    <br />
                    <textarea
                      type="text"
                      placeholder="Điều bạn muốn nói về sản phẩm ..."
                      style="height: 130px"
                      class="form-control"
                      name="contentVote"
                      v-validate="'required'"
                      v-model="evaluate.content"
                    ></textarea>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6 text-center">
                      <div class="position-relative d-inline-block">
                        <label for="file_img_banner1">
                          <div class="img-drop-box mt-2 mr-2">
                            <img
                              src
                              ref="imageDispaly_1"
                              class="img-thumbnail"
                            />
                            <svg
                              width="45"
                              height="45"
                              viewBox="0 0 45 45"
                              style="
                                margin-top: 52px;
                                margin-left: 38%;
                                margin-right: 38%;
                              "
                              ref="iconFile_1"
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
                            name="image_1"
                            ref="image_1"
                            v-on:change="attachImage_1"
                            accept="image_1/*"
                          />
                        </label>
                        <a
                          class="btn btn-light icon-close-white display-none"
                          style="background-color: black; border-radius: 91%"
                          ref="iconClose_1"
                          @click="deleteImage_1"
                        ></a>
                      </div>
                      <div style="color: red" role="alert">
                        {{ errors.first("image_1") }}
                      </div>
                    </div>

                    <div class="form-group col-md-6 text-center">
                      <div class="position-relative d-inline-block">
                        <label for="file_img_banner2">
                          <div class="img-drop-box mt-2 mr-2">
                            <img
                              src
                              ref="imageDispaly_2"
                              class="img-thumbnail"
                            />
                            <svg
                              width="45"
                              height="45"
                              viewBox="0 0 45 45"
                              style="
                                margin-top: 52px;
                                margin-left: 38%;
                                margin-right: 38%;
                              "
                              ref="iconFile_2"
                            >
                              <use
                                xlink:href="/images/Group_1287.svg#Group_1287"
                              ></use>
                            </svg>
                          </div>
                          <input
                            type="file"
                            id="file_img_banner2"
                            v-validate="'required'"
                            name="image_2"
                            ref="image_2"
                            v-on:change="attachImage_2"
                            accept="image_2/*"
                            style="display: none"
                          />
                        </label>
                        <a
                          class="btn btn-light icon-close-white display-none"
                          style="background-color: black; border-radius: 91%"
                          ref="iconClose_2"
                          @click="deleteImage_2"
                        ></a>
                      </div>
                      <div style="color: red" role="alert">
                        {{ errors.first("image_2") }}
                      </div>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-6 text-center">
                      <div class="position-relative d-inline-block">
                        <label for="file_img_banner3">
                          <div class="img-drop-box mt-2 mr-2">
                            <img
                              src
                              ref="imageDispaly_3"
                              class="img-thumbnail"
                            />
                            <svg
                              width="45"
                              height="45"
                              viewBox="0 0 45 45"
                              style="
                                margin-top: 52px;
                                margin-left: 38%;
                                margin-right: 38%;
                              "
                              ref="iconFile_3"
                            >
                              <use
                                xlink:href="/images/Group_1287.svg#Group_1287"
                              ></use>
                            </svg>
                          </div>
                          <input
                            type="file"
                            id="file_img_banner3"
                            v-validate="'required'"
                            name="image_3"
                            ref="image_3"
                            v-on:change="attachImage_3"
                            accept="image_3/*"
                            style="display: none"
                          />
                        </label>
                        <a
                          class="btn btn-light icon-close-white display-none"
                          style="background-color: black; border-radius: 91%"
                          ref="iconClose_3"
                          @click="deleteImage_3"
                        ></a>
                      </div>
                      <div style="color: red" role="alert">
                        {{ errors.first("image_3") }}
                      </div>
                    </div>

                    <div class="form-group col-md-6 text-center">
                      <div class="position-relative d-inline-block">
                        <label for="file_img_banner4">
                          <div class="img-drop-box mt-2 mr-2">
                            <img
                              src
                              ref="imageDispaly_4"
                              class="img-thumbnail"
                            />
                            <svg
                              width="45"
                              height="45"
                              viewBox="0 0 45 45"
                              style="
                                margin-top: 52px;
                                margin-left: 38%;
                                margin-right: 38%;
                              "
                              ref="iconFile_4"
                            >
                              <use
                                xlink:href="/images/Group_1287.svg#Group_1287"
                              ></use>
                            </svg>
                          </div>
                          <input
                            type="file"
                            id="file_img_banner4"
                            v-validate="'required'"
                            name="image_4"
                            ref="image_4"
                            v-on:change="attachImage_4"
                            accept="image_4/*"
                            style="display: none"
                          />
                        </label>
                        <a
                          class="btn btn-light icon-close-white display-none"
                          style="background-color: black; border-radius: 91%"
                          ref="iconClose_4"
                          @click="deleteImage_4"
                        ></a>
                      </div>
                      <div style="color: red" role="alert">
                        {{ errors.first("image_4") }}
                      </div>
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
import StarRating from "vue-star-rating";
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

      evaluate: {
        id: "",
        user_id: "",
        order_id: "",
        star_vote: 0,
        content: "",
        image_1: "",
        image_2: "",
        image_3: "",
        image_4: "",
      },
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
    StarRating,
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

    voteProduct(order) {
      this.evaluate.id = order.id;
    },

    attachImage_1() {
      this.evaluate.image_1 = this.$refs.image_1.files[0];
      let reader_1 = new FileReader();
      reader_1.addEventListener(
        "load",
        function () {
          this.$refs.imageDispaly_1.style.display = "block";
          this.$refs.iconClose_1.style.display = "block";
          this.$refs.imageDispaly_1.src = reader_1.result;
          this.$refs.iconFile_1.style.display = "none";
        }.bind(this),
        false
      );
      reader_1.readAsDataURL(this.evaluate.image_1);
    },
    deleteImage_1() {
      this.evaluate.image_1 = "";
      this.$refs.imageDispaly_1.style.display = "none";
      this.$refs.iconClose_1.style.display = "none";
      this.$refs.image_1.value = "";
      this.$refs.iconFile_1.style.display = "block";
    },

    attachImage_2() {
      this.evaluate.image_2 = this.$refs.image_2.files[0];
      console.log(this.$refs.image_2.files[0]);
      let reader_2 = new FileReader();
      reader_2.addEventListener(
        "load",
        function () {
          this.$refs.imageDispaly_2.style.display = "block";
          this.$refs.iconClose_2.style.display = "block";
          this.$refs.imageDispaly_2.src = reader_2.result;
          this.$refs.iconFile_2.style.display = "none";
        }.bind(this),
        false
      );
      reader_2.readAsDataURL(this.evaluate.image_2);
    },
    deleteImage_2() {
      this.evaluate.image_2 = "";
      this.$refs.imageDispaly_2.style.display = "none";
      this.$refs.iconClose_2.style.display = "none";
      this.$refs.image_2.value = "";
      this.$refs.iconFile_2.style.display = "block";
    },

    attachImage_3() {
      this.evaluate.image_3 = this.$refs.image_3.files[0];
      console.log(this.$refs.image_3.files[0]);
      let reader_3 = new FileReader();
      reader_3.addEventListener(
        "load",
        function () {
          this.$refs.imageDispaly_3.style.display = "block";
          this.$refs.iconClose_3.style.display = "block";
          this.$refs.imageDispaly_3.src = reader_3.result;
          this.$refs.iconFile_3.style.display = "none";
        }.bind(this),
        false
      );
      reader_3.readAsDataURL(this.evaluate.image_3);
    },
    deleteImage_3() {
      this.evaluate.image_3 = "";
      this.$refs.imageDispaly_3.style.display = "none";
      this.$refs.iconClose_3.style.display = "none";
      this.$refs.image_3.value = "";
      this.$refs.iconFile_3.style.display = "block";
    },

    attachImage_4() {
      this.evaluate.image_4 = this.$refs.image_4.files[0];
      console.log(this.$refs.image_4.files[0]);
      let reader_4 = new FileReader();
      reader_4.addEventListener(
        "load",
        function () {
          this.$refs.imageDispaly_4.style.display = "block";
          this.$refs.iconClose_4.style.display = "block";
          this.$refs.imageDispaly_4.src = reader_4.result;
          this.$refs.iconFile_4.style.display = "none";
        }.bind(this),
        false
      );
      reader_4.readAsDataURL(this.evaluate.image_4);
    },
    deleteImage_4() {
      this.evaluate.image_4 = "";
      this.$refs.imageDispaly_4.style.display = "none";
      this.$refs.iconClose_4.style.display = "none";
      this.$refs.image_4.value = "";
      this.$refs.iconFile_4.style.display = "block";
    },

    customerReviews() {
       let that = this;
          this.$swal({
            title: "Are you sure with the above review ？",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes !",
            cancelButtonText: "No, cancel!",
          }).then((result) => {
            if (result.value) {
               let formData = new FormData();
                formData.append("order_id", this.evaluate.id);
                formData.append("star_vote", this.evaluate.star_vote);
                formData.append("content", this.evaluate.content);
                formData.append("image_1", this.evaluate.image_1);
                formData.append("image_2", this.evaluate.image_2);
                formData.append("image_3", this.evaluate.image_3);
                formData.append("image_4", this.evaluate.image_4);

              axios
                .post(`customer-reviews`, formData, {
                  headers: {
                    "Content-Type": "multipart/form-data",
                  },
                })
                .then((response) => {
                  that
                    .$swal({
                      title: "Successful Evaluation!",
                      icon: "success",
                      confirmButtonText: "OK!",
                    })
                    .then(function (confirm) {});
                })
                .catch((error) => {
                  that.flashMessage.error({
                    message: "Failure Evaluation!",
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

