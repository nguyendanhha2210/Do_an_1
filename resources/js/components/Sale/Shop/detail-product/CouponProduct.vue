<template>
  <div>
    <div
      class="filter-widget"
      style="background-color: white; margin-bottom: 10px"
    >
      <h4
        class="fw-title"
        style="
          margin-bottom: 16px;
          font-size: 20px;
          padding-left: 16px;
          padding-top: 10px;
        "
      >
        Add an Accessory :
      </h4>
      <table class="select-items">
        <tbody>
          <tr
            class="overflow"
            v-for="productAccessory in productAccessories"
            :key="productAccessory.id"
          >
            <td style="transform: translateY(-20%); padding-left: 17px">
              <input class="form-check-input" type="checkbox" name="" />
            </td>
            <td>
              <img
                style="width: 108px; height: 94px; padding-right: 3px"
                :src="baseUrl + '/uploads/products/' + productAccessory.images"
                alt=""
              />
            </td>

            <td>
              <div
                style="
                  float: left;
                  color: #e7ab3c;
                  overflow: hidden;
                  text-overflow: ellipsis;
                  -webkit-line-clamp: 1;
                  -webkit-box-orient: vertical;
                  display: -webkit-box;
                "
              >
                <b>
                  {{ productAccessory.name }}
                </b>
              </div>
              <br />

              <div>
                <b style="font-size: 14px; float: left; color: red">
                  {{ formatPrice(productAccessory.price) }} đ</b
                >
              </div>
              <br />
              <div>
                <i style="font-size: 14px; float: left"
                  >_{{ productAccessory.created_at | formatDate }}_</i
                >
              </div>
            </td>
          </tr>
          <tr>
            <td style="transform: translateY(-6%); padding-left: 17px">
              <input class="form-check-input" type="checkbox" name="" />
            </td>
            <td colspan="2">
              <button
                class="primary-btn pd-cart btn btn-success"
                style="height: 34px; padding-top: 6px; margin-top: 19px"
                href="#"
              >
                Add To List
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <hr />
    <div
      class="filter-widget"
      style="background-color: white; margin-bottom: 10px"
    >
      <h4
        class="fw-title"
        style="
          margin-bottom: 16px;
          font-size: 20px;
          padding-left: 16px;
          padding-top: 10px;
        "
      >
        Store Code Discount :
      </h4>
      <div class="overflow">
        <div
          class="coupon mt-2"
          v-for="couponStore in couponStores"
          :key="couponStore.id"
        >
          <div class="container" style="background-color: #fff4f4">
            <form role="form" @submit.prevent="saveCoupon(couponStore.id)">
              <div class="row">
                <div
                  class="col-lg-8 col-md-6 col-sm-6"
                  v-if="couponStore.coupon.condition == 1"
                >
                  <b>{{ couponStore.coupon.number }}% off Order</b><br />
                  <i style="font-size: 14px"
                    >HSD :
                    {{ couponStore.coupon.end_date | formatDateCoupon }}</i
                  >
                </div>
                <div class="col-lg-8 col-md-6 col-sm-6" v-else>
                  <b> {{ formatPrice(couponStore.coupon.number) }}đ off Order</b
                  ><br />
                  <i style="font-size: 14px"
                    >HSD :
                    {{ couponStore.coupon.end_date | formatDateCoupon }}</i
                  >
                </div>
                <div
                  class="col-lg-4 col-md-6 col-sm-6 text-center"
                  style="display: flex; align-items: center"
                >
                  <button
                    v-if="couponStore.statusUse == 3"
                    type="submit"
                    class="btn btn-success"
                  >
                    Save
                  </button>
                  <button
                    v-if="couponStore.statusUse == 4"
                    class="btn btn-info"
                  >
                    Use
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <hr />
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
  </div>
</template>

<style scoped>
.coupon {
  border: 5px dotted #fbc9c0;
  width: 100%;
  border-radius: 15px;
  margin: 0 auto;
  max-width: 600px;
}

.container {
  padding: 2px 16px;
  background-color: #f1f1f1;
}
</style>

<script>
import Modal from "../../../Modal/Modal.vue";
import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      coupon: this.couponProduct,

      productAccessories: [],
      productAccessory: {
        id: "",
        name: "",
        images: "",
        price: "",
        type_id: "",
        description_id: "",
        content: "",
        status: "",
      },

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
      couponId: "",

      couponStores: [],
      couponStore: {
        user_id: "",
        coupon_id: "",
        coupon_name: "",
        coupon_time: "",
        statusUse: "",
      },

      couponUsers: [],
      couponUser: {
        id: "",
        name: "",
        condition: "",
        number: "",
        start_date: "",
        end_date: "",
      },
    };
  },
  created() {},
  components: {
    Modal,
  },
  mounted() {
    // this.fetchData();
    this.fetchCoupon();
    this.fetchUserCoupon();
  },
  props: ["couponProduct"],
  methods: {
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },

    // fetchData() {
    //   let that = this;
    //   axios
    //     .get(`/get-accessory/${this.coupon.id}`)
    //     .then(function (response) {
    //       that.productAccessories = response.data.productAccessory; //show data ra
    //     })
    //     .catch((err) => {
    //       switch (err.response.status) {
    //         case 500:
    //           that
    //             .$swal({
    //               title: "Error loading data !",
    //               icon: "warning",
    //               confirmButtonText: "Ok",
    //             })
    //             .then(function (confirm) {});
    //           break;
    //         default:
    //           break;
    //       }
    //     });
    // },

    fetchCoupon() {
      let that = this;
      axios
        .get(`/get-coupon-store`)
        .then(function (response) {
          that.couponStores = response.data.couponStores; //show data ra
          console.log(that.couponStores[0].coupon.name);
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

    saveCoupon(id) {
      let that = this;
      axios
        .post(`/sale/save-coupon-store/${id}`)
        .then((response) => {})
        .catch((err) => {
          switch (err.response.status) {
            case 422:
              this.errorBackEnd = err.response.data.errors;
              break;
            case 404:
              that
                .$swal({
                  title: "Add Error !",
                  icon: "warning",
                  confirmButtonText: "Cancle !",
                })
                .then(function (confirm) {});
              break;
            case 500:
              that
                .$swal({
                  title: "Add Error !",
                  icon: "warning",
                  confirmButtonText: "Cancle !",
                })
                .then(function (confirm) {});
              break;
            default:
              break;
          }
        });
    },

    fetchUserCoupon() {
      let that = this;
      axios
        .post(`/sale/get-coupon-user`)
        .then(function (response) {
          that.couponUsers = response.data.userCoupons; //show data ra
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