import { login, superuser } from '../../api/auth'
import { setToken, removeToken } from '../../utils/auth'

const user = {
    state: {
        username: '',
        email: '',
        roles: []
    },

    mutations: {
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
        Logout() {
            removeToken();
            return;
        }
    }
}

export default user;