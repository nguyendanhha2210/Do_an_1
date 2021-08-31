<template>
  <div>
    <section class="shopping-cart spad">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="cart-table">
              <table class="table table-condensed">
                <thead>
                  <tr class="cart_menu">
                    <td>Họ Tên</td>
                    <td>Email</td>
                    <td>Ngày Tạo</td>
                    <td>Ngày Thay Đổi</td>
                    <td></td>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="user in users" :key="user.id">
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.created_at | formatDate }}</td>
                    <td>{{ user.updated_at | formatDate }}</td>
                    <td>
                      <button
                        type="button"
                        class="btn btn-warning mr-1"
                        data-toggle="modal"
                        data-target="#myModal"
                        @click="editUser(user)"
                      >
                        Edit
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
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
                User Information
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
              <form
                @submit.prevent="updateUser()"
                enctype="multipart/form-data"
              >
                <div class="form-group">
                  <input
                    type="text"
                    class="form-control"
                    id="exampleInputEmail1"
                    v-model="user.id"
                    hidden
                  />
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Name User</label>
                  <input
                    type="text"
                    class="form-control"
                    id="exampleInputEmail1"
                    name="name"
                    v-validate="'required'"
                    v-model="user.name"
                  />
                  <div style="color: red" role="alert">
                    {{ errors.first("name") }}
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Email</label>
                  <input
                    type="text"
                    class="form-control"
                    id="exampleInputEmail1"
                    name="email"
                    v-validate="'required|email_format'"
                    v-model="user.email"
                  />
                  <div style="color: red" role="alert">
                    {{ errors.first("email") }}
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      users: [],
      user: {
        id: "",
        name: "",
        email: "",
        password: "",
        created_at: "",
        updated_at: "",
      },
    };
  },
  created() {
    let messError = {
      custom: {
        name: {
          required: "* Tên chưa được nhập !",
        },
        email: {
          required: "* Email chưa nhập !",
          email_format: "* Email chưa hợp lệ !",
        },
      },
    };
    this.$validator.localize("en", messError);
    this.fetchData();
  },
  mounted() {},
  methods: {
    fetchData() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .get("get-user")
        .then(function (response) {
          that.users = response.data; //show data ra
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
    editUser(user) {
      this.user.id = user.id;
      this.user.name = user.name;
      this.user.email = user.email;
    },

    updateUser() {
      let formData = new FormData();
      formData.append("id", this.user.id);
      formData.append("name", this.user.name);
      formData.append("email", this.user.email);
      axios
        .post(`user-update`, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          this.fetchData();
          this.$swal({
            title: "Update success!",
            icon: "success",
            confirmButtonText: "Yes !",
            confirmButtonColor: "#3085d6",
          }).then(function (confirm) {
            if (confirm.isConfirmed) {
              window.location = response.data;
            } else {
            }
          });
        })
        .catch((err) => {
          switch (err.response.status) {
            case 422:
              this.errorBackEnd = err.response.data.errors;
              break;
            case 500:
              this.$swal({
                title: "Update Failure Data!",
                icon: "error",
                confirmButtonText: "Ok",
              }).then(function (confirm) {});
              break;
            default:
              break;
          }
        });
    },
  },
};
</script>