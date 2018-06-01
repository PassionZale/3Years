import { getToken } from './auth';

export const baseURL = process.env.NODE_ENV === 'production' ?
    'http://server.3years.lovchun.com/backend' :
    //'http://3years.tom.com/backend' :
    'http://127.0.0.1:8000/backend';


export function descartes(list) {
    //parent上一级索引;count指针计数
    var point = {};
    var result = [];
    var pIndex = null;
    var tempCount = 0;
    var temp = [];
    //根据参数列生成指针对象
    for (var index in list) {
        if (typeof list[index] == 'object') {
            point[index] = { 'parent': pIndex, 'count': 0 }
            pIndex = index;
        }
    }
    //单维度数据结构直接返回
    if (pIndex == null) {
        return list;
    }
    //动态生成笛卡尔积
    while (true) {
        for (var index in list) {
            tempCount = point[index]['count'];
            temp.push(list[index][tempCount]);
        }
        //压入结果数组
        result.push(temp);
        temp = [];
        //检查指针最大值问题
        while (true) {
            if (point[index]['count'] + 1 >= list[index].length) {
                point[index]['count'] = 0;
                pIndex = point[index]['parent'];
                if (pIndex == null) {
                    return result;
                }
                //赋值parent进行再次检查
                index = pIndex;
            }
            else {
                point[index]['count']++;
                break;
            }
        }
    }
}

// 富文本编辑器 自定义工具栏
export const editorMenu = [
    "head", // 标题
    "bold", // 粗体
    "fontSize", // 字号
    "fontName", // 字体
    "italic", // 斜体
    "underline", // 下划线
    "strikeThrough", // 删除线
    "foreColor", // 文字颜色
    "backColor", // 背景颜色
    "link", // 插入链接
    "list", // 列表
    "justify", // 对齐方式
    "image", // 插入图片
    "table", // 表格
    "video", // 插入视频
    "undo", // 撤销
    "redo" // 重复
];

// 富文本编辑器 上传图片服务端接口地址
export const editorUploadImgServer = `${baseURL}/api/upload/product_editor_images`;

// 富文本编辑器 上传图片大小限制为 2MB
export const uploadImgMaxSize = 2 * 1024 * 1024;

// 富文本编辑器 上传图片每次最多上传5张
export const uploadImgMaxLength = 5;

// 富文本编辑器 上传图片自定义 filename
export const uploadFileName = 'editor_images[]';

// 富文本编辑器 上传图片自定义 Headers
export const uploadImgHeaders = { 'Authorization': getToken() };
