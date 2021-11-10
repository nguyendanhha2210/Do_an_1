<template>
  <section class="product-shop" style="background-color: #e9edf0">
    <div class="ABC" style="margin-left: 49px">
      <StepperPurchase :data=1></StepperPurchase>
    </div>
    <div class="container" style="margin-top: 17px">
      <div class="row">
        <div
          class="col-lg-3 col-md-6 col-sm-8 order-1 order-lg-1"
          style="background-color: white; border-right: solid 2px #e9edf0"
        >
          <CouponProduct :couponProduct="couponproduct"></CouponProduct>
        </div>
        <div
          class="col-lg-9 order-2 order-lg-2"
          style="background-color: white"
        >
          <ProductInfo :infoProduct="productinfo"></ProductInfo>
          <ProductDecrip :decripProduct="productdecrip"></ProductDecrip><br />
        </div>
      </div>
      <div class="row">
        <ProductRelated :relatedProduct="productrelated"></ProductRelated>
      </div>
      <div class="row">
        <ProductCompare :compareProduct="productcompare"></ProductCompare>
      </div>
    </div>
  </section>
</template>

<script>
import CouponProduct from "./CouponProduct.vue";
import ProductInfo from "./ProductInfo.vue";
import ProductDecrip from "./ProductDecrip.vue";
import ProductRelated from "./ProductRelated.vue";
import ProductCompare from "./ProductCompare.vue";

import StepperPurchase from "../../../Common/Stepper/StepperPurchase.vue";

import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      productinfo: this.product,
      productdecrip: this.product,
      productrelated: this.product,
      couponproduct: this.product,
      productcompare: this.product,
    };
  },
  created() {},
  components: {
    ProductInfo,
    ProductDecrip,
    ProductRelated,
    CouponProduct,
    ProductCompare,
    StepperPurchase,
  },
  props: ["product"],
  mounted() {},
  methods: {},
};
</script>