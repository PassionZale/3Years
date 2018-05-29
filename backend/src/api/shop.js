import ajax from '../utils/ajax'
import { baseURL } from '../utils/base'

export const ACTION_FOR_SHOP_BANNER = `${baseURL}/api/upload/shop_banner`;

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

export function createBanner(data) {
    return ajax({
        method: 'post',
        url: '/api/shop/banner',
        data
    });
}

export function fetchBanner(id = '') {
    let url = id ? `/api/shop/banner/${id}` : '/api/shop/banner';
    return ajax({
        method: 'get',
        url
    });
}

export function deleteBanner(id = '') {
    return ajax({
        method: 'delete',
        url: `/api/shop/banner/${id}`
    });
}

export function updateBanner(id, data){
    return ajax({
        method: 'put',
        url: `/api/shop/banner/${id}`,
        data
    });
}

export function fetchRecommend(){
    return ajax({
        method: 'get',
        url: '/api/shop/recommend'
    });
}

export function createRecommend(data){
    return ajax({
        method: 'post',
        url: '/api/shop/recommend',
        data
    });
}

export function deleteRecommend(id){
    return ajax({
        method: 'delete',
        url: `/api/shop/recommend/${id}`,
    });
}
