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
    }
});