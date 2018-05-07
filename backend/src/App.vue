<template>
    <div id="app">
      <router-view></router-view>       
    </div>
</template>

<script>
export default {};
</script>

<style lang="less">
hr {
  margin-top: 20px;
  margin-bottom: 20px;
  border: 0;
  border-top: 1px solid #eee;
}
.form-item-wrapper {
  margin: 10px 0;
  label {
    display: inline-block;
    width: 80px;
    text-align: left;
  }
}
.router-link-active {
  li {
    color: #2d8cf0;
    border-right: 2px solid #2d8cf0;
    z-index: 2;
  }
}
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