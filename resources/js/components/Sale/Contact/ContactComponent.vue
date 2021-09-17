<template>
  <div style="background-color: #e9edf0">
    <!-- Map Section Begin -->
    <div class="pt-5 pb-5">
      <div class="container" style="background-color: white">
        <div class="map-inner">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29786.53735057556!2d105.65036752910699!3d21.059990852076865!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313456926dffe03b%3A0x603734b21af6b8f1!2zRMawxqFuZyBMaeG7hXUsIEhvw6BpIMSQ4bupYywgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1624633251436!5m2!1svi!2s"
            height="610"
            style="border: 0"
            allowfullscreen=""
          >
          </iframe>

          <div class="icon">
            <i class="fa fa-map-marker"></i>
          </div>
        </div>
      </div>
    </div>
    <!-- Map Section Begin -->

    <!-- Contact Section Begin -->
    <div class="container pb-5">
      <div class="row">
        <div
          class="col-lg-5"
          style="background-color: white; padding: 15px 10px"
        >
          <div class="contact-title">
            <h4>Contacts Us</h4>
            <p>
              Hãy liên hệ với chúng tôi nều bạn đang có nhưng băn khoăn và chưa
              rõ về cách mua hàng .
            </p>
          </div>
          <div class="contact-widget">
            <div class="cw-item">
              <div class="ci-icon">
                <i class="ti-location-pin"></i>
              </div>
              <div class="ci-text">
                <span>Address:</span>
                <p>Dương Liễu - Hoài Đức - Hà Nội</p>
              </div>
            </div>
            <div class="cw-item">
              <div class="ci-icon">
                <i class="ti-mobile"></i>
              </div>
              <div class="ci-text">
                <span>Phone:</span>
                <p>+33 6868.6868</p>
              </div>
            </div>
            <div class="cw-item">
              <div class="ci-icon">
                <i class="ti-email"></i>
              </div>
              <div class="ci-text">
                <span>Email:</span>
                <p>danhha221020@gmail.com</p>
              </div>
            </div>
          </div>
        </div>
        <div
          class="col-lg-6 offset-lg-1"
          style="background-color: white; padding: 15px 10px"
        >
          <div class="contact-form">
            <div class="leave-comment">
              <h4>Leave A Comment</h4>
              <p>Our staff will call back later and answer your questions.</p>
              <form action="#" class="comment-form">
                <div class="row">
                  <div class="col-lg-6">
                    <input type="text" placeholder="Your name" />
                  </div>
                  <div class="col-lg-6">
                    <input type="text" placeholder="Your email" />
                  </div>
                  <div class="col-lg-12 text-center">
                    <textarea placeholder="Your message"></textarea>
                    <button type="submit" class="site-btn">Send message</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Contact Section End -->
  </div>
</template>

<style lang="scss" scoped>
.button-mualai {
  float: initial;
  margin-top: 3px;
  transform: translateY(-4px);
}
</style>

<script>
import Vue from "vue";
import axios from "axios";
export default {
  data() {
    return {};
  },
  created() {},
  mounted() {},
  components: {},
  methods: {},
};
</script>

