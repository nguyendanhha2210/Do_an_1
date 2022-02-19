<template>
  <div style="background-color: #e9edf0">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 mt-3 mb-3" style="background-color: white">
          <div class="mt-3">
            <table
              class="table table-condensed"
              style="border: 1px solid #e9edf0"
            >
              <thead>
                <tr class="cart_menu" style="background-color: #e9edf0">
                  <td>Tên Mã</td>
                  <td>Số Lượt Dùng</td>
                  <td>Mã Code</td>
                  <td>Ngày Bắt Đầu</td>
                  <td>Ngày Kết Thúc</td>
                  <td></td>
                </tr>
              </thead>
              <tbody>
                <tr v-for="userCoupon in userCoupons" :key="userCoupon.id">
                  <td>{{ userCoupon.coupon_name }}</td>

                  <td v-if="userCoupon.coupon_time < 1">
                    <b style="color: red">Hết Mã</b>
                  </td>
                  <td v-else>{{ userCoupon.coupon_time }}</td>

                  <td style="color: blue">{{ userCoupon.coupon.code }}</td>
                  <td>{{ userCoupon.coupon.start_date | formatDate }}</td>
                  <td>{{ userCoupon.coupon.end_date | formatDate }}</td>
                  <td>
                    <b
                      style="color: red"
                      v-if="userCoupon.coupon.end_date < todayDate"
                      >Hết Hạn</b
                    >
                    <b style="color: green" v-else>Còn Hạn</b> <br />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
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
import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      userCoupons: [],
      userCoupon: {
        coupon_name: "",
        statusUse: "",
      },
      todayDate: this.today,
    };
  },
  created() {
    this.fetchData();
  },
  props: ["today"],
  methods: {
    fetchData() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .get("get-coupon")
        .then(function (response) {
          that.userCoupons = response.data;
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
  },
};
</script>