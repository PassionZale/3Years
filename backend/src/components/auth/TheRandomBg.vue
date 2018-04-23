<template>
  <div 
    class="random-bg"
    :style="{backgroundImage: imageSrc}">
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      imageSrc: {}
    };
  },
  computed: {
    ...mapGetters(["authRandomBg"])
  },
  created() {
    let index = parseInt(Math.random() * 5, 10);
    this.$set(this, "imageSrc", `url(${this.authRandomBg[index].origin})`);
  }
};
</script>

<style lang="less">
.random-bg {
  position: fixed;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  min-width: 1000px;
  z-index: -10;
  background-position: center 0;
  background-repeat: no-repeat;
  background-size: cover;
  -webkit-background-size: cover;
  zoom: 1;
}
</style>


