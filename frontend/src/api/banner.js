import ajax from '../utils/ajax'

export function fetchBanners() {
    return ajax({
        method: 'get',
        url: '/api/banner'
    });
}