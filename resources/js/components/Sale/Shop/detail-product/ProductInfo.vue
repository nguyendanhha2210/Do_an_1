<template>
  <div>
    <div class="row" style="padding-top: 15px">
      <div class="col-lg-6">
        <v-zoomer>
          <img
            class="product-big-img"
            style="height: 428px"
            ref="image"
            v-lazy="baseUrl + '/uploads/products/' + info.images"
            alt=""
          />
        </v-zoomer>
        <div class="product-thumbs">
          <div class="product-thumbs-track ps-slider owl-carousel">
            <div v-for="data in info.product_images" :key="data.id">
              <div class="pt active">
                <img
                  class="product-big-img"
                  :ref="`images${data.id}`"
                  height="150px"
                  :src="baseUrl + '/uploads/products/' + data.url"
                  alt=""
                  @click="changeImage(data.id)"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="product-details">
          <div class="pd-title">
            <span>Genuine</span>
            <button
              class="btb btn-danger"
              disabled
              style="
                float: left;
                width: 81px;
                height: 28px;
                border: 1px solid red;
                border-radius: 25px;
                transform: translate(-3%, 24%);
              "
            >
              yêu thích
            </button>
            <h3>
              {{ info.name }}
            </h3>
            <a class="heart-icon" @click="addFavorite(info)"
              ><i class="icon_heart_alt" style="color: red; font-size: 22px"></i
            ></a>
          </div>
          <div class="pd-rating" style="font-size: 14px">
            <star-rating
              read-only
              :star-size="15"
              :increment="0.1"
              :rating="Number(info.star_vote)"
            ></star-rating>
          </div>
          <div class="pd-desc" style="margin-bottom: 7px">
            <p style="transform: translate(23%, -115%)">
              <b style="padding-left: 2%">|</b>
              <u style="padding-left: 2%">{{ info.product_sold }}</u> Đã bán
              <b style="padding-left: 2%">|</b>
              <u style="padding-left: 2%">{{ this.countEvaluated }}</u> Đánh giá
            </p>
            <h4
              style="transform: translate(0%, -62%)"
              v-if="statusChooseWeight"
            >
              {{ formatPrice(this.weightProduct.price) }} đ
              <input hidden type="text" v-model="weightProduct.price" />
              <input hidden type="text" v-model="weightProduct.weight" />
            </h4>
            <h4 style="transform: translate(0%, -62%)" v-else>
              <div v-if="this.priceWeightProduct == 0">
                {{ formatPrice(this.weightProductMin) }} -
                {{ formatPrice(this.weightProductMax) }} đ
              </div>
              <div v-else>
                {{ formatPrice(this.priceWeightProduct) }} đ
                <input hidden type="text" v-model="priceWeightProduct" />
                <input hidden type="text" v-model="weightProduct" />
              </div>
            </h4>
          </div>
          <div class="pd-size-choose">
            <div
              class="sc-item"
              v-for="data in info.weight_products"
              :key="data.id"
            >
              <input type="radio" id="sm-size" />
              <label for="sm-size" @click="chooseWeight(data.id)"
                >{{ data.weight }}kg</label
              >
            </div>
          </div>
          <div class="quantity">
            <div class="pro-qty">
              <span @click="decrease()" class="dec qtybtn">-</span>
              <input type="text" v-model="qualityOrder" min="1" readonly />
              <span @click="increase()" class="inc qtybtn">+</span>
            </div>
            <a
              @click="addCartProduct()"
              v-if="statusChoosed"
              class="primary-btn pd-cart"
              href="#"
              >Add To Cart</a
            >
            <b v-else style="font-size: 18px; padding-top: 10px; color: red"
              >Please Click Option !</b
            >
          </div>
          <ul class="pd-tags">
            <li style="color:red;margin-bottom: 20px;">{{ info.quantity }} sản phẩm có sẵn</li>
            <li><span>CATEGORIES</span>: {{ info.type.type }}</li>
            <li>
              <span>DECRIPTIONS</span>: {{ info.description.description }}
            </li>
          </ul>
          <div class="pd-share" style="transform: translate(0%, -81%)">
            <div class="p-code"><b>ID</b>: 000{{ info.id }}</div>
            <div class="pd-social">
              <a href="https://www.facebook.com/Mekhoebexinh02"
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
import StarRating from "vue-star-rating";
import Modal from "../../../Modal/Modal.vue";
import Vue from "vue";
import axios from "axios";

export default {
  data() {
    return {
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      info: this.infoProduct,

      countEvaluated: 0,
      qualityOrder: 1,
      message: "",
      weightProduct: {
        product_id: "",
        weight: "",
        price: "",
      },
      statusChooseWeight: false,
      priceWeightProduct: 0,
      weightProduct: 0,
      weightProductMax: 0,
      weightProductMin: 0,
      statusChoosed: false,

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
  created() {
    this.fillEvaluated();
    this.fillWeight();
  },
  components: {
    Modal,
    StarRating,
  },
  props: ["infoProduct"],
  mounted() {
    this.fillWeight();
  },
  methods: {
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    changeImage(value) {
      console.log(this.$refs.zoom_image);

      this.$refs.image.src = this.$refs["images" + value][0].src;
    },
    addCartProduct() {
      if (this.info.quantity < this.qualityOrder * this.weightProduct.weight) {
        this.$swal({
          title: "Not Enough Products",
          icon: "warning",
          text: "Sản phẩm còn lại trong kho : " + this.info.quantity + " kg",
          confirmButtonText: "Cancle !",
        }).then(function (confirm) {});
      } else {
        let that = this;
        let formData = new FormData();
        formData.append("qualityOrder", this.qualityOrder);
        formData.append("id", this.info.id);
        formData.append("name", this.info.name);
        formData.append("images", this.info.images);
        if (this.priceWeightProduct == 0) {
          formData.append("price", this.weightProduct.price);
          formData.append("weight", this.weightProduct.weight);
        } else {
          formData.append("price", this.priceWeightProduct);
          formData.append("weight", this.weightProduct);
        }

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
      if (this.qualityOrder * this.weightProduct.weight < this.info.quantity) {
        this.qualityOrder += 1;
      }
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

    fillEvaluated() {
      let that = this;
      axios
        .post(`/fill-evaluated/${this.info.id}`)
        .then((response) => {
          that.countEvaluated = response.data;
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
    },

    fillWeight() {
      axios.post(`/fill-weight-product/${this.info.id}`).then((response) => {
        if (response.data.priceWeightProduct != "") {
          this.priceWeightProduct = response.data.priceWeightProduct;
          this.weightProduct = response.data.weightProduct;
          this.statusChoosed = true;
        } else {
          this.weightProductMax = response.data.weightProductMax;
          this.weightProductMin = response.data.weightProductMin;
        }
      });
    },

    chooseWeight(value) {
      let that = this;
      let formData = new FormData();
      formData.append("id", value);
      axios
        .post(`/choose-weight-product`, formData)
        .then((response) => {
          that.weightProduct = response.data;
          that.statusChooseWeight = true;
          that.statusChoosed = true;
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
    },
  },
};
</script>