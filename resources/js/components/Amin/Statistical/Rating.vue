<template>
  <div class="table-agile-info">
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <h3 class="text-center">Products Rating</h3>
        <BarChart v-if="chartRating.length > 0" :data="chartRating" />
      </div>
    </div>
  </div>
</template>

<script>
import Loader from "../../Common/loader.vue";
import Modal from "../../Modal/Modal.vue";
import BarChart from "../../Common/Chart/BarChart.vue";

const axios = require("axios").default;

export default {
  data() {
    return {
      chartRating: [],
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
  },
  watch: {},
  methods: {
    fetchProductChart() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .get(`get-rating-statistical`)
        .then(function (response) {
          that.chartRating = response.data.rating;
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
