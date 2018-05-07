<template>
  <div>
    <div class="form-item-wrapper">
      <label>名称：</label>
      <Input v-model="permission.name" placeholder="请输入权限名称" clearable style="width: 300px"></Input>
    </div>
    <div class="form-item-wrapper">
      <label>资源：</label>
      <Input v-model="permission.resource" placeholder="请输入权限资源" clearable style="width: 300px"></Input>
    </div>
    <hr>
    <div class="form-item-wrapper">
      <Button type="primary" @click="update_permission" :loading="permission_btn_loading">保存修改</Button>
    </div>
  </div>
  
</template>

<script>
import { fetchPermission, updatePermission } from "../../../api/system";
export default {
  data() {
    return {
      id: this.$route.params.permission_id,
      permission_btn_loading: false,
      permission: {
        name: "",
        resource: ""
      }
    };
  },
  created() {
    fetchPermission(this.id)
      .then(response => {
        if (response.ret_code === 0) {
          this.permission = Object.assign({}, this.permission, {
            name: response.ret_msg.name,
            resource: response.ret_msg.resource
          });
        } else {
          this.$Message.error("未找到对应权限");
        }
      })
      .catch(error => {});
  },
  methods: {
    update_permission() {
      this.permission_btn_loading = true;
      updatePermission(this.id, this.permission)
        .then(response => {
          this.permission_btn_loading = false;
          if (response.ret_code === 0) {
            this.$Message.success("修改成功");
            this.$router.push("/system/permissions");
          } else {
            this.$Message.error("未找到对应权限");
          }
        })
        .catch(error => {
          this.permission_btn_loading = false;
        });
    }
  }
};
</script>

