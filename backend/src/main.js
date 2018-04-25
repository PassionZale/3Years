import Vue from 'vue'
import router from './routers'
import store from './vuex/store'
import App from './App.vue'
import iView from 'iview'
import { getToken } from './utils/auth'
import 'iview/dist/styles/iview.css';

Vue.use(iView);

const whiteListRouter = ['/login', '/superuser'];

router.beforeEach((to, from, next) => {
    if (getToken()) {
        if(to.path === '/login'){
            next({ path: '/' })
        }else{
            next();
        }
    } else {
        if (whiteListRouter.indexOf(to.path) !== -1) {
            next();
        } else {
            next('/login');
        }
    }
});

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app');