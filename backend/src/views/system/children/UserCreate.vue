<template>
  <div>
    <div class="form-item-wrapper">
      <label>用户名：</label>
      <Input v-model="data.username" type="text" placeholder="请输入用户名" clearable style="width: 300px"></Input> 
    </div>
    <div class="form-item-wrapper">
      <label>邮箱：</label>
      <Input v-model="data.email" type="email" placeholder="请输入邮箱" clearable style="width: 300px"></Input> 
    </div>
    <div class="form-item-wrapper">
      <label>密码：</label>
      <Input v-model="data.password" type="password" placeholder="请输入密码" clearable style="width: 300px"></Input>   
    </div>
    <div class="form-item-wrapper">
      <label>确认密码：</label>
      <Input v-model="data.password_confirm" type="password" placeholder="请再次输入密码" clearable style="width: 300px"></Input>   
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
      <Button type="primary" @click="create" :loading="btn_loading">确认创建</Button>
    </div>
  </div>
</template>

<script>
import { fetchRoles, createUser } from "../../../api/system";
export default {
  data() {
    return {
      btn_loading: false,
      data: {
        username: "",
        email: "",
        password: "",
        password_confirm: "",
        role: ""
      },
      roles: []
    };
  },
  created() {
    fetchRoles()
      .then(response => {
        this.roles = response.ret_msg;
      })
      .catch(error => {});
  },
  methods: {
    create() {
      this.btn_loading = true;
      createUser(this.data)
        .then(response => {
          if (response.ret_code === 0) {
            this.$Message.success("创建成功");
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

