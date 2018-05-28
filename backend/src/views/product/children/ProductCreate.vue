<template>
  <div>

    <Steps :current="current" class="form-item-wrapper">
      <Step title="基本信息"></Step>
      <Step title="图片上传"></Step>
      <Step title="详情简介"></Step>
      <Step title="配置规格"></Step>
    </Steps>
    <hr>

    <div v-show="current === 0">
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
      <Button type="primary" @click="step_0_next">下一步</Button>
    </div>

    <div v-show="current === 1">
      
      <c-product-thumb-uploader :thumb.sync="data.thumb_img"></c-product-thumb-uploader>

      <c-product-banners-uploader :banners.sync="data.banners"></c-product-banners-uploader>

      <hr>
      <Button type="primary" @click="step_1_pre">上一步</Button>
      <Button type="primary" @click="step_1_next">下一步</Button>
    </div>

    <div v-show="current === 2">
      <div class="form-item-wrapper">
        <label>商品简介：</label>
        <Input v-model="data.base_info" type="textarea" :autosize="{minRows: 6}" placeholder="请输入商品简介... ..." style="display: inline-block; width: 300px;"></Input>
      </div>
      <div class="form-item-wrapper">
        <label>商品详情：</label>
        <div ref="product_create_editor"  style="width: 700px; margin-top: 15px;">
          <p>请输入商品详情... ...</p>
        </div>
      </div>
      <hr>
      <Button type="primary" @click="step_2_pre">上一步</Button>
      <Button type="primary" @click="step_2_next">下一步</Button>
    </div>

    <div v-show="current === 3">
      <template v-for="(attribute, attr_index) in attributes">
        <div class="form-item-wrapper">
          <label>{{ attribute.name }}：</label>
          <label v-for="item in attribute.items" class="item-label">
            <input 
            v-model="attribute.selectedItems"
            type="checkbox" 
            :value="item"/>
            {{ item.name }}
          </label>
        </div>
      </template>

      <div v-show="data.skus.length">
        <hr>
        <div class="ivu-table-wrapper">
          <div class="ivu-table ivu-table-stripe">
            <div class="ivu-table-header">
              <table cellspacing="0" cellpadding="0" border="0" style="width: 100%">
                <thead>
                  <tr>
                    <th v-for="attribute in attributes" v-if="attribute.selectedItems.length">
                      <div class="ivu-table-cell">
                        <span>{{ attribute.name }}</span>
                      </div>
                    </th>
                    <th>
                      <div class="ivu-table-cell">
                        <span>商品库存</span>
                      </div>
                    </th>
                    <th>
                      <div class="ivu-table-cell">
                        <span>商品价格</span>
                      </div>
                    </th>
                  </tr>
                </thead>
              </table>
            </div>
            <div class="ivu-table-body">
              <table cellspacing="0" cellpadding="0" border="0" style="width: 100%">
                <tbody class="ivu-table-tbody">
                  <tr class="ivu-table-row" v-for="sku in data.skus">
                    <td v-for="attribute in attributes" v-if="attribute.selectedItems.length">
                      <div class="ivu-table-cell">
                        <span>{{ get_item_name(sku, attribute) }}</span>
                      </div>
                    </td>
                    <td>
                      <InputNumber :min="0" :step="1" v-model="sku.sku_stock" placeholder="填写商品库存" style="width: 100px;"></InputNumber>
                    </td>
                    <td>
                      <InputNumber :min="0.00" :formatter="value => `¥${value}`" :parser="value => value.replace('¥', '')" :step="0.01" v-model="sku.sku_price" placeholder="填写商品价格" style="width: 100px;"></InputNumber>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <hr> 
      <Button type="primary" @click="step_3_pre">上一步</Button>
      <Button type="success" @click="submit" :loading="btn_loading">确认创建</Button>
    </div>

  </div>
</template>

<script>
import {
  descartes,
  editorMenu,
  editorUploadImgServer,
  uploadImgMaxSize,
  uploadImgMaxLength,
  uploadFileName,
  uploadImgHeaders
} from "../../../utils/base";
import {
  fetchCategories,
  fetchAttributes,
  createProduct
} from "../../../api/product";
import cProductThumbUploader from "../../../components/upload/ProductThumbImg.vue";
import cProductBannersUploader from "../../../components/upload/ProductBanners.vue";
import E from "wangeditor";
export default {
  components: { cProductThumbUploader, cProductBannersUploader },
  data() {
    return {
      current: 0,
      btn_loading: false,
      categories: [],
      attributes: [],
      editor: "",
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
  mounted() {
    this.create_editor();
  },
  created() {
    fetchCategories()
      .then(response => {
        this.categories = response.ret_msg;
      })
      .catch();
  },
  beforeDestroy() {
    this.destroy_editor();
  },
  computed: {
    selectedListner: function() {
      let length = 0;
      this.attributes.map(item => {
        length += item.selectedItems.length;
      });
      return length;
    }
  },
  watch: {
    selectedListner: {
      handler: "rebuildSkus"
    },
    "data.category": {
      handler: "step_3_init"
    }
  },
  methods: {
    create_editor() {
      this.editor = new E(this.$refs.product_create_editor);
      this.editor.customConfig.menus = editorMenu;
      this.editor.customConfig.uploadImgServer = editorUploadImgServer;
      this.editor.customConfig.uploadImgMaxSize = uploadImgMaxSize;
      this.editor.customConfig.uploadImgMaxLength = uploadImgMaxLength;
      this.editor.customConfig.uploadFileName = uploadFileName;
      this.editor.customConfig.uploadImgHeaders = uploadImgHeaders;
      this.editor.customConfig.onchange = html => {
        this.data.detail_info = html;
      };
      this.editor.create();
    },
    destroy_editor() {
      this.editor = null;
    },
    get_item_name(sku, attribute) {
      let item_name = "";
      sku.values.map(value => {
        if (value.attribute_id === attribute.id) {
          attribute.selectedItems.map(item => {
            if (value.item_id === item.id) {
              item_name = item.name;
              return false;
            }
          });
        }
      });
      return item_name;
    },
    rebuildSkus(val, oldVal) {
      let ori = [];
      // 每次勾选规格时，重置 skus
      this.data.skus.length = 0;
      this.attributes.map(item => {
        if (item.selectedItems.length) {
          ori.push(item.selectedItems);
        }
      });
      let ret = descartes(ori);
      ret.map(item => {
        var sku = { sku_price: 0.0, sku_stock: 0, values: [] };
        item.map(value => {
          sku.values.push({
            attribute_id: value.attribute_id,
            item_id: value.id
          });
        });

        this.data.skus.push(sku);
      });
    },
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
    step_3_init() {
      let parent_category_id = this.data.category[0];
      fetchAttributes(parent_category_id, "all")
        .then(response => {
          this.attributes = response.ret_msg.data.map(item => {
            item.selectedItems = [];
            return item;
          });
        })
        .catch();
    },
    step_3_pre() {
      this.current -= 1;
    },
    submit() {
      this.btn_loading = true;
      createProduct(this.data)
        .then(response => {
          this.btn_loading = false;
          if (response.ret_code === 0) {
            this.$Message.success("商品创建成功");
            this.$router.push("/product/commodity");
          } else {
            this.$Message.error("商品创建失败");
          }
        })
        .catch(error => {
          this.btn_loading = false;
        });
    }
  }
};
</script>

<style lang="less">
.item-label {
  width: 150px;
  input {
    margin-top: 4px;
  }
}
</style>
