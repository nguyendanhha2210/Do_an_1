<template>
  <div v-if="modalShow"></div>
</template>

<script>
export default {
  mounted() {},
  created: function () {
    if (this.modalShow) {
      this.showNotification();
    }
  },
  props: [
    "type",
    "title",
    "text",
    "confirm",
    "cancle",
    "urlConfirm",
    "urlCancle",
    "modalShow",
  ],

  mounted() {},
  methods: {
    showNotification() {
      this.$swal({
        position: "center-center",
        icon: this.type,
        title: this.title,
        text: this.text,
        showCancelButton: true,
        confirmButtonText: this.confirm,
        confirmButtonColor: "#3085d6",
        cancelButtonText: this.cancle,
        cancelButtonColor: "#d33",
      }).then((result) => {
        if (result.isConfirmed) {
          window.location = this.urlConfirm;
        } else {
          window.location = this.urlCancle;
        }
      });
    },
  },
};
</script>
