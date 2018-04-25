import ajax from '../utils/ajax'

export function fetchUserInfo() {
    return ajax({
        method: 'get',
        url: '/api/user'
    })
}

export function updateUserInfo(params) {
    return ajax({
        method: 'put',
        url: `/api/user/userinfo`,
        data: params
    })
}

export function updateUserPwd(params) {
    return ajax({
        method: 'put',
        url: `/api/user/userpwd`,
        data: params
    })
}