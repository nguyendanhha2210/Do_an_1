require('./bootstrap');
// window.Vue = require('vue').default;
import Vue from 'vue'
import Paginate from 'vuejs-paginate'
import VeeValidate from "vee-validate";
import FlashMessage from '@smartweb/vue-flash-message';
import DataTable from 'laravel-vue-datatable'
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import LoginComponent from './components/Ship/User/LoginComponent'
import OrderComponent from './components/Ship/Order/OrderComponent.vue'


Vue.use(VueSweetalert2);
Vue.use(DataTable);
Vue.component('paginate', Paginate)
Vue.use(FlashMessage);
Vue.use(VeeValidate, {
    locale: "ja"
});

new Vue({
    el: '#shipApp',
    // render: h => h(App),
    components: {
        LoginComponent,
        OrderComponent,
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
                return /\.(jpe?g|png|gif)$/i.test(value[0].name);
            }
        });
    }
});