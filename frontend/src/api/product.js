import ajax from '../utils/ajax'

export function fetchProducts(page = 1) {
    return ajax({
        method: 'get',
        url: `/api/product/list?page=${page}`
    });
}