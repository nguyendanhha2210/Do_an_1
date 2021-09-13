<template>
  <div class="table-agile-info">
    <div class="panel panel-default">
      <div class="row w3-res-tb">
        <div for="paginate" class="col-md-3 col-sm-2 col-4">
          <select v-model="paginate" class="form-control w-sm inline v-middle">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
          </select>
        </div>
        <div
          class="col-md-4 col-sm-3 col-3"
          style="float: left; transform: translate(14%, -19%)"
        >
          <a
            data-toggle="modal"
            data-target="#myModal"
            data-whatever="@getbootstrap"
            v-if="buttonAdd"
            @click="edit = false"
            class="btn btn-success"
            >Add New</a
          >
        </div>
        <div class="col-md-5 col-sm-3 col-5" style="float: right">
          <input type="text" class="form-control" v-model="search" />
        </div>
      </div>

      <div
        class="modal fade"
        id="myModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                Import adminper information
              </h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="Addadmin()" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="exampleInputEmail1">Name adminper</label>
                  <input
                    type="text"
                    class="form-control"
                    id="exampleInputEmail1"
                    placeholder="Name"
                    name="name"
                    v-validate="'required'"
                    v-model="admin.name"
                  />
                  <div style="color: red" role="alert">
                    {{ errors.first("name") }}
                  </div>
                </div>
                <div class="form-row">
                  <label for="inputEmail4">Email</label>
                  <input
                    type="text"
                    class="form-control"
                    name="email"
                    v-validate="'required|email_format'"
                    v-model="admin.email"
                  />
                  <div style="color: red" role="alert">
                    {{ errors.first("email") }}
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">New Password</label>
                  <input
                    type="password"
                    class="form-control"
                    id="exampleInputEmail1"
                    name="password"
                    v-validate="'required'"
                    v-model="admin.password"
                  />
                  <div style="color: red" role="alert">
                    {{ errors.first("password") }}
                  </div>
                </div>

                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                  >
                    Close
                  </button>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th>STT</th>
              <th class="text-center">Name</th>
              <th class="text-center">Type</th>
              <th class="text-center">Date Created</th>
              <th class="text-center"></th>
            </tr>
          </thead>
          <transition-group type="slide-fade" tag="tbody">
            <tr v-for="(admin, index) in admins" :key="admin.id">
              <th scope="row" class="text-center">{{ index + 1 }}</th>
              <td class="text-center">
                {{ admin.name }}
              </td>
              <td class="text-center">
                {{ admin.email }}
              </td>
              <td class="text-center">
                {{ admin.created_at | formatDate }}
              </td>

              <td>
                <div class="td-action">
                  <a
                    data-toggle="modal"
                    data-target="#myModal"
                    @click="
                      updateAdmin(admin), ((buttonAdd = false), (edit = true))
                    "
                    style="font-size: 21px; transform: translate(-26%, -14%)"
                    ><i
                      class="fa fa-pencil-square-o text-success text-active"
                    ></i
                  ></a>
                  <!-- <i
                    class="fa fa-times-circle"
                    style="font-size: 21px; color: red"
                    aria-hidden="true"
                    @click="deleteAdmin(admin.id)"
                  ></i> -->
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
      buttonAdd: true,
      admins: [],
      admin: {
        name: "",
        email: "",
        password: "",
        created_at: "",
      },
      errorBackEnd: {}, //Lỗi bên backend laravel
      page: 1,
      paginate: 5,
      search: "",
      flagShowLoader: false,
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
    };
  },
  created() {
    let messError = {
      custom: {
        name: {
          required: "* Tên chưa nhập",
        },
        email: {
          required: "* Email chưa nhập",
          email_format: "* Email chưa đúng định dạng",
        },
        password: {
          required: "* Mật khẩu chưa nhập",
        },
      },
    };
    this.$validator.localize("en", messError);
    this.fetchData(1);
  },
  watch: {
    paginate: function (value) {
      this.fetchData(1);
    },
    search: function (value) {
      this.fetchData(1);
    },
  },
  mounted() {},
  components: {
    Modal,
    Loader,
  },
  methods: {
    prev() {},
    next() {},
    chanePage: function (page) {},

    Addadmin() {
      let that = this;
      if (this.edit == false) {
        let formData = new FormData();
        formData.append("name", this.admin.name);
        formData.append("email", this.admin.email);
        formData.append("password", this.admin.password);
        axios
          .post(`admin-add`, formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((response) => {
            that.fetchData();
            that.flashMessage.setStrategy("multiple");
            that.flashMessage.success({
              message: "Thêm Thành Công !",
              icon: "/backend/icon/check.svg",
              blockClass: "text-centet",
            });
            that
              .$swal({
                title: "buttonAdd success!",
                icon: "success",
                showCancelButton: true,
                confirmButtonText: "Yes !",
                confirmButtonColor: "#3085d6",
                cancelButtonText: "Cancle !",
                cancelButtonColor: "#d33",
              })
              .then(function (confirm) {
                if (confirm.isConfirmed) {
                  that.admin = {
                    name: "",
                    email: "",
                    password: "",
                  };
                } else {
                  window.location = response.data;
                }
              });
          })
          .catch((err) => {
            switch (err.response.status) {
              case 422:
                that.errorBackEnd = err.response.data.errors;
                break;
              case 500:
                that
                  .$swal({
                    title: "buttonAdd Failure Data!",
                    icon: "error",
                    confirmButtonText: "Ok",
                  })
                  .then(function (confirm) {});
                break;
              default:
                break;
            }
          });
      } else {
        let formData = new FormData();
        formData.append("name", this.admin.name);
        formData.append("email", this.admin.email);
        formData.append("password", this.admin.password);
        axios
          .post(`admin/${that.admin.id}/update`, formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((response) => {
            that.fetchData();
            that
              .$swal({
                title: "Update success!",
                icon: "success",
                confirmButtonText: "Yes !",
                confirmButtonColor: "#3085d6",
              })
              .then(function (confirm) {
                if (confirm.isConfirmed) {
                  that.buttonAdd = true;
                  that.admin = {
                    name: "",
                    email: "",
                    password: "",
                  };
                } else {
                }
              });
          })
          .catch((err) => {
            switch (err.response.status) {
              case 422:
                that.errorBackEnd = err.response.data.errors;
                break;
              case 500:
                that
                  .$swal({
                    title: "Update Failure Data!",
                    icon: "error",
                    confirmButtonText: "Ok",
                  })
                  .then(function (confirm) {});
                break;
              default:
                break;
            }
          });
      }
    },

    updateAdmin(admin) {
      this.admin.id = admin.id;
      this.admin.name = admin.name;
      this.admin.email = admin.email;
      this.admin.password = admin.password;
    },

    fetchData(page) {
      let that = this;
      this.flagShowLoader = true;
      axios
        .get("get-admin", {
          params: {
            page: page,
            paginate: this.paginate,
            search: this.search,
          },
        })
        .then(function (response) {
          that.admins = response.data.data; //show data ra
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

    deleteAdmin(id) {
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
            .get(`admin/${id}/delete`)
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
  },
};
</script>
