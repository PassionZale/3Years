<template>
    <div>

        <div class="form-item-wrapper">
            <Select v-model="data.product_id" filterable style="width: 300px;">
                <Option v-for="(product, index) in products" :value="product.id" :key="index">{{ product.name }}</Option>
            </Select>
            <Button type="ghost" icon="plus" @click="add" :loading="btn_loading">添加推荐</Button>
        </div>

        <hr>

        <div class="form-item-wrapper">
            <Tag
                closable 
                type="dot"
                color="blue" 
                v-for="(recommend, index) in recommends" 
                :key="index"
                @on-close="remove(recommend.id, index)">
                {{ recommend.name }}
            </Tag>
        </div>

    </div>
</template>

<script>
import {
  fetchRecommend,
  createRecommend,
  deleteRecommend
} from "../../../api/shop";
export default {
  data() {
    return {
      btn_loading: false,
      recommends: [],
      products: [],
      data: { product_id: "" }
    };
  },
  created() {
    fetchRecommend()
      .then(response => {
        this.recommends = response.ret_msg.recommends;
        this.products = response.ret_msg.products;
      })
      .catch();
  },
  methods: {
    add() {
      if (this.data.product_id) {
        this.btn_loading = true;
        createRecommend(this.data)
          .then(response => {
            if (response.ret_code === 0) {
              this.recommends.push(response.ret_msg);
              this.$nextTick(function() {
                this.$Message.success("添加成功");
              });
            } else {
              this.$Message.error("该商品已在推荐中");
            }
            this.btn_loading = false;
          })
          .catch(error => {
            this.btn_loading = false;
          });
      } else {
        this.$Message.error("请选择一个商品");
      }
    },
    remove(id, index) {
        deleteRecommend(id).then(response => {
            if(response.ret_code === 0){
                this.recommends.splice(index, 1);
                this.$nextTick(function(){
                    this.$Message.success('删除成功');
                });
            }else{
                this.$Message.error('删除失败');
            }
        }).catch();
    }
  }
};
</script>
