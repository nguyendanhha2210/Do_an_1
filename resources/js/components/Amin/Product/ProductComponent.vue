<template>
  <div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading"></div>
      <div class="row w3-res-tb">
        <div for="paginate" class="col-md-3 col-sm-2 col-4">
          <select v-model="paginate" class="form-control w-sm inline v-middle">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
          </select>
        </div>
        <div class="col-md-4 col-sm-7 col-3" style="float: left">
          <!-- <a href="product-image">
            <button
              style="background-color: green; color: white; height: 36px"
              type="button"
              class="btn btn-sm"
            >
              <span class="fa fa-plus"></span>
              Image
            </button></a
          > -->
        </div>
        <div class="col-md-5 col-sm-3 col-5" style="float: right">
          <input
            type="text"
            class="form-control"
            v-model="search"
            placeholder="Search"
          />
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
                Import product information
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
                @submit.prevent="AddProduct"
                enctype="multipart/form-data"
                method="POST"
                ref="addForm"
                :action="formUrl"
              >
                <input type="hidden" name="productId" :value="product.id" />

                <input type="hidden" :value="csrfToken" name="_token" />

                <div class="form-group">
                  <label for="exampleInputEmail1">Name Product</label>
                  <input
                    type="text"
                    class="form-control"
                    id="exampleInputEmail1"
                    placeholder="Name"
                    name="name"
                    v-validate="'required'"
                    v-model="product.name"
                  />
                  <!-- validate -->
                  <div style="color: red" role="alert">
                    {{ errors.first("name") }}
                  </div>
                  <div style="color: red" v-if="errorBackEnd.name">
                    {{ errorBackEnd.name[0] }}
                  </div>
                  <!-- validate -->
                </div>
                <div class="form-group">
                  <div class="position-relative d-inline-block">
                    <label for="file_img_banner1">
                      <div class="img-drop-box mt-2 mr-2">
                        <img src ref="imageDispaly" class="img-thumbnail" />
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
                      />
                    </label>
                    <a
                      class="btn btn-light icon-close-white display-none"
                      style="background-color: black; border-radius: 91%"
                      ref="iconClose"
                      @click="deleteImage"
                    ></a>
                  </div>
                  <div style="color: red" role="alert">
                    {{ errors.first("images") }}
                  </div>
                  <div style="color: red" v-if="errorBackEnd.images">
                    {{ errorBackEnd.images[0] }}
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Import Price</label>
                  <input
                    type="text"
                    class="form-control"
                    name="price"
                    v-validate="'required'"
                    v-model="product.price"
                  />
                  <div style="color: red" role="alert">
                    {{ errors.first("price") }}
                  </div>
                  <div style="color: red" v-if="errorBackEnd.price">
                    {{ errorBackEnd.price[0] }}
                  </div>
                </div>

                <div class="form-row">
                  <div
                    class="form-group col-md-3 text-center"
                    v-for="(data, index) in weight_product"
                    :key="data.id"
                  >
                    <label :for="`data${index}`">{{ data.weight }}</label>
                    <!-- <input
                      type="text"
                      class="form-control text-center"
                      :name="'price[' + index + ']'"
                      v-validate="'required'"
                    /> -->

                    <!-- <input
                      class="form-check-input"
                      type="text"
                      v-model="selectedIds"
                      :id="`weight${index}`"
                      @change="changeInputPrice()"/> -->

                    <input
                      class="form-check-input"
                      type="text"
                      v-model="selectedIds"
                      :id="`data${index}`"
                      name="weight"
                      @change="updateCheckAll(data.id)"
                      :ref="`comment${data.id}`"
                      />

                    <div style="color: red" role="alert">
                      {{ errors.first("price") }}
                    </div>
                    <div style="color: red" v-if="errorBackEnd.price">
                      {{ errorBackEnd.price[0] }}
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Type_id</label>
                  <select v-model="product.type_id" class="form-control">
                    <option value="">Select product type</option>
                    <option
                      v-for="data in type_product"
                      :key="data.id"
                      :value="data.id"
                    >
                      {{ data.type }}
                    </option>
                  </select>
                  <!-- validate -->
                  <div style="color: red" role="alert">
                    {{ errors.first("type_id") }}
                  </div>
                  <div style="color: red" v-if="errorBackEnd.type_id">
                    {{ errorBackEnd.type_id[0] }}
                  </div>
                  <!-- validate -->
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Description_id</label>
                  <select v-model="product.description_id" class="form-control">
                    <option value="">Select product description</option>
                    <option
                      v-for="data in description_product"
                      :key="data.id"
                      :value="data.id"
                    >
                      {{ data.description }}
                    </option>
                  </select>
                  <!-- validate -->
                  <div style="color: red" role="alert">
                    {{ errors.first("description_id") }}
                  </div>
                  <div style="color: red" v-if="errorBackEnd.description_id">
                    {{ errorBackEnd.description_id[0] }}
                  </div>
                  <!-- validate -->
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Content</label>
                  <ckeditor
                    v-model="product.content"
                    :config="editorConfig"
                    :editor-url="editorUrl"
                  ></ckeditor>

                  <!-- <input
                    type="text"
                    class="form-control"
                    id="exampleInputEmail1"
                    placeholder="Name"
                    name="content"
                    v-validate="'required'"
                    v-model="product.content"
                  /> -->
                  <!-- validate -->
                  <div style="color: red" role="alert">
                    {{ errors.first("content") }}
                  </div>
                  <div style="color: red" v-if="errorBackEnd.content">
                    {{ errorBackEnd.content[0] }}
                  </div>
                  <!-- validate -->
                </div>

                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                  >
                    Close
                  </button>
                  <button class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- <div
        class="modal fade"
        id="myModalImage"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                Import product images
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
                @submit.prevent="AddProductImage()"
                enctype="multipart/form-data"
              >
                <div class="row">
                  <input type="text" v-model="productImage.product_id" hidden />
                  <div class="col-md-9 px-0">
                    <div
                      class="position-relative float-left"
                      v-for="(item, index) in listImages"
                      :key="item.id"
                    >
                      <label :for="`file_img_banner${index}`">
                        <div class="img-drop-box mt-2 mr-2">
                          <img
                            :src="item.src"
                            :ref="`imageDisplay${index}`"
                            class="mh-100 mw-100 mx-auto display-block"
                          />
                          <svg
                            width="45"
                            height="45"
                            viewBox="0 0 45 45"
                            style="margin-top: 30px"
                            :ref="`imageIconPlus${index}`"
                            class="display-none"
                          >
                            <use
                              xlink:href="/images/Group_1287.svg#Group_1287"
                            ></use>
                          </svg>
                        </div>
                        <input
                          type="file"
                          :id="`file_img_banner${index}`"
                          :ref="`image${index}`"
                          v-on:change="attachImage('image', index)"
                          accept="image/*"
                          style="display: none"
                        />
                      </label>
                      <a
                        class="btn btn-light icon-close-white display-block"
                        :ref="`imageIconClose${index}`"
                        @click="deleteImage('image', index)"
                      >
                      </a>
                    </div>
                    <div class="position-relative float-left">
                      <label :for="`file_img_banner${listImages.length}`">
                        <div class="img-drop-box mt-2 mr-2">
                          <img
                            src
                            :ref="`imageDisplay${listImages.length}`"
                            class="mh-100 mw-100 mx-auto"
                          />
                          <svg
                            width="45"
                            height="45"
                            viewBox="0 0 45 45"
                            style="margin-top: 30px"
                            :ref="`imageIconPlus${listImages.length}`"
                          >
                            <use
                              xlink:href="/images/Group_1287.svg#Group_1287"
                            ></use>
                          </svg>
                        </div>
                        <input
                          type="file"
                          :id="`file_img_banner${listImages.length}`"
                          :ref="`image${listImages.length}`"
                          v-on:change="
                            attachImageAdd('image', listImages.length)
                          "
                          accept="image/*"
                          style="display: none"
                        />
                      </label>
                      <a
                        class="btn btn-light icon-close-white display-none"
                        :ref="`imageIconClose${listImages.length}`"
                        @click="deleteImageAdd('image', listImages.length)"
                      >
                      </a>
                    </div>
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
      </div> -->

      <div class="table-responsive">
        <table class="table table-striped b-t b-light text-center">
          <thead>
            <tr>
              <th scope="col">STT</th>
              <th scope="col">Name</th>
              <th scope="col">Images</th>
              <th scope="col" class="text-center">
                <a href="#" @click.prevent="change_sort('price')">Price</a>
                <span v-if="sort_direction == 'desc' && sort_field == 'price'"
                  >&uarr;</span
                >
                <span v-if="sort_direction == 'asc' && sort_field == 'price'"
                  >&darr;</span
                >
              </th>
              <th scope="col">Status</th>
              <th scope="col">Type</th>
              <th scope="col">Description_id</th>
              <th scope="col">Content</th>

              <th scope="col" class="text-center">
                <a href="#" @click.prevent="change_sort('quantity')"
                  >Quantity</a
                >
                <span
                  v-if="sort_direction == 'desc' && sort_field == 'quantity'"
                  >&uarr;</span
                >
                <span v-if="sort_direction == 'asc' && sort_field == 'quantity'"
                  >&darr;</span
                >
              </th>

              <th scope="col" class="text-center">
                <a href="#" @click.prevent="change_sort('import_price')"
                  >Import Price</a
                >
                <span
                  v-if="
                    sort_direction == 'desc' && sort_field == 'import_price'
                  "
                  >&uarr;</span
                >
                <span
                  v-if="sort_direction == 'asc' && sort_field == 'import_price'"
                  >&darr;</span
                >
              </th>

              <th scope="col" class="text-center">
                <a href="#" @click.prevent="change_sort('product_sold')"
                  >Product Sold</a
                >
                <span
                  v-if="
                    sort_direction == 'desc' && sort_field == 'product_sold'
                  "
                  >&uarr;</span
                >
                <span
                  v-if="sort_direction == 'asc' && sort_field == 'product_sold'"
                  >&darr;</span
                >
              </th>

              <th scope="col">Ware Houses</th>
              <th scope="col" class="text-center">
                <a href="#" @click.prevent="change_sort('views')">Views</a>
                <span v-if="sort_direction == 'desc' && sort_field == 'views'"
                  >&uarr;</span
                >
                <span v-if="sort_direction == 'asc' && sort_field == 'views'"
                  >&darr;</span
                >
              </th>
              <th></th>
            </tr>
          </thead>
          <transition-group name="slide-fade" tag="tbody">
            <tr v-for="(product, index) in products.data" :key="product.id">
              <th scope="row">{{ index + 1 }}</th>
              <td>
                {{ product.name }}
              </td>
              <td>
                <img
                  :src="baseUrl + '/uploads/products/' + product.images"
                  width="50px"
                  height="50px"
                  alt=""
                />
                <a
                  :href="`add-image/${product.id}`"
                  style="font-size: 21px; transform: translate(-26%, -14%)"
                  ><i
                    style="color: green"
                    class="fa fa-plus"
                    aria-hidden="true"
                  ></i
                ></a>

                <a :href="`detail-image/${product.id}`"
                  ><i
                    style="font-size: 21px; transform: translate(29%, 3%)"
                    class="fa fa-pencil-square-o text-success text-active"
                  ></i
                ></a>
              </td>
              <td>
                {{ product.price }}
              </td>
              <td v-if="product.price != 0">
                <span class="text-ellipsis">
                  <a
                    href="javascript:;"
                    v-if="product.status == 0"
                    @click="activeStatus(product)"
                    ><span class="fa-thumb-styling fa fa-thumbs-up"></span
                  ></a>
                  <a href="javascript:;" v-else @click="activeStatus(product)"
                    ><span class="fa-thumb-styling fa fa-thumbs-down"></span
                  ></a>
                </span>
              </td>
              <td v-else></td>
              <td>
                {{ product.type.type }}
              </td>
              <td>
                {{ product.description.description }}
              </td>
              <td>
                {{ product.content }}
              </td>
              <td>
                {{ product.quantity }}
              </td>
              <td>
                {{ product.import_price }}
              </td>
              <td>
                {{ product.product_sold }}
              </td>
              <td>
                <a style="font-size: 20px" href="warehouse"
                  ><span class="fa fa-eye"></span
                ></a>
              </td>
              <td>
                {{ product.views }}
              </td>
              <td>
                <div class="td-action">
                  <a
                    data-toggle="modal"
                    data-target="#myModal"
                    @click="
                      updateProduct(product),
                        ((buttonAdd = false), (edit = true))
                    "
                    style="font-size: 21px; transform: translate(-26%, -14%)"
                    ><i
                      class="fa fa-pencil-square-o text-success text-active"
                    ></i
                  ></a>
                </div>
              </td>
            </tr>
          </transition-group>
        </table>
      </div>
    </div>
    <div v-if="products != ''">
      <nav aria-label="Page navigation example">
        <paginate
          v-model="page"
          :page-count="parseInt(products.last_page)"
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
    </div>
    <div class="text-center" v-else style="color: red">There is no data !</div>
    <loader :flag-show="flagShowLoader"></loader>
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
import Loader from "../../Common/loader.vue";
const axios = require("axios").default;
export default {
  data() {
    return {
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      csrfToken: Laravel.csrfToken,
      buttonAdd: true,

      update_comment: [],
      selectedIds:[],

      productImages: [],
      productImage: {
        id: "",
        product_id: "",
        url: "",
      },
      listImages: [],

      products: [],
      product: {
        id: "",
        name: "",
        images: "",
        price: "",
        type_id: "",
        description_id: "",
        content: "",
        status: "",
        quantity: "",
        import_price: "",
        product_sold: "",
        ware_houses_id: "",
        views: "",
      },

      errorBackEnd: {},
      edit: false,
      page: 1,
      paginate: 5,
      search: "",
      type_product: {},
      description_product: {},
      weight_product: {},
      flagShowLoader: false,

      sort_direction: "desc",
      sort_field: "created_at",

      editorUrl: "https://cdn.ckeditor.com/4.14.1/full-all/ckeditor.js",
      editorConfig: {
        toolbarGroups: [
          { name: "document", groups: ["mode", "document", "doctools"] },
          { name: "clipboard", groups: ["clipboard", "undo"] },
          {
            name: "editing",
            groups: ["find", "selection", "spellchecker", "editing"],
          },
          { name: "forms", groups: ["forms"] },
          { name: "basicstyles", groups: ["basicstyles", "cleanup"] },
          {
            name: "paragraph",
            groups: ["list", "indent", "blocks", "align", "bidi", "paragraph"],
          },
          { name: "links", groups: ["links"] },
          { name: "insert", groups: ["insert"] },
          { name: "styles", groups: ["styles"] },
          { name: "colors", groups: ["colors"] },
          { name: "tools", groups: ["tools"] },
          { name: "others", groups: ["others"] },
          { name: "about", groups: ["about"] },
        ],
        removeButtons:
          "NewPage,Print,Save,Templates,Replace,Find,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CreateDiv,Anchor,Flash,Smiley,PageBreak,ShowBlocks,About,Language,Iframe,Image",
      },
    };
  },
  created() {
    let messError = {
      custom: {
        name: {
          required: "* Tên chưa nhập",
        },
        images: {
          required: "* Ảnh chưa chọn",
          image_format: "* Ảnh chưa đúng định dạng",
        },
        price: {
          required: "* Giá chưa nhập",
        },
        type_id: {
          required: "* Thể loại chưa nhập",
        },
        description_id: {
          required: "* Mô tả chưa nhập",
        },
        content: {
          required: "* Nội dung chưa nhập",
        },
        status: {
          required: "* Trạng thái chưa nhập",
        },
      },
    };
    this.$validator.localize("en", messError);
    this.fetchData();
    this.fill_Product();
  },
  props: ["formUrl"],
  mounted() {
  
  },
  components: {
    Loader,
  },
  watch: {
    paginate: function (value) {
      this.fetchData();
    },
    search: function (value) {
      this.fetchData();
    },
  },
  methods: {
   updateCheckAll: function (id) {
     this.update_comment = [];
      this.update_comment.push({
          id: id,
          content: this.$refs["comment" + id][0].value,
      });
    },

    AddProduct(e) {
      // let formData = new FormData();
      // formData.append("id", this.product.id);
      // formData.append("name", this.product.name);
      // formData.append("images", this.product.images);
      // formData.append("price", this.product.price);
      // formData.append("type_id", this.product.type_id);
      // formData.append("description_id", this.product.description_id);
      // formData.append("content", this.product.content);
      // formData.append("priceImport",priceImport);
      axios
        .post(`product/update`, this.update_comment, {
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
                (window.location = response.data),
                  (that.product = {
                    name: "",
                    images: "",
                    price: "",
                    type_id: "",

                    description_id: "",
                    content: "",
                    status: "",
                  });
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
    },

    // updateProductImage(product) {
    //   this.productImage.product_id = product.id;
    // },
    // attachImageAdd(type, value) {
    //   var file = null;
    //   if (type == "image") {
    //     if (value < this.listImages.length) {
    //       this.listImages[value].file = this.$refs[type + value][0].files[0];
    //       file = this.$refs[type + value][0].files[0];
    //       this.$refs[type + value][0].value = "";
    //     } else {
    //       this.listImages.push({
    //         file_id: null,
    //         file: this.$refs[type + value].files[0],
    //         src: "",
    //       });
    //       file = this.$refs[type + value].files[0];
    //       this.$refs[type + value].value = "";
    //     }
    //   }
    //   let reader = new FileReader();
    //   reader.addEventListener(
    //     "load",
    //     function () {
    //       this.$refs[type + "Display" + value][0].style.setProperty(
    //         "display",
    //         "block",
    //         "important"
    //       );
    //       this.$refs[type + "IconClose" + value][0].style.setProperty(
    //         "display",
    //         "block",
    //         "important"
    //       );
    //       this.$refs[type + "Display" + value][0].src = reader.result;
    //       if (type == "image") {
    //         this.listImages[value].src = reader.result;
    //       }
    //       this.$refs[type + "IconPlus" + value][0].style.setProperty(
    //         "display",
    //         "none",
    //         "important"
    //       );
    //     }.bind(this),
    //     false
    //   );
    //   reader.readAsDataURL(file);
    // },

    // deleteImageAdd(type, value) {
    //   var index = 0;
    //   if (type == "image") {
    //     index = this.listImages.length;
    //     this.listImages.splice(value, 1);
    //   }
    //   this.$refs[type + index].value = "";
    // },

    // AddProductImage() {
    //   let that = this;
    //   let formData = new FormData();
    //   this.listImages.forEach((item) => {
    //     formData.append("images[]", item.file);
    //   });

    //   axios
    //     .post(
    //       `product-image/${that.productImage.product_id}/update`,
    //       formData,
    //       {
    //         headers: {
    //           "Content-Type": "multipart/form-data",
    //         },
    //       }
    //     )
    //     .then((response) => {
    //       that
    //         .$swal({
    //           title: "Update success!",
    //           icon: "success",
    //           confirmButtonText: "Yes !",
    //           confirmButtonColor: "#3085d6",
    //         })
    //         .then(function (confirm) {
    //           window.location.href = "/admin/product";
    //         });
    //     })
    //     .catch((err) => {
    //       switch (err.response.status) {
    //         case 422:
    //           that.errorBackEnd = err.response.data.errors;
    //           break;
    //         case 500:
    //           that
    //             .$swal({
    //               title: "Update Failure Data!",
    //               icon: "error",
    //               confirmButtonText: "Ok",
    //             })
    //             .then(function (confirm) {});
    //           break;
    //         default:
    //           break;
    //       }
    //     });
    // },

    change_sort(field) {
      if (this.sort_field == field) {
        this.sort_direction = this.sort_direction == "asc" ? "desc" : "asc";
      } else {
        this.sort_field = field;
      }
      this.fetchData(1);
    },
    activeStatus(product) {
      let that = this;
      let formData = new FormData();
      formData.append("status", product.status);
      // formData.append("_method", "put");
      axios
        .post(`update-product-status/${product.id}`, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          this.$swal({
            title: "Update Status successfully!",
            icon: "success",
            confirmButtonText: "OK",
          }).then(function (confirm) {
            that.fetchData();
          });
        })
        .catch((err) => {
          that.flashMessage.error({
            message: "Update Status Failure!",
            icon: "/backend/icon/error.svg",
            blockClass: "text-centet",
          });
        });
    },

    fill_Product() {
      axios
        .get(`fill-product`, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          this.type_product = res.data.type_product;
          this.description_product = res.data.description_product;
          this.weight_product = res.data.weight_product;
        });
    },

    attachFile() {
      this.product.images = this.$refs.fileImage.files[0];
      let reader = new FileReader();
      reader.buttonAddEventListener(
        "load",
        function () {
          this.$refs.fileImageDispaly.src = reader.result;
        }.bind(this),
        false
      );

      reader.readAsDataURL(this.product.images);
    },

    // AddProduct(e) {
    // let that = this;
    // if (this.edit == false) {
    //   let formData = new FormData();
    //   formData.append("name", this.product.name);
    //   formData.append("images", this.product.images);
    //   formData.append("price", this.product.price);
    //   formData.append("type_id", this.product.type_id);
    //   formData.append("description_id", this.product.description_id);
    //   formData.append("content", this.product.content);
    //   formData.append("status", this.product.status);
    //   axios
    //     .post(`product-add`, formData, {
    //       headers: {
    //         "Content-Type": "multipart/form-data",
    //       },
    //     })
    //     .then((response) => {
    //       that.fetchData();
    //       that.flashMessage.setStrategy("multiple");
    //       that.flashMessage.success({
    //         message: "Thêm Thành Công !",
    //         icon: "/backend/icon/check.svg",
    //         blockClass: "text-centet",
    //       });
    //       that
    //         .$swal({
    //           title: "buttonAdd success!",
    //           icon: "success",
    //           showCancelButton: true,
    //           confirmButtonText: "Yes !",
    //           confirmButtonColor: "#3085d6",
    //           cancelButtonText: "Cancle !",
    //           cancelButtonColor: "#d33",
    //         })
    //         .then(function (confirm) {
    //           if (confirm.isConfirmed) {
    //             that.product = {
    //               name: "",
    //               images: "",
    //               price: "",
    //               type_id: "",
    //               description_id: "",
    //               content: "",
    //               status: "",
    //             };
    //           } else {
    //             window.location = response.data;
    //           }
    //         });
    //     })
    //     .catch((err) => {
    //       switch (err.response.status) {
    //         case 422:
    //           that.errorBackEnd = err.response.data.errors;
    //           break;
    //         case 500:
    //           that
    //             .$swal({
    //               title: "buttonAdd Failure Data!",
    //               icon: "error",
    //               confirmButtonText: "Ok",
    //             })
    //             .then(function (confirm) {});
    //           break;
    //         default:
    //           break;
    //       }
    //     });
    // } else {
    //   let formData = new FormData();
    //   formData.append("id", this.product.id);
    //   formData.append("name", this.product.name);
    //   formData.append("images", this.product.images);
    //   formData.append("price", this.product.price);
    //   formData.append("type_id", this.product.type_id);
    //   formData.append("description_id", this.product.description_id);
    //   formData.append("content", this.product.content);
    //   axios
    //     .post(`product/update`, formData, {
    //       headers: {
    //         "Content-Type": "multipart/form-data",
    //       },
    //     })
    //     .then((response) => {
    //       that.fetchData();
    //       that
    //         .$swal({
    //           title: "Update success!",
    //           icon: "success",
    //           confirmButtonText: "Yes !",
    //           confirmButtonColor: "#3085d6",
    //         })
    //         .then(function (confirm) {
    //           if (confirm.isConfirmed) {
    //             that.buttonAdd = true;
    //             (window.location = response.data),
    //               (that.product = {
    //                 name: "",
    //                 images: "",
    //                 price: "",
    //                 type_id: "",

    //                 description_id: "",
    //                 content: "",
    //                 status: "",
    //               });
    //           } else {
    //           }
    //         });
    //     })
    //     .catch((err) => {
    //       switch (err.response.status) {
    //         case 422:
    //           that.errorBackEnd = err.response.data.errors;
    //           break;
    //         case 500:
    //           that
    //             .$swal({
    //               title: "Update Failure Data!",
    //               icon: "error",
    //               confirmButtonText: "Ok",
    //             })
    //             .then(function (confirm) {});
    //           break;
    //         default:
    //           break;
    //       }
    //     });
    // }
    // },

    fetchData() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .get(
          "get-product?page=" +
            that.page +
            "&paginate=" +
            that.paginate +
            "&search=" +
            that.search +
            "&sort_direction=" +
            that.sort_direction +
            "&sort_field=" +
            that.sort_field
        )
        .then(function (response) {
          that.products = response.data;
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

    prev() {
      if (this.products.prev_page_url) {
        this.page--;
        this.fetchData();
      }
    },
    next() {
      if (this.products.next_page_url) {
        this.page++;
        this.fetchData();
      }
    },

    changePage(page) {
      this.page = page;
      this.fetchData();
    },

    updateProduct(product) {
      this.product.id = product.id;
      this.product.name = product.name;
      if (product.images != "") {
        this.$refs.imageDispaly.src =
          this.baseUrl + "/uploads/products/" + product.images;
        this.$refs.imageDispaly.style.display = "block";
        this.$refs.iconClose.style.display = "block";
        this.$refs.iconFile.style.display = "none";
      }

      this.product.price = product.price;
      this.product.type_id = product.type_id;
      this.product.description_id = product.description_id;
      this.product.content = product.content;
      this.product.import_price = product.import_price;
    },

    deleteProduct(id) {
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
            .get(`product/${id}/delete`)
            .then((response) => {
              this.$swal({
                title: "Delete successfully!",
                icon: "success",
                confirmButtonText: "OK",
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

    attachImage() {
      this.product.images = this.$refs.image.files[0];
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
      reader.readAsDataURL(this.product.images);
    },
    deleteImage() {
      this.product.images = "";
      this.$refs.imageDispaly.style.display = "none";
      this.$refs.iconClose.style.display = "none";
      this.$refs.image.value = "";
      this.$refs.iconFile.style.display = "block";
    },
  },
};
</script>
