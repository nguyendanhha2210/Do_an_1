<template>
  <div>
    <div class="table-agile-info">
      <div class="panel panel-default">
        <div class="panel-heading">User Information</div>
        <div class="table-responsive">
          <table class="table table-striped b-t b-light text-center">
            <thead>
              <tr>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Registration Date</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ users.name }}</td>
                <td>{{ users.email }}</td>
                <td>{{ users.created_at }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <br />
    <div class="table-agile-info">
      <div class="panel panel-default">
        <div class="panel-heading">Orders Placed</div>
        <div class="row w3-res-tb">
          <div for="paginate" class="col-lg-2 col-md-2 col-sm-3 col-3">
            <select
              v-model="paginate"
              class="form-control w-sm inline v-middle"
            >
              <option value="5">5</option>
              <option value="10">10</option>
              <option value="20">20</option>
            </select>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-5 col-5"></div>

          <div class="col-lg-3 col-md-5 col-sm-5 col-4"></div>

          <div class="col-lg-1 col-md-2 col-sm-2 col-2 text-date-warehouse">
            <b>Date:</b>
          </div>

          <div class="col-lg-2 col-md-10 col-sm-3 col-8 input-search">
            <input
              type="text"
              class="form-control"
              v-model="search"
              placeholder="Search"
            />
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-striped b-t b-light text-center">
            <thead>
              <tr>
                <th>STT</th>
                <th>Shipping Id</th>
                <th>Order Code</th>
                <th>Order Status</th>
                <th>Order Date</th>
                <th>Order Destroy</th>
                <th style="width: 20%">Action</th>
              </tr>
            </thead>
            <transition-group type="slide-fade" tag="tbody">
              <tr
                v-for="(orderDetail, index) in orderDetails.data"
                :key="orderDetail.id"
              >
                <th scope="row">{{ index + 1 }}</th>
                <td>
                  <a :href="`/admin/order/${orderDetail.order_code}/detail`">
                    {{ orderDetail.shipping_id }}</a
                  >
                </td>
                <td>
                  <a :href="`/admin/order/${orderDetail.order_code}/detail`">
                    {{ orderDetail.order_code }}</a
                  >
                </td>
                <td v-if="orderDetail.order_status == 1">
                  <b style="color: blue">Ordered</b>
                </td>
                <td v-else-if="orderDetail.order_status == 2">
                  <b style="color: #ffcc00">Shipping</b>
                </td>
                <td v-else-if="orderDetail.order_status == 3">
                  <b style="color: #00cc00">SUCCESS</b>
                </td>
                <td v-else-if="orderDetail.order_status == 4">
                  <b style="color: #ff0000">Failure</b>
                </td>
                <td>
                  {{ orderDetail.order_date }}
                </td>
                <td v-if="orderDetail.order_destroy == ''">null</td>
                <td v-else>
                  {{ orderDetail.order_destroy }}
                </td>
                <td style="color: red">
                  {{ formatPrice(orderDetail.total_bill) }}
                </td>
              </tr>
            </transition-group>
          </table>
        </div>
      </div>
      <nav aria-label="Page navigation example">
        <paginate
          v-model="page"
          :page-count="parseInt(orderDetails.last_page)"
          :page-range="5"
          :margin-pages="2"
          :click-handler="changePage"
          :prev-text="'<<'"
          :next-text="'>>'"
          :container-class="'pagination justify-content-center'"
          :page-class="'page-item'"
          :prev-class="'page-item'"
          :next-class="'page-item'"
          :page-link-class="'page-link bg-info text-light'"
          :next-link-class="'page-link bg-info text-light'"
          :prev-link-class="'page-link bg-info text-light'"
        >
        </paginate>
      </nav>
      <Loader :flag-show="flagShowLoader"></Loader>
    </div>
  </div>
</template>
<script>
import Loader from "../../Common/loader.vue";
import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      users: [],
      user: {
        name: "",
        email: "",
        created_at: "",
      },
      orderDetails: [],
      orderDetail: {
        shipping_id: "",
        order_code: "",
        order_status: "",
        order_date: "",
        total_bill: "",
      },
      page: 1,
      paginate: 5,
      search: "",
      flagShowLoader: false,
    };
  },
  created() {
    this.fetchData();
  },
  watch: {
    paginate: function (value) {
      this.fetchData();
    },
    search: function (value) {
      this.fetchData();
    },
  },
  components: {
    Loader,
  },
  methods: {
    fetchData() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .get("get-user-detail?page=" +
            that.page +
            "&paginate=" +
            that.paginate +
            "&search=" +
            that.search)

        // .post(`get-user-detail`, formData)
        .then(function (response) {
          that.users = response.data.userDetails; //show data ra
          that.orderDetails = response.data.orders; //show data ra
          that.flagShowLoader = false;
        })
        .catch((err) => {
          switch (err.response.status) {
            case 500:
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

    prev() {
      if (this.orderDetails.prev_page_url) {
        this.page--;
        this.fetchData();
      }
    },
    
    next() {
      if (this.orderDetails.next_page_url) {
        this.page++;
        this.fetchData();
      }
    },

    changePage(page) {
      this.page = page;
      this.fetchData();
    },

    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " đ";
    },
  },
};
</script>