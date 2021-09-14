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
                    <td>Ảnh</td>
                    <td>Email</td>
                    <td>Phone</td>
                    <td>Ngày Tạo</td>
                    <td>Ngày Thay Đổi</td>
                    <td></td>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="user in users" :key="user.id">
                    <td>{{ user.name }}</td>
                    <td>
                      <img
                        style="width: 50px; height: 50px"
                        :src="baseUrl + '/uploads/' + user.images"
                        alt=""
                      />
                    </td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.phone }}</td>
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
                  <div class="position-relative d-inline-block">
                    <label for="file_img_banner1">
                      <div class="img-drop-box mt-2 mr-2 profile-image">
                        <img
                          src
                          ref="imageDispaly"
                          style="width: 200px; height: 200px"
                          class="img-thumbnail profile-image"
                        />
                        <svg
                          width="45"
                          height="45"
                          viewBox="0 0 45 45"
                          style="
                            margin-top: 52px;
                            margin-left: 38%;
                            margin-right: 38%;
                          "
                          ref="iconFile"
                        >
                          <use
                            xlink:href="/images/Group_1287.svg#Group_1287"
                          ></use>
                        </svg>
                      </div>
                      <input
                        type="file"
                        id="file_img_banner1"
                        v-validate="'required'"
                        name="images"
                        ref="image"
                        v-on:change="attachImage"
                        accept="image/*"
                        style="display: none"
                      />
                    </label>
                    <a ref="iconClose" @click="deleteImage"
                      ><i
                        class="fa fa-times"
                        aria-hidden="true"
                        style="
                          transform: translate(942%, -898%);
                          font-size: 25px;
                          color: red;
                          font-weight: 600;
                        "
                      ></i
                    ></a>
                  </div>
                  <div style="color: red" role="alert">
                    {{ errors.first("images") }}
                  </div>
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

                <div class="form-group">
                  <label for="exampleInputEmail1">Phone</label>
                  <input
                    type="text"
                    class="form-control"
                    id="exampleInputEmail1"
                    name="phone"
                    v-validate="'required|number_phone'"
                    v-model="user.phone"
                  />
                  <div style="color: red" role="alert">
                    {{ errors.first("phone") }}
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

<style lang="scss" scoped>
.td-action {
  display: inline-flex;
}
.btn-success {
  float: right;
  margin-top: 10px;
  margin-right: 5%;
}
</style>

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
        phone: "",
        images: "",
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
          required: "* Name has not been entered !",
        },
        email: {
          required: "* Email has not been entered !",
          email_format: "* Email is not valid !",
        },
        phone: {
          required: "* Phone has not been entered !",
          number_phone: "* Phone is not valid !",
        },
        images: {
          required: "* Images has not been entered",
          image_format: "* Ảnh chưa đúng định dạng",
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
      this.user.phone = user.phone;
      if (user.images != "") {
        this.$refs.imageDispaly.src = this.baseUrl + "/uploads/" + user.images;
        this.$refs.imageDispaly.style.display = "block";
        this.$refs.iconClose.style.display = "block";
        this.$refs.iconFile.style.display = "none";
      }
    },

    updateUser() {
      let formData = new FormData();
      formData.append("id", this.user.id);
      formData.append("name", this.user.name);
      formData.append("email", this.user.email);
      formData.append("phone", this.user.phone);
      formData.append("images", this.user.images);
      axios
        .post(`user-update`, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          this.fetchData();
          if (response.data.result) {
            this.$swal({
              title: "Update success!",
              icon: "success",
              confirmButtonText: "Yes !",
              confirmButtonColor: "#3085d6",
            }).then(function (confirm) {
              if (confirm.isConfirmed) {
                window.location = response.data.result;
              }
            });
          } else {
            this.$swal({
              title: response.data.error,
              icon: "error",
              confirmButtonText: "Yes !",
              confirmButtonColor: "#3085d6",
            }).then(function (confirm) {
              if (confirm.isConfirmed) {
              }
            });
          }
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
    attachImage() {
      this.user.images = this.$refs.image.files[0];
      let reader = new FileReader();
      reader.addEventListener(
        "load",
        function () {
          this.$refs.imageDispaly.style.display = "block";
          this.$refs.iconClose.style.display = "block";
          this.$refs.imageDispaly.src = reader.result;
          this.$refs.iconFile.style.display = "none";
        }.bind(this),
        false
      );
      reader.readAsDataURL(this.user.images);
    },
    deleteImage() {
      this.user.images = "";
      this.$refs.imageDispaly.style.display = "none";
      this.$refs.iconClose.style.display = "none";
      this.$refs.image.value = "";
      this.$refs.iconFile.style.display = "block";
    },
  },
};
</script>