<template>
  <div>

    <div class="form-item-wrapper">
      <label>一级分类：</label>
      <Select v-model="attribute.category_id" placeholder="请选择" filterable style="width: 300px">
        <Option v-for="item in parent_categories" :value="item.id" :key="item.id">{{ item.name }}</Option>
      </Select>
    </div>

    <div class="form-item-wrapper">
      <label>规格名称：</label>
      <Input type="text" v-model="attribute.name" placeholder="请输入规格名称" clearable style="width: 300px"></Input>
    </div>
    
    <hr>
    <div class="form-item-wrapper">
      <label>规格选项：</label>
      <Input type="text" v-model="item_input_name" placeholder="请输入规格选项" clearable style="width: 150px;"></Input>
      <Button icon="ios-plus-empty" type="dashed" @click="add_item">
        添加选项
      </Button>
      
      <div class="form-item-wrapper">
        <Tag v-for="(item, index) in attribute.items" type="dot" color="blue" :key="index" :name="item.name" closable @on-close="remove_item(index)">{{ item.name }}</Tag>
      </div>
    </div>

    <hr>
    <div class="form-item-wrapper">
      <Button type="primary" @click="click" :loading="btn_loading">保存修改</Button>
    </div>
  </div>
</template>

<script>
import {
  fetchParentCategories,
  fetchAttribute,
  updateAttribute
} from "../../../api/product";
export default {
  data() {
    return {
      id: this.$route.params.id,
      btn_loading: false,
      parent_categories: [],
      item_input_name: "",
      attribute: {}
    };
  },
  created() {
    fetchParentCategories()
      .then(response => {
        this.parent_categories = response.ret_msg;
      })
      .catch();
    fetchAttribute(this.id)
      .then(response => {
        this.attribute = response.ret_msg;
      })
      .catch();
  },
  methods: {
    add_item() {
      let name = this.item_input_name;
      if (name) {
        this.attribute.items.push({
          attribute_id: this.id,
          name
        });
        this.$nextTick(function() {
          this.item_input_name = "";
        });
      } else {
        this.$Message.error("规格选项不能为空");
      }
    },
    remove_item(index) {
      this.attribute.items.splice(index, 1);
    },
    click() {
      if (!this.attribute.name) {
        this.$Message.error("规格名称不能为空");
        return;
      }
      if (!this.attribute.items.length) {
        this.$Message.error("至少添加一个规格选项");
        return;
      }

      this.btn_loading = true;

      updateAttribute(this.id, this.attribute)
        .then(response => {
          if (response.ret_code === 0) {
            this.$Message.success("操作成功");
            this.$router.push("/product/attribute");
          } else {
            this.$Message.error("操作失败");
          }
          this.btn_loading = false;
        })
        .catch(error => {
          this.btn_loading = false;
          this.$Message.error("操作失败");
        });
    }
  }
};
</script>

