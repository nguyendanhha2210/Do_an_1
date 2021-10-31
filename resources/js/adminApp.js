require('./bootstrap');
// window.Vue = require('vue').default;
import Vue from 'vue'
import Paginate from 'vuejs-paginate'
import VeeValidate from "vee-validate";
import FlashMessage from '@smartweb/vue-flash-message';
import DataTable from 'laravel-vue-datatable'
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import moment from 'moment';
import VueStarRating from 'vue-star-rating';
import CKEditor from 'ckeditor4-vue';

import LoginComponent from './components/Amin/User/LoginComponent'
import TypeComponent from './components/Amin/Type/TypeComponent.vue'
import TypeAdd from './components/Amin/Type/TypeAdd.vue'
import TypeEdit from './components/Amin/Type/TypeEdit.vue'
import WeightComponent from './components/Amin/Weight/WeightComponent.vue'
import WeightAdd from './components/Amin/Weight/WeightAdd.vue'
import WeightEdit from './components/Amin/Weight/WeightEdit.vue'
import ProductComponent from './components/Amin/Product/ProductComponent.vue'
import DescriptionAdd from './components/Amin/Description/DescriptionAdd.vue'
import DescriptionComponent from './components/Amin/Description/DescriptionComponent.vue'
import DescriptionEdit from './components/Amin/Description/DescriptionEdit.vue'
import ForgotPassword from './components/Amin/User/Password/Forgot.vue'
import SuccessEmail from './components/Amin/User/Password/SuccessMail.vue'
import ChangePassword from './components/Amin/User/Password/Change.vue'
import SuccessChange from './components/Amin/User/Password/Success.vue'
import CouponComponent from './components/Amin/Coupon/CouponComponent.vue'
import CouponSend from './components/Amin/Coupon/CouponSendCustomer.vue'
import CouponShow from './components/Amin/Coupon/CouponShowCustomer.vue'
import CouponEdit from './components/Amin/Coupon/CouponEdit.vue'
import OrderComponent from './components/Amin/Order/OrderComponent.vue'
import WarehouseComponent from './components/Amin/WareHouse/WareHouseComponent.vue'
import WarehouseAdd from './components/Amin/WareHouse/WareHouseAdd.vue'
import WarehouseEdit from './components/Amin/WareHouse/WareHouseEdit.vue'
import CategoryPostAdd from './components/Amin/CategoryPost/CategoryAdd.vue'
import CategoryPostComponent from './components/Amin/CategoryPost/CategoryComponent.vue'
import CategoryPostEdit from './components/Amin/CategoryPost/CategoryEdit.vue'
import PostComponent from './components/Amin/Post/PostComponent.vue'
import ReplyComment from './components/Amin/ReplyComment/ReplyComment.vue'
import UserComponent from './components/Amin/User/UserComponent.vue'
import UserDetail from './components/Amin/User/UserDetail.vue'
import ShipperComponent from './components/Amin/User/ShipperComponent.vue'
import AdminComponent from './components/Amin/User/AdminComponent.vue'
import ImageAdd from './components/Amin/Product/ImageAdd.vue'
import ImageDetail from './components/Amin/Product/ImageDetail.vue'
import ImageEdit from './components/Amin/Product/ImagesEdit.vue'
import DashBoards from './components/Amin/Dashboard/DashBoard.vue'

import InvoiceStatistical from './components/Amin/Statistical/Invoice.vue'
import ProductStatistical from './components/Amin/Statistical/Product.vue'
import RatingStatistical from './components/Amin/Statistical/Rating.vue'


Vue.use(CKEditor);
Vue.use(VueStarRating)
Vue.use(VueSweetalert2);
Vue.use(DataTable);
Vue.component('paginate', Paginate)
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
    el: '#adminApp',
    // render: h => h(App),
    components: {
        LoginComponent,
        TypeComponent,
        TypeAdd,
        TypeEdit,
        WeightComponent,
        WeightAdd,
        WeightEdit,
        ProductComponent,
        DescriptionAdd,
        DescriptionComponent,
        DescriptionEdit,
        ForgotPassword,
        SuccessEmail,
        ChangePassword,
        SuccessChange,
        CouponComponent,
        CouponSend,
        CouponShow,
        CouponEdit,
        OrderComponent,
        WarehouseComponent,
        WarehouseAdd,
        WarehouseEdit,
        CategoryPostAdd,
        CategoryPostComponent,
        CategoryPostEdit,
        PostComponent,
        ReplyComment,
        UserComponent,
        UserDetail,
        ShipperComponent,
        AdminComponent,
        ImageAdd,
        ImageDetail,
        ImageEdit,
        DashBoards,
        InvoiceStatistical,
        ProductStatistical,
        RatingStatistical,
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
                // console.log(value[0]);
                return /\.(jpe?g|png|gif)$/i.test(value[0].name);
            }
        });
    }
});