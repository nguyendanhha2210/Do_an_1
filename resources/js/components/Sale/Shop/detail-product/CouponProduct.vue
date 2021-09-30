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
  </div>
</template>

<style scoped>
</style>

<script>
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
    };
  },
  created() {},
  components: {},
  mounted() {
    // this.fetchData();
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
  },
};
</script>