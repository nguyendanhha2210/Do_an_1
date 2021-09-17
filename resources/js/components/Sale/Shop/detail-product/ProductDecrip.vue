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
            <a data-toggle="tab" href="#tab-3" role="tab"
              >Customer Reviews ({{ this.count }})</a
            >
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
                <div class="col-lg-7">
                  <textarea
                    style="
                      padding-left: 10px;
                      border: none;
                      transform: translate(4%, -6%);
                    "
                    readonly
                    cols="51"
                    rows="11"
                  >
                      {{ decrip[0].content }}
                  </textarea>
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
              <table>
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
                    <div class="p-price">{{ decrip[0].price }} vnđ</div>
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
              class="d-flex justify-content-center row"
              v-for="comment in comments.data"
              :key="comment.id"
            >
              <div class="col-md-12">
                <div class="d-flex flex-column comment-section" id="myGroup">
                  <div class="bg-white p-2">
                    <div class="d-flex flex-row user-info">
                      <img
                        class="rounded-circle"
                        :src="baseUrl + '/uploads/' + comment.images"
                        width="40px"
                        height="40px"
                        alt=""
                      />
                      <div
                        class="d-flex flex-column justify-content-start ml-2"
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
                    class="bg-white p-2"
                    style="transform: translate(-1%, -45%)"
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
                          commentFirst(comment.id);
                          statusCommentFirst = !statusCommentFirst;
                          statusReplyFirst = !statusReplyFirst;
                        "
                        class="like p-2 cursor action-collapse"
                        data-toggle="collapse"
                        aria-expanded="true"
                        aria-controls="collapse-2"
                        href="#collapse-2"
                      >
                        <i class="fa fa-commenting-o"></i
                        ><span class="ml-1">Comment (...)</span>
                      </div>
                    </div>
                  </div>
                  <div
                    v-if="idFormReplyFirst == comment.id && statusReplyFirst"
                    id="collapse-1"
                    class="bg-light collapse"
                    style="transform: translate(1%, -24%)"
                    data-parent="#myGroup"
                  >
                    <form
                      @submit.prevent="repCommentFirst(comment.id)"
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
                          class="form-control ml-1 shadow-none textarea"
                          v-validate="'required'"
                          @input="changeInput()"
                          v-model="commentReply.contentRep"
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
                v-if="idFormCommentFirst == comment.id && statusCommentFirst"
              >
                <div
                  class="d-flex flex-column comment-section"
                  id="myGroup"
                  v-for="commentReply in commentReplys"
                  :key="commentReply.id"
                >
                  <div class="bg-white p-2">
                    <div class="d-flex flex-row user-info">
                      <img
                        class="rounded-circle"
                        :src="baseUrl + '/uploads/' + commentReply.images"
                        width="40px"
                        height="40px"
                        alt=""
                      />
                      <div
                        class="d-flex flex-column justify-content-start ml-2"
                      >
                        <span class="d-block font-weight-bold name">{{
                          commentReply.name
                        }}</span
                        ><span class="date text-black-50">{{
                          commentReply.created_at | formatDate
                        }}</span>
                      </div>
                    </div>
                    <div class="mt-2">
                      <p class="comment-text">
                        {{ commentReply.content }}
                      </p>
                    </div>
                  </div>
                  <div
                    class="bg-white p-2"
                    style="transform: translate(-1%, -45%)"
                  >
                    <div class="d-flex flex-row fs-12">
                      <div
                        @click="
                          codeReplySecond(commentReply.code);
                          idReplySecond(commentReply.id);
                          statusReplySecond = !statusReplySecond;
                        "
                        class="like p-2 cursor action-collapse"
                        data-toggle="collapse"
                        aria-expanded="true"
                        aria-controls="collapse-1"
                        href="#collapse-1"
                      >
                        <i class="fa fa-reply"></i
                        ><span class="ml-1">Reply</span>
                      </div>
                    </div>
                  </div>

                  <!-- Show Comment Reply -->
                  <div class="bg-white p-2">
                    <div class="d-flex flex-row fs-12"></div>
                  </div>

                  <div
                    v-if="
                      codeFormReplySecond == commentReply.code &&
                      idFormReplySecond == commentReply.id &&
                      statusReplySecond
                    "
                    id="collapse-1"
                    class="bg-light collapse"
                    style="transform: translate(1%, -24%)"
                    data-parent="#myGroup"
                  >
                    <form
                      @submit.prevent="repCommentSecond(commentReply.code)"
                      class="comment-form"
                    >
                      <div class="d-flex flex-row align-items-start">
                        <img
                          class="rounded-circle"
                          :src="baseUrl + '/uploads/' + comments.images"
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
            <div v-if="comments != ''">
              <nav aria-label="Page navigation example">
                <paginate
                  v-model="page"
                  :page-count="parseInt(comments.last_page)"
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

            <div class="customer-review-option">
              <div class="leave-comment">
                <h4>Leave A Comment</h4>
                <form @submit.prevent="addComment()" class="comment-form">
                  <div class="row">
                    <div class="col-lg-1">
                      <img
                        class="rounded-circle"
                        :src="baseUrl + '/uploads/' + showImage"
                        width="40px"
                        height="40px"
                        alt=""
                      />
                      <img
                        class="rounded-circle"
                        src="/frontend/images/flag-1.jpg"
                        width="40"
                        height="40px"
                      />
                    </div>
                    <div class="col-lg-11">
                      <textarea
                        placeholder="Messages"
                        name="content"
                        class="form-control"
                        v-validate="'required'"
                        @input="changeInput()"
                        v-model="comment.content"
                      ></textarea>
                      <div style="color: red" role="alert">
                        {{ errors.first("content") }}
                      </div>
                      <div style="color: red" v-if="errorBackEnd.content">
                        {{ errorBackEnd.content[0] }}
                      </div>
                      <button type="submit" class="site-btn">
                        Send message
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <!-- <div class="customer-review-option">
              <h4>{{ this.count }} Comments</h4>
              <div class="comment-option">
                <div
                  class="co-item"
                  v-for="comment in comments.data"
                  :key="comment.id"
                >
                  <div class="avatar-pic">
                    <img src="img/product-single/avatar-1.png" alt="" />
                  </div>
                  <div class="avatar-text">
                    <h5>
                      {{ comment.name }}
                      <span>{{ comment.created_at | formatDate }}</span>
                    </h5>
                    <div class="at-reply">{{ comment.content }}</div>
                  </div>
                </div>
                <nav aria-label="Page navigation example">
                  <paginate
                    v-model="page"
                    :page-count="parseInt(comments.last_page)"
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

              <div class="leave-comment">
                <h4>Leave A Comment</h4>
                <form @submit.prevent="addComment()" class="comment-form">
                  <div class="row">
                    <div class="col-lg-12">
                      <input
                        type="text"
                        placeholder="Name"
                        name="name"
                        class="form-control"
                        v-validate="'required'"
                        @input="changeInput()"
                        v-model="comment.name"
                      />
                      <div style="color: red" role="alert">
                        {{ errors.first("name") }}
                      </div>
                      <div style="color: red" v-if="errorBackEnd.name">
                        {{ errorBackEnd.name[0] }}
                      </div>
                    </div>
                    <div class="col-lg-6"></div>
                    <div class="col-lg-12">
                      <textarea
                        placeholder="Messages"
                        name="content"
                        class="form-control"
                        v-validate="'required'"
                        @input="changeInput()"
                        v-model="comment.content"
                      ></textarea>
                      <div style="color: red" role="alert">
                        {{ errors.first("content") }}
                      </div>
                      <div style="color: red" v-if="errorBackEnd.content">
                        {{ errorBackEnd.content[0] }}
                      </div>
                      <button type="submit" class="site-btn">
                        Send message
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div> -->
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
import Loader from "../../../Common/loader.vue";
import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      decrip: this.decripProduct,

      comments: [],
      comment: {
        images: "",
        product_id: "",
        content: "",
      },
      idProduct: "",

      showImage: "",

      commentReplys: [],
      commentReply: {
        nameRep: "",
        images: "",
        product_id: "",
        contentRep: "",
      },

      replySecond: {
        nameRep: "",
        images: "",
        product_id: "",
        contentRep: "",
      },

      errorBackEnd: {}, //Lỗi bên backend laravel
      count: "",
      countReply: "",
      page: 1,
      paginate: 5,
      flagShowLoader: false,

      idFormReplyFirst: "",
      statusReplyFirst: false,

      idFormCommentFirst: "",
      statusCommentFirst: false,

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
  props: ["decripProduct"],
  mounted() {
    this.fetchData();
    this.fillImage();
    console.log("ANC", this.showImage);
  },
  methods: {
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
    commentFirst(id) {
      this.idFormCommentFirst = id;
      this.statusCommentFirst == true;

      let that = this;
      this.flagShowLoader = true;
      var url = `/get-commentReply/${id}`;
      axios
        .get(url)
        .then(function (response) {
          that.commentReplys = response.data.comments; //show data ra
          that.countReply = response.data.countReply; //show data ra
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
        "/get-comment/" +
        this.decrip[0].id +
        "?page=" +
        this.page +
        "&paginate=" +
        this.paginate;
      axios
        //   `/get-comment/${this.decrip[0].id}` +
        .get(url)
        .then(function (response) {
          that.comments = response.data.comments; //show data ra
          that.count = response.data.count; //show data ra
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
      // this.$validator.validateAll().then((valid) => {
      //   if (valid) {
      let that = this;
      let formData = new FormData();
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
      //   }
      // });
    },
    repCommentSecond(id) {
      // this.$validator.validateAll().then((valid) => {
      //   if (valid) {
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
          this.statusCommentFirst = !this.statusCommentFirst;
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
      //   }
      // });
    },

    fillImage() {
      axios.post("/fill-image").then(function (response) {
        this.showImage = response.data.image; //show data ra
      });
    },
  },
};
</script>