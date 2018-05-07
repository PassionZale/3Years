<template>
  <div>
    <div class="form-item-wrapper">
      <label>名称：</label>
      <Input v-model="data.name" placeholder="请输入角色名称" clearable style="width: 300px"></Input>
    </div>
    <div class="form-item-wrapper">
      <label>别名：</label>
      <Input v-model="data.alias" placeholder="请输入角色别名" clearable style="width: 300px"></Input>
    </div>
    <hr>
    <div class="form-item-wrapper">
      <label>权限配置：</label>
    </div>
    <div class="form-item-wrapper">
      <CheckboxGroup v-model="data.permissions">
        <Checkbox :label="permission.id" :key="permission.id" v-for="permission in permissions">{{ permission.name }}</Checkbox>
      </CheckboxGroup>
    </div>
    <hr>
    <div class="form-item-wrapper">
      <Button type="primary" @click="create" :loading="btn_loading">确认创建</Button>
    </div>
  </div>
</template>

<script>
import { createRole, fetchPermissions } from "../../../api/system";
export default {
  data() {
    return {
      btn_loading: false,
      data: {
        name: "",
        alias: "",
        permissions: []
      },
      permissions: []
    };
  },
  created() {
    fetchPermissions()
      .then(response => {
        this.permissions = response.ret_msg;
      })
      .catch(error => {});
  },
  methods: {
    create() {
      this.btn_loading = true;
      createRole(this.data)
        .then(response => {
          if (response.ret_code === 0) {
            this.$Message.success("创建角色成功");
            this.$router.push('/system/roles');
          } else {
            this.$Message.error(response.ret_msg);
          }
          this.btn_loading = false;
        })
        .catch(error => {
          this.btn_loading = false;
        });
    }
  }
};
</script>

