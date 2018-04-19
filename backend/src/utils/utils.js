import axios from 'axios';
import qs from 'qs';

const ajaxUrl = process.env.NODE_ENV === 'development' ?
    '127.0.0.1:8000' :
    process.env.NODE_ENV === 'production' ?
        'https://www.url.com' :
        'https://debug.url.com';


util.ajax = axios.create({
    baseURL: ajaxUrl,
    timeout: 30000,
    transformRequest: [function (data) {
        data = qs.stringify(data);
        return data;
    }]
});
util.ajax.defaults.headers.common['Authorization'] = '';
util.ajax.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

export default util;


