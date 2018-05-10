<template>
  <div>
    
    <router-link :to="{ path: '/product/category/create' }">
      <Button type="primary">
        <Icon type="plus-round"></Icon>
        创建分类
      </Button>
    </router-link>
    <br><br>
    <RadioGroup v-model="data.category_id" type="button" @on-change="change">
        <Radio :label="item.id" v-for="item in parentCategories" :key="item.id">{{item.name}}</Radio>
    </RadioGroup>
    <br><br>
    <Table :loading="table.loading" :row-class-name="highlight_parent_category_row" :columns="table.columns" :data="table.data"></Table>

    <Modal v-model="modal.show" width="360">
        <p slot="header" style="color:#f60;text-align:center">
            <Icon type="information-circled"></Icon>
            <span>正在删除一级分类</span>
        </p>
        <div style="text-align:center">
            <p>若该分类删除，则其子分类会被全部删除！</p>
            <p>是否确认删除?</p>
        </div>
        <div slot="footer">
            <Button type="dashed" size="large" :loading="modal.btn_loading" @click="del_parent_category">确认删除</Button>
            <Button type="error" size="large" @click="modal.show = !modal.show">放弃操作</Button>
        </div>
    </Modal>

  </div>
</template>

<script>
import {
  fetchParentCategories,
  fetchChildCategories,
  deleteCategory
} from "../../../api/product";
export default {
  data() {
    return {
      parentCategories: [],
      modal: {
        show: false,
        btn_loading: false,
        params: {}
      },
      data: {
        category_id: 0
      },
      table: {
        loading: false,
        columns: [
          {
            title: "名称",
            key: "name"
          },
          {
            title: "创建时间",
            key: "created_at"
          },
          {
            title: "最后修改",
            key: "updated_at"
          },
          {
            title: "排序",
            key: "sort"
          },
          {
            title: "操作",
            key: "CRUD",
            render: (h, params) => {
              return h("div", [
                h(
                  "Button",
                  {
                    props: {
                      type: "primary",
                      size: "small"
                    },
                    style: {
                      marginRight: "5px"
                    },
                    on: {
                      click: () => {
                        this.edit(params.row.id);
                      }
                    }
                  },
                  "编辑"
                ),
                h(
                  "Button",
                  {
                    props: {
                      type: "error",
                      size: "small"
                    },
                    on: {
                      click: () => {
                        if (params.row.p_id == 0) {
                          this.modal.params = Object.assign(
                            {},
                            this.modal.params,
                            params
                          );
                          this.modal.show = true;
                        } else {
                          this.del(params);
                        }
                      }
                    }
                  },
                  "删除"
                )
              ]);
            }
          }
        ],
        data: []
      }
    };
  },
  created() {
    fetchParentCategories()
      .then(response => {
        this.parentCategories = response.ret_msg;
      })
      .catch(error => {});
  },
  methods: {
    highlight_parent_category_row(row, index) {
      return row.p_id == 0 ? "parent-category" : "";
    },
    change() {
      this.table.loading = true;
      fetchChildCategories(this.data.category_id)
        .then(response => {
          this.table.data = response.ret_msg;
          this.$nextTick(function() {
            this.table.loading = false;
          });
        })
        .catch(error => {
          this.table.loading = false;
        });
    },
    edit(id) {
      this.$router.push({
        path: `/product/category/edit/${id}`
      });
    },
    del(params) {
      deleteCategory(params.row.id)
        .then(response => {
          if (response.ret_code === 0) {
            this.$Message.success(`删除成功`);
            this.table.data.splice(params.index, 1);
          } else {
            this.$Message.error(response.ret_msg);
          }
        })
        .catch(error => {});
    },
    del_parent_category() {
      let params = this.modal.params;
      this.modal.btn_loading = true;

      deleteCategory(params.row.id)
        .then(response => {
          this.modal.btn_loading = false;
          this.modal.show = false;
          if (response.ret_code === 0) {
            this.$Message.success("一级分类删除成功");
            this.$nextTick(function() {
              location.reload();
            });
          } else {
            this.$Message.error(response.ret_msg);
          }
        })
        .catch(error => {});
    }
  }
};
</script>

<style lang="less">
.ivu-table .parent-category td:first-child {
  background-color: #2d8cf0;
  color: #fff;
}
</style>
