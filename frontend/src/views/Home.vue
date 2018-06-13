<template>
    <div>

        <c-search-bar></c-search-bar>
        
        <c-swipe :images="banners"></c-swipe>

        <div style="margin-top: 10px;">
            <van-list
                v-model="loading"
                :finished="finished"
                @load="onLoad"
                >
                <van-row v-for="(product, index) in products" :key="index" :style="{background:'#fff',marginBottom:'10px', padding:'10px'}">
                    <van-col span="8" :style="{textAlign:'center'}">
                        <img class="product-thumb-img" :src="product.thumb_img" :alt="product.name">
                    </van-col>
                    <van-col span="16">
                        <h2>{{ product.name }}</h2>
                        <p>
                            &yen;{{ product.current_price }}
                            <del style="color: rgb(243, 89, 75)">
                                &yen;{{ product.original_price }}
                            </del>
                        </p>
                    </van-col>
                </van-row>
            </van-list>
        </div>

    </div>

</template>

<script>
import cSearchBar from "../components/layouts/TheSearchBar.vue";
import cSwipe from "../components/utils/Swipe.vue";
import { List, Row, Col } from "vant";
import { fetchBanners } from "../api/banner";
import { fetchProducts } from "../api/product";
export default {
  components: {
    cSwipe,
    cSearchBar
  },
  data() {
    return {
      banners: [],
      product_list_page: 1,
      products: [],
      loading: false,
      finished: false
    };
  },
  created() {
    fetchBanners().then(response => {
      this.banners = response.ret_msg;
    });
  },
  methods: {
    onLoad() {
      fetchProducts(this.product_list_page).then(response => {
        if (response.ret_msg.length) {
          this.proudcts = [].push.apply(this.products, response.ret_msg);
          this.product_list_page++;
        } else {
          this.finished = true;
        }
        this.$nextTick(function() {
          this.loading = false;
        });
      });
    }
  }
};
</script>

<style lang="less" scoped>
.product-thumb-img {
  width: 100px;
  height: auto;
}
</style>

