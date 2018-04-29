<template>
<div>
    <Breadcrumb :style="{marginBottom:'16px'}">
        <BreadcrumbItem>系统设置</BreadcrumbItem>
        <BreadcrumbItem to="/system/users" v-show="this.$route.name === '/system/users'">用户列表</BreadcrumbItem>
        <BreadcrumbItem to="/system/roles" v-show="this.$route.name === '/system/roles'">角色列表</BreadcrumbItem>
        <BreadcrumbItem to="/system/permissions" v-show="this.$route.name === '/system/permissions'">权限列表</BreadcrumbItem>
    </Breadcrumb>
    <router-view></router-view>
</div>
</template>

<script>
export default {
  data() {
    return {
      active_route_name: ""
    };
  },
  created() {
    this.active_route_name = this.$route.name;
  },
  watch: {
    $route(to, from) {
      this.active_route_name = to.name;
    }
  }
};
</script>
