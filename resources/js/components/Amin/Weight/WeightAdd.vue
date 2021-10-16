<template>
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading"></header>
        <div class="panel-body">
          <div class="position-center">
            <form
              role="form"
              @submit.prevent="addWeight"
              method="POST"
              ref="addWeightForm"
              :action="weightAdd"
              enctype="multipart/form-data"
            >
              <input type="hidden" :value="csrfToken" name="_token" />
              <div class="form-group">
                <label for="exampleInputEmail1">Weight (vd : 0.3, 0.5, 1, 2) (đơn vị : kg)</label>
                <input
                  type="text"
                  name="weight"
                  style="width: 20%"
                  class="form-control"
                  v-validate="'required|between:0,999.99'"
                  v-model="weight.weight"
                />
                <div style="color: red" role="alert">
                  {{ errors.first("weight") }}
                </div>
              </div>
              <button type="submit" class="btn btn-info">Add</button>
            </form>
          </div>
        </div>
      </section>
    </div>
    <Loader :flag-show="flagShowLoader"></Loader>
    <FlashMessage :position="'left bottom'"></FlashMessage>
  </div>
</template>

<script>
import Loader from "../../Common/loader.vue";
import Vue from "vue";
import axios from "axios";
export default {
  created() {
    let messError = {
      custom: {
        weight: {
          required: "* Khối lượng chưa nhập",
          between: "* Khối lượng sai định dạng",
        },
      },
    };
    this.$validator.localize("en", messError);
  },
  data() {
    return {
      csrfToken: Laravel.csrfToken,
      weight: {
        weight: "",
      },
      flagShowLoader: false,
    };
  },
  props: ["weightAdd"],
  mounted() {},
  computed: {
    Loader,
  },
  methods: {
    addWeight: function (e) {
      e.preventDefault();
      let that = this;
      this.$validator.validateAll().then((valid) => {
        if (valid) {
          that.$refs.addWeightForm.submit();
          this.$swal({
            title: "Add successfully!",
            icon: "success",
            confirmButtonText: "OK",
          }).then(function (confirm) {});
        }
      });
    },
  },
};
</script>
