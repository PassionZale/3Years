import middlewares from './middlewares';
import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

const state = {
    user: {
        id: null,
        username: null,
        email: null,
        role: {}
    }
};

const mutations = {
    // 登录成功
    LOGIN_SUCCESS(state, params) {
        state.user = params;
    },
};

export default new Vuex.Store({
    state,
    mutations,
    strict: process.env.NODE_ENV !== 'production',
    plugins: middlewares,
});