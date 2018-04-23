const StorageKey = 'Authorization_Token';
const StorageValuePrefix = 'lovchun.com';

export function getToken() {
    return localStorage.getItem(StorageKey);
}

export function setToken(token) {
    return localStorage.setItem(StorageKey, `${StorageValuePrefix} ${token}`);
}

export function removeToken() {
    return localStorage.removeItem(StorageKey);
}