<template>
  <div>
    <div class="product-tab">
      <div class="tab-item">
        <ul class="nav" role="tablist">
          <li>
            <a
              style="width: 260px"
              class="active tab-description"
              data-toggle="tab"
              href="#tab-1"
              role="tab"
              >DESCRIPTION</a
            >
          </li>
          <li>
            <a style="width: 270px" data-toggle="tab" href="#tab-2" role="tab"
              >SPECIFICATIONS</a
            >
          </li>
          <li>
            <a data-toggle="tab" href="#tab-3" role="tab">Customer Reviews</a>
          </li>
        </ul>
      </div>
      <div class="tab-item-content">
        <div class="tab-content">
          <div
            class="tab-pane fade-in active"
            id="tab-1"
            role="tabpanel"
            style="background-color: #e9edf0"
          >
            <div class="product-content">
              <div class="row">
                <div class="col-lg-7" style="transform: translate(0%, -8%)">
                  <!-- <div
                    style="
                      overflow: hidden;
                      position: relative;
                      line-height: 18px;
                      height: 270px;
                      -ms-hyphens: auto;
                      -webkit-hyphens: auto;
                      hyphens: auto;
                      word-wrap: break-word;
                      text-overflow: ellipsis;
                      padding-left: 16px;
                    "
                  >
                    {{ decrip[0].content }}
                  </div> -->
                  <div
                    style="
                      height: 270px;
                      position: relative;
                      width: 100%;
                      -ms-hyphens: auto;
                      -webkit-hyphens: auto;
                      hyphens: auto;
                      word-wrap: break-word;
                      text-overflow: ellipsis;
                      padding-left: 16px;
                      overflow: hidden;
                      -webkit-line-clamp: 11;
                      -webkit-box-orient: vertical;
                      display: -webkit-box;
                    "
                  >
                    {{ decrip[0].content }}
                  </div>
                </div>
                <div class="col-lg-5" style="transform: translate(-5%, 0%)">
                  <img
                    style="height: 268px; transform: translate(0%, -6%)"
                    :src="baseUrl + '/uploads/products/' + decrip[0].images"
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="tab-2" role="tabpanel">
            <div class="specification-table">
              <table style="background-color: #e9edf0">
                <tr>
                  <td class="p-catagory">Customer Rating</td>
                  <td>
                    <div class="pd-rating" style="display: inline-flex">
                      <star-rating
                        read-only
                        :star-size="15"
                        :increment="0.1"
                        v-model="decrip[0].star_vote"
                      ></star-rating>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="p-catagory">Price</td>
                  <td>
                    <div class="p-price">
                      {{ formatPrice(decrip[0].price) }} đ
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="p-catagory">Add To Cart</td>
                  <td>
                    <div class="cart-add">+ add to cart</div>
                  </td>
                </tr>
                <tr>
                  <td class="p-catagory">Availability</td>
                  <td>
                    <div class="p-stock">{{ decrip[0].quantity }} in stock</div>
                  </td>
                </tr>
                <tr>
                  <td class="p-catagory">Weight</td>
                  <td>
                    <div class="p-weight">{{ decrip[0].weight.weight }}</div>
                  </td>
                </tr>
                <tr>
                  <td class="p-catagory">Id</td>
                  <td>
                    <div class="p-code">000{{ decrip[0].id }}</div>
                  </td>
                </tr>
              </table>
            </div>
          </div>

          <div class="tab-pane fade" id="tab-3" role="tabpanel">
            <div
              class="mt-3 mb-3"
              style="
                padding: 40px;
                border: 1px dotted #e9edf0;
                background-color: #e9edf0;
              "
            >
              <div class="row">
                <div class="col-lg-3 col-5">
                  <div style="font-size: 20px; color: #17a2b8">
                    <b class="pl-4">{{ decrip[0].star_vote }} </b>trên 5
                  </div>
                  <div>
                    <star-rating
                      read-only
                      :star-size="27"
                      :increment="0.1"
                      :show-rating="false"
                      style="margin: auto"
                      v-model="decrip[0].star_vote"
                    ></star-rating>
                  </div>
                </div>
                <div class="col-lg-9 col-7">
                  <button
                    @click="selectAll()"
                    class="btn btn-info mt-1"
                    style="width: max-content; font-size: 17px"
                  >
                    Tất Cả ({{ this.countAll }})
                  </button>
                  <button
                    @click="select5Star()"
                    class="btn btn-info mt-1"
                    style="width: max-content; font-size: 17px"
                  >
                    5 sao ({{ this.count5Stars }})
                  </button>
                  <button
                    @click="select4Star()"
                    class="btn btn-info mt-1"
                    style="width: max-content; font-size: 17px"
                  >
                    4 sao ({{ this.count4Stars }})
                  </button>
                  <button
                    @click="select3Star()"
                    class="btn btn-info mt-1"
                    style="width: max-content; font-size: 17px"
                  >
                    3 sao ({{ this.count3Stars }})
                  </button>
                  <button
                    @click="select2Star()"
                    class="btn btn-info mt-1"
                    style="width: max-content; font-size: 17px"
                  >
                    2 sao ({{ this.count2Stars }})
                  </button>
                  <button
                    @click="select1Star()"
                    class="btn btn-info mt-1"
                    style="width: max-content; font-size: 17px"
                  >
                    1 sao ({{ this.count1Stars }})
                  </button>
                  <button
                    class="btn btn-info mt-1"
                    style="width: max-content; font-size: 17px"
                  >
                    Có Ảnh ({{ this.countAllImage }})
                  </button>
                </div>
              </div>
            </div>
            <div>
              <div
                class="d-flex justify-content-center row"
                v-for="evaluate in evaluates.data"
                :key="evaluate.id"
              >
                <div class="col-md-12 mt-3">
                  <div class="d-flex flex-column comment-section" id="myGroup">
                    <div class="bg-white p-2" style="display: contents">
                      <div class="d-flex flex-row user-info">
                        <img
                          class="rounded-circle"
                          :src="
                            baseUrl + '/uploads/users/' + evaluate.user.images
                          "
                          width="40px"
                          height="40px"
                          alt=""
                        />
                        <div
                          class="d-flex flex-column justify-content-start ml-2"
                        >
                          <span class="d-block font-weight-bold name">{{
                            evaluate.user.name
                          }}</span
                          ><span class="date text-black-50">
                            <star-rating
                              read-only
                              :star-size="15"
                              v-model="evaluate.star_vote"
                            ></star-rating>
                          </span>
                        </div>
                      </div>
                      <div class="mt-2 ml-5">
                        <p class="comment-text" style="font-size: 17px">
                          {{ evaluate.content }}
                        </p>
                      </div>
                      <div
                        class="ml-5"
                        id="gallery"
                        data-toggle="modal"
                        data-target="#exampleModal"
                      >
                        <div
                          v-for="data in evaluate.evaluate_images"
                          :key="data.id"
                        >
                          <img
                            :src="baseUrl + '/uploads/comments/' + data.url"
                            style="
                              float: left;
                              margin-right: 9px;
                              width: 104px;
                              height: 115px;
                            "
                            alt="First slide"
                            data-target="#carouselExample"
                            data-slide-to="0"
                          />
                        </div>
                      </div>

                      <div class="mt-2 ml-5">
                        <p class="comment-text" style="font-size: 12px">
                          {{ evaluate.created_at | formatDate }}
                        </p>
                      </div>
                      <div
                        v-if="evaluate.rank == 2"
                        class="ml-5"
                        style="background-color: #f5f5f5"
                      >
                        <b class="p-2">Phản Hồi Của Người Bán</b>
                        <p class="p-2">{{ evaluate.reply_comment }}</p>
                      </div>
                      <div v-else>
                        <hr />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- <div
              class="modal fade"
              id="exampleModal"
              tabindex="-1"
              role="dialog"
              aria-hidden="true"
            >
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
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
                    <div
                      id="carouselExample"
                      class="carousel slide"
                      data-ride="carousel"
                      v-for="data in evaluate.evaluate_images"
                      :key="data.id"
                    >
                      <ol class="carousel-indicators">
                        <li
                          data-target="#carouselExample"
                          data-slide-to="{{data.id}}"
                          v-if="(data.id = 1)"
                          class="active"
                        ></li>
                        <li
                          data-target="#carouselExample"
                          data-slide-to="{{data.id}}"
                          v-else
                        ></li>
                      </ol>
                      <div class="carousel-inner">
                        <div
                          class="carousel-item"
                          v-for="data in evaluate.evaluate_images"
                          :key="data.id"
                        >
                          <img
                            class="d-block w-100"
                            :src="baseUrl + '/uploads/comments/' + data.url"
                            alt="Second slide"
                          />
                        </div>
                      </div>
                      <a
                        class="carousel-control-prev"
                        href="#carouselExample"
                        role="button"
                        data-slide="prev"
                      >
                        <span
                          class="carousel-control-prev-icon"
                          aria-hidden="true"
                        ></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a
                        class="carousel-control-next"
                        href="#carouselExample"
                        role="button"
                        data-slide="next"
                      >
                        <span
                          class="carousel-control-next-icon"
                          aria-hidden="true"
                        ></span>
                        <span class="sr-only">Next</span>
                      </a>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button
                      type="button"
                      class="btn btn-secondary"
                      data-dismiss="modal"
                    >
                      Close
                    </button>
                  </div>
                </div>
              </div>
            </div> -->

            <div v-if="evaluates != ''">
              <nav aria-label="Page navigation example">
                <paginate
                  v-model="page"
                  :page-count="parseInt(evaluates.last_page)"
                  :page-range="3"
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
            <div class="text-center" v-else style="color: red">
              There is no data !
            </div>
          </div>
        </div>
      </div>
    </div>
    <Loader :flag-show="flagShowLoader"></Loader>
  </div>
</template>

<style scoped>
body {
  background: #eee;
}

.date {
  font-size: 11px;
}

.comment-text {
  font-size: 12px;
}

.fs-12 {
  font-size: 12px;
}

.shadow-none {
  box-shadow: none;
}

.name {
  color: #007bff;
}

.cursor:hover {
  color: blue;
}

.cursor {
  cursor: pointer;
}

.textarea {
  resize: none;
}

.fa-facebook {
  color: #3b5999;
}

.fa-twitter {
  color: #55acee;
}

.fa-linkedin {
  color: #0077b5;
}

.fa-instagram {
  color: #e4405f;
}

.fa-dribbble {
  color: #ea4c89;
}

.fa-pinterest {
  color: #bd081c;
}

.fa {
  cursor: pointer;
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
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      decrip: this.decripProduct,

      evaluates: [],
      evaluate: {
        user_id: "",
        order_code: "",
        product_id: "",
        star_vote: 0,
        content: "",
        rank: "",
        reply_comment: "",
      },

      idProduct: "",

      errorBackEnd: {}, //Lỗi bên backend laravel
      count: "",
      page: 1,
      paginate: 5,
      flagShowLoader: false,

      select_all: false,
      select_5star: false,
      select_4star: false,
      select_3star: false,
      select_2star: false,
      select_1star: false,

      count5Stars: 0,
      count4Stars: 0,
      count3Stars: 0,
      count2Stars: 0,
      count1Stars: 0,
      countAll: 0,
      countAllImage: 0,
    };
  },
  created() {
    let messError = {
      custom: {
        content: {
          required: "* Comment is not !",
        },
        contentRep: {
          required: "* Reply is not !",
        },
      },
    };
    this.$validator.localize("en", messError);
    this.fetchData();
    this.fetchCountStar();
  },
  components: {
    Loader,
    StarRating,
  },
  props: ["decripProduct"],
  mounted() {
    this.fetchData();
  },
  methods: {
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },

    selectAll() {
      this.select_all = !this.select_all;
      this.select_5star = false;
      this.select_4star = false;
      this.select_3star = false;
      this.select_2star = false;
      this.select_1star = false;
      this.fetchData();
    },
    select5Star() {
      this.select_5star = true;
      this.select_all = false;
      this.select_4star = false;
      this.select_3star = false;
      this.select_2star = false;
      this.select_1star = false;
      this.fetchData();
    },
    select4Star() {
      this.select_4star = true;
      this.select_5star = false;
      this.select_3star = false;
      this.select_2star = false;
      this.select_1star = false;
      this.fetchData();
    },
    select3Star() {
      this.select_3star = !this.select_3star;
      this.select_5star = false;
      this.select_4star = false;
      this.select_all = false;
      this.select_2star = false;
      this.select_1star = false;
      this.fetchData();
    },
    select2Star() {
      this.select_2star = !this.select_2star;
      this.select_5star = false;
      this.select_4star = false;
      this.select_3star = false;
      this.select_all = false;
      this.select_1star = false;
      this.fetchData();
    },
    select1Star() {
      this.select_1star = !this.select_1star;
      this.select_5star = false;
      this.select_4star = false;
      this.select_3star = false;
      this.select_2star = false;
      this.select_all = false;
      this.fetchData();
    },

    fetchCountStar() {
      let that = this;
      axios
        .post(`/get-count-star?product_id=` + that.decrip[0].id)
        .then(function (response) {
          that.count5Stars = response.data.count5Stars;
          that.count4Stars = response.data.count4Stars;
          that.count3Stars = response.data.count3Stars;
          that.count2Stars = response.data.count2Stars;
          that.count1Stars = response.data.count1Stars;
          that.countAll = response.data.countAll;
          that.countAllImage = response.data.countAllImage;
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

    fetchData() {
      let that = this;
      this.flagShowLoader = true;
      if (that.select_5star == true) {
        axios
          .post(
            `/get-select-5star?page=` +
              that.page +
              "&paginate=" +
              that.paginate +
              "&product_id=" +
              that.decrip[0].id
          )
          .then(function (response) {
            // console.log(response.data.evaluate5Stars.data[0].evaluate_images);
            that.evaluates = response.data.evaluate5Stars; //show data ra
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
      } else if (that.select_4star == true) {
        axios
          .post(
            `/get-select-4star?page=` +
              that.page +
              "&paginate=" +
              that.paginate +
              "&product_id=" +
              that.decrip[0].id
          )
          .then(function (response) {
            that.evaluates = response.data.evaluate4Stars; //show data ra
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
      } else if (that.select_3star == true) {
        axios
          .post(
            `/get-select-3star?page=` +
              that.page +
              "&paginate=" +
              that.paginate +
              "&product_id=" +
              that.decrip[0].id
          )
          .then(function (response) {
            that.evaluates = response.data.evaluate3Stars; //show data ra
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
      } else if (that.select_2star == true) {
        axios
          .post(
            `/get-select-2star?page=` +
              that.page +
              "&paginate=" +
              that.paginate +
              "&product_id=" +
              that.decrip[0].id
          )
          .then(function (response) {
            that.evaluates = response.data.evaluate2Stars; //show data ra
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
      } else if (that.select_1star == true) {
        axios
          .post(
            `/get-select-1star?page=` +
              that.page +
              "&paginate=" +
              that.paginate +
              "&product_id=" +
              that.decrip[0].id
          )
          .then(function (response) {
            that.evaluates = response.data.evaluate1Stars; //show data ra
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
      } else {
        var url =
          `/get-evaluated?page=` +
          this.page +
          "&paginate=" +
          this.paginate +
          "&product_id=" +
          this.decrip[0].id;
        axios
          .post(url)
          .then(function (response) {
            that.evaluates = response.data.evaluates; //show data ra
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
      if (this.types.prev_page_url) {
        this.page--;
        this.fetchData();
      }
    },
    next() {
      if (this.types.next_page_url) {
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

    switchStyle() {
      if (document.getElementById("styleSwitch").checked) {
        document.getElementById("gallery").classList.add("custom");
        document.getElementById("exampleModal").classList.add("custom");
      } else {
        document.getElementById("gallery").classList.remove("custom");
        document.getElementById("exampleModal").classList.remove("custom");
      }
    },
  },
};
</script>