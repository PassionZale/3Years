<template>
<Sider :style="{position: 'fixed', height: '100vh',background:'#fff', left: 0, overflow: 'auto'}">
    <Menu width="200px" theme="light" :active-name="active_route_name" :style="{height: '100%'}">
        <router-link :to="{ path: '/' }" exact>
            <MenuItem name="首页">
                <Icon type="home"></Icon>
                首页
            </MenuItem>
        </router-link>
        <MenuGroup title="系统设置">
            <router-link :to="{ path: '/system/users' }">
                <MenuItem name="用户管理">
                    <Icon type="person-stalker"></Icon>
                    用户管理
                </MenuItem>
            </router-link>
            <router-link :to="{ path: '/system/roles' }">
                <MenuItem name="角色管理">
                    <Icon type="ionic"></Icon>
                    角色管理
                </MenuItem>
            </router-link>
            <router-link :to="{ path: '/system/permissions' }">
                <MenuItem name="权限管理">
                    <Icon type="locked"></Icon>
                    权限管理
                </MenuItem>
            </router-link>
        </MenuGroup>
        <!-- <MenuGroup title="公众号设置">
            <MenuItem name="粉丝管理">
                粉丝管理
            </MenuItem>
            <MenuItem name="菜单管理">
                菜单管理
            </MenuItem>          
        </MenuGroup>
        <MenuGroup title="商城设置">
            <MenuItem name="基础配置">
                基础配置
            </MenuItem>
            <MenuItem name="商品管理">
                商品管理
            </MenuItem>
        </MenuGroup> -->
    </Menu>
</Sider>
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

<style lang="less">
// reset a tag's font color
.ivu-menu {
  a {
    color: #495060;
  }
}
</style>
