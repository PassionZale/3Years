<template>
    <div>

        <div class="form-item-wrapper">
            <label>排序：</label>
            <Poptip trigger="focus" title="注意！" content="排序默认为0，值越大则越靠前" placement="right">
            <InputNumber :min="0" :step="1" v-model="data.sort" style="width: 300px;"></InputNumber>
            </Poptip>
        </div>

        <div class="form-item-wrapper">
            <c-shop-banner :banner.sync="banner" :default-file-list="defaultBannerList"></c-shop-banner>
        </div>  

        <div class="form-item-wrapper">
            <label>跳转链接：</label>
            <Input type="text" v-model="data.redirect" placeholder="请输入跳转链接" clearable style="width: 300px;"></Input>
        </div>

        <hr>

        <div class="form-item-wrapper">
            <Button type="primary" @click="click" :loading="btn_loading">保存修改</Button>
        </div>

    </div>
</template>

<script>
import cShopBanner from "../../../components/upload/ShopBanner.vue";
import { fetchBanner, updateBanner } from "../../../api/shop";
export default {
  components: { cShopBanner },
  data() {
    return {
      id: this.$route.params.id,
      btn_loading: false,
      banner: {},
      data: {
        sort: 0,
        imgurl: "",
        redirect: "javascript:;"
      }
    };
  },
  computed: {
    defaultBannerList: function() {
      return [{ url: this.data.imgurl, name: '轮播图' }];
    },
    banner_url: function() {
      return this.banner.url;
    }
  },
  created() {
    fetchBanner(this.id)
      .then(response => {
        this.data = response.ret_msg;
      })
      .catch(error => {});
  },
  methods: {
    click() {
      this.btn_loading = true;
      this.data.imgurl = this.banner_url;
      updateBanner(this.id, this.data)
        .then(response => {
          this.btn_loading = false;
          if (response.ret_code === 0) {
            this.$router.push('/shop/banner');
            this.$Message.success("修改成功");
          } else {
            this.$Message.error(response.ret_msg);
          }
        })
        .catch(error => {
          this.btn_loading = false;
        });
    }
  }
};
</script>
