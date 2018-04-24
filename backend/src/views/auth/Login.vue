<template>
  <div>
      <c-random-bg></c-random-bg>
      <div id="login-wrapper">
        <div class="login-box">
          <p class="box-title">
            3Years --- LOVCHUN.COM
          </p>
          <div class="box-group">
            <Input v-model="data.username" type="text" placeholder="请输入用户名" clearable style="width: 300px"></Input> 
          </div>
          <div class="box-group">
            <Input v-model="data.password" type="password" placeholder="请输入密码" clearable style="width: 300px"></Input>   
          </div>
          <div class="box-group">
            <Button 
              type="primary"
              long 
              @click.native.prevent="login"
              :loading="loading"
            >
              {{ btnText }}
            </Button>
          </div>
        </div>
      </div>
  </div>

</template>
<script>
import cRandomBg from "../../components/auth/TheRandomBg.vue";
export default {
  components: {
    cRandomBg
  },
  data() {
    return {
      data: {
        username: "",
        password: ""
      },
      btnText: "登录",
      loading: false
    };
  },
  methods: {
    login() {
      this.loading = true;
      this.$store
        .dispatch("Login", this.data)
        .then(() => {
          this.btnText = "登录成功，正在跳转...";
          this.$nextTick(() => {
            this.$router.push("/");
          });
        })
        .catch(error => {
          if(typeof error === 'string' && error.constructor === String){
            this.$Message.error(error);
          }
          this.loading = false;
        });
    }
  }
};
</script>