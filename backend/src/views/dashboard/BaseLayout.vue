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
import cSideBar from "../../components/layouts/TheSideBar.vue";
import cHeader from "../../components/layouts/TheHeader.vue";
import cContent from "../../components/layouts/TheContent.vue";
import cFooter from "../../components/layouts/TheFooter.vue";
export default {
  components: {
    cSideBar,
    cHeader,
    cContent,
    cFooter
  }
};
</script>
