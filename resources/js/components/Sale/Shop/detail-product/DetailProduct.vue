<template>
  <div style="padding-top:16px">
    <ProductInfo :infoProduct="productinfo"></ProductInfo>
    <ProductDecrip :decripProduct="productdecrip"></ProductDecrip><br>
    <ProductRelated :relatedProduct="productrelated"></ProductRelated>
  </div>
</template>

<script>
import ProductInfo from "./ProductInfo.vue";
import ProductDecrip from "./ProductDecrip.vue";
import ProductRelated from "./ProductRelated.vue";

import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      productinfo: this.product,
      productdecrip: this.product,
      productrelated: this.product,
    };
  },
  created() {},
  components: {
    ProductInfo,
    ProductDecrip,
    ProductRelated,
  },
  props: ["product"],
  mounted() {},
  methods: {},
};
</script>