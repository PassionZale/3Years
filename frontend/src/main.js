import Vue from 'vue'
import router from './routers'
import App from './App.vue'


new Vue({
    router,
    render: h => h(App)
}).$mount('#app');

