import ajax from '../utils/ajax'

export function fetchParentCategories() {
    return ajax({
        method: 'get',
        url: '/api/product/parentCategories'
    });
}

export function fetchChildCategories(id) {
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