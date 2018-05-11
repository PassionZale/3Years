<template>
    <div>

      <Steps :current="current" class="form-item-wrapper">
          <Step title="选择所属分类"></Step>
          <Step title="配置规格名称"></Step>
          <Step title="配置规格选项"></Step>
          <Step title="确认创建"></Step>
      </Steps>
      <hr>

      <div class="form-item-wrapper" v-show="current === 0">
        <label>一级分类：</label>
        <Select v-model="data.category_id" placeholder="请选择" filterable style="width: 300px">
          <Option v-for="item in parent_categories" :value="item.id" :key="item.id">{{ item.name }}</Option>
        </Select>
        <hr>
        <Button type="primary" @click="step_0_next">下一步</Button>
      </div>

      <div v-show="current === 1">
        <div class="form-item-wrapper">
          <label>规格名称：</label>
          <Input type="text" v-model="attribute_name" placeholder="请输入规格名称" clearable style="width: 150px;"></Input>
          <Button icon="ios-plus-empty" type="dashed" @click="add_name">
            添加规格
          </Button>
        </div>

        <div v-show="data.attributes.length > 0">
          <hr>
          <div class="form-item-wrapper">
            <Tag v-for="(item, index) in data.attributes" type="dot" color="blue" :key="index" :name="item.name" closable @on-close="remove_name(index)">{{ item.name }}</Tag>
          </div>
        </div>
        
        <hr>
        <Button type="primary" @click="step_1_pre">上一步</Button>
        <Button type="primary" @click="step_1_next">下一步</Button>
      </div>

      <div v-show="current === 2">
        <div class="form-item-wrapper" v-for="(attribute, index) in data.attributes">
          <label>{{ attribute.name }}：</label>
          <Input type="text" v-model="attribute.item_input_name" placeholder="请输入规格选项" clearable style="width: 150px;"></Input>
          <Button icon="ios-plus-empty" type="dashed" @click="add_item(index)">
            添加选项
          </Button>
          <div v-show="attribute.items.length > 0">
            <div class="form-item-wrapper">
              <Tag v-for="(item, i) in attribute.items" type="dot" color="blue" :key="i" :name="item.name" closable @on-close="remove_item(index, i)">{{ item.name }}</Tag>
            </div>
          </div>
          <hr>
        </div> 

        <Button type="primary" @click="step_2_pre">上一步</Button>
        <Button type="primary" @click="step_2_next">下一步</Button>
      </div>

      <div class="form-item-wrapper" v-show="current === 3">
        <div class="form-item-wrapper" v-for="attribute in data.attributes">
          <label>{{ attribute.name }}：</label>
          <Tag v-for="(item, index) in attribute.items" :key="index" :name="item.name">{{ item.name }}</Tag>
          <hr>
        </div>
        <Button type="primary" @click="step_3_pre">上一步</Button>
        <Button type="success" @click="submit" :loading="btn_loading">确认创建</Button>
      </div>

    </div>
</template>
<script>
import { fetchParentCategories, createAttribute } from "../../../api/product";
export default {
  data() {
    return {
      current: 0,
      parent_categories: [],
      category_name: "",
      attribute_name: "",
      btn_loading: false,
      data: {
        category_id: "",
        attributes: []
      }
    };
  },
  created() {
    fetchParentCategories()
      .then(response => {
        this.parent_categories = response.ret_msg;
      })
      .catch();
  },
  methods: {
    step_0_next() {
      if (this.data.category_id) {
        this.current += 1;
      } else {
        this.$Message.error("请选择一个分类");
      }
    },
    step_1_pre() {
      this.current -= 1;
    },
    step_1_next() {
      if (this.data.attributes.length > 0) {
        this.current += 1;
      } else {
        this.$Message.error("还未配置规格名称");
      }
    },
    step_2_pre() {
      this.current -= 1;
    },
    step_2_next() {
      let not_empty = this.data.attributes.every(this.items_not_empty);
      if (not_empty) {
        this.current += 1;
      } else {
        this.$Message.error("请为每一个规格填入至少一个选项");
      }
    },
    step_3_pre() {
      if (this.btn_loading) {
        this.$Message.error("正在提交中...");
        return;
      }
      this.current -= 1;
    },
    add_name() {
      if (this.attribute_name) {
        let attribute = {
          name: this.attribute_name,
          item_input_name: "",
          items: []
        };
        this.data.attributes.push(attribute);
        this.$nextTick(function() {
          this.attribute_name = "";
        });
      } else {
        this.$Message.error("规格名称不能为空");
      }
    },
    remove_name(index) {
      this.data.attributes.splice(index, 1);
    },
    add_item(index) {
      let name = this.data.attributes[index].item_input_name;
      if (name) {
        let item = {
          name
        };
        this.data.attributes[index].items.push(item);
        this.$nextTick(function() {
          this.data.attributes[index].item_input_name = "";
        });
      } else {
        this.$Message.error("规格选项不能为空");
      }
    },
    remove_item(attr_index, item_index) {
      this.data.attributes[attr_index].items.splice(item_index, 1);
    },
    items_not_empty(element, index, array) {
      return element.items.length > 0;
    },
    submit() {
      this.btn_loading = true;
      createAttribute(this.data)
        .then(response => {
          this.btn_loading = false;
          if (response.ret_code === 0) {
            this.$Message.success("创建成功");
            this.$router.push("/product/attribute");
          } else {
            this.$Message.error("创建失败，提交数据过多");
          }
        })
        .catch(error => {
          this.btn_loading = false;
        });
    }
  }
};
</script>