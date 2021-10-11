<template>
  <div class="table-agile-info">
    <div class="row pb-3">
      <div class="col-md-6 col-xs-12">
        <h3 class="text-center">Product in Stock</h3>
        <PieChart
          v-if="chartProductStocks.length > 0"
          :data="chartProductStocks"
        />
      </div>
      <div class="col-md-6 col-xs-12">
        <h3 class="text-center">Viewed Products</h3>
        <BarChart
          v-if="chartProductViews.length > 0"
          :data="chartProductViews"
        />
      </div>
    </div>
    <br />
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <h3 class="text-center">Products Sold</h3>
        <BarChart v-if="chartProductSold.length > 0" :data="chartProductSold" />
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
import Loader from "../../Common/loader.vue";
import Modal from "../../Modal/Modal.vue";
import BarChart from "../../Common/Chart/BarChart.vue";
import PieChart from "../../Common/Chart/PieChart.vue";

const axios = require("axios").default;

export default {
  data() {
    return {
      chartProductStocks: [],
      chartProductViews: [],
      chartProductSold: [],
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      flagShowLoader: false,
    };
  },
  created() {
    this.fetchProductChart();
  },
  mounted() {},
  components: {
    Loader,
    Modal,
    BarChart,
    PieChart,
  },
  watch: {},
  methods: {
    fetchProductChart() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .get(`get-product-statistical`)
        .then(function (response) {
          that.chartProductStocks = response.data.dataProductStock;
          that.chartProductViews = response.data.dataProductView;
          that.chartProductSold = response.data.dataProductSold;
          that.flagShowLoader = false;
        })
        .catch((err) => {
          switch (err.response.status) {
            case 404:
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
