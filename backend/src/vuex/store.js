import middlewares from './middlewares'
import Vue from 'vue'
import Vuex from 'vuex'
import authRandomBg from './modules/randomImages'
import user from './modules/user'
import permissions from './modules/permissions'
import getters from './getters'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        authRandomBg,
        user,
        permissions
    },
    getters,
    strict: process.env.NODE_ENV !== 'production',
    plugins: middlewares,
});