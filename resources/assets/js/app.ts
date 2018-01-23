import Vue,{ComponentOptions} from "vue";
import axios from "./util/axios";
import Vuex from "vuex";
import VueRouter from "vue-router";
import * as _ from 'lodash';
import Main from './page/Main.vue';
import storeFactoy from './store/';
import routerFactoy from './router';
import ElementUI from 'element-ui';
import Loading from './components/Loading.vue'

declare module 'vue/types/vue' {
// 3. 声明为 Vue 补充的东西
    interface Vue {
        $loadingBar: Loading;
        $router:VueRouter
    }
}


interface vueWindow extends Window{
    axios: any;
    _: any;
    Vue: any
}
declare var window: vueWindow;


(function (window: vueWindow, document: any) {
    window.Vue = Vue;
    window._ = _;

    Vue.use(VueRouter);
    Vue.use(Vuex);
    Vue.use(ElementUI);

    const store = storeFactoy(Vuex);
    const router = routerFactoy(store);
    window.axios = axios(store,router);
    const app = new Main({
        el: '#app',
        store,
        router
    })
})(window, document);


