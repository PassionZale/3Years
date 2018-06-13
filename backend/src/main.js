import Vue from 'vue'
import router from './routers'
import store from './vuex/store'
import App from './App.vue'
import iView from 'iview'
import { getToken } from './utils/auth'

Vue.use(iView);

const whiteListRouter = ['/login', '/superuser'];

router.beforeEach((to, from, next) => {
    iView.LoadingBar.start();
    if (getToken()) {
        if (to.path === '/login') {
            next({ path: '/' })
        } else {
            if (store.getters.user.role === '') {
                // 1. 初始化用户信息
                store.dispatch('FetchUserInfo').then(user => {
                    // 2. 渲染 routes
                    store.dispatch('GenerateRoutes', user).then(() => {
                        // 3. 增加 routes
                        router.addRoutes(store.getters.addRouters)
                        next({ ...to, replace: true })
                    });
                }).catch(error => {
                    console.log(error);
                });
            } else {
                next();
            }
        }
    } else {
        if (whiteListRouter.indexOf(to.path) !== -1) {
            next();
        } else {
            next('/login');
        }
    }
});

router.afterEach(router => {
    let title = '3Years';
    if (router.name) {
        title += `-${router.name}`;
    }
    document.title = title;
    iView.LoadingBar.finish();
});

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app');