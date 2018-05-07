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
      <Button type="primary" @click="create_permission" :loading="permission_btn_loading">确认创建</Button>
    </div>
  </div>
  
</template>

<script>
import { createPermission } from "../../../api/system";
export default {
  data() {
    return {
      permission_btn_loading: false,
      permission: {
        name: "",
        resource: ""
      }
    };
  },
  methods: {
    create_permission() {
      this.permission_btn_loading = true;
      createPermission(this.permission)
        .then(response => {
          if (response.ret_code === 0) {
            this.$Message.success("创建成功");
          } else {
            this.$Message.error(response.ret_msg);
          }
          this.permission_btn_loading = false;
        })
        .catch(error => {
          this.$Message.error(error);
          this.permission_btn_loading = false;
        });
    }
  }
};
</script>

