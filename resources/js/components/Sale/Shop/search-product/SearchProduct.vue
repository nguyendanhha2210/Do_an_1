<template>
  <div class="advanced-search">
    <button type="button" class="category-btn">All Products</button>
    <div class="input-group form-seach">
      <form
        class="vue-autosuggest"
        role="form"
        @submit.prevent="searchProduct()"
      >
        <vue-autosuggest
          v-model="query"
          :limit="10"
          :suggestions="filteredOptions"
          @input="changeInput"
          @selected="onSelected"
          :get-suggestion-value="getSuggestionValue"
          :input-props="{
            placeholder: 'What do you need?',
            class: 'form-control',
          }"
        >
          <div
            slot-scope="{ suggestion }"
            style="display: flex; align-items: center"
          >
            <div style="{ display: 'flex', color: 'navyblue'}">
              {{ suggestion.item.name }}
            </div>
          </div>
        </vue-autosuggest>
        <div>
          <input
            v-model="query"
            name="name"
            id="name"
            type="hidden"
            class="form-control"
            v-validate="'required'"
          />
          <div class="input-group is-danger-search" role="alert">
            {{ errors.first("name") }}
          </div>
        </div>
        <button type="submit"><i class="ti-search"></i></button>
      </form>
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
    <Loader :flag-show="flagShowLoader"></Loader>
  </div>
</template>
<script>
import Loader from "../../../Common/loader.vue";
import Modal from "../../../Modal/Modal.vue";
import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      name: "",
      query: "",
      errorsData: [],
      options: [],
      userId: "",
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
    };
  },
  created: function () {
    let messError = {
      custom: {
        name: {
          required: "* Tên là bắt buộc !",
        },
      },
    };
    this.$validator.localize("en", messError);
  },

  components: {
    Loader,
    Modal,
  },

  computed: {
    filteredOptions() {
      return [
        {
          data: this.options.filter((option) => {
            return (
              option.name.toLowerCase().indexOf(this.query.toLowerCase()) > -1,
              option.name.toLowerCase().indexOf(this.query.toLowerCase()) > -1
            );
          }),
        },
      ];
    },
  },

  mounted() {
    this.getProduct();
  },

  methods: {
    onSelected(item) {
      this.userId = item.item.id;
      this.query = item.item.name;
    },

    getSuggestionValue(suggestion) {
      return suggestion.item.name;
    },

    changeInput() {
      this.errorsData = [];
      this.messageText = "";
    },

    getProduct() {
      axios
        .get("/get-full-product", {
          _token: Laravel.csrfToken,
        })
        .then((response) => {
          this.options = response.data;
        });
    },

    searchProduct() {
      let that = this;
      let formData = new FormData();
      formData.append("name", this.query);
      formData.append("id", this.userId);
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          window.location.href = `/search-product?id=${this.userId}&name=${this.query}`;
        }
      });
    },
  },
};
</script>