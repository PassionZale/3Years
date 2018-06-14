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
                
                <div class="product-list-container" v-for="(productGroup, index) in products" :key="index">
                  <div class="product-list-item" v-for="item in productGroup">
                    <div class="product-thumb-img">
                      <img class="product-thumb-img" :src="item.thumb_img" :alt="item.name">
                    </div>
                    <div class="product-info">
                      <div class="product-name">{{ item.name }}</div>
                      <div class="product-price">
                          &yen;{{ item.current_price }}
                          <del style="color: rgb(243, 89, 75)">
                              &yen;{{ item.original_price }}
                          </del>
                      </div>
                    </div>
                  </div>
                </div>

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
import { chunkArr } from "../utils/base";
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
          this.proudcts = [].push.apply(
            this.products,
            chunkArr(response.ret_msg)
          );
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
.product-list-container {
  display: flex;
  justify-content: center;
  padding: 10px;
  .product-list-item {
    flex: 1;
    background: #fff;
    &:nth-child(even) {
      margin-left: 10px;
    }
    .product-thumb-img {
      width: 100%;
      height: 150px;
      display: block;
      border-bottom: 1px solid #f5f5f5;
    }
    .product-info {
      margin-top:10px;
    }
  }
}
</style>

