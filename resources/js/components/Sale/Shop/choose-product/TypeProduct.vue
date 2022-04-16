<template>
  <div class="pt-3" style="min-height: 100%; position: relative">
    <div
      style="background-color: #e9edf0; height: 54px"
      class="product-show-option"
      v-if="products != ''"
    >
      <div class="row">
        <div
          class="col-lg-2 col-md-2 col-3"
          style="transform: translate(10%, 23%)"
        >
          <select v-model="paginate" class="form-control text-center">
            <option
              v-for="item in limitNumber"
              :key="item.key"
              :value="item.key"
            >
              {{ item.value }}
            </option>
          </select>
        </div>

        <div
          class="col-lg-3 col-md-3 col-2"
          style="transform: translate(10%, 23%)"
        >
          <select
            v-model="statusView"
            class="form-control w-sm inline v-middle text-center"
          >
            <option
              v-for="item in sortOption"
              :key="item.key"
              :value="item.key"
            >
              {{ item.value }}
            </option>
          </select>
        </div>

        <div class="col-lg-3 col-md-3 col-2"></div>

        <div
          class="col-lg-4 col-md-4 col-5 text-right"
          style="transform: translate(-4%, 23%)"
        >
          <input
            type="text"
            class="form-control"
            v-model="search"
            placeholder="Search"
          />
        </div>
      </div>
    </div>
    <div class="product-list" style="background-color: #e9edf0">
      <div class="row" style="padding-top: 25px">
        <div
          class="col-lg-4 col-sm-6"
          v-for="product in products.data"
          :key="product.id"
        >
          <a :href="`/product-detail/${product.id}`">
            <div class="product-item" style="background-color: white">
              <div class="pi-pic">
                <img
                  style="height: 250px"
                  v-lazy="baseUrl + '/uploads/products/' + product.images"
                  alt=""
                />
                <div
                  class="sale pp-sale"
                  style="background: red"
                  v-if="maxSold.id == product.id"
                >
                  Best Sellers
                </div>
                <div
                  class="sale pp-sale"
                  style="background: #c0c0c0"
                  v-else-if="product.quantity < 1"
                >
                  Sold Out
                </div>
                <div class="sale pp-sale" v-else>Sale</div>
                <ul>
                  <li class="quick-view">
                    <a
                      type="button"
                      data-toggle="modal"
                      data-target="#myModal"
                      @click="showQuickView(product)"
                      href="#"
                      >+ Quick View</a
                    >
                  </li>
                </ul>
              </div>
              <div
                class="pi-text"
                style="
                  padding-top: 19px !important;
                  border: 0.5px solid #e9edf0;
                "
              >
                <a
                  href="#"
                  style="transform: translate(0%, -34%); font-size: 21px"
                >
                  <h5 style="">
                    {{ product.name }}
                  </h5>
                </a>
                <div style="color: red; transform: translate(-27%, 53%)">
                  <u
                    style="
                      font-size: 13px;
                      display: -webkit-inline-box;
                      transform: translate(0%, -13%);
                    "
                    >đ</u
                  >
                  <span style="font-size: 19px">{{
                    formatPrice(product.price)
                  }}</span>
                </div>
                <div
                  class="da-ban"
                  style="
                    transform: translate(32%, -47%);
                    font-size: 14px;
                    color: dimgray;
                  "
                >
                  <span>Đã bán {{ product.product_sold }}</span>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
    <div
      class="loading-more"
      v-if="products != ''"
      style="position: absolute; bottom: 9px; left: 50%; right: 50%"
    >
      <nav aria-label="Page navigation example" style="height: 44px">
        <paginate
          v-model="page"
          :page-count="parseInt(products.last_page)"
          :page-range="9"
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
    <div v-else class="text-center" style="color: red">There is no data !</div>

    <div
      class="modal fade"
      id="myModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div
        class="modal-dialog modal-lg"
        style="width: 85% !important"
        role="document"
      >
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Product Information
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
            <div class="row">
              <div class="col-md-6 col-12">
                <v-zoomer>
                  <img
                    class="product-big-img"
                    style="height: 377px"
                    ref="image"
                    :src="baseUrl + '/uploads/products/' + quickViews.images"
                    alt=""
                  />
                </v-zoomer>
              </div>

              <div class="col-md-6 col-12 product_content">
                <b style="font-size: 13px">
                  Mã ID : <span>{{ quickViews.id }}</span>
                </b>
                <h3 style="color: #e7ab3c">{{ quickViews.name }}</h3>
                <div class="rating" style="font-size: 13px; padding-top: 4px">
                  <star-rating
                    read-only
                    :star-size="15"
                    :increment="0.1"
                    :rating="Number(quickViews.star_vote)"
                  ></star-rating>
                  <div style="transform: translate(30%, -99%); font-size: 14px">
                    <b style="padding-left: 2%">|</b>
                    <u style="padding-left: 2%">{{
                      quickViews.product_sold
                    }}</u>
                    Đã bán
                    <b style="padding-left: 2%"> |</b>
                    <u style="padding-left: 2%">{{ quickViews.views }}</u>
                    Đã xem
                  </div>
                </div>
                <p
                  style="
                    height: 175px;
                    position: relative;
                    width: 100%;
                    -ms-hyphens: auto;
                    -webkit-hyphens: auto;
                    hyphens: auto;
                    word-wrap: break-word;
                    text-overflow: ellipsis;
                    overflow: hidden;
                    -webkit-line-clamp: 7;
                    -webkit-box-orient: vertical;
                    display: -webkit-box;
                  "
                  v-html="quickViews.content"
                ></p>
                <div
                  class="cost"
                  style="color: red; transform: translate(0%, -10%)"
                >
                  <u
                    style="
                      font-size: 13px;
                      display: -webkit-inline-box;
                      transform: translate(0%, -13%);
                    "
                    >đ</u
                  >
                  <span class="glyphicon glyphicon-usd" style="font-size: 27px"
                    ><b> {{ formatPrice(quickViews.price) }}</b></span
                  >
                </div>

                <div class="row">
                  <div class="col-md-6 col-sm-12" style="position: relative">
                    <div class="quantity">
                      <a
                        :href="`/product-detail/${quickViews.id}`"
                        class="primary-btn pd-cart btn btn-success"
                        >View Detail</a
                      >
                    </div>
                  </div>
                </div>
                <div class="space-ten"></div>
              </div>
            </div>
            <br />
            <div class="row">
              <div class="col-lg-12">
                <div class="section-title">
                  <h2 style="font-size: 22px">Frequently Bought Together</h2>
                </div>
              </div>
            </div>
            <div
              class="row"
              style="background-color: #e9edf0; margin-bottom: 15px"
            >
              <div
                style="padding-top: 29px"
                class="col-lg-4 col-sm-6"
                v-for="productTogether in productTogethers"
                :key="productTogether.id"
              >
                <a :href="`product-detail/${productTogether.id}`">
                  <div
                    class="product-item div-hover"
                    style="background-color: white"
                  >
                    <div class="pi-pic">
                      <img
                        style="height: 167px"
                        :src="
                          baseUrl +
                          '/uploads/products/' +
                          productTogether.images
                        "
                        alt=""
                      />
                      <div class="sale">Sale</div>
                    </div>
                    <div
                      class="pi-text"
                      style="
                        padding-top: 19px !important;
                        border: 0.5px solid #e9edf0;
                      "
                    >
                      <a
                        href="#"
                        style="transform: translate(0%, -34%); font-size: 21px"
                      >
                        <h5 style="">
                          {{ productTogether.name }}
                        </h5>
                      </a>
                      <div style="color: red; transform: translate(-27%, 53%)">
                        <u
                          style="
                            font-size: 13px;
                            display: -webkit-inline-box;
                            transform: translate(0%, -13%);
                          "
                          >đ</u
                        >
                        <span style="font-size: 19px">{{
                          formatPrice(productTogether.price)
                        }}</span>
                      </div>
                      <div
                        class="da-ban"
                        style="
                          transform: translate(32%, -47%);
                          font-size: 14px;
                          color: dimgray;
                        "
                      >
                        <span>Đã bán {{ productTogether.product_sold }}</span>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
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
import StarRating from "vue-star-rating";
import Modal from "../../../Modal/Modal.vue";
import Loader from "../../../Common/loader.vue";
import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      typ: this.productType,
      products: [],
      product: {
        id: "",
        name: "",
        images: "",
        price: "",
        type_id: "",
        weight_id: "",
        description_id: "",
        content: "",
        status: "",
      },

      quickViews: {
        id: "",
        name: "",
        images: "",
        price: "",
        quantity: "",
        product_sold: "",
        views: "",
        content: "",
        star_vote: "",
      },
      productTogethers: [],
      productTogether: {
        id: "",
        name: "",
        images: "",
        price: "",
        quantity: "",
        product_sold: "",
        views: "",
        content: "",
        star_vote: "",
      },

      page: 1,
      paginate: 9,
      search: "",
      statusView: 0,
      maxSold: "",

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
      sortOption: [],
      limitNumber: [],
    };
  },
  created() {
    this.fetchData();
    this.getSortOption();
    this.getLimitNumber();
  },
  components: {
    Modal,
    Loader,
    StarRating,
  },
  props: ["productType"],
  mounted() {},

  watch: {
    paginate: function (value) {
      this.fetchData();
    },
    search: function (value) {
      this.fetchData();
    },
    statusView: function (value) {
      this.fetchData();
    },
  },
  methods: {
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    fetchData() {
      let that = this;
      this.flagShowLoader = true;
      var url =
        "/get-type-product/" +
        this.typ[0].type_id +
        "?page=" +
        this.page +
        "&paginate=" +
        this.paginate +
        "&search=" +
        this.search +
        "&statusView=" +
        that.statusView;
      axios
        .get(url)
        .then(function (response) {
          that.products = response.data.products;
          that.maxSold = response.data.maxSold;
          that.flagShowLoader = false;
        })
        .catch((err) => {
          switch (err.response.status) {
            case 404:
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
      if (this.products.prev_page_url) {
        this.page--;
        this.fetchData();
      }
    },
    next() {
      if (this.products.next_page_url) {
        this.page++;
        this.fetchData();
      }
    },
    changePage(page) {
      this.page = page;
      this.fetchData();
    },
    showQuickView(product) {
      let that = this;
      this.flagShowLoader = true;
      let formData = new FormData();
      formData.append("id", product.id);
      axios
        .post(`/quick-view-shop`, formData)
        .then(function (response) {
          that.quickViews = response.data.productQuick;
          that.productTogethers = response.data.productTogether;
          that.flagShowLoader = false;
        })
        .catch((err) => {
          switch (err.response.status) {
            case 404:
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
    getSortOption() {
      axios.get(`/get-sort-option`).then((response) => {
        this.sortOption = response.data;
      });
    },
    getLimitNumber() {
      axios.get(`/get-limit-number`).then((response) => {
        this.limitNumber = response.data;
      });
    },
  },
};
</script>