<template>
  <div>
    <div class="form-item-wrapper">
      <label>排序：</label>
      <Poptip trigger="focus" title="注意！" content="排序默认为0，值越大则越靠前" placement="right">
        <InputNumber :min="0" :step="1" v-model="data.sort" style="width: 300px;"></InputNumber>
      </Poptip>
    </div>
    <div class="form-item-wrapper">
      <label>所属分类：</label>
      <Cascader v-model="data.category" :data="categories" style="width: 300px;display: inline-block;"></Cascader>
    </div>
    <div class="form-item-wrapper">
      <label>商品名称：</label>
      <Input type="text" v-model="data.name" placeholder="请输入商品名称" clearable style="width: 300px;"></Input>
    </div>
    <div class="form-item-wrapper">
      <label>商品原价：</label>
      <InputNumber :min="0" :step="0.01" v-model="data.original_price" style="width: 300px;"></InputNumber>
    </div>
    <div class="form-item-wrapper">
      <label>商品现价：</label>
      <InputNumber :min="0" :step="0.01" v-model="data.current_price" style="width: 300px;"></InputNumber>
    </div>
    <div class="form-item-wrapper">
      <label>已售数量：</label>
      <InputNumber :min="0" :step="1" v-model="data.sold" style="width: 300px;"></InputNumber>
    </div>
    <div class="form-item-wrapper">
      <label>库存数量：</label>
      <InputNumber :min="0" :step="1" v-model="data.stock" style="width: 300px;"></InputNumber>
    </div>
    <div class="form-item-wrapper">
      <label>上架状态</label>
      <RadioGroup v-model="data.status" >
        <Radio :label="1">上架</Radio>
        <Radio :label="0">下架</Radio>
      </RadioGroup>
    </div>

    <hr>

    <c-product-thumb-uploader :thumb.sync="data.thumb_img" :default-file-list="defaultThumbList"></c-product-thumb-uploader>

    <c-product-banners-uploader :banners.sync="data.banners" :default-file-list="defaultBannerList"></c-product-banners-uploader>


    <hr>
    <div class="form-item-wrapper">
      <Button type="primary" @click="click" :loading="btn_loading">保存修改</Button>
    </div>
  </div>
</template>

<script>
import {
  fetchCategories,
  fetchAttributes,
  fetchProduct
} from "../../../api/product";
import cProductThumbUploader from "../../../components/upload/ProductThumbImg.vue";
import cProductBannersUploader from "../../../components/upload/ProductBanners.vue";
export default {
  components: { cProductThumbUploader, cProductBannersUploader },
  data() {
    return {
      id: this.$route.params.id,
      categories: [],
      btn_loading: false,
      data: {
        // 排序
        sort: 0,
        // 分类级联
        category: [],
        // 商品名称
        name: "",
        // 原价
        original_price: 0.0,
        // 现价
        current_price: 0.0,
        // 已售数
        sold: 0,
        // 库存数
        stock: 0,
        // 上下架
        status: 1,
        // 缩略图
        thumb_img: {},
        // 轮播图
        banners: [],
        // 商品简介
        base_info: "",
        // 商品详情
        detail_info: "",
        // 规格组合
        skus: []
      }
    };
  },
  computed: {
    defaultThumbList: function() {
      return [{ url: this.data.thumb_img.url, name: this.data.name }];
    },
    defaultBannerList: function() {
      return this.data.banners.map(item => {
        item.name = this.data.name;
        return item;
      });
    }
  },
  created() {
    fetchCategories()
      .then(response => {
        this.categories = response.ret_msg;
      })
      .catch();

    fetchProduct(this.id)
      .then(response => {
        this.data = response.ret_msg;
      })
      .catch();
  },
  methods: {
    click() {}
  }
};
</script>

