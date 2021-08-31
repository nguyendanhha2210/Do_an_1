<template>
  <div class="container-fluid">
    <div class="fade-in">
      <div class="row">
        <div class="col-lg-12">
          <div class="panel-heading"></div>
          <div class="card">
            <div class="row w3-res-tb">
              <div class="col-md-4 col-sm-7 col-3" style="float: left">
                <a class="btn btn-success btn-sm" :href="formAdd">Add New</a>
              </div>
            </div>
            <div class="card-body">
              <div class="cd-table-responsive admin-user-list text-center">
                <data-table
                  :columns="columns"
                  :url="urlGetData"
                  ref="weightList"
                  :translate="translate"
                  :classes="classes"
                >
                  <span slot="filters"> </span>
                  <tbody slot="body" slot-scope="{ data }">
                    <tr :key="item.id" v-for="item in data">
                      <td :key="column.name" v-for="column in columns">
                        <data-table-cell
                          :value="item"
                          :name="column.name"
                          :meta="column.meta"
                          :comp="column.component"
                          :classes="column.classes"
                        >
                        </data-table-cell>
                        <slot v-if="column.name == 'action' && item.id != 2">
                          <a :href="`weight/${item.id}/edit`">
                            <button
                              class="btn btn-success delete-button"
                              type="button"
                            >
                              Sửa
                            </button></a
                          >
                          <button
                            class="btn btn-danger delete-button"
                            @click="deleteWeight(item.id)"
                          >
                            Xóa
                          </button>
                        </slot>
                      </td>
                    </tr>
                  </tbody>
                </data-table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <Loader :flag-show="flagShowLoader"></Loader>
  </div>
</template>

<script>
import Loader from "../../Common/loader.vue";
import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      csrfToken: Laravel.csrfToken,
      urlGetData: this.getWeight,
      columns: [
        { label: "Numerical Order", name: "id", orderable: true },
        { label: "Name", name: "weight", orderable: true },
        { label: "Action", name: "action" },
      ],
      filters: {},
      translate: { nextButton: ">", previousButton: "<" },
      pagination: { data: {}, hideWhenEmpty: true },
      classes: {
        "table-container": {
          "table-responsive": true,
        },
        table: {
          table: true,
          "table-borderless": true,
          border: false,
        },
        "t-head": {},
        "t-body": {},
        "t-head-tr": {},
        "t-body-tr": {},
        td: {},
        th: {},
      },
      flagShowLoader: false,
    };
  },
  props: ["formAdd", "getWeight"],
  mounted() {},
  components: {
    Loader,
  },
  methods: {
    deleteWeight(id) {
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
          that.flagShowLoader = true;
          axios
            .get(`weight/${id}/delete`)
            .then((response) => {
              this.$swal({
                title: "Delete successfully!",
                icon: "success",
                confirmButtonText: "OK",
              }).then(function (confirm) {});
              that.updateTable();
              that.flagShowLoader = false;
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
    updateTable() {
      this.$refs.weightList.getData();
    },
  },
};
</script>
