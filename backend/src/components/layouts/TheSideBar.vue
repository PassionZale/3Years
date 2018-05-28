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
        <MenuGroup title="商品设置">
            <router-link :to="{ path: '/product/category' }">
                <MenuItem name="分类管理">
                    <Icon type="ios-pricetag"></Icon>
                    分类管理
                </MenuItem>
            </router-link>
            <router-link :to="{ path: '/product/attribute' }">
                <MenuItem name="规格管理">
                    <Icon type="ios-pricetag-outline"></Icon>
                    规格管理
                </MenuItem>
            </router-link>
            <router-link :to="{ path: '/product/commodity' }">
                <MenuItem name="商品管理">
                    <Icon type="bag"></Icon>
                    商品管理
                </MenuItem>
            </router-link>
        </MenuGroup>
        <MenuGroup title="商城设置">
            <router-link :to="{ path: '/shop/freight' }">
                <MenuItem name="运费管理">
                    <Icon type="social-yen"></Icon>
                    运费管理
                </MenuItem>
            </router-link>            
            <router-link :to="{ path: '/shop/banner' }">
                <MenuItem name="轮播图管理">
                    <Icon type="images"></Icon>
                    轮播图管理
                </MenuItem>
            </router-link>
            <router-link :to="{ path: '/shop/topic' }">
                <MenuItem name="专题管理">
                    <Icon type="pound"></Icon>
                    专题管理
                </MenuItem>
            </router-link>
            <router-link :to="{ path: '/shop/recommend' }">
                <MenuItem name="推荐管理">
                    <Icon type="android-favorite"></Icon>
                    推荐管理
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
