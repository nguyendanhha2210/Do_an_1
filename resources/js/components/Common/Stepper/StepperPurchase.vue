<template>
  <div>
    <div
      class="wrapper-stepper"
      style="width: 1104px; margin-left: 29px; margin-top: 15px"
    >
      <div class="stepper mx-auto">
        <div class="stepper-progress">
          <div
            class="stepper-progress-bar"
            :style="'width:' + stepperProgress"
          ></div>
        </div>
        <div
          class="stepper-item"
          :class="{ current: step == item, success: step > item }"
          v-for="item in 3"
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
            style="width: max-content"
          >
            Chọn Sản Phẩm</span
          >
          <span
            v-else-if="item == 2"
            class="stepper-item-title"
            style="width: max-content"
          >
            Giỏ Hàng</span
          >
          <span
            v-else-if="item == 3"
            class="stepper-item-title"
            style="width: max-content"
          >
            Xác Nhận Thanh Toán</span
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
    };
  },
  props: ["data"],
  mounted() {
    this.fillStatus();
  },
  methods: {
    fillStatus() {
      let stepperProgress = (100 / 3) * (this.step - 1) + "%";
      return stepperProgress;
    },
  },
};
</script>
