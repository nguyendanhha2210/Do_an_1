<template>
  <div class="table-agile-info">
    <div class="panel panel-default">
      <div class="row w3-res-tb">
        <div for="paginate" class="col-md-3 col-sm-2 col-3">
          <select v-model="paginate" class="form-control w-sm inline v-middle text-center">
            <option
              v-for="item in limitNumber"
              :key="item.key"
              :value="item.key"
            >
              {{ item.value }}
            </option>
          </select>
        </div>
        <div class="col-md-4 col-sm-5 col-4"></div>
        <div class="col-md-1 col-sm-2 col-1">
          <b class="text-date">Email:</b>
        </div>

        <div class="col-md-4 col-sm-3 col-4 input-search">
          <input
            type="text"
            class="form-control"
            v-model="search"
            placeholder="Search"
          />
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th class="text-center">STT</th>
              <th class="text-center">Name</th>
              <th class="text-center">Email</th>
              <th class="text-center">Role</th>
              <th class="text-center">Registration Date</th>
              <th class="text-center"></th>
            </tr>
          </thead>
          <transition-group type="slide-fade" tag="tbody">
            <tr v-for="(user, index) in users.data" :key="user.id">
              <th scope="row" class="text-center">{{ index + 1 }}</th>
              <td class="text-center">
                {{ user.name }}
              </td>
              <td class="text-center">
                <a :href="`account/${user.id}/detail`"> {{ user.email }}</a>
              </td>
              <td class="text-center" v-if="user.role_id == 2">
                <b style="color: #00cc00">user</b>
              </td>
              <td class="text-center" v-else>
                <b style="color: #ffcc00">shipper</b>
              </td>
              <td class="text-center">
                {{ user.created_at | formatDate }}
              </td>

              <td>
                <div class="td-action">
                  <!-- <a :href="`type/${user.id}/edit`" v-if="user.role_id == 3">
                    <button class="btn btn-warning mr-1" type="button">
                      Edit
                    </button></a
                  > -->
                  <i
                    class="fa fa-times-circle"
                    style="font-size: 21px; color: red"
                    aria-hidden="true"
                    @click="singleDelete(user.id)"
                  ></i>
                </div>
              </td>
            </tr>
          </transition-group>
        </table>
      </div>
    </div>
    <div v-if="users != ''">
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
    </div>

    <div class="text-center" v-else style="color: red">There is no data !</div>
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
      users: [],
      user: {
        id: "",
        name: "",
        email: "",
        role_id: "",
        created_at: "",
      },
      errorBackEnd: {}, //Lỗi bên backend laravel
      page: 1,
      paginate: 5,
      search: "",
      role: "",
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
      limitNumber: [],
    };
  },
  created() {
    this.fetchData(1);
    this.getLimitNumber();
  },
  watch: {
    paginate: function (value) {
      this.fetchData(1);
    },
    search: function (value) {
      this.fetchData(1);
    },
    role: function (value) {
      this.fetchData(1);
    },
  },
  props: ["formAdd"],
  mounted() {},
  components: {
    Modal,
    Loader,
  },
  methods: {
    prev() {},
    next() {},
    chanePage: function (page) {},

    fetchData(page) {
      let that = this;
      this.flagShowLoader = true;
      axios
        .get("get-user", {
          params: {
            page: page,
            paginate: this.paginate,
            search: this.search,
            role: this.role,
          },
        })
        .then(function (response) {
          that.users = response.data; //show data ra
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
            .get(`user/${id}/delete`)
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
    getLimitNumber() {
      axios.get(`/get-limit-number`).then((response) => {
        this.limitNumber = response.data;
      });
    },
  },
};
</script>
