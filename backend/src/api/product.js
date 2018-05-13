import ajax from '../utils/ajax'

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

export function fetchAttributes() {
    return ajax({
        method: 'get',
        url: '/api/product/attributes'
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