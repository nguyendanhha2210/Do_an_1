<template>
  <div class="table-agile-info">
    <div class="row">
      <div class="col-md-4 col-xs-12">
        <p class="title_thongke">Thống kê</p>
        <BarChart v-if="optionChars.length > 0" :data="optionChars" />
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
import BarChart from "../../Common/BarChar";
const axios = require("axios").default;

// const data = {
//   [
//     date : "2021/12/12",
//     profit : 15
//   ],
//   [
//     date : "2021/12/13",
//     profit : 40
//   ],
//   [
//     date : "2021/12/14",
//     profit : 55
//   ],
// }

export default {
  data() {
    return {
      optionChars: [],
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      flagShowLoader: false,
      posts: [],
      products: [],
    };
  },
  created() {
    this.fetchData();
    this.fetchABC();
  },
  mounted() {},
  components: {
    Loader,
    BarChart,
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

    fetchABC() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .post("get-map")
        .then(function (response) {
          that.optionChars = response.data;
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
