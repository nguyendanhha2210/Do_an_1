<template>
  <div>
    <div class="product-tab">
      <div class="tab-item">
        <ul class="nav" role="tablist">
          <li>
            <a class="active" data-toggle="tab" href="#tab-1" role="tab"
              >DESCRIPTION</a
            >
          </li>
          <li>
            <a data-toggle="tab" href="#tab-2" role="tab">SPECIFICATIONS</a>
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
          <div class="tab-pane fade-in active" id="tab-1" role="tabpanel">
            <div class="product-content">
              <div class="row">
                <div class="col-lg-7">
                  <p>
                    {{ decrip[0].content }}
                  </p>
                </div>
                <div class="col-lg-5">
                  <img
                    style="height: 250px"
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
            <div class="customer-review-option">
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
                        <!-- Lỗi validate bên vuejs-->
                      </div>
                      <div style="color: red" v-if="errorBackEnd.name">
                        {{ errorBackEnd.name[0] }}
                        <!-- Lỗi validate bên backend laravel-->
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
                        <!-- Lỗi validate bên vuejs-->
                      </div>
                      <div style="color: red" v-if="errorBackEnd.content">
                        {{ errorBackEnd.content[0] }}
                        <!-- Lỗi validate bên backend laravel-->
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
    <Loader :flag-show="flagShowLoader"></Loader>
  </div>
</template>

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
        name: "",
        images: "",
        product_id: "",
        content: "",
      },
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
        name: {
          required: "* Tên chưa nhập !",
        },
        content: {
          required: "* Nội dung chưa nhập !",
        },
      },
    };
    this.$validator.localize("en", messError);
    this.fetchData();
  },
  components: {
    Loader,
  },
  props: ["decripProduct"],
  mounted() {
    this.fetchData();
  },
  methods: {
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
              this.comment.name = "";
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
  },
};
</script>