import axios from 'axios'
import qs from 'qs'
import store from '../vuex/store'
import { getToken } from './auth'
import { superUserIsNotExist, superUserIsExist, defaultErrorMsg } from './error'

const baseURL = process.env.NODE_ENV === 'production' ?
    'https://www.url.com/backend' :
    // 'http://127.0.0.1:8000/backend';
    'http://server.3years.com/backend';

const ajax = axios.create({
    baseURL: baseURL,
    timeout: 5000,
    transformRequest: [function (data) {
        data = qs.stringify(data);
        return data;
    }]
});

ajax.interceptors.request.use(config => {
    config.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
    if (getToken()) {
        config.headers['Authorization'] = getToken();
    }
    return config;
}, error => {
    Promise.reject(error);
});

ajax.interceptors.response.use(response => {
    return response.data;
}, error => {
    if (error.response) {
        let error_msg = error.response.data.ret_msg;
        if (error.response.status === 406) {
            if (error.response.data.ret_code === 'superuser is exist') {
                superUserIsExist(error_msg);
            } else {
                superUserIsNotExist(error_msg);
            }
        } else {
            defaultErrorMsg(error.response.data);
        }
    }
    return Promise.reject(error);
});

export default ajax;


