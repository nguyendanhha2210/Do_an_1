<template>
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
          <a class="btn btn-success btn-sm" :href="formAdd">Add New</a>
        </div>
        <div class="col-md-5 col-sm-3 col-5" style="float: right">
          <input type="text" class="form-control" v-model="search" />
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped b-t b-light text-center">
          <thead>
            <tr>
              <th>STT</th>
              <th>name</th>
              <th>desc</th>
              <th></th>
            </tr>
          </thead>
          <transition-group type="slide-fade" tag="tbody">
            <tr v-for="(data, index) in categoryPosts.data" :key="data.id">
              <th scope="row">{{ index + 1 }}</th>
              <td>
                {{ data.name }}
              </td>
              <td>
                {{ data.desc }}
              </td>
              <td>
                <div class="td-action">
                  <a
                    :href="`category-post/${data.id}/edit`"
                    style="font-size: 21px; transform: translate(-26%, -14%)"
                    ><i
                      class="fa fa-pencil-square-o text-success text-active"
                    ></i
                  ></a>
                  <i
                    class="fa fa-times-circle"
                    style="font-size: 21px; color: red"
                    aria-hidden="true"
                    @click="deleteCategoryPost(data.id)"
                  ></i>
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
        :page-count="parseInt(categoryPosts.last_page)"
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

    <Loader :flag-show="flagShowLoader"></Loader>
    <FlashMessage :position="'left bottom'"></FlashMessage>
  </div>
</template>

<style lang="scss" scoped>
.td-action {
  display: inline-flex;
}
.btn-success {
  float: right;
  margin-top: 10px;
  margin-right: 7%;
}
</style>

<script>
import Loader from "../../Common/loader.vue";
import Modal from "../../Modal/Modal.vue";
import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      categoryPosts: [],
      category: {
        name: "",
        desc: "",
      },
      errorBackEnd: {}, //Lỗi bên backend laravel
      page: 1,
      paginate: 5,
      search: "",
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
    };
  },
  created() {
    this.fetchData();
  },
  watch: {
    paginate: function (value) {
      this.fetchData();
    },
    search: function (value) {
      this.fetchData();
    },
  },
  props: ["formAdd"],
  mounted() {},
  components: {
    Modal,
    Loader,
  },
  methods: {
    fetchData() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .get(
          "get-category-post?page=" +
            that.page +
            "&paginate=" +
            that.paginate +
            "&search=" +
            that.search
        )
        .then(function (response) {
          that.categoryPosts = response.data; //show data ra
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
      if (this.categoryPosts.prev_page_url) {
        this.page--;
        this.fetchData();
      }
    },
    next() {
      if (this.categoryPosts.next_page_url) {
        this.page++;
        this.fetchData();
      }
    },

    changePage(page) {
      this.page = page;
      this.fetchData();
    },

    deleteCategoryPost(id) {
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
            .get(`category-post/${id}/delete`)
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
  },
};
</script>
