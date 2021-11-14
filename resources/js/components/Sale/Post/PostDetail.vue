<template>
  <div style="background-color: #e9edf0">
    <section class="pt-5 pb-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-12" style="background-color: white">
            <div
              class="blog-details-inner"
              v-for="post in postDetails"
              :key="post.id"
            >
              <div class="blog-detail-title">
                <h2>{{ post.title }}</h2>
                <p>
                  {{ post.categorypost.name
                  }}<span>-{{ post.created_at | formatDate }}</span>
                </p>
              </div>
              <div class="blog-large-pic">
                <img
                  style="height: 550px"
                  :src="baseUrl + '/uploads/posts/' + post.images"
                  alt=""
                />
              </div>
              <div class="blog-detail-desc">
                <p v-html="post.content">
                </p>
              </div>
              <div class="blog-quote">
                <p>“ {{ post.desc }}”</p>
              </div>
              <div class="tag-share">
                <div class="details-tag">
                  <ul>
                    <li><i class="fa fa-tags"></i></li>
                    <li>{{ post.categorypost.name }}</li>
                  </ul>
                </div>
                <div class="blog-share">
                  <span>Share:</span>
                  <div class="social-links">
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-google-plus"></i></a>
                    <a href="#"><i class="fa fa-instagram"></i></a>
                    <a href="#"><i class="fa fa-youtube-play"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Blog Details Section End -->

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
import Modal from "../../Modal/Modal.vue";
import Loader from "../../Common/loader.vue";
import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {
      baseUrl: Laravel.baseUrl, //Gọi thay cho đg dẫn http://127.0.0.1:8000
      postDetails: [],
      post: {
        title: "",
        id_category_post: "",
        desc: "",
        images: "",
        status: "",
        content: "",
      },
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
  created() {
    this.fetchData();
  },
  components: {
    Modal,
    Loader,
  },
  //   mounted() { console.log(this.posts.title)},

  methods: {
    fetchData() {
      let that = this;
      this.flagShowLoader = true;
      axios
        .get("get-detail")
        .then(function (response) {
          that.postDetails = response.data.postDetail; //show data ra
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
  },
};
</script>