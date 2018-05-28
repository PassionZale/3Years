<template>
  <div>

    <Tabs>
        <TabPane label="基本信息">
          <div class="form-item-wrapper">
            <label>排序：</label>
            <Poptip trigger="focus" title="注意！" content="排序默认为0，值越大则越靠前" placement="right">
              <InputNumber :min="0" :step="1" v-model="data.sort" style="width: 300px;"></InputNumber>
            </Poptip>
          </div>
          <div class="form-item-wrapper">
            <label>所属分类：</label>
            <Tooltip content="移除全部规格后，才可切换分类。" :disabled="data.skus.length ? false : true">
              <Cascader v-model="data.category" :data="categories" style="width: 300px;display: inline-block;" :disabled="data.skus.length ? true : false"></Cascader>
            </Tooltip>
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
          <div class="form-item-wrapper">
            <Button type="primary" @click="update('info')" :loading="btn_loading">保存基本信息</Button>
          </div>
        </TabPane>

        <TabPane label="图片上传">
          <c-product-thumb-uploader :thumb.sync="data.thumb_img" :default-file-list="defaultThumbList"></c-product-thumb-uploader>
          <c-product-banners-uploader :banners.sync="data.banners" :default-file-list="defaultBannerList"></c-product-banners-uploader>
          <hr>
          <div class="form-item-wrapper">
            <Button type="primary" @click="update('image')" :loading="btn_loading">保存图片上传</Button>
          </div>
        </TabPane>

        <TabPane label="详情简介">
          <div class="form-item-wrapper">
            <label>商品简介：</label>
            <Input v-model="data.base_info" type="textarea" :autosize="{minRows: 6}" placeholder="请输入商品简介... ..." style="display: inline-block; width: 300px;"></Input>
          </div>

          <div class="form-item-wrapper">
            <label>商品详情：</label>
            <div ref="product_edit_editor">
              <p>请输入商品详情... ...</p>
            </div>
          </div>

          <hr>
          <div class="form-item-wrapper">
            <Button type="primary" @click="update('detail')" :loading="btn_loading">保存详情简介</Button>
          </div>
        </TabPane>

        <TabPane label="配置规格">
          <div v-for="(attribute, attr_index) in attributes" v-show="attribute_reset">
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
          </div>

          <div v-show="data.skus.length">
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
                        <th v-if="!attribute_reset">
                          <div class="ivu-table-cell">
                            <span>操作</span>
                          </div>
                        </th>
                      </tr>
                    </thead>
                  </table>
                </div>
                <div class="ivu-table-body">
                  <table cellspacing="0" cellpadding="0" border="0" style="width: 100%">
                    <tbody class="ivu-table-tbody">
                      <tr class="ivu-table-row" v-for="(sku,index) in data.skus">
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
                        <td v-if="!attribute_reset">
                          <div class="ivu-table-cell">
                            <div>
                              <Button type="primary" size="small" @click="updateSku(sku)">保存</Button>
                              <Button type="error" size="small" @click="deleteSku(index)">删除</Button>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="form-item-wrapper" v-show="data.skus.length === 0 && !attribute_reset">
            <p style="text-align:center;">规格已全部移除，请<Button style="margin-left: 10px;" type="dashed" @click="resetSku">创建规格</Button></p>
          </div>
          <hr>

          <div class="form-item-wrapper" v-show="attribute_reset">
            <Button type="primary" @click="saveSku" :loading="btn_loading" :disabled="data.skus.length ? false : true">保存规格</Button>
          </div>

        </TabPane>
    </Tabs>

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
  fetchProduct,
  updateProduct,
  updateSku,
  deleteSku,
  createSku
} from "../../../api/product";
import cProductThumbUploader from "../../../components/upload/ProductThumbImg.vue";
import cProductBannersUploader from "../../../components/upload/ProductBanners.vue";
import E from "wangeditor";
export default {
  components: { cProductThumbUploader, cProductBannersUploader },
  data() {
    return {
      id: this.$route.params.id,
      categories: [],
      attributes: [],
      editor: "",
      btn_loading: false,
      attribute_reset: false,
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
    },
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
      handler: "initAttributes"
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
        this.create_editor();
      })
      .catch();
  },
  beforeDestroy() {
    this.destroy_editor();
  },
  methods: {
    create_editor() {
      this.editor = new E(this.$refs.product_edit_editor);
      // this.editor.customConfig.debug = true;
      this.editor.customConfig.menus = editorMenu;
      this.editor.customConfig.uploadImgServer = editorUploadImgServer;
      this.editor.customConfig.uploadImgMaxSize = uploadImgMaxSize;
      this.editor.customConfig.uploadImgMaxLength = uploadImgMaxLength;
      this.editor.customConfig.uploadFileName = uploadFileName;
      this.editor.customConfig.uploadImgHeaders = uploadImgHeaders;

      let vm = this;
      this.editor.customConfig.uploadImgHooks = {
        fail: function (xhr, editor, result) {
          console.log(result);
          vm.$Message.error(result.msg);
        },
        error: function (xhr, editor) {
          vm.$Message.error('图片上传失败');
        },
        success: function(xhr, editor, result){}
      }

      this.editor.customConfig.customAlert = function (info) {
          vm.$Message.error(info);
      }

      this.editor.customConfig.onchange = html => {
        this.data.detail_info = html;
      };
      this.editor.create();
      this.editor.txt.html(this.data.detail_info);
    },
    destroy_editor() {
      this.editor = null;
    },
    initAttributes() {
      let parent_category_id = this.data.category[0];
      fetchAttributes(parent_category_id, "all")
        .then(response => {
          this.attributes = response.ret_msg.data.map(attribute => {
            attribute.selectedItems = [];
            attribute.items.map(item => {
              this.data.skus.map(sku => {
                sku.values.map(value => {
                  if (
                    item.attribute_id === value.attribute_id &&
                    item.id === value.item_id
                  ) {
                    attribute.selectedItems.push(item);
                    return false;
                  }
                });
              });
            });
            return attribute;
          });
        })
        .catch();
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
      if (this.attribute_reset) {
        let ori = [];
        this.data.skus.length = 0;
        this.attributes.map(item => {
          if (item.selectedItems.length) {
            ori.push(item.selectedItems);
          }
        });
        let ret = descartes(ori);
        ret.map(item => {
          var sku = {
            product_id: this.id,
            sku_price: 0.0,
            sku_stock: 0,
            values: []
          };
          item.map(value => {
            sku.values.push({
              attribute_id: value.attribute_id,
              item_id: value.id
            });
          });

          this.data.skus.push(sku);
        });
      }
    },
    buildData(type) {
      let data = {};
      switch (type) {
        case "info":
          data = Object.assign({}, data, {
            sort: this.data.sort,
            category: this.data.category,
            name: this.data.name,
            original_price: this.data.original_price,
            current_price: this.data.current_price,
            sold: this.data.sold,
            stock: this.data.stock,
            status: this.data.status
          });
          break;
        case "image":
          data = Object.assign({}, data, {
            thumb_img: this.data.thumb_img,
            banners: this.data.banners
          });
          break;
        case "detail":
          data = Object.assign({}, data, {
            base_info: this.data.base_info,
            detail_info: this.data.detail_info
          });
          break;
        default:
          break;
      }
      return data;
    },
    update(type) {
      this.btn_loading = true;
      let data = this.buildData(type);
      updateProduct(type, this.id, data)
        .then(response => {
          if (response.ret_code === 0) {
            this.$Message.success("保存成功");
          } else {
            this.$Message.error("保存失败");
          }
          this.btn_loading = false;
        })
        .catch(error => {
          this.btn_loading = false;
        });
    },
    resetSku() {
      this.attribute_reset = !this.attribute_reset;
      this.data.skus.length = 0;
      this.attributes.map(attribute => {
        attribute.selectedItems.length = 0;
      });
    },
    updateSku(sku) {
      let data = { price: sku.sku_price, stock: sku.sku_stock };
      updateSku(sku.sku_id, data)
        .then(response => {
          if (response.ret_code === 0) {
            this.$Message.success("保存成功");
          } else {
            this.$Message.success("保存失败");
          }
        })
        .catch();
    },
    deleteSku(index) {
      let sku = this.data.skus[index];
      deleteSku(sku.sku_id)
        .then(response => {
          if (response.ret_code === 0) {
            this.data.skus.splice(index, 1);
            this.$Message.success("删除成功");
          } else {
            this.$Message.error("删除失败");
          }
        })
        .catch();
    },
    saveSku() {
      this.btn_loading = true;
      createSku(this.data.skus)
        .then(response => {
          if (response.ret_code === 0) {
            this.attribute_reset = !this.attribute_reset;
            this.$Message.success("保存成功");
          } else {
            this.$Message.error("保存失败");
          }
          this.btn_loading = false;
        })
        .catch(error => {
          this.btn_loading = false;
        });
    }
  }
};
</script>

