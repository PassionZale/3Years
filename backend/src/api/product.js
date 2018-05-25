import ajax from '../utils/ajax'
import { baseURL } from '../utils/base'

export const ACTION_FOR_PRODUCT_THUMB_IMG = `${baseURL}/api/upload/product_thumb_img`;

export const ACTION_FOR_PRODUCT_BANNERS = `${baseURL}/api/upload/product_banners`;

export function createProduct(data) {
    return ajax({
        method: 'post',
        url: '/api/product',
        data
    });
}

export function fetchProduct(id = '') {
    return ajax({
        method: 'get',
        url: `/api/product/${id}`
    });
}

export function fetchProducts(page = 1, category = 'all', keyword = '') {
    let url = `/api/product?page=${page}&category=${category}`
    if (keyword !== '') {
        url += `&keyword=${keyword}`;
    }
    return ajax({
        method: 'get',
        url
    });
}

export function deleteProduct(id) {
    return ajax({
        method: 'delete',
        url: `/api/product/${id}`
    })
}

export function updateProduct(type = '', id = '', data) {
    return ajax({
        method: 'put',
        url: `/api/product/${type}/${id}`,
        data
    });
}

export function updateSku(id = '', data) {
    return ajax({
        method: 'put',
        url: `/api/product/sku/${id}`,
        data
    })
}

export function deleteSku(id = '') {
    return ajax({
        method: 'delete',
        url: `/api/product/sku/${id}`
    });
}

export function createSku(data){
    return ajax({
        method: 'post',
        url: '/api/product/sku',
        data
    });
}

export function fetchParentCategories() {
    return ajax({
        method: 'get',
        url: '/api/product/parentCategories'
    });
}

export function fetchChildCategories(id = '') {
    return ajax({
        method: 'get',
        url: `/api/product/childCategories/${id}`
    });
}

export function fetchCategories() {
    return ajax({
        mehtod: 'get',
        url: '/api/product/categories'
    });
}

export function createCategory(data) {
    return ajax({
        method: 'post',
        url: '/api/product/category',
        data
    });
}

export function deleteCategory(id) {
    return ajax({
        method: 'delete',
        url: `/api/product/category/${id}`
    });
}

export function fetchCategory(id) {
    return ajax({
        method: 'get',
        url: `/api/product/category/${id}`
    });
}

export function updateCategory(id, data) {
    return ajax({
        method: 'put',
        url: `/api/product/category/${id}`,
        data
    });
}

export function createAttribute(data) {
    return ajax({
        method: 'post',
        url: '/api/product/attribute',
        data
    });
}

export function fetchAttributes(category_id = 0, page = 1) {
    return ajax({
        method: 'get',
        url: `/api/product/attributes?category_id=${category_id}&page=${page}`,
    });
}

export function fetchAttribute(id = '') {
    return ajax({
        method: 'get',
        url: `/api/product/attribute/${id}`
    });
}

export function updateAttribute(id = '', data) {
    return ajax({
        method: 'put',
        url: `/api/product/attribute/${id}`,
        data
    });
}

export function deleteAttribute(id = '') {
    return ajax({
        method: 'delete',
        url: `/api/product/attribute/${id}`,
    });
}