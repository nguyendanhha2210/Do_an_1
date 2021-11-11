<template>
  <div>
    <div class="wrapper-stepper">
      <div class="stepper mx-auto">
        <div class="stepper-progress" style="margin-bottom: 22px">
          <div
            class="stepper-progress-bar"
            :style="'width:' + stepperProgress"
          ></div>
        </div>
        <div
          class="stepper-item"
          style="margin-bottom: 24px"
          :class="{ current: step == item, success: step > item }"
          v-for="item in 4"
          :key="item"
        >
          <div class="stepper-item-counter">
            <img
              class="icon-success"
              src="https://www.seekpng.com/png/full/1-10353_check-mark-green-png-green-check-mark-svg.png"
              alt=""
            />
            <span class="number">
              {{ item }}
            </span>
          </div>
          <span
            v-if="item == 1"
            class="stepper-item-title"
            style="width: max-content; text-align: center"
          >
            <i
              style="font-size: 11px; color: red"
              v-if="date.order_date != ''"
              >{{ date.order_date }}</i
            >
            <i style="font-size: 11px; color: red" v-else></i>
            <br /><b style="font-size: 17px">Đơn Hàng Đã Đặt</b>
          </span>
          <span
            v-else-if="item == 2"
            class="stepper-item-title"
            style="width: max-content; text-align: center"
          >
            <i
              style="font-size: 11px; color: red"
              v-if="date.delivery_date != ''"
              >{{ date.delivery_date }}</i
            >
            <i style="font-size: 11px; color: red" v-else></i>
            <br /><b style="font-size: 17px">Đang Vận Chuyển</b>
          </span>
          <span
            v-else-if="item == 3"
            class="stepper-item-title"
            style="width: max-content; text-align: center"
          >
            <i
              style="font-size: 11px; color: red"
              v-if="date.receive_date != ''"
              >{{ date.receive_date }}</i
            >
            <i style="font-size: 11px; color: red" v-else></i>
            <br /><b style="font-size: 17px">Đơn Hàng Đã Nhận</b></span
          >
          <span
            v-else-if="item == 4"
            class="stepper-item-title"
            style="width: max-content; text-align: center"
          >
            <i
              style="font-size: 11px; color: red"
              v-if="date.evaluate_date != ''"
              >{{ date.evaluate_date }}</i
            >
            <i style="font-size: 11px; color: red" v-else></i>
            <br /><b style="font-size: 17px">Đơn Hàng Đã Đánh Giá</b></span
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      step: this.data,
      stepperProgress: "",
      date: "",
    };
  },
  props: ["data", "id"],
  created() {
    // this.fillDate();
  },
  mounted() {
    this.fillStatus();
    this.fillDate();
  },
  methods: {
    fillStatus() {
      let stepperProgress = (100 / 3) * (this.step - 1) + "%";
      return stepperProgress;
    },

    fillDate() {
      let that = this;
      axios
        .get("get-date-order", {
          params: {
            id: this.id,
          },
        })
        .then(function (response) {
          that.date = response.data; //show data ra
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
