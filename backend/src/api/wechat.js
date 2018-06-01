import ajax from '../utils/ajax'
import qs from 'qs'

export function fetchFollows(data = {}) {
    let url = '/api/wechat/follow';
    let params = qs.stringify(data);
    if (params) {
        url = `/api/wechat/follow?${qs.stringify(data)}`;
    }
    return ajax({
        method: 'get',
        url
    });
}