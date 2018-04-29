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