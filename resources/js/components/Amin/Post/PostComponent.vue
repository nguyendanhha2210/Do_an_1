m<template>
  <div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading"></div>
      <div class="row w3-res-tb">
        <div for="paginate" class="col-md-3 col-sm-2 col-4">
          <select v-model="paginate" class="form-control w-sm inline v-middle">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
          </select>
        </div>
        <div class="col-md-4 col-sm-7 col-3" style="float: left">
          <button
            style="background-color: green; color: white; height: 36px"
            type="button"
            class="btn btn-sm"
            data-toggle="modal"
            data-target="#myModal"
            data-whatever="@getbootstrap"
            v-if="buttonAdd"
            @click="edit = false"
          >
            Add New
          </button>
        </div>
        <div class="col-md-5 col-sm-3 col-5" style="float: right">
          <input
            type="text"
            class="form-control"
            v-model="search"
            placeholder="Search"
          />
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
                Import post information
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
              <form @submit.prevent="AddPost()" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="exampleInputEmail1">Title Post</label>
                  <input
                    type="text"
                    class="form-control"
                    id="exampleInputEmail1"
                    name="title"
                    v-validate="'required'"
                    v-model="post.title"
                  />

                  <div style="color: red" role="alert">
                    {{ errors.first("title") }}
                  </div>
                  <div style="color: red" v-if="errorBackEnd.title">
                    {{ errorBackEnd.title[0] }}
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Category_id</label>
                  <select v-model="post.id_category_post" class="form-control">
                    <option value="">Select post category</option>
                    <option
                      v-for="data in category_post"
                      :key="data.id"
                      :value="data.id"
                    >
                      {{ data.name }}
                    </option>
                  </select>
                  <div style="color: red" role="alert">
                    {{ errors.first("id_category_post") }}
                  </div>
                  <div style="color: red" v-if="errorBackEnd.id_category_post">
                    {{ errorBackEnd.id_category_post[0] }}
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Desc</label>
                  <input
                    type="text"
                    class="form-control"
                    id="exampleInputEmail1"
                    name="desc"
                    v-validate="'required'"
                    v-model="post.desc"
                  />
                  <div style="color: red" role="alert">
                    {{ errors.first("desc") }}
                  </div>
                  <div style="color: red" v-if="errorBackEnd.desc">
                    {{ errorBackEnd.desc[0] }}
                  </div>
                </div>

                <div class="form-group">
                  <div class="position-relative d-inline-block">
                    <label for="file_img_banner1">
                      <div class="img-drop-box mt-2 mr-2">
                        <img src ref="imageDispaly" class="img-thumbnail" />
                        <svg
                          width="45"
                          height="45"
                          viewBox="0 0 45 45"
                          style="
                            margin-top: 52px;
                            margin-left: 38%;
                            margin-right: 38%;
                          "
                          ref="iconFile"
                        >
                          <use
                            xlink:href="/images/Group_1287.svg#Group_1287"
                          ></use>
                        </svg>
                      </div>
                      <input
                        type="file"
                        id="file_img_banner1"
                        v-validate="'required|image_format'"
                        name="images"
                        ref="image"
                        v-on:change="attachImage"
                        accept="image/*"
                      />
                    </label>
                    <a
                      class="btn btn-light icon-close-white display-none"
                      style="background-color: black; border-radius: 91%"
                      ref="iconClose"
                      @click="deleteImage"
                    ></a>
                  </div>
                  <div style="color: red" role="alert">
                    {{ errors.first("images") }}
                  </div>
                  <div style="color: red" v-if="errorBackEnd.images">
                    {{ errorBackEnd.images[0] }}
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Content</label>
                  <input
                    type="text"
                    class="form-control"
                    id="exampleInputEmail1"
                    name="content"
                    v-validate="'required'"
                    v-model="post.content"
                  />
                  <div style="color: red" role="alert">
                    {{ errors.first("content") }}
                  </div>
                  <div style="color: red" v-if="errorBackEnd.content">
                    {{ errorBackEnd.content[0] }}
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
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped b-t b-light text-center">
          <thead>
            <tr>
              <th scope="col">STT</th>
              <th scope="col">Title</th>
              <th scope="col">Category</th>
              <th scope="col">Desc</th>
              <th scope="col">Images</th>
              <th scope="col">Status</th>
              <th scope="col">Content</th>
              <th scope="col">Views</th>
              <th>Action</th>
            </tr>
          </thead>
          <transition-group name="slide-fade" tag="tbody">
            <tr v-for="(data, index) in posts.data" :key="data.id">
              <th scope="row">{{ index + 1 }}</th>
              <td>
                {{ data.title }}
              </td>
              <td>
                {{ data.categorypost.name }}
              </td>
              <td>
                {{ data.desc }}
              </td>
              <td>
                <img
                  :src="baseUrl + '/uploads/' + data.images"
                  width="50px"
                  height="50px"
                  alt=""
                />
              </td>
              <td>
                <span class="text-ellipsis">
                  <a
                    href="javascript:;"
                    v-if="data.status == 0"
                    @click="activeStatus(data)"
                    ><span class="fa-thumb-styling fa fa-thumbs-up"></span
                  ></a>
                  <a href="javascript:;" v-else @click="activeStatus(data)"
                    ><span class="fa-thumb-styling fa fa-thumbs-down"></span
                  ></a>
                </span>
              </td>
              <td>
                {{ data.content }}
              </td>
              <td>
                {{ data.views }}
              </td>
              <td>
                <div class="td-action">
                  <button
                    type="button"
                    class="btn btn-warning mr-1"
                    data-toggle="modal"
                    data-target="#myModal"
                    @click="
                      updatePost(data), ((buttonAdd = false), (edit = true))
                    "
                  >
                    Edit
                  </button>

                  <button
                    type="button"
                    class="btn btn-danger"
                    @click="deletePost(data.id)"
                  >
                    Delete
                  </button>
                </div>
              </td>
            </tr>
          </transition-group>
        </table>
      </div>
    </div>

    <nav aria-label="Page navigation example">
      <paginate
        v-model="page"
        :page-count="parseInt(posts.last_page)"
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
    <loader :flag-show="flagShowLoader"></loader>
  </div>
</template>

<style lang="scss" scoped>
.td-action {
  display: inline-flex;
}
.btn-success {
  float: right;
  margin-top: 10px;
  margin-right: 5%;
}
</style>

<script>
import Loader from "../../Common/loader.vue";
const axios = require("axios").default;
export default {
  data() {
    return {
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      buttonAdd: true,
      posts: [],
      post: {
        id: "",
        title: "",
        id_category_post: "",
        desc: "",
        images: "",
        content: "",
        status: "",
        views: "",
      },
      errorBackEnd: {},
      edit: false,
      page: 1,
      paginate: 5,
      search: "",
      category_post: {},
      flagShowLoader: false,
    };
  },
  created() {
    let messError = {
      custom: {
        title: {
          required: "* Tiêu đề chưa nhập",
        },
        id_category_post: {
          required: "* Thể loại chưa chọn",
        },
        desc: {
          required: "* Mô tả chưa nhập",
        },
        images: {
          required: "* Ảnh chưa nhập",
          image_format: "* Ảnh chưa đúng định dạng",
        },
        content: {
          required: "* Nội dung chưa nhập",
        },
      },
    };
    this.$validator.localize("en", messError);
    this.fetchData();
    this.fill_Post();
  },
  mounted() {},
  components: {
    Loader,
  },
  watch: {
    paginate: function (value) {
      this.fetchData();
    },
    search: function (value) {
      this.fetchData();
    },
  },
  methods: {
    activeStatus(data) {
      let that = this;
      let formData = new FormData();
      formData.append("status", data.status);
      // formData.append("_method", "put");
      axios
        .post(`update-post-status/${data.id}`, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          this.$swal({
            title: "Update Status successfully!",
            icon: "success",
            confirmButtonText: "OK",
          }).then(function (confirm) {
            that.fetchData();
          });
        })
        .catch((err) => {
          that.flashMessage.error({
            message: "Update Status Failure!",
            icon: "/backend/icon/error.svg",
            blockClass: "text-centet",
          });
        });
    },

    fill_Post() {
      axios
        .get(`fill-post`, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          this.category_post = res.data.category_post;
        });
    },

    AddPost() {
      let that = this;
      if (this.edit == false) {
        let formData = new FormData();
        formData.append("title", this.post.title);
        formData.append("id_category_post", this.post.id_category_post);
        formData.append("desc", this.post.desc);
        formData.append("images", this.post.images);
        formData.append("status", this.post.status);
        formData.append("content", this.post.content);
        axios
          .post(`post-add`, formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((response) => {
            that.fetchData();
            that.flashMessage.setStrategy("multiple");
            that.flashMessage.success({
              message: "Thêm Thành Công !",
              icon: "/backend/icon/check.svg",
              blockClass: "text-centet",
            });
            that
              .$swal({
                title: "buttonAdd success!",
                icon: "success",
                showCancelButton: true,
                confirmButtonText: "Yes !",
                confirmButtonColor: "#3085d6",
                cancelButtonText: "Cancle !",
                cancelButtonColor: "#d33",
              })
              .then(function (confirm) {
                if (confirm.isConfirmed) {
                  that.product = {
                    title: "",
                    id_category_post: "",
                    desc: "",
                    images: "",
                    content: "",
                    views: "",
                  };
                } else {
                  window.location = response.data;
                }
              });
          })
          .catch((err) => {
            switch (err.response.status) {
              case 422:
                that.errorBackEnd = err.response.data.errors;
                break;
              case 500:
                that
                  .$swal({
                    title: "buttonAdd Failure Data!",
                    icon: "error",
                    confirmButtonText: "Ok",
                  })
                  .then(function (confirm) {});
                break;
              default:
                break;
            }
          });
      } else {
        let formData = new FormData();
        formData.append("title", this.post.title);
        formData.append("id_category_post", this.post.id_category_post);
        formData.append("desc", this.post.desc);
        formData.append("images", this.post.images);
        formData.append("status", this.post.status);
        formData.append("content", this.post.content);
        axios
          .post(`post/${that.post.id}/update`, formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((response) => {
            that.fetchData();
            that
              .$swal({
                title: "Update success!",
                icon: "success",
                confirmButtonText: "Yes !",
                confirmButtonColor: "#3085d6",
              })
              .then(function (confirm) {
                if (confirm.isConfirmed) {
                  that.buttonAdd = true;
                  (window.location = response.data),
                    (that.post = {
                      title: "",
                      id_category_post: "",
                      desc: "",
                      images: "",
                      status: "",
                      content: "",
                      views: "",
                    });
                } else {
                }
              });
          })
          .catch((err) => {
            switch (err.response.status) {
              case 422:
                that.errorBackEnd = err.response.data.errors;
                break;
              case 500:
                that
                  .$swal({
                    title: "Update Failure Data!",
                    icon: "error",
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

    fetchData() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .post(
          "get-post?page=" +
            that.page +
            "&paginate=" +
            that.paginate +
            "&search=" +
            that.search
        )
        .then(function (response) {
          that.posts = response.data;
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
      if (this.posts.prev_page_url) {
        this.page--;
        this.fetchData();
      }
    },
    next() {
      if (this.posts.next_page_url) {
        this.page++;
        this.fetchData();
      }
    },

    changePage(page) {
      this.page = page;
      this.fetchData();
    },

    updatePost(post) {
      this.post.id = post.id;
      this.post.title = post.title;
      if (post.images != "") {
        this.$refs.imageDispaly.src = this.baseUrl + "/uploads/" + post.images;
        this.$refs.imageDispaly.style.display = "block";
        this.$refs.iconClose.style.display = "block";
        this.$refs.iconFile.style.display = "none";
      }
      this.post.id_category_post = post.id_category_post;
      this.post.desc = post.desc;
      this.post.content = post.content;
      this.post.views = post.views;
    },

    deletePost(id) {
      let that = this;
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
            .get(`post/${id}/delete`)
            .then((response) => {
              this.$swal({
                title: "Delete successfully!",
                icon: "success",
                confirmButtonText: "OK",
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

    attachImage() {
      this.post.images = this.$refs.image.files[0];
      let reader = new FileReader();
      reader.addEventListener(
        "load",
        function () {
          this.$refs.imageDispaly.style.display = "block";
          this.$refs.iconClose.style.display = "block";
          this.$refs.imageDispaly.src = reader.result;
          this.$refs.iconFile.style.display = "none";
        }.bind(this),
        false
      );
      reader.readAsDataURL(this.post.images);
    },
    deleteImage() {
      this.post.images = "";
      this.$refs.imageDispaly.style.display = "none";
      this.$refs.iconClose.style.display = "none";
      this.$refs.image.value = "";
      this.$refs.iconFile.style.display = "block";
    },
  },
};
</script>
