<template>
  <div>
    <div class="row">
      <div class="col-lg-6">
        <div class="product-pic-zoom">
          <img
            class="product-big-img"
            style="height: 400px"
            :src="baseUrl + '/uploads/' + info[0].images"
            alt=""
          />
          <div class="zoom-icon">
            <i class="fa fa-search-plus"></i>
          </div>
        </div>
        <div class="product-thumbs">
          <div class="product-thumbs-track ps-slider owl-carousel">
            <div
              class="pt active"
              :src="baseUrl + '/uploads/' + info[0].product_images[0].image_1"
            >
              <img
                class="product-big-img"
                height="150px"
                :src="baseUrl + '/uploads/' + info[0].product_images[0].image_1"
                alt=""
              />
            </div>
            <div
              class="pt"
              :src="baseUrl + '/uploads/' + info[0].product_images[0].image_2"
            >
              <img
                class="product-big-img"
                height="150px"
                :src="baseUrl + '/uploads/' + info[0].product_images[0].image_2"
                alt=""
              />
            </div>
            <div
              class="pt"
              :src="baseUrl + '/uploads/' + info[0].product_images[0].image_3"
            >
              <img
                class="product-big-img"
                height="150px"
                :src="baseUrl + '/uploads/' + info[0].product_images[0].image_3"
                alt=""
              />
            </div>
            <div
              class="pt"
              :src="baseUrl + '/uploads/' + info[0].product_images[0].image_4"
            >
              <img
                class="product-big-img"
                height="150px"
                :src="baseUrl + '/uploads/' + info[0].product_images[0].image_4"
                alt=""
              />
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="product-details">
          <div class="pd-title">
            <span>Genuine</span>
            <h3>{{ info[0].name }}</h3>
            <a class="heart-icon" @click="addFavorite(info[0])"
              ><i class="icon_heart_alt" style="color: red; font-size: 22px"></i
            ></a>
          </div>
          <div class="pd-rating">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star-o"></i>
            <span>(5)</span>
          </div>
          <div class="pd-desc">
            <p style="color: #aaaaaa">
              Đã bán :
              {{ info[0].product_sold }}
            </p>
            <h4>{{ formatPrice(info[0].price) }} đ</h4>
            
          </div>
          <div class="pd-size-choose">
            <div class="sc-item">
              <input type="radio" id="sm-size" />
              <label for="sm-size">{{ info[0].weight.weight }}</label>
            </div>
          </div>
          <div class="quantity">
            <div class="pro-qty">
              <span @click="decrease()" class="dec qtybtn">-</span>
              <input type="text" v-model="qualityOrder" min="1" readonly />
              <span @click="increase()" class="inc qtybtn">+</span>
              <!-- <input
                  name="qualityOrder"
                  v-model="qualityOrder"
                  type="number"
                /> -->
            </div>
            <a @click="addCartProduct()" class="primary-btn pd-cart" href="#"
              >Add To Cart</a
            >
          </div>
          <ul class="pd-tags">
            <li><span>CATEGORIES</span>: {{ info[0].type.type }}</li>
            <li>
              <span>DECRIPTIONS</span>: {{ info[0].description.description }}
            </li>
          </ul>
          <div class="pd-share" style="transform: translate(0%, -81%)">
            <div class="p-code"><b>Id</b>: 000{{ info[0].id }}</div>
            <div class="pd-social">
              <a
                href="https://www.facebook.com/Mekhoebexinh02"
                ><img
                  style="width: 34px; height: 31px"
                  src="/frontend/images/fb.png"
                  alt=""
              /></a>
              <a
                href="https://www.sendo.vn/shop/fresh-mama?fbclid=IwAR3tWlCBasdebaIOqqRRh8PmPmBfPUQnIH5rXNFAcbldGHvgGPeRHn5TGn4"
                ><img
                  style="width: 34px; height: 31px"
                  src="/frontend/images/sendo.png"
                  alt=""
              /></a>
              <a
                href="https://shopee.vn/shop/227054554/?fbclid=IwAR2ZW6JvJH3sC4r_YsvntvaW8NxT00HnmJ4CnEd0uAmJEbtl8Ot45VcEr1I"
                ><img
                  style="width: 34px; height: 31px"
                  src="/frontend/images/shoppee.jpg"
                  alt=""
              /></a>
            </div>
          </div>
          <div>
            <img
              style="width: 401px; height: 92px"
              src="/frontend/images/sale-logo.jpg"
              alt=""
            />
          </div>
        </div>
      </div>
    </div>
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
  </div>
</template>

<script>
import Modal from "../../../Modal/Modal.vue";
import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      info: this.infoProduct,

      qualityOrder: 1,
      message: "",
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
    };
  },
  created() {},
  components: {
    Modal,
  },
  props: ["infoProduct"],
  mounted() {
  },
  methods: {
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    addCartProduct() {
      if (this.info[0].quantity < this.qualityOrder) {
        this.$swal({
          title: "Not Enough Products",
          icon: "warning",
          text: "Sản phẩm còn lại trong kho : " + this.info[0].quantity,
          confirmButtonText: "Cancle !",
        }).then(function (confirm) {});
      } else {
        let that = this;
        let formData = new FormData();
        formData.append("qualityOrder", this.qualityOrder);
        formData.append("id", this.info[0].id);
        formData.append("name", this.info[0].name);
        formData.append("images", this.info[0].images);
        formData.append("price", this.info[0].price);

        this.$validator.validateAll().then((valid) => {
          if (valid) {
            axios
              .post(`/add-to-cart`, formData)
              .then((response) => {
                (that.type = "success"),
                  (that.title = ""),
                  (that.text = "Do you want to continue ?"),
                  (that.confirm = "Xem tiếp !"),
                  (that.cancle = "Đi đến giỏ hàng !"),
                  (that.urlConfirm = ""),
                  (that.urlCancle = response.data), //lấy url từ respon->json() bên controller
                  (that.modalShow = true); //gọi modal thêm thành công ra
              })
              .catch((err) => {
                switch (err.response.status) {
                  case 422:
                    that.errorBackEnd = err.response.data.errors;
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
          }
        });
      }
    },
    increase() {
      this.qualityOrder += 1;
    },
    decrease() {
      if (this.qualityOrder != 1) {
        this.qualityOrder -= 1;
      }
    },
    addFavorite(info) {
      let that = this;
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          axios
            .post(`/add-to-favorite`, info)
            .then((response) => {
              this.$swal({
                title: "Add Successfully!",
                icon: "success",
                confirmButtonText: "OK",
              }).then((confirm) => {});
            })
            .catch((err) => {
              switch (err.response.status) {
                case 422:
                  that.errorBackEnd = err.response.data.errors;
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
        }
      });
    },
  },
};
</script>