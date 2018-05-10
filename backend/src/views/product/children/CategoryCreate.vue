<template>
  <div>
    <div class="form-item-wrapper">
      <label>分类名称：</label>
      <Input type="text" v-model="data.name" placeholder="请输入分类名称" clearable style="width: 300px"></Input>
    </div>
    <div class="form-item-wrapper">
      <label>一级分类：</label>
      <Select v-model="data.p_id" placeholder="请选择" filterable style="width: 300px">
          <Option v-for="item in parent_categories" :value="item.id" :key="item.id">{{ item.name }}</Option>
      </Select>
    </div>
    <hr>
    <div class="form-item-wrapper">
        <label>排序：</label>
        <Poptip trigger="focus" title="注意！" content="排序默认为0，值越大则越靠前" placement="right">
          <InputNumber :max="10000" :min="0" :step="1" v-model="data.sort"></InputNumber>
        </Poptip>
    </div>
    <hr>
    <div class="form-item-wrapper">
      <Button type="primary" @click="click" :loading="btn_loading">确认创建</Button>
    </div>
  </div>
</template>

<script>
import { createCategory, fetchParentCategories } from "../../../api/product";
export default {
  data() {
    return {
      btn_loading: false,
      data: {
        name: "",
        sort: 0,
        p_id: ""
      },
      parent_categories: []
    };
  },
  created() {
    fetchParentCategories()
      .then(response => {
        this.parent_categories = Object.assign(
          {},
          this.parent_categories,
          response.ret_msg
        );
      })
      .catch();
  },
  methods: {
    click() {
      this.btn_loading = true;
      createCategory(this.data)
        .then(response => {
          if (response.ret_code === 0) {
            this.$Message.success("创建成功");
            this.$router.push("/product/category");
          } else {
            this.$Message.error(response.ret_msg);
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

