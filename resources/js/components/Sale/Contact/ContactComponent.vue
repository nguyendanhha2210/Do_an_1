<template>
  <div style="background-color: #e9edf0">
    <!-- Map Section Begin -->
    <div class="pt-5 pb-5">
      <div class="container" style="background-color: white">
        <div class="map-inner">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29786.53735057556!2d105.65036752910699!3d21.059990852076865!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313456926dffe03b%3A0x603734b21af6b8f1!2zRMawxqFuZyBMaeG7hXUsIEhvw6BpIMSQ4bupYywgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1624633251436!5m2!1svi!2s"
            height="610"
            style="border: 0"
            allowfullscreen=""
          >
          </iframe>

          <div class="icon">
            <i class="fa fa-map-marker"></i>
          </div>
        </div>
      </div>
    </div>
    <!-- Map Section Begin -->

    <!-- Contact Section Begin -->
    <div class="container pb-5">
      <div class="row">
        <div
          class="col-lg-5"
          style="background-color: white; padding: 15px 10px"
        >
          <div class="contact-title">
            <h4>Contacts Us</h4>
            <p>
              Hãy liên hệ với chúng tôi nều bạn đang có nhưng băn khoăn và chưa
              rõ về cách mua hàng .
            </p>
          </div>
          <div class="contact-widget">
            <div class="cw-item">
              <div class="ci-icon">
                <i class="ti-location-pin"></i>
              </div>
              <div class="ci-text">
                <span>Address:</span>
                <p>Dương Liễu - Hoài Đức - Hà Nội</p>
              </div>
            </div>
            <div class="cw-item">
              <div class="ci-icon">
                <i class="ti-mobile"></i>
              </div>
              <div class="ci-text">
                <span>Phone:</span>
                <p>+33 6868.6868</p>
              </div>
            </div>
            <div class="cw-item">
              <div class="ci-icon">
                <i class="ti-email"></i>
              </div>
              <div class="ci-text">
                <span>Email:</span>
                <p>danhha221020@gmail.com</p>
              </div>
            </div>

            <div
              style="width: 100%"
              class="fb-page text-center"
              data-href="https://www.facebook.com/Mekhoebexinh02/"
              data-tabs="timeline"
              data-width=""
              data-height="40px"
              data-small-header="false"
              data-adapt-container-width="true"
              data-hide-cover="false"
              data-show-facepile="true"
            >
              <blockquote
                cite="https://www.facebook.com/Mekhoebexinh02/"
                class="fb-xfbml-parse-ignore"
              >
                <a href="https://www.facebook.com/Mekhoebexinh02/"
                  >Fresh Mama - Nguồn dinh dưỡng tự nhiên</a
                >
              </blockquote>
            </div>

            <div class="top-social mt-5 text-center">
              <a href="https://www.facebook.com/Mekhoebexinh02"
                ><img
                  style="width: 92px; height: 81px; margin-right: 27px"
                  :src="'/frontend/images/fb.png'"
                  alt=""
              /></a>
              <a
                href="https://www.sendo.vn/shop/fresh-mama?fbclid=IwAR3tWlCBasdebaIOqqRRh8PmPmBfPUQnIH5rXNFAcbldGHvgGPeRHn5TGn4"
                ><img
                  style="width: 92px; height: 81px; margin-right: 27px"
                  :src="'/frontend/images/sendo.png'"
                  alt=""
              /></a>
              <a
                href="https://shopee.vn/shop/227054554/?fbclid=IwAR2ZW6JvJH3sC4r_YsvntvaW8NxT00HnmJ4CnEd0uAmJEbtl8Ot45VcEr1I"
                ><img
                  style="width: 92px; height: 81px"
                  :src="'/frontend/images/shoppee.jpg'"
                  alt=""
              /></a>
            </div>
          </div>
        </div>

        <div
          class="col-lg-6 offset-lg-1"
          style="background-color: white; padding: 15px 10px"
        >
          <div class="contact-form">
            <div class="leave-comment">
              <div>
                <div
                  class="d-flex justify-content-center row"
                  v-for="comment in exchangeReviews.data"
                  :key="comment.id"
                >
                  <div class="col-md-12">
                    <div
                      class="d-flex flex-column comment-section"
                      id="myGroup"
                    >
                      <div class="bg-white pr-2">
                        <div class="d-flex flex-row user-info">
                          <img
                            class="rounded-circle"
                            :src="baseUrl + '/uploads/' + comment.images"
                            width="40px"
                            height="40px"
                            alt=""
                          />
                          <div
                            class="
                              d-flex
                              flex-column
                              justify-content-start
                              ml-2
                            "
                          >
                            <span class="d-block font-weight-bold name">{{
                              comment.name
                            }}</span
                            ><span class="date text-black-50">{{
                              comment.created_at | formatDate
                            }}</span>
                          </div>
                        </div>
                        <div class="mt-2">
                          <p class="comment-text">
                            {{ comment.content }}
                          </p>
                        </div>
                      </div>
                      <div
                        class="bg-white pr-2"
                        style="transform: translate(-1%, -90%)"
                      >
                        <div
                          class="d-flex flex-row fs-12"
                          @click="
                            replyFirst(comment.id);
                            statusReplyFirst = !statusReplyFirst;
                          "
                        >
                          <div
                            class="like p-2 cursor action-collapse"
                            data-toggle="collapse"
                            aria-expanded="true"
                            aria-controls="collapse-1"
                            href="#collapse-1"
                          >
                            <i class="fa fa-reply"></i
                            ><span class="ml-1">Reply</span>
                          </div>
                          <div
                            @click="
                              exchangeReviewFirst(comment.id);
                              statusExchangeReviewFirst =
                                !statusExchangeReviewFirst;
                              statusReplyFirst = !statusReplyFirst;
                            "
                            class="like p-2 cursor action-collapse"
                            data-toggle="collapse"
                            aria-expanded="true"
                            aria-controls="collapse-2"
                            href="#collapse-2"
                          >
                            <i class="fa fa-commenting-o"></i
                            ><span class="ml-1">Comment</span>
                          </div>
                          <div
                            @click="
                              deltetExchangeReview(comment.code, comment.id)
                            "
                            class="like p-2 cursor action-collapse"
                            style="color: red"
                          >
                            <i class="fa fa-close"></i
                            ><span class="ml-1">Delete</span>
                          </div>
                        </div>
                      </div>
                      <div
                        v-if="
                          idFormReplyFirst == comment.id && statusReplyFirst
                        "
                        id="collapse-1"
                        class="bg-light collapse"
                        style="transform: translate(1%, -32%)"
                        data-parent="#myGroup"
                      >
                        <form
                          @submit.prevent="repexchangeReviewFirst(comment.id)"
                          class="comment-form"
                        >
                          <div class="d-flex flex-row align-items-start">
                            <img
                              class="rounded-circle"
                              :src="baseUrl + '/uploads/' + comment.images"
                              width="40px"
                              height="40px"
                              alt=""
                            />
                            <textarea
                              placeholder="Messages"
                              name="content"
                              style="height: 60px; margin-bottom: 0px"
                              class="form-control ml-1 shadow-none textarea"
                              v-validate="'required'"
                              @input="changeInput()"
                              v-model="exchangeReviewReply.contentRep"
                            ></textarea>
                            <div style="color: red" role="alert">
                              {{ errors.first("contentRep") }}
                            </div>
                          </div>
                          <div class="mt-2 text-right">
                            <button
                              class="btn btn-primary btn-sm shadow-none"
                              type="submit"
                            >
                              Post comment</button
                            ><button
                              @click="statusReplyFirst = !statusReplyFirst"
                              class="
                                btn btn-outline-primary btn-sm
                                ml-1
                                shadow-none
                              "
                              type="button"
                            >
                              Cancel
                            </button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <div
                    class="col-md-12"
                    style="padding-left: 58px"
                    v-if="
                      idFormexchangeReviewFirst == comment.id &&
                      statusExchangeReviewFirst
                    "
                  >
                    <div
                      class="d-flex flex-column comment-section"
                      id="myGroup"
                      v-for="exchangeReviewReply in exchangeReviewReplys"
                      :key="exchangeReviewReply.id"
                    >
                      <div
                        class="bg-white"
                        style="transform: translate(2%, -21%)"
                      >
                        <div class="d-flex flex-row user-info">
                          <img
                            class="rounded-circle"
                            :src="
                              baseUrl + '/uploads/' + exchangeReviewReply.images
                            "
                            width="40px"
                            height="40px"
                            alt=""
                          />
                          <div
                            class="
                              d-flex
                              flex-column
                              justify-content-start
                              ml-2
                            "
                          >
                            <span class="d-block font-weight-bold name">{{
                              exchangeReviewReply.name
                            }}</span
                            ><span class="date text-black-50">{{
                              exchangeReviewReply.created_at | formatDate
                            }}</span>
                          </div>
                        </div>
                        <div class="mt-2">
                          <p>
                            {{ exchangeReviewReply.content }}
                          </p>
                        </div>
                      </div>
                      <div
                        class="bg-white pr-2"
                        style="transform: translate(-1%, -215%)"
                      >
                        <div class="d-flex flex-row fs-12">
                          <div
                            @click="
                              codeReplySecond(exchangeReviewReply.code);
                              idReplySecond(exchangeReviewReply.id);
                              statusReplySecond = !statusReplySecond;
                            "
                            class="like pr-3 pl-3 cursor action-collapse"
                            data-toggle="collapse"
                            aria-expanded="true"
                            aria-controls="collapse-1"
                            href="#collapse-1"
                          >
                            <i class="fa fa-reply"></i
                            ><span class="ml-1">Reply</span>
                          </div>
                          <div
                            @click="
                              deltetExchangeReview(
                                exchangeReviewReply.code,
                                exchangeReviewReply.id
                              )
                            "
                            class="like pr-2 cursor action-collapse"
                            style="color: red"
                          >
                            <i class="fa fa-close"></i
                            ><span class="ml-1">Delete</span>
                          </div>
                        </div>
                      </div>

                      <!-- Show Comment Reply -->
                      <div class="bg-white pr-2">
                        <div class="d-flex flex-row fs-12"></div>
                      </div>

                      <div
                        v-if="
                          codeFormReplySecond == exchangeReviewReply.code &&
                          idFormReplySecond == exchangeReviewReply.id &&
                          statusReplySecond
                        "
                        id="collapse-1"
                        class="bg-light collapse"
                        style="transform: translate(1%, -54%)"
                        data-parent="#myGroup"
                      >
                        <form
                          @submit.prevent="
                            repexchangeReviewsecond(exchangeReviewReply.code)
                          "
                          class="comment-form"
                        >
                          <div class="d-flex flex-row align-items-start">
                            <img
                              class="rounded-circle"
                              :src="
                                baseUrl + '/uploads/' + exchangeReviews.images
                              "
                              width="40px"
                              height="40px"
                              alt=""
                            />
                            <!-- <img
                          class="rounded-circle"
                          src="/frontend/images/flag-1.jpg"
                          width="40"
                          height="40px"
                        /> -->
                            <textarea
                              placeholder="Messages"
                              name="content"
                              style="height: 60px; margin-bottom: 0px"
                              class="form-control ml-1 shadow-none textarea"
                              v-validate="'required'"
                              @input="changeInput()"
                              v-model="replySecond.contentRep"
                            ></textarea>
                            <div style="color: red" role="alert">
                              {{ errors.first("contentRep") }}
                            </div>
                          </div>
                          <div class="mt-2 text-right">
                            <button
                              class="btn btn-primary btn-sm shadow-none"
                              type="submit"
                            >
                              Post comment</button
                            ><button
                              @click="statusReplySecond = !statusReplySecond"
                              class="
                                btn btn-outline-primary btn-sm
                                ml-1
                                shadow-none
                              "
                              type="button"
                            >
                              Cancel
                            </button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <div v-if="exchangeReviews != ''">
                  <nav aria-label="Page navigation example">
                    <paginate
                      v-model="page"
                      :page-count="parseInt(exchangeReviews.last_page)"
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

                <div class="customer-review-option" style="padding-top: 10px">
                  <div class="leave-comment">
                    <form
                      @submit.prevent="addExchangeReview()"
                      class="comment-form"
                    >
                      <div class="row">
                        <div
                          class="col-lg-2"
                          style="transform: translate(20%, 7%)"
                        >
                          <!-- <img
                        class="rounded-circle"
                        :src="baseUrl + '/uploads/' + showImage"
                        width="40px"
                        height="40px"
                        alt=""
                      /> -->
                          <img
                            class="rounded-circle"
                            src="/frontend/images/flag-1.jpg"
                            width="40"
                            height="40px"
                          />
                        </div>
                        <div class="col-lg-10">
                          <textarea
                            placeholder="Messages"
                            name="content"
                            style="height: 92px; margin-bottom: 16px"
                            class="form-control"
                            v-validate="'required'"
                            @input="changeInput()"
                            v-model="comment.content"
                          ></textarea>
                          <div style="color: red" role="alert">
                            {{ errors.first("content") }}
                          </div>
                          <div style="color: red" v-if="errorBackEnd.content">
                            <!-- {{ errorBackEnd.content[0] }} -->
                          </div>
                          <button type="submit" class="site-btn">
                            Send message
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <Loader :flag-show="flagShowLoader"></Loader>
    <!-- Contact Section End -->
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
import Loader from "../../Common/loader.vue";
import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000

      exchangeReviews: [],
      comment: {
        images: "",
        content: "",
      },

      idProduct: "",
      // showImage: "",

      exchangeReviewReplys: [],
      exchangeReviewReply: {
        nameRep: "",
        images: "",
        contentRep: "",
      },

      replySecond: {
        nameRep: "",
        images: "",
        product_id: "",
        contentRep: "",
      },

      errorBackEnd: {}, //Lỗi bên backend laravel
      page: 1,
      paginate: 5,
      flagShowLoader: false,

      idFormReplyFirst: "",
      statusReplyFirst: false,

      idFormexchangeReviewFirst: "",
      statusExchangeReviewFirst: false,

      codeFormReplySecond: "",
      idFormReplySecond: "",
      statusReplySecond: false,
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
    // this.fillImage();
  },
  components: {
    Loader,
  },
  mounted() {
    this.fetchData();
    // this.fillImage();
  },
  methods: {
    deltetExchangeReview(code, id) {
      let that = this;
      let formData = new FormData();
      formData.append("codeExchangeReview", code);
      formData.append("idExchangeReview", id);
      this.$swal({
        title: "Do you want to delete ？",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
      }).then((result) => {
        if (result.value) {
          axios
            .post(`/exchangeReview/delete`, formData)
            .then((response) => {
              this.$swal({
                title: "Delete successfully!",
                icon: "success",
                confirmButtonText: "OK!",
              }).then(function (confirm) {});
              that.fetchData();
            })
            .catch((error) => {
              that.flashMessage.error({
                message: "Delete Failure!",
                icon: "/backend/icon/error.svg",
                blockClass: "text-centet",
              });
            });
        }
      });
    },
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    codeReplySecond(code) {
      this.codeFormReplySecond = code;
      this.statusReplySecond == true;
    },

    idReplySecond(id) {
      this.idFormReplySecond = id;
    },

    replyFirst(id) {
      this.idFormReplyFirst = id;
      this.statusReplyFirst == true;
    },
    exchangeReviewFirst(id) {
      this.idFormexchangeReviewFirst = id;
      this.statusExchangeReviewFirst == true;

      let that = this;
      this.flagShowLoader = true;
      var url = `/get-exchangeReviewReply/${id}`;
      axios
        .get(url)
        .then(function (response) {
          that.exchangeReviewReplys = response.data.exchangeReviews; //show data ra
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
    fetchData() {
      let that = this;
      this.flagShowLoader = true;
      var url =
        "/get-exchange-review/" +
        "?page=" +
        this.page +
        "&paginate=" +
        this.paginate;
      axios
        .get(url)
        .then(function (response) {
          that.exchangeReviews = response.data.exchangeReviews; //show data ra
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

    addExchangeReview() {
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          axios
            .post(`/contact/add-exchange-review`, this.comment)
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

    repexchangeReviewFirst(id) {
      let that = this;
      let formData = new FormData();
      // formData.append("name", this.comment.name);
      formData.append("repExchangeReview", this.exchangeReviewReply.contentRep);
      axios
        .post(`/reply-exchange-review/${id}`, formData)
        .then((response) => {
          that.$swal({
            title: response.data,
            icon: "success",
            confirmButtonText: "OK!",
          });
          that.exchangeReviewReply.contentRep = "";
          that.statusExchangeReviewFirst = !this.statusExchangeReviewFirst;
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
    repexchangeReviewsecond(id) {
      let formData = new FormData();
      formData.append("repExchangeReview", this.replySecond.contentRep);
      axios
        .post(`/reply-exchange-review-second/${id}`, formData)
        .then((response) => {
          this.$swal({
            title: response.data,
            icon: "success",
            confirmButtonText: "OK!",
          });
          this.replySecond.contentRep = "";
          // this.statusExchangeReviewFirst = !this.statusExchangeReviewFirst;
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

    // fillImage() {
    //   axios.post(`/fill-image`).then(function (response) {
    //     this.showImage = response.data.image;
    //     console.log("ẢNh", this.showImage);
    //   });
    // },
  },
};
</script>
