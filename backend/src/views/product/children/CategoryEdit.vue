<template>
  <div>
    <div class="form-item-wrapper">
      <label>分类名称：</label>
      <Input type="text" v-model="data.name" placeholder="请输入分类名称" clearable style="width: 300px"></Input>
    </div>
    <div class="form-item-wrapper">
      <label>一级分类：</label>
      <Button type="dashed" v-if="data.p_id == 0">已为一级分类，无法设置</Button>
      <Select v-else v-model="data.p_id" placeholder="请选择" filterable style="width: 300px">
          <Option :value="0">无</Option>
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
      <Button type="primary" @click="click" :loading="btn_loading">保存修改</Button>
    </div>
  </div>
</template>

<script>
import {
  fetchParentCategories,
  fetchCategory,
  updateCategory
} from "../../../api/product";
export default {
  data() {
    return {
      id: this.$route.params.id,
      btn_loading: false,
      parent_categories: [],
      data: {
        name: "",
        p_id: 0,
        sort: 0
      }
    };
  },
  created() {
    fetchCategory(this.id)
      .then(response => {
        // 由于 InputNumber 只接受 Number 类型，在此强制转换为 Number
        response.ret_msg.sort = parseInt(response.ret_msg.sort);
        this.data = Object.assign({}, this.data, response.ret_msg);
      })
      .catch();
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
      updateCategory(this.id, this.data)
        .then(response => {
          this.btn_loading = false;
          if (response.ret_code === 0) {
            this.$Message.success("保存成功");
            this.$router.push("/product/category");
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

