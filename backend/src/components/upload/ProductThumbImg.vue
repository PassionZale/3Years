<template>
    <div class="form-item-wrapper">
        <label>缩略图：</label>
        
        <div class="upload-file-wrapper" v-for="file in fileList" v-if="fileList.length">
          <template v-if="file.status === 'finished'">
            <img :src="file.url" :alt="file.name" :title="file.name"/>
          </template>
          <template v-else>
            <Progress v-if="file.showProgress" :percent="file.percentage" hide-info></Progress>
          </template>
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
          :on-error="handleError"
          :show-upload-list="upload.show_upload_list"
          :default-file-list="defaultFileList"
          style="display:inline-block;">
          <Button type="ghost" icon="ios-cloud-upload-outline">点击上传</Button>
        </Upload>

    </div>
</template>

<script>
import { ACTION_FOR_PRODUCT_THUMB_IMG } from "../../api/product";
import { getToken } from "../../utils/auth";
export default {
  props: {
    thumb: {
      type: Object,
      default: function() {
        return {};
      },
      required: true
    },
    defaultFileList: {
      type: Array,
      default: function() {
        return [];
      }
    }
  },
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
      fileList: []
    };
  },
  mounted() {
    this.fileList = this.$refs.thumb_uploader.fileList;
  },
  updated() {
    this.fileList = this.$refs.thumb_uploader.fileList;
  },
  methods: {
    handleFormatError() {
      this.$Message.error("只允许上传.PNG、.JPG、.JPEG文件");
    },
    handleExceedeSize() {
      this.$Message.error("只允许上传1MB以内的文件");
    },
    handleBeforeUpload() {
      if (this.fileList.length >= 1) {
        this.fileList.length = 0;
      }
    },
    handleSuccess(response, file) {
      if (response.ret_code === 0) {
        file.name = response.ret_msg.name;
        file.url = response.ret_msg.url;
        this.$Message.success("上传成功");
        this.$emit("update:thumb", { url: file.url });
      } else {
        this.$Message.error(response.ret_msg);
      }
    },
    handleError(error) {
      if(error.status === 403){
        this.$Message.error('暂无文件上传权限');
      }else{
        this.$Message.error('上传失败');
      }
    }
  }
};
</script>

<style lang="less">
.upload-file-wrapper {
  display: inline-block;
  width: 80px;
  height: auto;
  vertical-align: middle;
  margin-right: 15px;
  img {
    display: block;
    max-width: 100%;
    height: auto;
  }
}
</style>

