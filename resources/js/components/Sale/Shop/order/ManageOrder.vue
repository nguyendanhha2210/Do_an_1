<template>
  <div>
    <div class="pt-4 pb-4" style="background-color: #e9edf0">
      <div class="container">
        <div
          v-for="order in orders.data"
          :key="order.id"
          style="margin-bottom: 23px"
        >
          <StepperComponet
            v-if="orderId == order.id && order.order_status < 5"
            :data="order.order_status"
            :id="order.id"
          ></StepperComponet>
        </div>
        <div class="row" style="background-color: white">
          <div
            class="col-lg-2"
            style="border: dotted 1px #c0c0c0"
            @click="showCorfirm()"
          >
            <div
              class="single-benefit hover-status"
              v-bind:class="{
                'bt btn-success': isBackGroundConfirming,
                'text-white': isBackGroundConfirming,
              }"
            >
              <div class="sb-icon text-center">
                <img
                  class="pt-2"
                  src="/frontend/images/confirm.jpg"
                  style="height: 66px; width: 81px"
                  alt=""
                />
              </div>
              <br />
              <div class="sb-text text-center pb-2">
                <h6>
                  Confirming
                  <span
                    v-if="this.countOrder != 0"
                    style="
                      background-color: crimson;
                      color: white;
                      padding: 3px;
                      font-size: 13px;
                      border-radius: 25px;
                    "
                    >{{ this.countOrder }}</span
                  >
                </h6>
              </div>
            </div>
          </div>
          <div
            class="col-lg-2"
            style="border: dotted 1px #c0c0c0"
            @click="showDeliver()"
          >
            <div
              class="single-benefit hover-status"
              v-bind:class="{
                'bt btn-success': isBackGroundDelivering,
                'text-white': isBackGroundDelivering,
              }"
            >
              <div class="sb-icon text-center">
                <img
                  class="pt-2"
                  src="/frontend/images/deliver.jpg"
                  style="height: 66px; width: 81px"
                  alt=""
                />
              </div>
              <br />
              <div class="sb-text text-center pb-2">
                <h6>
                  Delivering
                  <span
                    v-if="this.countshipping != 0"
                    style="
                      background-color: gold;
                      color: white;
                      padding: 3px;
                      font-size: 13px;
                      border-radius: 25px;
                    "
                    >{{ this.countshipping }}</span
                  >
                </h6>
              </div>
            </div>
          </div>
          <div
            class="col-lg-2"
            style="border: dotted 1px #c0c0c0"
            @click="showRecive()"
          >
            <div
              class="single-benefit hover-status"
              v-bind:class="{
                'bt btn-success': isBackGroundReceived,
                'text-white': isBackGroundReceived,
              }"
            >
              <div class="sb-icon text-center">
                <img
                  class="pt-2"
                  src="/frontend/images/status-payment-3.jpg"
                  style="height: 66px; width: 81px"
                  alt=""
                />
              </div>
              <br />
              <div class="sb-text text-center pb-2">
                <h6>
                  Received
                  <span
                    v-if="this.countSuccess != 0"
                    style="
                      background-color: blue;
                      color: white;
                      padding: 3px;
                      font-size: 13px;
                      border-radius: 25px;
                    "
                    >{{ this.countSuccess }}</span
                  >
                </h6>
              </div>
            </div>
          </div>
          <div
            class="col-lg-2"
            style="border: dotted 1px #c0c0c0"
            @click="showEvaluat()"
          >
            <div
              class="single-benefit hover-status"
              v-bind:class="{
                'bt btn-success': isBackGroundEvaluated,
                'text-white': isBackGroundEvaluated,
              }"
            >
              <div class="sb-icon text-center">
                <img
                  class="pt-2"
                  src="/frontend/images/status-payment-1.jpg"
                  style="height: 66px; width: 81px"
                  alt=""
                />
              </div>
              <br />
              <div class="sb-text text-center pb-2">
                <h6>
                  Evaluated
                  <span
                    v-if="this.countEvaluate != 0"
                    style="
                      background-color: yellowgreen;
                      color: white;
                      padding: 3px;
                      font-size: 13px;
                      border-radius: 25px;
                    "
                    >{{ this.countEvaluate }}</span
                  >
                </h6>
              </div>
            </div>
          </div>
          <div
            class="col-lg-2"
            style="border: dotted 1px #c0c0c0"
            @click="showCancel()"
          >
            <div
              class="single-benefit hover-status"
              v-bind:class="{
                'bt btn-success': isBackGroundCancelled,
                'text-white': isBackGroundCancelled,
              }"
            >
              <div class="sb-icon text-center">
                <img
                  class="pt-2"
                  src="/frontend/images/status-payment-2.jpg"
                  style="height: 66px; width: 81px"
                  alt=""
                />
              </div>
              <br />
              <div class="sb-text text-center pb-2">
                <h6>
                  Cancelled
                  <span
                    v-if="this.countFailure != 0"
                    style="
                      background-color: red;
                      color: white;
                      padding: 3px;
                      font-size: 13px;
                      border-radius: 25px;
                    "
                    >{{ this.countFailure }}</span
                  >
                </h6>
              </div>
            </div>
          </div>
          <div
            class="col-lg-2"
            style="border: dotted 1px #c0c0c0"
            @click="showReturn()"
          >
            <div
              class="single-benefit hover-status"
              v-bind:class="{
                'bt btn-success': isBackGroundReturns,
                'text-white': isBackGroundReturns,
              }"
            >
              <div class="sb-icon text-center">
                <img
                  class="pt-2"
                  src="/frontend/images/status-payment-4.jpg"
                  style="height: 66px; width: 81px"
                  alt=""
                />
              </div>
              <br />
              <div class="sb-text text-center pb-2">
                <h6>
                  Returns
                  <span
                    v-if="this.countReturn != 0"
                    style="
                      background-color: crimson;
                      color: white;
                      padding: 3px;
                      font-size: 13px;
                      border-radius: 25px;
                    "
                    >{{ this.countReturn }}</span
                  >
                </h6>
              </div>
            </div>
          </div>
        </div>
        <!-- Show màn hình từng sp chưa được vote -->
        <div
          v-if="this.view_vote && this.show_receive && this.voteDetails != ''"
          class="row mt-3 pt-1"
          style="background-color: white"
        >
          <div class="col-lg-12">
            <div class="cart-table text-center">
              <b style="color: green; font-size: 26px">Evaluated</b>
              <table class="table table-condensed">
                <thead>
                  <tr class="cart_menu">
                    <td><b>STT</b></td>
                    <td><b>Sản Phẩm</b></td>
                    <td><b>Ảnh</b></td>
                    <td><b>Đơn Giá</b></td>
                    <td><b>Số lượng</b></td>
                    <td><b>Status</b></td>
                    <td></td>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(voteDetail, index) in voteDetails"
                    :key="voteDetail.id"
                  >
                    <td>{{ index + 1 }}</td>
                    <td>{{ voteDetail.product_name }}</td>
                    <td>
                      <img
                        style="height: 50px; width: 50px"
                        v-lazy="
                          baseUrl +
                          '/uploads/products/' +
                          voteDetail.product.images
                        "
                        alt=""
                      />
                    </td>
                    <td>{{ formatPrice(voteDetail.product_price) }} đ</td>
                    <td>{{ voteDetail.product_sales_quantity }}</td>
                    <td v-if="voteDetail.status_vote == 1">
                      <a
                        data-toggle="modal"
                        data-target="#myModalVote"
                        @click="voteProduct(voteDetail)"
                        ><button class="btn btn-warning">Evaluate</button></a
                      >
                    </td>
                    <td v-else>
                      <button class="btn btn-success">Have evaluated</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- Show màn hình từng sp đã được vote -->
        <div
          v-if="
            this.detail_voted &&
            this.show_evaluat &&
            this.votedProductDetail != ''
          "
          class="row mt-2 pt-1 pb-1"
          style="background-color: white"
        >
          <div class="col-lg-12">
            <div class="cart-table text-center">
              <b style="color: green; font-size: 26px">Your Review !</b>
              <table class="table table-condensed">
                <thead>
                  <tr class="cart_menu">
                    <td><b>STT</b></td>
                    <td><b>Sản Phẩm</b></td>
                    <td><b>Ảnh</b></td>
                    <td><b>Đơn Giá</b></td>
                    <td><b>Số lượng</b></td>
                    <td><b>Status</b></td>
                    <td></td>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(votedProductDetail, index) in votedProductDetails"
                    :key="votedProductDetail.id"
                  >
                    <td>{{ index + 1 }}</td>
                    <td>{{ votedProductDetail.product_name }}</td>
                    <td>
                      <img
                        style="height: 50px; width: 50px"
                        :src="
                          baseUrl +
                          '/uploads/comments/' +
                          votedProductDetail.product.images
                        "
                        alt=""
                      />
                    </td>
                    <td>
                      {{ formatPrice(votedProductDetail.product_price) }} đ
                    </td>
                    <td>{{ votedProductDetail.product_sales_quantity }}</td>
                    <td>
                      <a
                        data-toggle="modal"
                        data-target="#myModalViewVote"
                        @click="yourReview(votedProductDetail)"
                        ><button class="btn btn-warning">
                          Your review !
                        </button></a
                      >
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <br />
        <div
          v-if="
            this.show_corfirm ||
            this.show_deliver ||
            this.show_receive ||
            this.show_evaluat ||
            this.show_cancel ||
            this.show_return
          "
        >
          <div class="row pt-5 pb-1" style="background-color: white">
            <div class="col-lg-12">
              <div class="cart-table">
                <table class="table table-condensed">
                  <thead>
                    <tr class="cart_menu">
                      <td><b>ID</b></td>
                      <td><b>Orderer</b></td>
                      <td><b>Receiver</b></td>
                      <td><b>Total Money</b></td>
                      <td><b>Order Date</b></td>
                      <td><b>Status</b></td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(order, index) in orders.data"
                      :key="order.id"
                      @click="showProcess(order.id)"
                    >
                      <td>{{ index + 1 }}</td>
                      <td>
                        {{ order.user.name }}
                      </td>
                      <td>{{ order.shipping.name }}</td>
                      <td>{{ formatPrice(order.total_bill) }} đ</td>
                      <td>{{ order.order_date }}</td>
                      <td v-if="order.order_status == 1">
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
                        <b style="color: blue">Đang Giao !</b>
                      </td>
                      <td v-else-if="order.order_status == 3">
                        <a @click="detailProduct(order.order_code)"
                          ><button class="btn btn-warning">
                            View Evaluate
                          </button></a
                        >
                      </td>

                      <td v-else-if="order.order_status == 5">
                        <button
                          class="btn btn-success button-mualai"
                          @click="muaLai(order.id)"
                        >
                          Mua Lại
                        </button>
                      </td>
                      <td v-else-if="order.order_status == 4">
                        <a @click="detaulVotedProduct(order.order_code)"
                          ><button class="btn btn-warning">
                            Xem Đánh Giá
                          </button></a
                        >
                      </td>
                      <td v-else-if="order.order_status == 6">
                        <b style="color: red">Trả Lại !</b> <br />
                      </td>

                      <td>
                        <a :href="`order-detail/${order.order_code}/view`">
                          <i
                            class="
                              fa fa-pencil-square-o
                              text-success text-active
                            "
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
          <div v-if="orders != ''" class="pt-4">
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
                      id="message-text"
                      v-model="order.order_destroy"
                    ></textarea>
                    <div
                      style="color: red"
                      v-if="errorBackEnd_HuyDon.order_destroy"
                    >
                      {{ errorBackEnd_HuyDon.order_destroy[0] }}
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
                      name="order_code "
                      v-model="evaluate.order_code"
                    />

                    <input
                      hidden
                      type="text"
                      class="form-control"
                      id="exampleInputEmail1"
                      name="product_id"
                      v-model="evaluate.product_id"
                    />

                    <div style="margin: auto; display: table">
                      <star-rating
                        :star-size="45"
                        :increment="1"
                        v-model="evaluate.star_vote"
                      ></star-rating>
                      <input
                        hidden
                        type="number"
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
                      name="content"
                      v-model="evaluate.content"
                    ></textarea>
                    <div style="color: red" v-if="errorBackEnd.content">
                      {{ errorBackEnd.content[0] }}
                    </div>
                  </div>

                  <input
                    type="file"
                    ref="file"
                    class="form-control"
                    accept="image/*"
                    multiple="multiple"
                  />

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
          id="myModalViewVote"
          tabindex="-1"
          role="dialog"
          aria-labelledby="exampleModalLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                  Your review !
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
                <div class="form-group">
                  <div style="margin: auto; display: table">
                    <star-rating
                      :star-size="45"
                      :increment="0.5"
                      v-model="viewVote.star_vote"
                    ></star-rating>
                  </div>
                  <br />
                  <textarea
                    readonly
                    type="text"
                    placeholder="Điều bạn muốn nói về sản phẩm ..."
                    style="height: 130px"
                    class="form-control"
                    name="content"
                    v-model="viewVote.content"
                  ></textarea>
                </div>
                <div class="row" style="display: grid">
                  <div class="border-bottom w-100">
                    <div
                      class="form-group row row-container mb-0 pd-tb-20"
                      style="margin-left: 1px"
                    >
                      <div class="col-md-12">
                        <div
                          class="image-thumbnail mt-8-sp text-center"
                          v-if="viewVote.evaluate_images == 0"
                        >
                          <img
                            src="/backend/images/no-image-found-360x250.png"
                            class="w-10 h-10"
                            alt=""
                          />
                        </div>
                        <div
                          class="image-thumbnail mt-8-sp mr-2 float-left"
                          v-else
                          v-for="data in viewVote.evaluate_images"
                          :key="data.id"
                        >
                          <img
                            style="width: 150px; height: 170px; margin-top: 9px"
                            :src="baseUrl + '/uploads/comments/' + data.url"
                            alt=""
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <Loader :flag-show="flagShowLoader"></Loader>
      <FlashMessage :position="'left bottom'"></FlashMessage>
    </div>
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
import StepperComponet from "../../../Common/Stepper/StepperComponet.vue";
import StarRating from "vue-star-rating";
import Loader from "../../../Common/loader.vue";
import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000

      show_corfirm: false,
      show_deliver: false,
      show_receive: false,
      show_evaluat: false,
      show_cancel: false,
      show_return: false,

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
      errorBackEnd_HuyDon: {},
      page: 1,
      paginate: 5,
      flagShowLoader: false,

      evaluate: {
        id: "",
        user_id: "",
        order_id: "",
        star_vote: 1,
        content: "",
        order_code: "",
        product_id: "",
      },

      detail_voted: false,
      votedProductDetails: [],
      votedProductDetail: {
        product_id: "",
        product_name: "",
        product_price: "",
        product_sales_quantity: 1,
        created_at: "",
      },
      viewVote: {
        id: "",
        user_id: "",
        star_vote: 1,
        content: "",
      },

      view_vote: false,
      voteDetails: [],
      voteDetail: {
        product_id: "",
        product_name: "",
        product_price: "",
        product_sales_quantity: 1,
        created_at: "",
      },

      isBackGroundConfirming: false,
      isBackGroundDelivering: false,
      isBackGroundReceived: false,
      isBackGroundEvaluated: false,
      isBackGroundCancelled: false,
      isBackGroundReturns: false,

      countOrder: "",
      countshipping: "",
      countSuccess: "",
      countFailure: "",
      countEvaluate: "",
      countReturn: "",

      orderId: "",
      processOrder: false,
    };
  },
  created() {
    let messError = {
      custom: {},
    };
    this.$validator.localize("en", messError);
    this.fetchData();
    this.fetchCountStatus();
  },
  mounted() {
    this.fetchCountStatus();
  },
  components: {
    Loader,
    StarRating,
    StepperComponet,
  },
  methods: {
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    showCorfirm() {
      this.isBackGroundConfirming = !this.isBackGroundConfirming;
      (this.isBackGroundDelivering = false),
        (this.isBackGroundReceived = false),
        (this.isBackGroundEvaluated = false),
        (this.isBackGroundCancelled = false),
        (this.isBackGroundReturns = false),
        (this.show_corfirm = !this.show_corfirm);
      this.show_deliver = false;
      this.show_receive = false;
      this.show_evaluat = false;
      this.show_cancel = false;
      this.show_return = false;
      this.view_vote = false;
      this.detail_voted = false;
      this.fetchData();
    },
    showDeliver() {
      this.isBackGroundDelivering = !this.isBackGroundDelivering;
      (this.isBackGroundConfirming = false),
        (this.isBackGroundReceived = false),
        (this.isBackGroundEvaluated = false),
        (this.isBackGroundCancelled = false),
        (this.isBackGroundReturns = false),
        (this.show_deliver = !this.show_deliver);
      this.show_corfirm = false;
      this.show_receive = false;
      this.show_evaluat = false;
      this.show_cancel = false;
      this.show_return = false;
      this.view_vote = false;
      this.detail_voted = false;
      this.fetchData();
    },
    showRecive() {
      this.isBackGroundReceived = !this.isBackGroundReceived;
      (this.isBackGroundConfirming = false),
        (this.isBackGroundDelivering = false),
        (this.isBackGroundEvaluated = false),
        (this.isBackGroundCancelled = false),
        (this.isBackGroundReturns = false),
        (this.show_receive = !this.show_receive);
      this.show_deliver = false;
      this.show_corfirm = false;
      this.show_evaluat = false;
      this.show_cancel = false;
      this.show_return = false;
      this.detail_voted = false;
      this.fetchData();
    },
    showEvaluat() {
      this.isBackGroundEvaluated = !this.isBackGroundEvaluated;
      (this.isBackGroundConfirming = false),
        (this.isBackGroundDelivering = false),
        (this.isBackGroundReceived = false),
        (this.isBackGroundCancelled = false),
        (this.isBackGroundReturns = false),
        (this.show_evaluat = !this.show_evaluat);
      this.show_deliver = false;
      this.show_receive = false;
      this.show_corfirm = false;
      this.show_cancel = false;
      this.show_return = false;
      this.view_vote = false;
      this.detail_voted = false;
      this.fetchData();
    },
    showCancel() {
      this.isBackGroundCancelled = !this.isBackGroundCancelled;
      (this.isBackGroundConfirming = false),
        (this.isBackGroundDelivering = false),
        (this.isBackGroundReceived = false),
        (this.isBackGroundEvaluated = false),
        (this.isBackGroundReturns = false),
        (this.show_cancel = !this.show_cancel);
      this.show_deliver = false;
      this.show_receive = false;
      this.show_evaluat = false;
      this.show_corfirm = false;
      this.show_return = false;
      this.view_vote = false;
      this.detail_voted = false;
      this.fetchData();
    },
    showReturn() {
      this.isBackGroundReturns = !this.isBackGroundReturns;
      (this.isBackGroundConfirming = false),
        (this.isBackGroundDelivering = false),
        (this.isBackGroundReceived = false),
        (this.isBackGroundEvaluated = false),
        (this.isBackGroundCancelled = false),
        (this.show_return = !this.show_return);
      this.show_deliver = false;
      this.show_receive = false;
      this.show_evaluat = false;
      this.show_cancel = false;
      this.show_corfirm = false;
      this.view_vote = false;
      this.detail_voted = false;
      this.fetchData();
    },

    fetchData() {
      let that = this;
      if (that.show_corfirm == true) {
        this.flagShowLoader = true;
        axios
          .post(`get-order-confirm`)
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
      } else if (that.show_deliver == true) {
        this.flagShowLoader = true;
        axios
          .post(`get-order-deliver`)
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
      } else if (that.show_receive == true) {
        this.flagShowLoader = true;
        axios
          .post(`get-order-receive`)
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
      } else if (that.show_evaluat == true) {
        this.flagShowLoader = true;
        axios
          .post(`get-order-evaluat`)
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
      } else if (that.show_cancel == true) {
        this.flagShowLoader = true;
        axios
          .post(`get-order-cancel`)
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
      } else if (that.show_return == true) {
        this.flagShowLoader = true;
        axios
          .post(`get-order-return`)
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
      }
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
    changeInput() {
      this.errorBackEnd = []; //Khi thay đổi trong input thì biến đổi về rỗng
    },

    updateProduct(id) {
      this.order.id = id;
    },

    cancelOrder() {
      let that = this;
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
              window.location.href = "/sale/manage-order";
              that.fetchData();
              that.fetchCountStatus();
            })
            .catch((err) => {
              switch (err.response.status) {
                case 400: //lỗi validate trong function
                  that
                    .$swal({
                      title: err.response.data.order_destroy,
                      icon: "warning",
                      confirmButtonText: "Cancle !",
                    })
                    .then(function (confirm) {});
                  break;
                case 404:
                  that
                    .$swal({
                      title: "Evaluation Error !",
                      icon: "warning",
                      confirmButtonText: "Cancle !",
                    })
                    .then(function (confirm) {});
                  break;
                case 500:
                  that
                    .$swal({
                      title: "Evaluation Error !",
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
              that.fetchCountStatus();
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
      this.evaluate.order_code = order.order_code;
      this.evaluate.product_id = order.product_id;
    },

    // attachImage_1() {
    //   this.evaluate.image_1 = this.$refs.image_1.files[0];
    //   let reader_1 = new FileReader();
    //   reader_1.addEventListener(
    //     "load",
    //     function () {
    //       this.$refs.imageDispaly_1.style.display = "block";
    //       this.$refs.iconClose_1.style.display = "block";
    //       this.$refs.imageDispaly_1.src = reader_1.result;
    //       this.$refs.iconFile_1.style.display = "none";
    //     }.bind(this),
    //     false
    //   );
    //   reader_1.readAsDataURL(this.evaluate.image_1);
    // },
    // deleteImage_1() {
    //   this.evaluate.image_1 = "";
    //   this.$refs.imageDispaly_1.style.display = "none";
    //   this.$refs.iconClose_1.style.display = "none";
    //   this.$refs.image_1.value = "";
    //   this.$refs.iconFile_1.style.display = "block";
    // },

    // attachImage_2() {
    //   this.evaluate.image_2 = this.$refs.image_2.files[0];
    //   console.log(this.$refs.image_2.files[0]);
    //   let reader_2 = new FileReader();
    //   reader_2.addEventListener(
    //     "load",
    //     function () {
    //       this.$refs.imageDispaly_2.style.display = "block";
    //       this.$refs.iconClose_2.style.display = "block";
    //       this.$refs.imageDispaly_2.src = reader_2.result;
    //       this.$refs.iconFile_2.style.display = "none";
    //     }.bind(this),
    //     false
    //   );
    //   reader_2.readAsDataURL(this.evaluate.image_2);
    // },
    // deleteImage_2() {
    //   this.evaluate.image_2 = "";
    //   this.$refs.imageDispaly_2.style.display = "none";
    //   this.$refs.iconClose_2.style.display = "none";
    //   this.$refs.image_2.value = "";
    //   this.$refs.iconFile_2.style.display = "block";
    // },

    // attachImage_3() {
    //   this.evaluate.image_3 = this.$refs.image_3.files[0];
    //   console.log(this.$refs.image_3.files[0]);
    //   let reader_3 = new FileReader();
    //   reader_3.addEventListener(
    //     "load",
    //     function () {
    //       this.$refs.imageDispaly_3.style.display = "block";
    //       this.$refs.iconClose_3.style.display = "block";
    //       this.$refs.imageDispaly_3.src = reader_3.result;
    //       this.$refs.iconFile_3.style.display = "none";
    //     }.bind(this),
    //     false
    //   );
    //   reader_3.readAsDataURL(this.evaluate.image_3);
    // },
    // deleteImage_3() {
    //   this.evaluate.image_3 = "";
    //   this.$refs.imageDispaly_3.style.display = "none";
    //   this.$refs.iconClose_3.style.display = "none";
    //   this.$refs.image_3.value = "";
    //   this.$refs.iconFile_3.style.display = "block";
    // },

    // attachImage_4() {
    //   this.evaluate.image_4 = this.$refs.image_4.files[0];
    //   console.log(this.$refs.image_4.files[0]);
    //   let reader_4 = new FileReader();
    //   reader_4.addEventListener(
    //     "load",
    //     function () {
    //       this.$refs.imageDispaly_4.style.display = "block";
    //       this.$refs.iconClose_4.style.display = "block";
    //       this.$refs.imageDispaly_4.src = reader_4.result;
    //       this.$refs.iconFile_4.style.display = "none";
    //     }.bind(this),
    //     false
    //   );
    //   reader_4.readAsDataURL(this.evaluate.image_4);
    // },
    // deleteImage_4() {
    //   this.evaluate.image_4 = "";
    //   this.$refs.imageDispaly_4.style.display = "none";
    //   this.$refs.iconClose_4.style.display = "none";
    //   this.$refs.image_4.value = "";
    //   this.$refs.iconFile_4.style.display = "block";
    // },

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
          formData.append("order_code", this.evaluate.order_code);
          formData.append("product_id", this.evaluate.product_id);
          formData.append("star_vote", this.evaluate.star_vote);
          formData.append("content", this.evaluate.content);
          formData.append("productId", this.productIdP);

          if (this.$refs.file.files.length < 8) {
            for (var i = 0; i < this.$refs.file.files.length; i++) {
              let file = this.$refs.file.files[i];
              formData.append("files[" + i + "]", file);
            }
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
                  .then(function (confirm) {
                    window.location.href = "/sale/manage-order";
                    that.fetchCountStatus();
                  });
                that.viewDetailProduct();
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
                        title: "Evaluation Error !",
                        icon: "warning",
                        confirmButtonText: "Cancle !",
                      })
                      .then(function (confirm) {});
                    break;
                  case 500:
                    that
                      .$swal({
                        title: "Evaluation Error !",
                        icon: "warning",
                        confirmButtonText: "Cancle !",
                      })
                      .then(function (confirm) {});
                    break;
                  default:
                    break;
                }
              });
          } else {
            this.$swal({
              title: "Số Ảnh Tối đa được chọn là 8 ",
              icon: "warning",
              confirmButtonColor: "#3085d6",
              confirmButtonText: "Yes !",
            });
          }
        }
      });
    },

    //Xem chi tiết sp đã vote
    detaulVotedProduct(order_code) {
      this.detail_voted = !this.detail_voted;
      this.viewVotedProduct(order_code);
    },

    viewVotedProduct(order_code) {
      let that = this;
      this.flagShowLoader = true;
      let formData = new FormData();
      formData.append("orderCode", order_code);
      axios
        .post("get-voted-product", formData)
        .then(function (response) {
          that.votedProductDetails = response.data; //show data ra
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

    yourReview(votedProductDetail) {
      let that = this;
      this.flagShowLoader = true;
      let formData = new FormData();
      formData.append("order_code", votedProductDetail.order_code);
      formData.append("product_id", votedProductDetail.product_id);
      axios
        .post(`get-view-voted`, formData)
        .then(function (response) {
          that.viewVote = response.data; //show data ra
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

    // viewVoted(order) {
    //   let that = this;
    //   this.flagShowLoader = true;
    //   let formData = new FormData();
    //   formData.append("order_id", order.id);
    //   axios
    //     .post(`get-view-voted`, formData)
    //     .then(function (response) {
    //       that.viewVote = response.data; //show data ra
    //       that.flagShowLoader = false;
    //     })
    //     .catch((err) => {
    //       switch (err.response.status) {
    //         case 500:
    //           that
    //             .$swal({
    //               title: "Error loading data !",
    //               icon: "warning",
    //               confirmButtonText: "Ok",
    //             })
    //             .then(function (confirm) {});
    //           break;
    //         default:
    //           break;
    //       }
    //     });
    // },

    //Xem chi tiết sp để vote

    detailProduct(order_code) {
      this.view_vote = !this.view_vote;
      this.viewDetailProduct(order_code);
    },

    viewDetailProduct(order_code) {
      let that = this;
      this.flagShowLoader = true;
      let formData = new FormData();
      formData.append("orderCode", order_code);
      axios
        .post("get-vote-product", formData)
        .then(function (response) {
          that.voteDetails = response.data; //show data ra
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

    fetchCountStatus() {
      let that = this;
      axios
        .post(`/sale/get-count-status`)
        .then(function (response) {
          console.log("AVCS", response.data);
          that.countOrder = response.data.countOrder;
          that.countshipping = response.data.countshipping;
          that.countSuccess = response.data.countSuccess;
          that.countFailure = response.data.countFailure;
          that.countEvaluate = response.data.countEvaluate;
          that.countReturn = response.data.countReturn;
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

    showProcess(id) {
      this.orderId = id;
    },
  },
};
</script>

