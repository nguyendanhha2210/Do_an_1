<template>
  <div class="table-agile-info">
    <div class="row pb-3">
      <div class="col-md-12 col-xs-12">
        <h3 class="text-center">Product</h3>
        <BarChart v-if="chartProfits.length > 0" :data="chartProfits" />
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
const axios = require("axios").default;

export default {
  data() {
    return {
      chartProfits: [],
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      flagShowLoader: false,

      flag: false,
      flag1: false,
      amount: 0,
      keyword: "",
      time1: "",
      time2: "",
    };
  },
  created() {
    this.fetchChart();
  },
  mounted() {},
  components: {
    Loader,
    Modal,
    BarChart,
  },
  watch: {},
  methods: {
    fetchChart() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .get(`get-invoice-statistical`)
        .then(function (response) {
          that.chartProfits = response.data.data;
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
