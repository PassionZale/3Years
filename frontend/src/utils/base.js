export const baseURL = process.env.NODE_ENV === 'production' ?
    'http://server.3years.lovchun.com/backend' :
    'http://127.0.0.1:8000/frontend';


export function chunkArr(arr = [], chunk = 2) {
    var i,
        len = arr.length,
        tmp_arr = [];
    for (i = 0; i < len; i += chunk) {
        tmp_arr.push(arr.slice(i, i + chunk));
    }
    return tmp_arr;
}