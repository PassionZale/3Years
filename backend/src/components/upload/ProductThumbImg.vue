<template>
    <div class="form-item-wrapper">
        <label>缩略图：</label>
        
        <div class="thumb-file-wrapper" v-for="file in fileList">
            <img :src="file.url" :alt="file.name">
        </div>

        <Upload 
           ref="thumb_uploader"
          :action="upload.action" 
          :name="upload.name"
          :headers="upload.headers"
          :format="upload.format"
          :on-format-error="handleFormatError"
          :max-size="upload.max_size"
          :on-exceeded-size="handleExceedeSize"
          :before-upload="handleBeforeUpload"
          :on-success="handleSuccess"
          :show-upload-list="upload.show_upload_list"
          style="display:inline-block;">
          <Button type="ghost" icon="ios-cloud-upload-outline">点击上传</Button>
        </Upload>
      </div>
</template>

<script>
import { ACTION_FOR_PRODUCT_THUMB_IMG } from "../../api/product";
import { getToken } from "../../utils/auth";
export default {
  data() {
    return {
      upload: {
        action: ACTION_FOR_PRODUCT_THUMB_IMG,
        name: "thumb_img",
        headers: { Authorization: getToken() },
        format: ["jpg", "jpeg", "png"],
        max_size: 1024,
        show_upload_list: false
      },
      fileList:[],
    };
  },
  mounted(){
      this.fileList = this.$refs.thumb_uploader.fileList;
  },
  methods: {
    handleFormatError() {
      this.$Message.error("只允许上传.PNG、.JPG、.JPEG文件");
    },
    handleExceedeSize() {
      this.$Message.error("只允许上传1MB以内的文件");
    },
    handleBeforeUpload(){
        if(this.fileList.length >= 1){
            this.fileList.length = 0
        }
    },
    handleSuccess(response, file, fileList) {
        this.$Message.success('上传成功');
    }
  }
};
</script>

<style lang="less">
.thumb-file-wrapper {
    display: inline-block;
    width: 80px;
    height: 80px;
    img {
        max-width: 100%;
        height: auto;        
    }
}
</style>

