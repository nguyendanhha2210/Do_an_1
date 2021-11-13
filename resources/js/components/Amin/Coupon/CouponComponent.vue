<template>
  <div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading"></div>
      <div class="row w3-res-tb">
        <div for="paginate" class="col-md-3 col-sm-2 col-4">
          <select
            v-model="paginate"
            class="form-control w-sm inline v-middle text-center"
          >
            <option
              v-for="item in limitNumber"
              :key="item.key"
              :value="item.key"
            >
              {{ item.value }}
            </option>
          </select>
        </div>
        <div
          class="col-md-6 col-sm-7 col-3 float-left"
          style="transform: translate(0%, -18%)"
        >
          <a class="btn btn-success btn-sm" :href="addSend"
            >Add for Send Mail</a
          >
          <a
            class="btn btn-success btn-sm"
            style="background-color: #008080"
            :href="addShow"
            >Add to Show for Customer</a
          >
        </div>
        <div class="col-md-3 col-sm-3 col-5" style="float: right">
          <input
            type="text"
            class="form-control"
            placeholder="Search with name"
            v-model="search"
          />
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped b-t b-light text-center">
          <thead>
            <tr>
              <th>STT</th>
              <th>Name</th>
              <th scope="col" class="text-center">
                <a href="#" @click.prevent="change_sort('time')">Quality</a>
                <span v-if="sort_direction == 'desc' && sort_field == 'time'"
                  >&uarr;</span
                >
                <span v-if="sort_direction == 'asc' && sort_field == 'time'"
                  >&darr;</span
                >
              </th>
              <th>Status</th>
              <th>Decrease</th>
              <th>Code</th>
              <th scope="col" class="text-center">
                <a href="#" @click.prevent="change_sort('start_date')"
                  >Start Date</a
                >
                <span
                  v-if="sort_direction == 'desc' && sort_field == 'start_date'"
                  >&uarr;</span
                >
                <span
                  v-if="sort_direction == 'asc' && sort_field == 'start_date'"
                  >&darr;</span
                >
              </th>
              <th scope="col" class="text-center">
                <a href="#" @click.prevent="change_sort('end_date')"
                  >End Date</a
                >
                <span
                  v-if="sort_direction == 'desc' && sort_field == 'end_date'"
                  >&uarr;</span
                >
                <span v-if="sort_direction == 'asc' && sort_field == 'end_date'"
                  >&darr;</span
                >
              </th>
              <th>Limit</th>
              <th></th>
            </tr>
          </thead>
          <transition-group type="slide-fade" tag="tbody">
            <tr v-for="(data, index) in coupons.data" :key="data.id">
              <th scope="row">{{ index + 1 }}</th>
              <td>
                {{ substring(data.name, 12) }}
              </td>
              <td v-if="data.time > 0">
                {{ data.time }}
              </td>
              <td v-else>
                <b style="color: red">Hết !</b>
              </td>
              <td>
                <span class="text-ellipsis">
                  <a
                    href="javascript:;"
                    v-if="
                      data.status == 0 &&
                      data.end_date > todayDate &&
                      data.time > 0
                    "
                    @click="activeStatus(data)"
                    ><span class="fa-thumb-styling fa fa-thumbs-up"></span
                  ></a>
                  <a
                    href="javascript:;"
                    v-else-if="
                      data.status == 1 &&
                      data.end_date > todayDate &&
                      data.time > 0
                    "
                    @click="activeStatus(data)"
                    ><span class="fa-thumb-styling fa fa-thumbs-down"></span
                  ></a>
                  <a href="javascript:;" v-else-if="data.time < 1"
                    ><span
                      class="fa fa-thumbs-down"
                      style="color: #808080"
                    ></span
                  ></a>

                  <a href="javascript:;" v-else-if="data.status == 3">
                    <b style="color: blue">Đã Gửi</b></a
                  >

                  <a href="javascript:;" v-else></a>
                </span>
              </td>

              <td v-if="data.condition == 1">-{{ data.number }} %</td>
              <td v-else>-{{ formatPrice(data.number) }} vnđ</td>

              <td>
                {{ data.code }}
              </td>
              <td>
                {{ data.start_date }}
              </td>
              <td>
                {{ data.end_date }}
              </td>
              <td v-if="data.end_date < todayDate">
                <b style="color: red">Hết Hạn</b>
              </td>
              <td v-else>
                <b style="color: green">Còn Hạn</b>
              </td>
              <td>
                <div class="td-action">
                  <a
                    v-if="
                      data.status == 0 &&
                      data.time > 0 &&
                      data.statusSendShow == 2 &&
                      data.end_date > todayDate
                    "
                  >
                    <i
                      @click="viewCustomer(data.id)"
                      class="fa fa-user text-dark text-active"
                      style="font-size: 21px; transform: translate(-54%, -9%)"
                    ></i
                  ></a>

                  <a
                    v-if="
                      data.status == 0 &&
                      data.time > 0 &&
                      data.statusSendShow == 1 &&
                      data.end_date > todayDate
                    "
                  >
                    <i
                      @click="sendCustomer(data.id)"
                      class="fa fa-paper-plane text-success text-active"
                      style="font-size: 21px; transform: translate(-26%, -14%)"
                    ></i
                  ></a>

                  <a v-else-if="data.status == 3"> </a>
                  <a :href="`coupon/${data.id}/edit`">
                    <i
                      style="font-size: 21px"
                      class="fa fa-pencil-square-o text-primary text-active"
                    ></i
                  ></a>
                </div>
              </td>
            </tr>
          </transition-group>
        </table>
      </div>
    </div>
    <div v-if="coupons != ''">
      <nav aria-label="Page navigation example">
        <paginate
          v-model="page"
          :page-count="parseInt(coupons.last_page)"
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
      coupons: [],
      coupon: {
        name: "",
        time: "",
        condition: "",
        number: "",
        code: "",
      },
      todayDate: this.today,
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
      sort_direction: "desc",
      sort_field: "created_at",
      limitNumber: [],
    };
  },
  created() {
    this.fetchData();
    this.getLimitNumber();
  },
  watch: {
    paginate: function (value) {
      this.fetchData();
    },
    search: function (value) {
      this.fetchData();
    },
  },
  props: ["addSend", "addShow", "today"],
  mounted() {},
  components: {
    Modal,
    Loader,
  },
  methods: {
    change_sort(field) {
      if (this.sort_field == field) {
        this.sort_direction = this.sort_direction == "asc" ? "desc" : "asc";
      } else {
        this.sort_field = field;
      }
      this.fetchData(1);
    },
    sendCustomer(id) {
      let that = this;
      this.$swal({
        title: "Do you want to send ？",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes !",
        cancelButtonText: "No, cancel!",
      }).then((result) => {
        if (result.value) {
          axios
            .get(`coupon/${id}/send-customer`)
            .then((response) => {
              this.$swal({
                title: "Send Successfully!",
                icon: "success",
                confirmButtonText: "OK!",
              }).then(function (confirm) {});
              that.fetchData();
            })
            .catch((error) => {
              that.flashMessage.error({
                message: "Send Failure!",
                icon: "/backend/icon/error.svg",
                blockClass: "text-centet",
              });
            });
        }
      });
    },
    viewCustomer(id) {
      let that = this;
      this.$swal({
        title: "Do you want to show coupons to all customers ？",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes !",
        cancelButtonText: "No, cancel!",
      }).then((result) => {
        if (result.value) {
          axios
            .get(`coupon/${id}/view-customer`)
            .then((response) => {
              this.$swal({
                title: "Show Successfully!",
                icon: "success",
                confirmButtonText: "OK!",
              }).then(function (confirm) {});
              that.fetchData();
            })
            .catch((error) => {
              that.flashMessage.error({
                message: "Show Failure!",
                icon: "/backend/icon/error.svg",
                blockClass: "text-centet",
              });
            });
        }
      });
    },
    activeStatus(data) {
      let that = this;
      let formData = new FormData();
      formData.append("status", data.status);
      // formData.append("_method", "put");
      axios
        .post(`update-coupon-status/${data.id}`, formData, {
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
    fetchData() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .get(
          "get-coupon?page=" +
            that.page +
            "&paginate=" +
            that.paginate +
            "&search=" +
            that.search +
            "&sort_direction=" +
            that.sort_direction +
            "&sort_field=" +
            that.sort_field
        )
        .then(function (response) {
          that.coupons = response.data.coupons; //show data ra
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
      if (this.coupons.prev_page_url) {
        this.page--;
        this.fetchData();
      }
    },
    next() {
      if (this.coupons.next_page_url) {
        this.page++;
        this.fetchData();
      }
    },
    changePage(page) {
      this.page = page;
      this.fetchData();
    },
    deleteCoupon(id) {
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
            .get(`coupon/${id}/delete`)
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
    substring(str, value) {
      if (str.length <= value) {
        return str;
      } else {
        return str.slice(0, value) + "…";
      }
    },
    getLimitNumber() {
      axios.get(`/get-limit-number`).then((response) => {
        this.limitNumber = response.data;
      });
    },
  },
};
</script>
