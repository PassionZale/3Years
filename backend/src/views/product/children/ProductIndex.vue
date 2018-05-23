<template>
  <div>

    <router-link :to="{ path: '/product/commodity/create' }">
      <Button type="primary">
        <Icon type="plus-round"></Icon>
        创建商品
      </Button>
    </router-link>

    <br><br>

    <div class="form-item-wrapper">
      <Cascader v-model="search.category" :data="categories" placeholder="请选择分类" style="width: 300px;display: inline-block;"></Cascader>
      <Input type="text" v-model="search.keyword" placeholder="请输入商品名称" closeable style="width: 200px;"></Input>
      <Button type="primary" @click="searchData" icon="search">查询</Button>
    </div>

    <Table :load="table.loading" :columns="table.columns" :data="table.data"></Table>

    <br>

    <Page :total="search.page.total" :current.sync="search.page.current" @on-change="loadPage" show-elevator></Page>

  </div>
</template>

<script>
import {
  fetchCategories,
  fetchProducts,
  deleteProduct
} from "../../../api/product";
export default {
  data() {
    return {
      categories: [],
      search: {
        category: [],
        keyword: "",
        page: {
          total: 0,
          current: 1
        }
      },
      table: {
        loading: false,
        columns: [
          {
            title: "缩略图",
            key: "thumb_img",
            render: (h, params) => {
              return h(
                "div",
                {
                  class: "thumb-img-wrapper"
                },
                [
                  h("img", {
                    attrs: {
                      src: params.row.thumb_img,
                      title: params.row.name,
                      alt: params.row.name
                    }
                  })
                ]
              );
            }
          },
          {
            title: "名称",
            key: "name"
          },
          {
            title: "原价",
            key: "original_price"
          },
          {
            title: "现价",
            key: "current_price"
          },
          {
            title: "已售数",
            key: "sold"
          },
          {
            title: "库存数",
            key: "stock"
          },
          {
            title: "状态",
            key: "status",
            render: (h, params) => {
              let text = params.row.status == 1 ? "上架" : "下架";
              let color = params.row.status == 1 ? "green" : "red";
              return h("Tag", { props: { color: color } }, [text]);
            }
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
                        this.del(params);
                      }
                    }
                  },
                  "下架"
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
    fetchCategories()
      .then(response => {
        this.categories = response.ret_msg;
      })
      .catch(error => {});
    this.initTable();
  },
  methods: {
    searchData() {
      this.search.page.current = 1;
      this.initTable();
    },
    loadPage(current = 1) {
      this.search.page.current = current;
      this.initTable();
    },
    initTable() {
      this.table.loading = true;
      fetchProducts(
        this.search.page.current,
        this.search.category[1],
        this.search.keyword
      )
        .then(response => {
          this.table.data = response.ret_msg.data;
          this.search.page.total = response.ret_msg.paginate.total;
          this.$nextTick(function() {
            this.table.loading = false;
          });
        })
        .catch(error => {
          this.table.loading = false;
        });
    },
    edit(id) {
      this.$router.push(`/product/commodity/edit/${id}`);
    },
    del(params) {
      if (params.row.status == 1) {
        deleteProduct(params.row.id)
          .then(response => {
            if (response.ret_code === 0) {
              this.$Message.success("下架成功");
              this.$set(params.row, "status", 0);
            } else {
              this.$Message.error("操作失败");
            }
          })
          .catch(error => {
            this.$Message.error("操作失败");
          });
      } else {
        this.$Message.warning("商品已是下架状态");
      }
    }
  }
};
</script>

<style lang="less">
.thumb-img-wrapper {
  display: inline-block;
  width: 100px;
  height: auto;
  padding: 10px 0;
  img {
    display: block;
    max-width: 100%;
    height: auto;
  }
}
</style>
