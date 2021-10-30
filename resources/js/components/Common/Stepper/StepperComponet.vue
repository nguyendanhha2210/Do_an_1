<template>
  <div>
    <div class="wrapper-stepper">
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
            style="width: max-content"
          >
            Đơn Hàng Đã Đặt</span
          >
          <span
            v-else-if="item == 2"
            class="stepper-item-title"
            style="width: max-content"
          >
            Đang Vận Chuyển</span
          >
          <span
            v-else-if="item == 3"
            class="stepper-item-title"
            style="width: max-content"
          >
            Đơn Hàng Đã Nhận</span
          >
          <span
            v-else-if="item == 4"
            class="stepper-item-title"
            style="width: max-content"
          >
            Đơn Hàng Đã Đánh Giá</span
          >
        </div>
      </div>
      <div class="stepper-content" v-for="item in 4" :key="item">
        <div class="stepper-pane" v-if="step == item">
          Mã đơn : <span class="tx-green-1">{{ item }}</span>
        </div>
      </div>

      <div class="controls">
        <button class="btn btn--green-1">
          Mua Lại
        </button>
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
