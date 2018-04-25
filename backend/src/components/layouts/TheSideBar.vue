<template>
<Sider :style="{position: 'fixed', height: '100vh',background:'#fff', left: 0, overflow: 'auto'}">
    <Menu width="200px" theme="light" :active-name="active_route_name" :style="{height: '100%'}">
        <router-link :to="{ path: '/' }">
            <MenuItem name="首页">
                <Icon type="home"></Icon>
                控制台
            </MenuItem>
        </router-link>
        <MenuGroup title="系统设置">
            <router-link :to="{ path: '/permission' }">
                <MenuItem name="权限管理">
                    <Icon type="person-stalker"></Icon>
                    权限管理
                </MenuItem>
            </router-link>
        </MenuGroup>
        <MenuGroup title="公众号设置">
            <router-link :to="{ path: '/follow' }">
                <MenuItem name="粉丝管理">
                    <Icon type="heart"></Icon>
                    粉丝管理
                </MenuItem>
            </router-link>
            <router-link :to="{path: '/nav'}">
                <MenuItem name="菜单管理">
                    <Icon type="navicon-round"></Icon>
                    菜单管理
                </MenuItem>          
            </router-link>

        </MenuGroup>
        <MenuGroup title="商城设置">
            <router-link :to="{path: '/setting'}">
                <MenuItem name="基础配置">
                    <Icon type="gear-a"></Icon>
                    基础配置
                </MenuItem>
            </router-link>
            <router-link :to="{path: '/product'}">
                <MenuItem name="商品管理">
                    <Icon type="tshirt"></Icon>
                    商品管理
                </MenuItem>
            </router-link>
        </MenuGroup>
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
