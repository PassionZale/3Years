<template>
<div>
    <Breadcrumb :style="{marginBottom:'16px'}">
        <template v-for="nav in navs" v-if="nav.path !== ''">
            <BreadcrumbItem>
                {{ nav.name }}
            </BreadcrumbItem>
        </template>
    </Breadcrumb>
    <router-view></router-view>
</div>
</template>

<script>
export default {
  data() {
    return {
      navs: []
    };
  },
  created() {
    this.navs = this.$route.matched;
  },
  watch: {
    $route(to, from) {
      this.navs = this.$route.matched;
    }
  }
};
</script>
