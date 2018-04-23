<template>
    <div id="app">
      <router-view></router-view>       
    </div>
</template>

<script>
export default {};
</script>

<style lang="less">
#login-wrapper {
  padding: 20px 10px 40px;
  .login-box {
    width: 300px;
    z-index: 100;
    margin: 140px auto 0 auto;
    text-align: center;
    p {
      margin: 0 0 10px;
      color: #fff;
      &.box-title {
        font-size: 18px;
      }
    }
    .box-group {
      margin-bottom: 15px;
    }
  }
}
</style>