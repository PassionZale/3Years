import axios from 'axios'
import qs from 'qs'
import { baseURL } from './base'

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
    return config;
}, error => {
    Promise.reject(error);
});

ajax.interceptors.response.use(response => {
    return response.data;
}, error => {
    return Promise.reject(error);
});

export default ajax;


