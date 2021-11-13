<template>
  <div class="table-agile-info">
    <div class="panel panel-default">
      <div class="row w3-res-tb">
        <div class="col-md-3 col-7" style="float: left">
          <div class="form-check form-check-inline">
            <label
              class="
                container-checkbox
                form-check-label
                align-items-center
                height-14
                p-0
              "
              for="checkAll"
            >
              <input
                v-model="isInputAll"
                class="form-check-input"
                type="checkbox"
                id="checkAll"
                name="checkAll"
                @click="checkAll" />
              <span class="checkmark"></span
            ></label>
          </div>
          <button
            class="btn border-radius-7"
            v-bind:class="{
              'btn-outline-secondary': !isBtnDeleteAll,
              'background-white': !isBtnDeleteAll,
              'btn-success': isBtnDeleteAll,
              disabled: !isBtnDeleteAll,
            }"
            @click="deleteAll"
          >
            Delete
          </button>

          <a
            class="btn border-radius-7"
            v-bind:class="{
              'btn-outline-secondary': !isBtnDeleteAll,
              'background-white': !isBtnDeleteAll,
              'btn-success': isBtnDeleteAll,
              disabled: !isBtnDeleteAll,
            }"
            :href="url"
          >
            Export
          </a>
        </div>
        <div for="paginate" class="col-md-2 col-5">
          <select v-model="paginate" class="form-control w-sm inline v-middle text-center">
            <option v-for="item in limitNumber" :key="item.key" :value="item.key">
              {{ item.value }}
            </option>
          </select>
        </div>
        <div class="col-md-1 col-3" style="float: left">
          <a
            class="btn btn-success"
            style="transform: translate(40%, -27%)"
            :href="formAdd"
            >Add New</a
          >
        </div>
        <div class="col-md-2 col-9" style="float: right">
          <input
            type="text"
            name="search"
            placeholder="Search"
            class="form-control"
            v-model="search"
          />
        </div>

        <div class="col-md-4 col-12" style="float: left">
          <form role="form" @submit.prevent="importCSV()" multiple="multiple">
            <div class="form-group" style="float: left; width: 204px">
              <input type="file" name="file" accept=".xlsx" />
              <!-- <input type="file" ref="file" name="file"  /> -->
            </div>
            <button type="submit" class="btn btn-info">Import</button>
          </form>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th></th>
              <th class="text-center">STT</th>
              <th class="text-center">
                <a href="#" @click.prevent="change_sort('description')"
                  >Description</a
                >
                <span
                  v-if="sort_direction == 'desc' && sort_field == 'description'"
                  >&uarr;</span
                >
                <span
                  v-if="sort_direction == 'asc' && sort_field == 'description'"
                  >&darr;</span
                >
              </th>
              <th class="text-center"></th>
            </tr>
          </thead>
          <transition-group type="slide-fade" tag="tbody">
            <tr
              v-for="(description, index) in descriptions"
              :key="description.id"
            >
              <td style="width: 5%">
                <div
                  class="form-check form-check-inline"
                  v-if="description.id != 2"
                >
                  <label
                    class="container-checkbox form-check-label height-17"
                    :for="`type${index}`"
                  >
                    <input
                      class="form-check-input"
                      type="checkbox"
                      v-model="selectedIds"
                      :id="`description${index}`"
                      name="category"
                      @change="updateCheckAll"
                      :value="description.id" />
                    <span class="checkmark"></span
                  ></label>
                </div>
              </td>
              <th scope="row" class="text-center">{{ index + 1 }}</th>
              <td class="text-center">
                {{ description.description }}
              </td>
              <td v-if="description.id == 2"></td>
              <td v-else>
                <div class="td-action">
                  <a
                    :href="`description/${description.id}/edit`"
                    style="font-size: 21px; transform: translate(-26%, -14%)"
                    ><i
                      class="fa fa-pencil-square-o text-success text-active"
                    ></i
                  ></a>
                  <i
                    class="fa fa-times-circle"
                    style="font-size: 21px; color: red"
                    aria-hidden="true"
                    @click="singleDelete(description.id)"
                  ></i>
                </div>
              </td>
            </tr>
          </transition-group>
        </table>
      </div>
    </div>
    <footer class="panel-footer">
      <div class="row">
        <div class="col-sm-5 text-center">
          <small
            class="text-muted inline m-t-sm m-b-sm"
            style="float: inherit; font-size: 16px"
            >showing {{ numberOfFirstRecord }}-{{ numberOfPage }} of
            {{ totalNumber }} items</small
          >
        </div>
      </div>
    </footer>
    <nav aria-label="Page navigation example">
      <paginate
        :page-count="lastPage"
        :container-class="'pagination d-flex justify-content-center mt-3'"
        :page-class="'page-item'"
        :page-link-class="'page-link'"
        :prev-class="'page-item prev-item'"
        :prev-link-class="'page-link'"
        :next-class="'page-item next-item'"
        :next-link-class="'page-link'"
        :prev-text="'<span><img src=\'/images/icons/angle-left.svg\'></span>'"
        :next-text="'<span><img src=\'/images/icons/angle-right.svg\'></span>'"
        :click-handler="fetchData"
      >
      </paginate>
    </nav>
    <Modal
      v-if="modalShow"
      :type="type"
      :title="title"
      :text="text"
      :confirm="confirm"
      :cancle="cancle"
      :urlConfirm="urlConfirm"
      :urlCancle="urlCancle"
      :modalShow="modalShow"
    ></Modal>

    <Loader :flag-show="flagShowLoader"></Loader>
    <FlashMessage :position="'left bottom'"></FlashMessage>
  </div>
</template>

<style lang="scss" scoped>
.td-action {
  display: inline-flex;
}
.btn-success {
  float: right;
  margin-top: 10px;
  margin-right: 7%;
}
</style>

<script>
import Loader from "../../Common/loader.vue";
import Modal from "../../Modal/Modal.vue";
import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      descriptions: [],
      description: {
        description: "",
      },
      errorBackEnd: {}, //Lỗi bên backend laravel
      page: 1,
      paginate: 5,
      search: "",
      flagShowLoader: false,

      url: "",
      //Modal
      modalShow: false,
      type: "",
      title: "",
      text: "",
      confirm: "",
      cancle: "",
      urlConfirm: "",
      urlCancle: "",
      //Modal
      currentPage: "",
      numberOfFirstRecord: "",
      numberOfPage: "",
      totalNumber: "",
      lastPage: 0,
      isBtnDeleteAll: false,
      isInputAll: false,
      selectedIds: [],
      sort_direction: "desc",
      sort_field: "created_at",
      limitNumber:[],
    };
  },
  created() {
    this.fetchData(1);
    this.getLimitNumber();
  },
  watch: {
    paginate: function (value) {
      this.fetchData(1);
    },
    search: function (value) {
      this.fetchData(1);
    },
  },
  props: ["formAdd", "data"],
  mounted() {},
  components: {
    Modal,
    Loader,
  },
  methods: {
    change_sort(field) {
      if (this.sort_field == field) {
        this.sort_direction = this.sort_direction == "asc" ? "desc" : "asc";
      } else {
        this.sort_field = field;
      }
      this.fetchData(1);
    },
    checkAll: function () {
      this.isInputAll = !this.isInputAll;
      this.selectedIds = [];
      if (this.isInputAll) {
        //Nếu check vào ô chon hết
        this.descriptions.forEach((item, index) => {
          this.selectedIds.push(item.id);
          this.isBtnDeleteAll = true;
        });
      } else {
        this.isBtnDeleteAll = false;
      }
      this.url = "/api/export-description-csv/" + this.selectedIds;
    },
    updateCheckAll: function () {
      //Check từng ô trong ds sp
      if (this.selectedIds.length > 0) {
        this.isBtnDeleteAll = true;
        if (this.selectedIds.length == this.descriptions.length) {
          //nếu chọn tất cả thì ô check tất cả trên sáng
          this.isInputAll = true;
        } else {
          this.isInputAll = false;
        }
      } else {
        this.isBtnDeleteAll = false;
      }
      this.url = "/api/export-description-csv/" + this.selectedIds;
    },
    deleteAll() {
      let that = this;
      this.$swal({
        title: "Do you want to delete ？",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
      }).then((result) => {
        if (result.value) {
          axios
            .post("/admin/description/delete-all", this.selectedIds)
            .then((response) => {
              this.$swal({
                title: "Delete successfully!",
                icon: "success",
                confirmButtonText: "OK!",
              }).then(function (confirm) {});
              that.fetchData(that.currentPage);
              that.isBtnDeleteAll = false;
              that.isInputAll = false;
            })
            .catch((error) => {
              that.flashMessage.error({
                message: "Delete Failure!",
                icon: "/backend/icon/error.svg",
                blockClass: "text-centet",
              });
            });
        }
      });
    },
    prev() {},
    next() {},
    chanePage: function (page) {},
    fetchData(page) {
      let that = this;
      this.flagShowLoader = true;
      axios
        .get("get-description", {
          params: {
            page: page,
            paginate: this.paginate,
            search: this.search,
            sort_direction: this.sort_direction,
            sort_field: this.sort_field,
          },
        })

        .then(function (response) {
          that.descriptions = response.data.data; //show data ra
          that.flagShowLoader = false;
          that.totalNumber = response.data.total; //Tổng số sp có
          that.currentPage = response.data.current_page; //Trang hiện hành
          that.numberOfFirstRecord = response.data.from; //Thứ tự sp đầu của 1 trang
          that.numberOfPage = response.data.to; //Thứ tự sp cuối của 1 trang
          that.lastPage = response.data.last_page;
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
    singleDelete(id) {
      let that = this;
      this.$swal({
        title: "Do you want to delete ？",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
      }).then((result) => {
        if (result.value) {
          axios
            .get(`description/${id}/delete`)
            .then((response) => {
              this.$swal({
                title: "Delete successfully!",
                icon: "success",
                confirmButtonText: "OK!",
              }).then(function (confirm) {});
              that.fetchData();
            })
            .catch((error) => {
              that.flashMessage.error({
                message: "Delete Failure!",
                icon: "/backend/icon/error.svg",
                blockClass: "text-centet",
              });
            });
        }
      });
    },
    importCSV() {
      let that = this;
      let formData = new FormData();
      var file = document.querySelector("input[type=file]").files[0];
      formData.append("file", file);
      axios
        .post("import-description-csv", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          this.$swal({
            title: "Import successfully!",
            icon: "success",
            confirmButtonText: "OK!",
          });
          that.fetchData();
        })
        .catch((err) => {
          switch (err.response.status) {
            case 422:
              this.errorBackEnd = err.response.data.errors;
              break;
            case 404:
              that
                .$swal({
                  title: "Add Error !",
                  icon: "warning",
                  confirmButtonText: "Cancle !",
                })
                .then(function (confirm) {});
              break;
            case 500:
              that
                .$swal({
                  title: "Add Error !",
                  icon: "warning",
                  confirmButtonText: "Cancle !",
                })
                .then(function (confirm) {});
              break;
            default:
              break;
          }
        });
    },
    getLimitNumber(){
      axios.get(`/get-limit-number`).then((response) => {
        this.limitNumber = response.data;
      });
    }
  },
};
</script>
