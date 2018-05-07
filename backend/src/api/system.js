import ajax from '../utils/ajax'

export function fetchUsers() {
    return ajax({
        method: 'get',
        url: '/api/system/users'
    })
}

export function fetchRoles() {
    return ajax({
        method: 'get',
        url: '/api/system/roles'
    })
}

export function fetchPermissions() {
    return ajax({
        method: 'get',
        url: '/api/system/permissions'
    });
}

export function createPermission(data) {
    return ajax({
        method: 'post',
        url: '/api/system/permission',
        data
    });
}

export function updatePermission(id, data) {
    return ajax({
        method: 'put',
        url: `/api/system/permission/${id}`,
        data
    });
}

export function deletePermission(id) {
    return ajax({
        method: 'delete',
        url: `/api/system/permission/${id}`
    });
}

export function fetchPermission(id) {
    return ajax({
        method: 'get',
        url: `/api/system/permission/${id}`
    });
}

export function createRole(data) {
    return ajax({
        method: 'post',
        url: '/api/system/role',
        data
    });
}

export function deleteRole(id) {
    return ajax({
        method: 'delete',
        url: `/api/system/role/${id}`
    });
}

export function fetchRole(id) {
    return ajax({
        method: 'get',
        url: `/api/system/role/${id}`
    });
}

export function updateRole(id, data) {
    return ajax({
        method: 'put',
        url: `/api/system/role/${id}`,
        data
    });
}
