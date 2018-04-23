import ajax from '../utils/ajax'

/**
 * 通过用户名及密码登录
 * 
 * @param {String} username 
 * @param {String} password 
 */
export function login(username, password) {
    const data = {
        username,
        password
    }
    return ajax({
        method: 'post',
        url: '/auth/login',
        data
    });
}

/**
 * 创建超级用户
 * 
 * @param {Object} params 
 */
export function superuser(params) {
    return ajax({
        method: 'post',
        url: '/auth/superuser',
        data: params
    })
}