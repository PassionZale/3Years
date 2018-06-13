<template>
    <van-swipe :autoplay="3000">
        <van-swipe-item v-for="(image, index) in images" :key="index">
            <img :src="image.imgurl" alt="3Years">
        </van-swipe-item>
    </van-swipe>
</template>

<script>
import { Swipe, SwipeItem } from "vant";
export default {
  props: {
    images: {
      type: Array,
      default: function() {
        return [];
      },
      required: true
    }
  }
};
</script>

<style lang="less" scoped>
img {
  width: 100%;
  height: 240px;
  display: block;
  box-sizing: border-box;
  background: #fff;
  pointer-events: none;
}
</style>


