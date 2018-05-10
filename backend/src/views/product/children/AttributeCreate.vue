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
          <Input type="text" v-model="data.name" placeholder="请输入规格名称" clearable style="width: 300px"></Input>
        </div>
        <hr>
        <Button type="primary" @click="step_1_pre">上一步</Button>
        <Button type="primary" @click="step_1_next">下一步</Button>
      </div>

      <div v-show="current === 2">
        <div class="form-item-wrapper" v-show="current === 2">
          <p>配置规格选项</p>
          <hr>
          <Button type="primary" @click="step_2_pre">上一步</Button>
          <Button type="primary" @click="step_2_next">下一步</Button>
        </div>
      </div>

      <div class="form-item-wrapper" v-show="current === 3">
        <p>确认创建</p>
        <hr>
        <Button type="primary" @click="step_3_pre">上一步</Button>
        <Button type="success" @click="submit">确认创建</Button>
      </div>

    </div>
</template>
<script>
import { fetchParentCategories } from "../../../api/product";
export default {
  data() {
    return {
      current: 1,
      parent_categories: [],
      category_name: "",
      data: {
        category_id: "6",
        name: "",
        sort: 0
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
    submit() {}
  }
};
</script>