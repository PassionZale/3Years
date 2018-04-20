import Vue from 'vue';
import router from './routers'
import App from './App.vue';
import iView from 'iview';
import 'iview/dist/styles/iview.css';

Vue.use(iView);

new Vue({
    el: '#app',
    router: router,
    render: h => h(App)
});