<template>
 <div style="padding-bottom: 50px;">

    <router-view></router-view>

    <c-footer-bar></c-footer-bar>
    
 </div>
</template>

<script>
import cFooterBar from "./TheFooterBar.vue";
export default {
  components: { cFooterBar }
};
</script>


