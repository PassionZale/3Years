import ajax from '../utils/ajax'
import { baseURL } from '../utils/base'

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

export const ACTION_FOR_PRODUCT_THUMB_IMG = `${baseURL}/api/upload/product_thumb_img`;

export const ACTION_FOR_PRODUCT_BANNERS = `${baseURL}/api/upload/product_banners`;