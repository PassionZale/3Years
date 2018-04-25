import { login, superuser } from '../../api/auth'
import { fetchUserInfo, updateUserInfo, updateUserPwd } from '../../api/user'
import { setToken, removeToken } from '../../utils/auth'

const user = {
    state: {
        id: '',
        username: '',
        email: '',
        roles: []
    },

    mutations: {
        SET_ID: (state, id) => {
            state.id = id
        },
        SET_USERNAME: (state, username) => {
            state.username = username
        },
        SET_EMAIL: (state, email) => {
            state.email = email
        },
        SET_ROLES: (state, roles) => {
            state.roles = roles;
        }
    },

    actions: {
        Login({ commit }, params) {
            return new Promise((resolve, reject) => {
                login(params.username, params.password).then(response => {
                    if (response.ret_code === 0) {
                        let token = response.ret_msg.token;
                        setToken(token);
                        resolve();
                    } else {
                        reject(response.ret_msg);
                    }
                }).catch(error => {
                    reject(error);
                });
            });
        },
        Superuser({ commit }, params) {
            return new Promise((resolve, reject) => {
                superuser(params).then(response => {
                    if (response.ret_code === 0) {
                        resolve();
                    } else {
                        reject(response.ret_msg);
                    }
                }).catch(error => {
                    reject(error);
                });
            })
        },
        LogOut() {
            removeToken();
            return;
        },
        FetchUserInfo({ commit, state }) {
            return new Promise((resolve, reject) => {
                fetchUserInfo().then(response => {
                    if (response.ret_code === 0) {
                        let userinfo = response.ret_msg;
                        commit('SET_ID', userinfo.id);
                        commit('SET_USERNAME', userinfo.username);
                        commit('SET_EMAIL', userinfo.email);
                        resolve();
                    } else {
                        reject(response.ret_msg);
                    }
                }).catch(error => {
                    reject(error);
                });
            });
        },
        UpdateUserInfo({ commit, state }, params) {
            return new Promise((resolve, reject) => {
                updateUserInfo(params).then(response => {
                    if(response.ret_code === 0) {
                        let userinfo = response.ret_msg;
                        commit('SET_ID', userinfo.id);
                        commit('SET_USERNAME', userinfo.username);
                        commit('SET_EMAIL', userinfo.email);
                        resolve();
                    }else{
                        reject(response.ret_msg);
                    }
                }).catch(error => {
                    reject(error);
                });
            });
        },
        UpdateUserPwd({ commit, state }, params) {
            return new Promise((resolve, reject) => {
                updateUserPwd(params).then(response => {
                    if(response.ret_code === 0) {
                        resolve();
                    }else{
                        reject(response.ret_msg);
                    }
                }).catch(error => {
                    reject(error);
                });
            });
        }
    }
}

export default user;