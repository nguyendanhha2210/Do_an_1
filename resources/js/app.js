require('./bootstrap');
// window.Vue = require('vue').default;
import Vue from 'vue'
import Paginate from 'vuejs-paginate'
import VeeValidate from "vee-validate";
import FlashMessage from '@smartweb/vue-flash-message';
import DataTable from 'laravel-vue-datatable';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import moment from 'moment';
import VueCardCarousel from "vue-card-carousel"
import LoginComponent from './components/Sale/User/LoginComponent.vue'
import RegisterComponent from './components/Sale/User/RegisterComponent.vue'
import ForgotPassword from './components/Sale/User/Password/Forgot.vue'
import SuccessEmail from './components/Sale/User/Password/SuccessMail.vue'
import ChangePassword from './components/Sale/User/Password/Change.vue'
import SuccessChange from './components/Amin/User/Password/Success.vue'
import ShopComponent from './components/Sale/Shop/shop/DataProducts.vue'
import DetailProduct from './components/Sale/Shop/detail-product/DetailProduct.vue'
import TypeProduct from './components/Sale/Shop/choose-product/TypeProduct.vue'
import DescriptionProduct from './components/Sale/Shop/choose-product/DescriptionProduct.vue'
import WeightProduct from './components/Sale/Shop/choose-product/WeightProduct.vue'
import CheckoutCart from './components/Sale/Shop/checkout-cart/CheckoutCart.vue'
import ManagerOrder from './components/Sale/Shop/order/ManageOrder.vue'

import PostComponent from './components/Sale/Post/PostComponent.vue'
import PostDetail from './components/Sale/Post/PostDetail.vue'
import ContactComponent from './components/Sale/Contact/ContactComponent.vue'
import ProfileComponent from './components/Sale/Profile/ProfileComponent.vue'



Vue.component('paginate', Paginate)
Vue.use(VueCardCarousel)
Vue.use(VueSweetalert2);
Vue.use(DataTable)
Vue.use(FlashMessage);
Vue.use(VeeValidate, {
    locale: "ja"
});
Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('MM/DD/YYYY hh:mm')
    }
});

new Vue({
    el: '#app',
    components: {
        LoginComponent,
        ForgotPassword,
        SuccessEmail,
        ChangePassword,
        SuccessChange,
        ShopComponent,
        DetailProduct,
        TypeProduct,
        DescriptionProduct,
        WeightProduct,
        CheckoutCart,
        RegisterComponent,
        ManagerOrder,
        PostComponent,
        PostDetail,
        ContactComponent,
        ProfileComponent,
    },
    created() {
        this.$validator.extend("number_phone", {
            validate: function(value) {
                return /(84|0[3|5|7|8|9])+([0-9]{8})\b/g.test(value);
            }
        });
        this.$validator.extend("email_format", {
            validate: function(value) {
                return /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/i.test(value);
            }
        });
        this.$validator.extend("image_format", {
            validate: function(value) {
                return /\.(gif|jpe?g|tiff?|png|webp|bmp)$/i.test(value);
            }
        });
    }
});