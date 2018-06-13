<template>
    <van-tabbar v-model="active">
        <van-tabbar-item icon="home" to="/home">首页</van-tabbar-item>
        <van-tabbar-item icon="points" to="/category">分类</van-tabbar-item>
        <van-tabbar-item icon="cart" to="/cart">购物车</van-tabbar-item>
        <van-tabbar-item icon="contact" to="/usercenter">个人中心</van-tabbar-item>
    </van-tabbar>
</template>

<script>
import { Tabbar, TabbarItem } from "vant";
export default {
  data() {
    return {
      active: ""
    };
  },
  created() {
    let path = this.$route.path;
    this.activeBar(path);
  },
  watch: {
    $route(to, from) {
      this.activeBar(to.path);
    }
  },
  methods: {
    activeBar(path = "") {
      switch (path) {
        case "/home":
          this.active = 0;
          break;
        case "/category":
          this.active = 1;
          break;
        case "/cart":
          this.active = 2;
          break;
        case "/usercenter":
          this.active = 3;
          break;
        default:
          this.active = 0;
      }
    }
  }
};
</script>

