import { login, superuser, logout } from '../../api/auth'
import { setToken,removeToken } from '../../utils/auth'

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
                    const token = response.ret_msg.token;
                    setToken(token);
                    resolve();
                }).catch(error => {
                    reject(error);
                });
            });
        },
        Superuser({ commit }, params) {
            return new Promise((resolve, reject) => {
                superuser(params).then(response => {
                    const data = response;
                    console.log(data);
                    resolve();
                }).cache(error => {
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