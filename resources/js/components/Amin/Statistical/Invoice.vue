<template>
  <div class="table-agile-info">
    <div class="row pb-3">
      <div class="col-md-12 col-xs-12">
        <h3 class="text-center">Profit</h3>
        <BarChart v-if="show" :data="chartProfits" />
      </div>
      <div class="col-md-12 col-xs-12">
        <button
          class="btn btn-success"
          style="float: right; margin-top: 10px; margin-left: 15px"
          @click="
            flag = !flag;
            flag1 = false;
          "
        >
          Filter the date
        </button>
        <button
          class="btn btn-success"
          style="float: right; margin-top: 10px"
          @click="
            flag1 = !flag1;
            flag = false;
          "
        >
          From date to date
        </button>
        <form v-if="flag" action="">
          <div style="width: 400px; margin-top: 10px">
            <label for="">Nhập ngày: </label>
            <input
              style="width: 210px"
              type="text"
              v-model="keyword"
              name="keyword"
            />
          </div>
        </form>
        <form @submit.prevent="searchDate()" v-if="flag1" action="">
          <br />
          <table style="width: 320px">
            <tr>
              <td>From date:</td>
              <td>
                <date-picker
                  v-model="time1"
                  type="date"
                  :lang="lang"
                  :disabled-date="disabledAfterEndTime"
                  class="mt-2"
                ></date-picker>
              </td>
              <td rowspan="2">
                <button type="submit" class="btn btn-danger">Lọc</button>
              </td>
            </tr>
            <tr>
              <td>To date:</td>
              <td>
                <date-picker
                  v-model="time2"
                  type="date"
                  :lang="lang"
                  :disabled-date="disabledAfterToday"
                  class="mt-2"
                ></date-picker>
              </td>
              <td></td>
            </tr>
          </table>
        </form>
        <br />
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="panel-heading">
          Total :
          <b style="color: red"> {{ formatPrice(amount) }}</b>
        </div>
        <div class="table-responsive">
          <table class="table table-striped b-t b-light text-center">
            <thead>
              <tr>
                <th>STT</th>
                <th>Order Detail</th>
                <th>Revenue</th>
                <th>Cost</th>
                <th>Profit</th>
                <th>Date</th>
              </tr>
            </thead>
            <transition-group type="slide-fade" tag="tbody">
              <tr v-for="(data, index) in profits.data" :key="data.id">
                <th scope="row">{{ index + 1 }}</th>
                <td>
                  <a :href="`order/${data.order_code}/detail`">
                    {{ data.order_code }}</a
                  >
                </td>
                <td>
                  {{ formatPrice(data.revenue) }}
                </td>
                <td>
                  {{ formatPrice(data.cost) }}
                </td>
                <td>
                  {{ formatPrice(data.profit) }}
                </td>
                <td>
                  {{ data.date }}
                </td>
              </tr>
            </transition-group>
          </table>
        </div>
        <div class="loading-more" v-if="profits != ''">
          <nav aria-label="Page navigation example">
            <paginate
              v-model="page"
              :page-count="parseInt(profits.last_page)"
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

        <div class="text-center" v-else style="color: red">
          There is no data !
        </div>
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
    </div>
  </div>
</template>

<style lang="scss" scoped>
.list_views {
  margin: 10px 0;
  color: #fff;
}

.list_views a {
  color: orange;
  font-weight: 400;
}
</style>

<script>
import moment from "moment-timezone";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import "vue2-datepicker/locale/en";
import Loader from "../../Common/loader.vue";
import Modal from "../../Modal/Modal.vue";
import BarChart from "../../Common/Chart/BarChart.vue";
const axios = require("axios").default;

export default {
  data() {
    return {
      chartProfits: [],
      show: false,
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      flagShowLoader: false,

      flag: false,
      flag1: false,
      amount: 0,
      keyword: "",
      time1: "",
      time2: "",

      profits: [],
      profit: {
        id: "",
        order_code: "",
        revenue: "",
        cost: "",
        profit: "",
        code: "",
      },
      todayDate: this.today,
      errorBackEnd: {}, //Lỗi bên backend laravel
      page: 1,
      paginate: 5,
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
      lang: "en",
    };
  },
  created() {
    this.fetchProfits();
  },
  mounted() {},
  components: {
    Loader,
    Modal,
    BarChart,
    DatePicker,
  },
  watch: {
    paginate: function (value) {
      this.fetchProfits();
    },
    keyword: function (value) {
      this.show = false;
      this.fetchProfits();
    },
  },
  methods: {
    fetchProfits() {
      let that = this;
      this.flagShowLoader = true;
      let formData = new FormData();
      formData.append("keyword", this.keyword);
      formData.append(
        "time1",
        this.time1
          ? moment(this.time1).tz("Asia/Ho_Chi_Minh").format("YYYY-MM-DD")
          : ""
      );
      formData.append(
        "time2",
        this.time2
          ? moment(this.time2).tz("Asia/Ho_Chi_Minh").format("YYYY-MM-DD")
          : ""
      );
      formData.append("page", this.page);
      formData.append("paginate", this.paginate);
      axios.post("get-profit-table", formData).then(function (response) {
        console.log("123", response.data.amount);
        that.profits = response.data.profits; //show data ra
        that.amount = response.data.amount;
        that.chartProfits = response.data.chart;
        that.show = true;
        that.flagShowLoader = false;
      });
      that.flagShowLoader = false;
    },

    searchKeyword() {
      //Nếu click vào nút Lọc trong search theo ngày thì sẽ gán lại 2 biến time1 và time2 về rỗng
      //Để tránh trường hợp 2 biến này có giá và truyền về controller rồi gọi lại hàm load.
      //lọc giữa 2 ngày cũng tương tự chỉ gán lại keyword về rỗng thôi
      this.time1 = "";
      this.time2 = "";
      this.show = false;
      this.fetchProfits();
      // this.fetchChart();
    },
    searchDate() {
      this.keyword = "";
      this.show = false;
      this.fetchProfits();
    },
    prev() {
      if (this.profits.prev_page_url) {
        this.page--;
        this.fetchProfits();
      }
    },
    next() {
      if (this.profits.next_page_url) {
        this.page++;
        this.fetchProfits();
      }
    },

    changePage(page) {
      this.page = page;
      this.fetchProfits();
    },
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " đ";
    },
    disabledAfterToday(date) {
      return date > new Date(new Date()) || date < moment(this.time1);
    },
    disabledAfterEndTime(date) {
      return date > moment(this.time2);
    },
  },
};
</script>
