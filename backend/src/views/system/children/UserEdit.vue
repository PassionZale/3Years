<template>
  <div>
    <div class="form-item-wrapper">
      <label>用户名：</label>
      <Input v-model="user.username" type="text" placeholder="请输入用户名" disabled style="width: 300px"></Input> 
    </div>
    <div class="form-item-wrapper">
      <label>邮箱：</label>
      <Input v-model="user.email" type="email" placeholder="请输入邮箱" disabled style="width: 300px"></Input> 
    </div>
    <hr>
    <div class="form-item-wrapper">
      <label>角色配置：</label>
      <RadioGroup v-model="data.role" >
        <Radio :label="role.id" :key="role.id" v-for="role in roles">{{role.name}}</Radio>
      </RadioGroup>
    </div>
    <hr>
    <div class="form-item-wrapper">
      <label>用户状态：</label>
      <RadioGroup v-model="data.is_active" >
        <Radio label="1">启用</Radio>
        <Radio label="0">禁用</Radio>
      </RadioGroup>
    </div>
    <hr>
    <div class="form-item-wrapper">
      <Button type="primary" @click="update" :loading="btn_loading">保存修改</Button>
    </div>
  </div>
</template>

<script>
import { fetchRoles, fetchUser, updateUser } from "../../../api/system";
export default {
  data() {
    return {
      btn_loading: false,
      id: this.$route.params.user_id,
      user: {
        username: "",
        email: ""
      },
      data: {
        role: "",
        is_active: ""
      },
      roles: []
    };
  },
  created() {
    fetchUser(this.id)
      .then(response => {
        this.user = Object.assign({}, this.user, {
          username: response.ret_msg.username,
          email: response.ret_msg.email
        });
        this.data = Object.assign({}, this.data, {
          role: response.ret_msg.role,
          is_active: response.ret_msg.is_active
        });
      })
      .catch(error => {});
    fetchRoles()
      .then(response => {
        this.roles = response.ret_msg;
      })
      .catch(error => {});
  },
  methods: {
    update() {
      this.btn_loading = true;
      updateUser(this.id, this.data)
        .then(response => {
          if (response.ret_code === 0) {
            this.$Message.success("修改成功");
            this.$router.push("/system/users");
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

