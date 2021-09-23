<template>
  <div class="table-agile-info">
    <div class="row" style="display: grid;">
      <div class="text-right mb-2">
        <a :href="`/admin/edit-image/${productImages[0].product_id}`">
          <i
            style="font-size: 21px"
            class="fa fa-pencil-square-o btn btn-success"
          ></i>
        </a>
      </div>

      <div class="border-bottom w-100">
        <div class="form-group row row-container mb-0 pd-tb-20">
          <div class="col-md-12">
            <div
              class="image-thumbnail mt-8-sp mr-2"
              v-if="productImages.length == 0"
            >
              <img
                src="/backend/images/no-image-found-360x250.png"
                class="w-100 h-100"
                alt=""
              />
            </div>
            <div
              class="image-thumbnail mt-8-sp mr-2 float-left"
              v-else
              v-for="productImage in productImages"
              :key="productImage.id"
            >
              <img
                style="width: 150px; height: 170px"
                :src="baseUrl + '/uploads/products/' + productImage.url"
                alt=""
              />
            </div>
          </div>
        </div>
      </div>
    </div>
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
const axios = require("axios").default;
export default {
  data() {
    return {
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      buttonAdd: true,
      productImage: {
        id: "",
        product_id: "",
        url: "",
      },
      productImages: this.data,
    };
  },
  props: ["data"],
  methods: {},
};
</script>
