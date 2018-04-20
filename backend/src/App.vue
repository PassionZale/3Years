<template>
    <div id="app">
        <c-side-bar></c-side-bar>
        <Layout :style="{marginLeft: '200px'}">
          <c-header></c-header>
          <c-content></c-content>
          <c-footer></c-footer>
        </Layout>    
    </div>
</template>

<script>
import cSideBar from "./components/layouts/TheSideBar.vue";
import cHeader from "./components/layouts/TheHeader.vue";
import cContent from "./components/layouts/TheContent.vue";
import cFooter from "./components/layouts/TheFooter.vue";
export default {
  components: {
    cSideBar,
    cHeader,
    cContent,
    cFooter
  }
};
</script>

<style scoped>
.layout {
  border: 1px solid #d7dde4;
  background: #f5f7f9;
  position: relative;
  border-radius: 4px;
  overflow: hidden;
}
.layout-header-bar {
  background: #fff;
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
}
</style>
