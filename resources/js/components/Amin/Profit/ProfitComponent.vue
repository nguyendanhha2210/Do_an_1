<template>
  <div>
    <div class="table-agile-info">
      <div class="panel panel-default">
        <div class="panel-heading">
          Lợi Nhuận : <b style="color: red"> {{ formatPrice(amount) }}</b>
        </div>
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
              <td><input type="date" name="time1" v-model="time1" /></td>
              <td rowspan="2">
                <button type="submit" class="btn btn-danger">Lọc</button>
              </td>
            </tr>
            <tr>
              <td>To date:</td>
              <td>
                <input class="mt-2" type="date" name="time2" v-model="time2" />
              </td>
              <td></td>
            </tr>
          </table>
        </form>
        <br />
        <div class="table-responsive">
          <table class="table table-striped b-t b-light text-center">
            <thead>
              <tr>
                <th>STT</th>
                <th>Order Code</th>
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

    <div
      class="modal fade bd-example-modal-lg"
      tabindex="-1"
      role="dialog"
      aria-labelledby="myLargeModalLabel"
      aria-hidden="true"
      id="myModal"
    ></div>
    <Loader :flag-show="flagShowLoader"></Loader>
    <FlashMessage :position="'left bottom'"></FlashMessage>
  </div>
</template>

<script>
import axios from "axios";
import Loader from "../../Common/loader.vue";
import Modal from "../../Modal/Modal.vue";
import Vue from "vue";
export default {
  data() {
    return {
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
    };
  },
  created() {
    this.fetchProfits();
  },
  components: {
    Modal,
    Loader,
  },
  watch: {
    paginate: function (value) {
      this.fetchProfits();
    },
    keyword: function (value) {
      this.fetchProfits();
    },
  },
  methods: {
    //Hiển thị dữ liệu
    fetchProfits() {
      let that = this;
      this.flagShowLoader = true;
      let formData = new FormData();
      formData.append("keyword", this.keyword);
      formData.append("time1", this.time1);
      formData.append("time2", this.time2);
      formData.append("page", this.page);
      formData.append("paginate", this.paginate);
      axios.post("get-profit", formData).then(function (response) {
        that.profits = response.data.profits; //show data ra
        that.amount = response.data.amount;
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
      this.fetchProfits();
    },
    searchDate() {
      this.keyword = "";
      // this.fetchProfits();
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
  },
};
</script>