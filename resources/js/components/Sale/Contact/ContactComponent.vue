<template>
  <div style="background-color: #e9edf0">
    <!-- Map Section Begin -->
    <div class="pt-5 pb-5">
      <div class="container" style="background-color: white">
        <div class="map-inner">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d133734.51705888164!2d105.7152809760182!3d21.06279575689283!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313454d615181497%3A0x171dfde04231e06f!2sCo%20Nhue%2C%20Bac%20Tu%20Liem%2C%20Hanoi%2C%20Vietnam!5e0!3m2!1sen!2s!4v1645812537186!5m2!1sen!2s"
            height="610"
            style="border: 0"
            allowfullscreen=""
            loading="lazy"
          ></iframe>

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
              rõ về cách mua hàng , đặt hàng bên chúng tôi.
            </p>
          </div>
          <div class="contact-widget">
            <div class="cw-item">
              <div class="ci-icon">
                <i class="ti-location-pin"></i>
              </div>
              <div class="ci-text">
                <span>Address:</span>
                <p>Cổ Nhuế - Bắc Từ Niêm - Hà Nội</p>
              </div>
            </div>
            <div class="cw-item">
              <div class="ci-icon">
                <i class="ti-mobile"></i>
              </div>
              <div class="ci-text">
                <span>Phone:</span>
                <p>0364401091</p>
              </div>
            </div>
            <div class="cw-item">
              <div class="ci-icon">
                <i class="ti-email"></i>
              </div>
              <div class="ci-text">
                <span>Email:</span>
                <p>nvnamphuong99@gmail.com</p>
              </div>
            </div>

            <div class="top-social mt-5 text-center">
              <a href="https://www.facebook.com/nvnp251999" target="_blank"
                ><img
                  style="width: 92px; height: 81px; margin-right: 27px"
                  :src="'/frontend/images/fb.png'"
                  alt=""
              /></a>
            </div>
          </div>
        </div>

        <div
          class="col-lg-6 offset-lg-1"
          style="background-color: white; padding: 15px 10px"
        ></div>
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
      showImage: "",

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
    this.fillImage();
  },
  components: {
    Loader,
  },
  mounted() {
    this.fetchData();
    this.fillImage();
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
        "/get-exchange-review?page=" + this.page + "&paginate=" + this.paginate;
      axios.get(url).then(function (response) {
        that.exchangeReviews = response.data.exchangeReviews; //show data ra
        that.flagShowLoader = false;
      });
      // .catch((err) => {
      //   switch (err.response.status) {
      //     case 500:
      //       that
      //         .$swal({
      //           title: "Error loading data !",
      //           icon: "warning",
      //           confirmButtonText: "Ok",
      //         })
      //         .then(function (confirm) {});
      //       break;
      //     default:
      //       break;
      //   }
      // });
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

    fillImage() {
      axios.post(`/sale/fill-image`).then((response) => {
        this.showImage = response.data.image;
      });
    },
  },
};
</script>
