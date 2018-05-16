import ajax from '../utils/ajax'

export function productThumbImg(data){
    return ajax({
        method: 'post',
        url: '/api/upload/product_thumb_img',
        data
    });
}

export function productBanners(data){
    return ajax({
        method: 'post',
        url: '/api/upload/product_banners',
        data
    });
}