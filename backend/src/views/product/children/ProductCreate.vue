<template>
  <div>

    <Steps :current="current" class="form-item-wrapper">
      <Step title="基本信息"></Step>
      <Step title="图片上传"></Step>
      <Step title="详情简介"></Step>
      <Step title="配置规格"></Step>
      <Step title="确认创建"></Step>
    </Steps>
    <hr>

    <div v-show="current === 0">
      <div class="form-item-wrapper">
        <label>排序：</label>
        <Poptip trigger="focus" title="注意！" content="排序默认为0，值越大则越靠前" placement="right">
          <InputNumber :max="10000" :min="0" :step="1" v-model="data.sort" style="width: 300px;"></InputNumber>
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
        <InputNumber :max="100000000" :min="0" :step="0.01" v-model="data.orignal_price" style="width: 300px;"></InputNumber>
      </div>
      <div class="form-item-wrapper">
        <label>商品现价：</label>
        <Input type="text" v-model="data.current_price" placeholder="请输入商品现价：" clearable style="width: 300px;"></Input>
      </div>
      <div class="form-item-wrapper">
        <label>已售数量：</label>
        <InputNumber :max="100000000" :min="0" :step="1" v-model="data.sold" style="width: 300px;"></InputNumber>
      </div>
      <div class="form-item-wrapper">
        <label>库存数量：</label>
        <InputNumber :max="100000000" :min="0" :step="1" v-model="data.stock" style="width: 300px;"></InputNumber>
      </div>
      <div class="form-item-wrapper">
        <label>上架状态</label>
        <RadioGroup v-model="data.status" >
          <Radio :label="1">上架</Radio>
          <Radio :label="0">下架</Radio>
        </RadioGroup>
      </div>
      <hr>
      <Button type="primary" @click="step_0_next">下一步</Button>
    </div>

    <div v-show="current === 1">
      
      <c-product-thumb-uploader :file-list.sync="data.thumb_img"></c-product-thumb-uploader>

      <c-product-banners-uploader :file-list.sync="data.banners"></c-product-banners-uploader>

      <hr>
      <Button type="primary" @click="step_1_pre">上一步</Button>
      <Button type="primary" @click="step_1_next">下一步</Button>
    </div>

    <div class="form-item-wrapper" v-show="current === 2">
      <p>详情简介</p>
      <hr>
      <Button type="primary" @click="step_2_pre">上一步</Button>
      <Button type="primary" @click="step_2_next">下一步</Button>
    </div>

    <div class="form-item-wrapper" v-show="current === 3">
      <p>配置规格</p>
      <hr>
      <Button type="primary" @click="step_3_pre">上一步</Button>
      <Button type="primary" @click="step_3_next">下一步</Button>
    </div>

    <div class="form-item-wrapper" v-show="current === 4">
      <p>确认创建</p>
      <hr>
      <Button type="primary" @click="step_4_pre">上一步</Button>
      <Button type="success" @click="submit" :loading="btn_loading">确认创建</Button>
    </div>

  </div>
</template>

<script>
import { fetchCategories } from "../../../api/product";
import cProductThumbUploader from "../../../components/upload/ProductThumbImg.vue";
import cProductBannersUploader from "../../../components/upload/ProductBanners.vue";
export default {
  components: { cProductThumbUploader, cProductBannersUploader },
  data() {
    return {
      current: 1,
      btn_loading: false,
      categories: [],
      data: {
        // 排序
        sort: 0,
        // 分类级联
        category: [],
        // 商品名称
        name: "",
        
        // 原价
        orignal_price: 0.0,
        // 现价
        current_price: 0.0,
        // 已售数
        sold: 0,
        // 库存数
        stock: 0,
        // 上下架
        status: 1,
        // 缩略图
        thumb_img: [],
        // 轮播图
        banners: []
      }
    };
  },
  created() {
    fetchCategories()
      .then(response => {
        this.categories = response.ret_msg;
      })
      .catch();
  },
  methods: {
    step_0_next() {
      this.current += 1;
    },
    step_1_pre() {
      this.current -= 1;
    },
    step_1_next() {
      this.current += 1;
    },
    step_2_pre() {
      this.current -= 1;
    },
    step_2_next() {
      this.current += 1;
    },
    step_3_pre() {
      this.current -= 1;
    },
    step_3_next() {
      this.current += 1;
    },
    step_4_pre() {
      this.current -= 1;
    },
    submit() {
      this.btn_loading = true;
    }
  }
};
</script>

