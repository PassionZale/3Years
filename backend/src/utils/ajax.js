import axios from 'axios'
import qs from 'qs'
import store from '../vuex/store'
import { getToken } from './auth'

const baseURL = process.env.NODE_ENV === 'production' ?
    'https://www.url.com/backend' :
    'http://127.0.0.1:8000/backend';

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
    if (store.getters.token) {
        config.headers['Authorization'] = getToken();
    }
    return config;
}, error => {
    console.log(error);
    Promise.reject(error);
});

ajax.interceptors.response.use(response => {
    let res = response.data;
    console.log(res);
    return res;
}, error => {
    console.log('err' + error);
    return Promise.reject(error);
});

export default ajax;


