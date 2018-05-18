<template>
    <div class="form-item-wrapper">
        <label>轮播图：</label>
        
        <div class="upload-file-list" v-for="file in fileList">
          <template v-if="file.status === 'finished'">
            <img :src="file.url" :alt="file.name" :title="file.name"/>
            <div class="upload-list-cover">
                <Icon type="ios-trash-outline" @click.native="handleRemove(file)"></Icon>
            </div>
          </template>
          <template v-else>
            <Progress v-if="file.showProgress" :percent="file.percentage" hide-info></Progress>
          </template>
        </div>

        <Upload 
           ref="banners_uploader"
           type="drag"
          :action="upload.action" 
          :name="upload.name"
          :headers="upload.headers"
          :on-format-error="handleFormatError"
          :max-size="upload.max_size"
          :on-exceeded-size="handleExceedeSize"
          :before-upload="handleBeforeUpload"
          :on-success="handleSuccess"
          :show-upload-list="upload.show_upload_list"
          style="display: inline-block;width:58px;vertical-align: middle;">
          <div style="width: 58px;height:58px;line-height: 58px;">
            <Icon type="camera" size="20"></Icon>
          </div>
        </Upload>

    </div>
</template>

<script>
import { ACTION_FOR_PRODUCT_BANNERS } from "../../api/product";
import { getToken } from "../../utils/auth";
export default {
  props: ['fileList'],  
  data() {
    return {
      upload: {
        action: ACTION_FOR_PRODUCT_BANNERS,
        name: "banner",
        headers: { Authorization: getToken() },
        format: ["jpg", "jpeg", "png"],
        max_size: 2048,
        show_upload_list: false
      },
    };
  },
  mounted() {
    this.fileList = this.$refs.banners_uploader.fileList;
  },
  methods: {
    handleFormatError() {
      this.$Message.error("只允许上传.PNG、.JPG、.JPEG文件");
    },
    handleExceedeSize() {
      this.$Message.error("只允许上传1MB以内的文件");
    },
    handleBeforeUpload() {},
    handleSuccess(response, file) {
      if (response.ret_code === 0) {
        file.name = response.ret_msg.name;
        file.url = response.ret_msg.url;
        this.$Message.success("上传成功");
      } else {
        this.$Message.error(response.ret_msg);
      }
    },
    handleRemove(file) {
      const fileList = this.$refs.banners_uploader.fileList;
      this.$refs.banners_uploader.fileList.splice(fileList.indexOf(file), 1);
    }
  }
};
</script>

<style lang="less">
.upload-file-list {
  display: inline-block;
  text-align: center;
  line-height: 60px;
  border: 1px solid transparent;
  border-radius: 4px;
  overflow: hidden;
  background: #fff;
  position: relative;
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
  margin-right: 4px;
  vertical-align: middle;
  img {
    display: block;
    max-width: 200px;
    height: auto;
  }
  .upload-list-cover {
    display: none;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.6);
  }
  &:hover {
    .upload-list-cover {
      display: block;
      i {
        color: #fff;
        font-size: 30px;
        cursor: pointer;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
      }
    }
  }
}
</style>
