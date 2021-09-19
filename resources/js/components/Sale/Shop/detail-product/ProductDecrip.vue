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
                    :src="baseUrl + '/uploads/' + decrip[0].images"
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
                    <div class="pd-rating">
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star-o"></i>
                      <span>(5)</span>
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
                <div class="col-lg-3 col-3">
                  <button class="btn btn-success mt-1">jajdad</button>
                </div>
                <div class="col-lg-9 col-9">
                  <button
                    class="btn btn-success"
                    style="width: max-content; font-size: 17px"
                  >
                    Tất Cả
                  </button>
                  <button
                    class="btn btn-success"
                    style="width: max-content; font-size: 17px"
                  >
                    5 sao()
                  </button>
                  <button
                    class="btn btn-success"
                    style="width: max-content; font-size: 17px"
                  >
                    4 sao()
                  </button>
                  <button
                    class="btn btn-success"
                    style="width: max-content; font-size: 17px"
                  >
                    3 sao()
                  </button>
                  <button
                    class="btn btn-success"
                    style="width: max-content; font-size: 17px"
                  >
                    2 sao()
                  </button>
                  <button
                    class="btn btn-success"
                    style="width: max-content; font-size: 17px"
                  >
                    1 sao()
                  </button>
                  <br />
                  <button
                    class="btn btn-success mt-1"
                    style="width: max-content; font-size: 17px"
                  >
                    Bình Luận()
                  </button>
                  <button
                    class="btn btn-success mt-1"
                    style="width: max-content; font-size: 17px"
                  >
                    Có Ảnh()
                  </button>
                </div>
              </div>
            </div>
            <div
              class="d-flex justify-content-center row"
              v-for="evaluate in evaluates.data"
              :key="evaluate.id"
            >
              <div class="col-md-12">
                <div class="d-flex flex-column comment-section" id="myGroup">
                  <div class="bg-white p-2">
                    <div class="d-flex flex-row user-info">
                      <img
                        class="rounded-circle"
                        :src="baseUrl + '/uploads/' + evaluate.user.images"
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
                            :increment="0.5"
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
                    <div class="mt-2 ml-5">
                      <img
                        :src="baseUrl + '/uploads/' + evaluate.image_1"
                        width="85px"
                        height="80px"
                        alt=""
                      />
                      <img
                        :src="baseUrl + '/uploads/' + evaluate.image_2"
                        width="85px"
                        height="80px"
                        alt=""
                      />
                      <img
                        :src="baseUrl + '/uploads/' + evaluate.image_3"
                        width="85px"
                        height="80px"
                        alt=""
                      />
                      <img
                        :src="baseUrl + '/uploads/' + evaluate.image_4"
                        width="85px"
                        height="80px"
                        alt=""
                      />
                    </div>
                    <div class="mt-2 ml-5">
                      <p class="comment-text" style="font-size: 12px">
                        {{ evaluate.created_at | formatDate }}
                      </p>
                    </div>
                    <hr />
                  </div>
                </div>
              </div>
            </div>
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
      evaluates: {
        user_id: "",
        order_code: "",
        product_id: "",
        star_vote: "",
        content: "",
        rank: "",
        reply_code: "",
        image_1: "",
        image_2: "",
        image_3: "",
        image_4: "",
      },

      idProduct: "",

      errorBackEnd: {}, //Lỗi bên backend laravel
      count: "",
      page: 1,
      paginate: 5,
      flagShowLoader: false,
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
  },
  components: {
    Loader,
    StarRating,
  },
  props: ["decripProduct"],
  mounted() {
    this.fetchData();
    // this.fillImage();
  },
  methods: {
    // deleteComment(code, id) {
    //   let that = this;
    //   let formData = new FormData();
    //   formData.append("codeComment", code);
    //   formData.append("idComment", id);
    //   this.$swal({
    //     title: "Do you want to delete ？",
    //     icon: "warning",
    //     showCancelButton: true,
    //     confirmButtonColor: "#3085d6",
    //     cancelButtonColor: "#d33",
    //     confirmButtonText: "Yes, delete it!",
    //     cancelButtonText: "No, cancel!",
    //   }).then((result) => {
    //     if (result.value) {
    //       axios
    //         .post(`/comment/delete`, formData)
    //         .then((response) => {
    //           this.$swal({
    //             title: "Delete successfully!",
    //             icon: "success",
    //             confirmButtonText: "OK!",
    //           }).then(function (confirm) {});
    //           that.fetchData();
    //         })
    //         .catch((error) => {
    //           that.flashMessage.error({
    //             message: "Delete Failure!",
    //             icon: "/backend/icon/error.svg",
    //             blockClass: "text-centet",
    //           });
    //         });
    //     }
    //   });
    // },
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    // codeReplySecond(code) {
    //   this.codeFormReplySecond = code;
    //   this.statusReplySecond == true;
    // },

    // idReplySecond(id) {
    //   this.idFormReplySecond = id;
    // },

    // replyFirst(id) {
    //   this.idFormReplyFirst = id;
    //   this.statusReplyFirst == true;
    // },
    // commentFirst(id) {
    //   this.idFormCommentFirst = id;
    //   this.statusCommentFirst == true;

    //   let that = this;
    //   this.flagShowLoader = true;
    //   var url = `/get-commentReply/${id}`;
    //   axios
    //     .get(url)
    //     .then(function (response) {
    //       that.commentReplys = response.data.comments; //show data ra
    //       that.countReply = response.data.countReply; //show data ra
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

    fetchData() {
      let that = this;
      this.flagShowLoader = true;
      var url =
        `/sale/get-evaluated?page=` +
        this.page +
        "&paginate=" +
        this.paginate +
        "&product_id=" +
        this.decrip[0].id;
      axios
        .get(url)
        .then(function (response) {
          // console.log(response.data);
          that.evaluates = response.data.evaluates; //show data ra
          // that.count = response.data.count; //show data ra
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

    addComment() {
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          axios
            .post(`/add-comment/${this.decrip[0].id}`, this.comment)
            .then((response) => {
              this.$swal({
                title: response.data,
                icon: "success",
                confirmButtonText: "OK!",
              });
              this.comment.content = "";
              this.fetchData();
            })
            .catch((err) => {
              switch (err.response.status) {
                case 422:
                  this.errorBackEnd = err.response.data.errors;
                  break;
                case 404:
                  this.$swal({
                    title: "Comment Error !",
                    icon: "warning",
                    confirmButtonText: "Cancle !",
                  }).then(function (confirm) {});
                  break;
                case 500:
                  this.$swal({
                    title: "Comment Error !",
                    icon: "warning",
                    confirmButtonText: "Cancle !",
                  }).then(function (confirm) {});
                  break;
                default:
                  break;
              }
            });
        }
      });
    },

    repCommentFirst(id) {
      let that = this;
      let formData = new FormData();
      formData.append("name", this.comment.name);
      console.log("Tên", this.comment.name);

      formData.append("repComment", this.commentReply.contentRep);
      formData.append("idProduct", this.decrip[0].id);
      axios
        .post(`/reply-comment/${id}`, formData)
        .then((response) => {
          that.$swal({
            title: response.data,
            icon: "success",
            confirmButtonText: "OK!",
          });
          that.commentReply.contentRep = "";
          that.statusCommentFirst = !this.statusCommentFirst;
          that.fetchData();
        })
        .catch((err) => {
          switch (err.response.status) {
            case 422:
              that.errorBackEnd = err.response.data.errors;
              break;
            case 404:
              that
                .$swal({
                  title: "Comment Error !",
                  icon: "warning",
                  confirmButtonText: "Cancle !",
                })
                .then(function (confirm) {});
              break;
            case 500:
              that
                .$swal({
                  title: "Comment Error !",
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
    repCommentSecond(id) {
      let formData = new FormData();
      formData.append("repComment", this.replySecond.contentRep);
      formData.append("idProduct", this.decrip[0].id);
      axios
        .post(`/reply-comment-second/${id}`, formData)
        .then((response) => {
          this.$swal({
            title: response.data,
            icon: "success",
            confirmButtonText: "OK!",
          });
          this.replySecond.contentRep = "";
          // this.statusCommentFirst = !this.statusCommentFirst;
          this.fetchData();
        })
        .catch((err) => {
          switch (err.response.status) {
            case 422:
              this.errorBackEnd = err.response.data.errors;
              break;
            case 404:
              this.$swal({
                title: "Comment Error !",
                icon: "warning",
                confirmButtonText: "Cancle !",
              }).then(function (confirm) {});
              break;
            case 500:
              this.$swal({
                title: "Comment Error !",
                icon: "warning",
                confirmButtonText: "Cancle !",
              }).then(function (confirm) {});
              break;
            default:
              break;
          }
        });
    },

    fillImage() {
      axios.post(`/fill-image`).then(function (response) {
        this.showImage = response.data.image;
        console.log("ẢNh", this.showImage);
      });
    },
  },
};
</script>