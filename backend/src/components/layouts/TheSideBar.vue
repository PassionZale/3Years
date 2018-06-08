<template>
<Sider :style="{position: 'fixed', height: '100vh',background:'#fff', left: 0, overflow: 'auto'}">
    <Menu width="200px" theme="light" :active-name="active_route_name" :style="{height: '100%'}">
        <router-link :to="{ path: '/' }" exact>
            <MenuItem name="首页">
                <Icon type="home"></Icon>
                首页
            </MenuItem>
        </router-link>
        <template v-for="router in addRouters">
            <MenuGroup :title="router.name" v-if="router.path !== '*'">
                <template v-for="child in router.children">
                    <router-link :to="{ path: `${router.path}/${child.path}` }">
                        <MenuItem :name="child.name">
                            <Icon :type="child.icon"></Icon>
                            {{child.name}}
                        </MenuItem>
                    </router-link>
                </template>
            </MenuGroup>
        </template>
    </Menu>
</Sider>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["addRouters"])
  },
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
