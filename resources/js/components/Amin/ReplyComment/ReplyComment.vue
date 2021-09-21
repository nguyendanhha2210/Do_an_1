<template>
  <div class="table-agile-info">
    <div class="panel panel-default">
      <div class="row w3-res-tb">
        <div class="col-md-2 col-sm-4 col-2" style="float: left">
          <div class="form-check form-check-inline">
            <label
              class="
                container-checkbox
                form-check-label
                align-items-center
                height-14
                p-0
              "
              for="checkAll"
            >
              <input
                v-model="isInputAll"
                class="form-check-input"
                type="checkbox"
                id="checkAll"
                name="checkAll"
                @click="checkAll" />
              <span class="checkmark"></span
            ></label>
          </div>
          <button
            class="btn border-radius-7"
            v-bind:class="{
              'btn-outline-secondary': !isBtnDeleteAll,
              'background-white': !isBtnDeleteAll,
              'btn-success': isBtnDeleteAll,
              disabled: !isBtnDeleteAll,
            }"
            @click="sendAll"
          >
            send
          </button>
        </div>
        <div for="paginate" class="col-md-3 col-sm-2 col-4">
          <select v-model="paginate" class="form-control w-sm inline v-middle">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
          </select>
        </div>
        <div class="col-md-2 col-sm-3 col-1" style="float: left"></div>
        <div class="col-md-5 col-sm-3 col-5" style="float: right">
          <input type="text" class="form-control" v-model="search" />
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th></th>
              <th class="text-center">STT</th>
              <th class="text-center">Product Id</th>
              <th class="text-center">Content</th>
              <th>Star Vote</th>
              <th class="text-center">Reply</th>
              <th class="text-center">Date</th>
              <th class="text-center"></th>
            </tr>
          </thead>
          <transition-group type="slide-fade" tag="tbody">
            <tr v-for="(evaluate, index) in evaluates" :key="evaluate.id">
              <td style="width: 5%">
                <div class="form-check form-check-inline">
                  <label
                    class="container-checkbox form-check-label height-17"
                    :for="`evaluate${index}`"
                  >
                    <input
                      class="form-check-input"
                      type="checkbox"
                      v-model="selectedIds"
                      :id="`evaluate${index}`"
                      name="category"
                      @change="updateCheckAll(evaluate.id)"
                      :disabled="evaluate.rank == 2"
                      :value="evaluate.id" />
                    <span class="checkmark"></span
                  ></label>
                </div>
              </td>
              <th scope="row" class="text-center">{{ index + 1 }}</th>
              <td class="text-center">
                {{ evaluate.product_id }}
              </td>
              <td>
                {{ evaluate.content }}
              </td>

              <td>
                <star-rating
                  read-only
                  :star-size="15"
                  :increment="1"
                  v-model="evaluate.star_vote"
                ></star-rating>
              </td>

              <td v-if="evaluate.rank == 2">
                {{ evaluate.reply_comment }}
              </td>
              <td v-else>
                <form role="form" @submit.prevent="singleReply(evaluate.id)">
                  <textarea
                    name="contentReply"
                    cols="30"
                    rows="4"
                    v-validate="'required'"
                    :ref="`comment${evaluate.id}`"
                  >
FreshMama cảm ơn anh/chị đã dành lời khen cho shop. Đây sẽ là nguồn động lực lớn để FreshMama ngày càng hoàn thiện hơn và cho ra mắt thêm nhiều sản phẩm mới. Hy vọng anh/chị luôn tin tưởng và đồng hành cùng shop trong thời gian sắp tới ạ. FreshMama cám ơn rất nhiều ❣️</textarea
                  >
                  <div style="color: red" role="alert">
                    {{ errors.first("contentReply") }}
                  </div>
                  <button type="submit" class="btn btn-info">Send</button>
                </form>
              </td>
              <td>
                {{ evaluate.created_at | formatDate }}
              </td>
              <td v-if="evaluate.rank == 2">
                <i
                  style="font-size: 20px; color: green"
                  class="fa fa-check"
                  aria-hidden="true"
                ></i>
              </td>
              <td v-else>
                <b style="color: red">Not answered</b>
              </td>
            </tr>
          </transition-group>
        </table>
      </div>
    </div>
    <footer class="panel-footer">
      <div class="row">
        <div class="col-sm-5 text-center">
          <small
            class="text-muted inline m-t-sm m-b-sm"
            style="float: inherit; font-size: 16px"
            >showing {{ numberOfFirstRecord }}-{{ numberOfPage }} of
            {{ totalNumber }} items</small
          >
        </div>
      </div>
    </footer>
    <nav aria-label="Page navigation example">
      <paginate
        :page-count="lastPage"
        :container-class="'pagination d-flex justify-content-center mt-3'"
        :page-class="'page-item'"
        :page-link-class="'page-link'"
        :prev-class="'page-item prev-item'"
        :prev-link-class="'page-link'"
        :next-class="'page-item next-item'"
        :next-link-class="'page-link'"
        :prev-text="'<span><img src=\'/images/icons/angle-left.svg\'></span>'"
        :next-text="'<span><img src=\'/images/icons/angle-right.svg\'></span>'"
        :click-handler="fetchData"
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
import StarRating from "vue-star-rating";
import Loader from "../../Common/loader.vue";
import Modal from "../../Modal/Modal.vue";
import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      evaluates: [],
      evaluate: {
        user_id: "",
        order_code: "",
        product_id: "",
        star_vote: "",
        content: "",
        reply_comment: "",
        created_at: "",
      },
      update_comment: [],

      contentReply:
        "FreshMama cảm ơn anh/chị đã dành lời khen cho shop. Đây sẽ là nguồn động lực lớn để FreshMama ngày càng hoàn thiện hơn và cho ra mắt thêm nhiều sản phẩm mới. Hy vọng anh/chị luôn tin tưởng và đồng hành cùng shop trong thời gian sắp tới ạ. FreshMama cám ơn rất nhiều ❣️",

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
      currentPage: "",
      numberOfFirstRecord: "",
      numberOfPage: "",
      totalNumber: "",
      lastPage: 0,
      isBtnDeleteAll: false,
      isInputAll: false,
      selectedIds: [],
    };
  },
  created() {
    let messError = {
      custom: {
        contentReply: {
          required: "* Nội dung chưa nhập",
        },
      },
    };
    this.$validator.localize("en", messError);
    this.fetchData(1);
  },
  watch: {
    paginate: function (value) {
      this.fetchData(1);
    },
    search: function (value) {
      this.fetchData(1);
    },
  },
  props: ["data"],
  mounted() {},
  components: {
    Modal,
    Loader,
    StarRating,
  },
  methods: {
    checkAll: function () {
      this.isInputAll = !this.isInputAll;
      this.selectedIds = [];
      this.update_comment = [];
      if (this.isInputAll) {
        this.evaluates.forEach((item, index) => {
          if (typeof this.$refs["comment" + item.id] != "undefined") {
            var comment = {
              id: item.id,
              content: this.$refs["comment" + item.id][0].value,
            };
            this.selectedIds.push(item.id);
            this.update_comment.push(comment);
          }
          this.isBtnDeleteAll = true;
        });
      } else {
        this.isBtnDeleteAll = false;
      }
    },

    updateCheckAll: function (id) {
      if (!this.selectedIds.includes(id)) {
        this.update_comment = this.update_comment.filter(
          (item) => item.id !== id
        );
      } else {
        this.update_comment.push({
          id: id,
          content: this.$refs["comment" + id][0].value,
        });
      }
      if (this.selectedIds.length > 0) {
        this.isBtnDeleteAll = true;
        if (this.selectedIds.length == this.evaluates.length) {
          //nếu chọn tất cả thì ô check tất cả trên sáng
          this.isInputAll = true;
        } else {
          this.isInputAll = false;
        }
      } else {
        this.isBtnDeleteAll = false;
      }
    },

    sendAll() {
      let that = this;
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          this.$swal({
            title: "Do you want to Send ？",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
          }).then((result) => {
            if (result.value) {
              axios
                .post(`all-send`, {
                  comments: this.update_comment,
                })
                .then((response) => {
                  that
                    .$swal({
                      title: "Reply successfully!",
                      icon: "success",
                      confirmButtonText: "OK!",
                    })
                    .then(function (confirm) {
                      window.location.href = "/admin/replyComment";
                    });
                })
                .catch((error) => {
                  that.flashMessage.error({
                    message: "Reply Failure!",
                    icon: "/backend/icon/error.svg",
                    blockClass: "text-centet",
                  });
                });
            }
          });
        }
      });
    },

    prev() {},
    next() {},
    chanePage: function (page) {},

    fetchData(page) {
      let that = this;
      this.flagShowLoader = true;
      axios
        .get("get-replyComment", {
          params: {
            page: page,
            paginate: this.paginate,
            search: this.search,
          },
        })
        .then(function (response) {
          that.evaluates = response.data.data; //show data ra
          that.flagShowLoader = false;
          that.totalNumber = response.data.total; //Tổng số sp có
          that.currentPage = response.data.current_page; //Trang hiện hành
          that.numberOfFirstRecord = response.data.from; //Thứ tự sp đầu của 1 trang
          that.numberOfPage = response.data.to; //Thứ tự sp cuối của 1 trang
          that.lastPage = response.data.last_page;
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

    singleDelete(id) {
      let that = this;
    },

    singleReply(id) {
      let that = this;
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          this.$swal({
            title: "Do you want to Send ？",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
          }).then((result) => {
            if (result.value) {
              let formData = new FormData();
              formData.append("id", id);
              formData.append("contentReply", that.contentReply);
              axios
                .post(`single-send`, formData)
                .then((response) => {
                  that
                    .$swal({
                      title: "Reply successfully!",
                      icon: "success",
                      confirmButtonText: "OK!",
                    })
                    .then(function (confirm) {});
                  that.fetchData(1);
                })
                .catch((error) => {
                  that.flashMessage.error({
                    message: "Reply Failure!",
                    icon: "/backend/icon/error.svg",
                    blockClass: "text-centet",
                  });
                });
            }
          });
        }
      });
    },
  },
};
</script>
