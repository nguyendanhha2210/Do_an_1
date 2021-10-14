<template>
  <div class="table-agile-info">
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <h3 class="text-center">General Statistics</h3>
        <PieChart v-if="chartGenerals.length > 0" :data="chartGenerals" />
      </div>
    </div>
    <loader :flag-show="flagShowLoader"></loader>
  </div>
</template>

<script>
import Loader from "../../Common/loader.vue";
import PieChart from "../../Common/Chart/PieChart.vue";
const axios = require("axios").default;

export default {
  data() {
    return {
      chartGenerals: [],
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      flagShowLoader: false,
    };
  },
  created() {
    this.fetchChart();
  },
  mounted() {},
  components: {
    Loader,
    PieChart,
  },
  watch: {},
  methods: {
    fetchChart() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .post("get-general-statistical")
        .then(function (response) {
          that.chartGenerals = response.data.general;
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
