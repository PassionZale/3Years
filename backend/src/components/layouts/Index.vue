<template>
  <div>
      <c-side-bar></c-side-bar>
      <Layout :style="{marginLeft: '200px'}">
        <c-header></c-header>
        <c-content></c-content>
        <c-footer></c-footer>
      </Layout> 
  </div>
</template>
<script>
import cSideBar from "./TheSideBar.vue";
import cHeader from "./TheHeader.vue";
import cContent from "./TheContent.vue";
import cFooter from "./TheFooter.vue";
export default {
  components: {
    cSideBar,
    cHeader,
    cContent,
    cFooter
  }
};
</script>
