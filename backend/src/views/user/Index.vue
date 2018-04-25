<template>
  <Tabs value="userinfo">
      <TabPane label="基本信息" name="userinfo">
        <div class="form-item-wrapper">
          <label>用户名：</label>
          <Input v-model="userinfo.username" placeholder="请输入用户名" clearable style="width: 300px"></Input>
        </div>
        <div class="form-item-wrapper">
          <label>邮箱：</label>
          <Input v-model="userinfo.email" placeholder="请输入邮箱" clearable style="width: 300px"></Input>
        </div>
        <hr>
        <div class="form-item-wrapper">
          <Button type="primary" @click="update_userinfo" :loading="userinfo_btn_loading">保存修改</Button>
        </div>
      </TabPane>
      <TabPane label="密码修改" name="password">
        <div class="form-item-wrapper">
          <label>旧密码：</label>
          <Input v-model="userpwd.old_password" type="password" placeholder="请输入旧密码" clearable style="width: 300px"></Input>
        </div>
        <div class="form-item-wrapper">
          <label>新密码：</label>
          <Input v-model="userpwd.password" type="password" placeholder="请输入新密码" clearable style="width: 300px"></Input>
        </div>
        <div class="form-item-wrapper">
          <label>确认新密码：</label>
          <Input v-model="userpwd.password_confirm" type="password" placeholder="请再次输入新密码" clearable style="width: 300px"></Input>
        </div>
        <hr>
        <div class="form-item-wrapper">
          <Button type="primary" @click="update_userpwd" :loading="userpwd_btn_loading">保存修改</Button>
        </div>
      </TabPane>
  </Tabs>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      userinfo_btn_loading: false,
      userpwd_btn_loading: false,
      userinfo: {
        username: "",
        email: ""
      },
      userpwd: {
        old_password: "",
        password: "",
        password_confirm: ""
      }
    };
  },
  computed: {
    ...mapGetters(["user"])
  },
  created() {
    this.userinfo = Object.assign({}, this.userinfo, {
      username: this.user.username,
      email: this.user.email
    });
  },
  methods: {
    update_userinfo() {
      this.userinfo_btn_loading = true;
      this.$store
        .dispatch("UpdateUserInfo", this.userinfo)
        .then(response => {
          this.$Message.success("基本信息修改成功");
          this.userinfo_btn_loading = false;
        })
        .catch(error => {
          this.$Message.error(error);
          this.userinfo_btn_loading = false;
        });
    },
    update_userpwd() {
      this.userpwd_btn_loading = true;
      this.$store
        .dispatch("UpdateUserPwd", this.userpwd)
        .then(response => {
          this.$Message.success("密码修改成功");
          this.userpwd_btn_loading = false;
          // 修改成功后，将 userpwd 重置为默认值：""
          Object.keys(this.userpwd).forEach(k => {
            this.userpwd[k] = "";
          });
        })
        .catch(error => {
          this.$Message.error(error);
          this.userpwd_btn_loading = false;
        });
    }
  }
};
</script>

<style lang="less">
.form-item-wrapper {
  margin: 10px 0;
  label {
    display: inline-block;
    width: 80px;
    text-align: left;
  }
}
</style>

