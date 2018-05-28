import ajax from '../utils/ajax'

export function fetchFreight() {
    return ajax({
        method: 'get',
        url: '/api/shop/freight'
    });
}

export function updateFreight(data) {
    return ajax({
        method: 'put',
        url: '/api/shop/freight',
        data
    });
}