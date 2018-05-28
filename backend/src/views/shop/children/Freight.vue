<template>
    <div>
        <div class="form-item-wrapper">
            <label>邮费：</label>
            <InputNumber :min="0" :step="0.01" v-model="data.cost_freight" style="width: 300px;"></InputNumber>
        </div>
        <div class="form-item-wrapper">
            <label>免邮：</label>
            <InputNumber :min="0" :step="0.01" v-model="data.free_freight" style="width: 300px;"></InputNumber>
        </div>
        <hr>
        <div class="form-item-wrapper">
            <Button type="primary" @click="click" :loading="btn_loading">保存修改</Button>
        </div>
    </div>
</template>

<script>
import { fetchFreight, updateFreight } from "../../../api/shop";
export default {
  data() {
    return {
      btn_loading: false,
      data: {
        cost_freight: 0.0,
        free_freight: 0.0
      }
    };
  },
  created() {
      fetchFreight().then(response => {
          this.data = response.ret_msg;
      }).catch();
  },
  methods: {
    click() {
        this.btn_loading = true;
        updateFreight(this.data).then(response => {
            this.$Message.success('修改成功');
            this.btn_loading = false;
        }).catch(error => {this.btn_loading = false});
    }
  }
};
</script>
