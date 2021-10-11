<template>
  <div class="table-agile-info">
    <div class="row">
      <div class="col-md-4 col-xs-12">
        <h3 class="text-center">Genneral</h3>
        <PieChart v-if="chartGenerals.length > 0" :general="chartGenerals" />
      </div>

      <div class="col-md-4 col-xs-12 text-center">
        <h3>Post Views</h3>
        <ul class="list_views" v-for="data in posts" :key="data.id">
          <li>
            <a target="_blank" :href="`post`">
              <div
                style="
                  width: 80%;
                  -ms-hyphens: auto;
                  -webkit-hyphens: auto;
                  hyphens: auto;
                  word-wrap: break-word;
                  text-overflow: ellipsis;
                  overflow: hidden;
                  -webkit-line-clamp: 1;
                  -webkit-box-orient: vertical;
                  display: -webkit-box;
                  float: left;
                "
              >
                {{ data.title }}
              </div>
              <span style="color: red"
                >| <b>{{ data.views }}</b>
                <i
                  style="color: blue; transform: translate(0%, -4%)"
                  class="fa fa-eye"
                  aria-hidden="true"
                ></i
              ></span>
            </a>
          </li>
        </ul>
      </div>

      <div class="col-md-4 col-xs-12 text-center">
        <h3>Product views</h3>
        <ul class="list_views" v-for="data in products" :key="data.id">
          <li>
            <a target="_blank" :href="`product`">
              <div
                style="
                  width: 67%;
                  -ms-hyphens: auto;
                  -webkit-hyphens: auto;
                  hyphens: auto;
                  word-wrap: break-word;
                  text-overflow: ellipsis;
                  overflow: hidden;
                  -webkit-line-clamp: 1;
                  -webkit-box-orient: vertical;
                  display: -webkit-box;
                  float: left;
                "
              >
                {{ data.name }}
              </div>
              <span style="color: red"
                >| <b>{{ data.views }}</b>
                <i
                  style="color: blue; transform: translate(0%, -4%)"
                  class="fa fa-eye"
                  aria-hidden="true"
                ></i
              ></span>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <loader :flag-show="flagShowLoader"></loader>
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
import BarChart from "../../Common/Chart/BarChart.vue";
import PieChart from "../../Common/Chart/PieChart.vue";
const axios = require("axios").default;

export default {
  data() {
    return {
      chartGenerals: [],
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      flagShowLoader: false,
      posts: [],
      products: [],
    };
  },
  created() {
    this.fetchData();
    this.fetchChart();
  },
  mounted() {},
  components: {
    Loader,
    BarChart,
    PieChart,
  },
  watch: {},
  methods: {
    fetchData() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .post("get-dashboard")
        .then(function (response) {
          that.posts = response.data.posts;
          that.products = response.data.products;
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

    fetchChart() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .post("get-general-statistical")
        .then(function (response) {
          that.chartGenerals = response.data.general;
          // console.log(that.chartGenerals);
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
