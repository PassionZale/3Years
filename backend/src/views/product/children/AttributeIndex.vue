<template>
  <div>
    
    <router-link :to="{ path: '/product/attribute/create' }">
      <Button type="primary">
        <Icon type="plus-round"></Icon>
        创建规格
      </Button>
    </router-link>

    <br><br>

    <Select v-model="search.category_id" placeholder="请选择分类" filterable style="width: 300px" @on-change="change">
        <Option value="all" :key="0">全部分类</Option>
        <Option v-for="item in categories" :value="item.id" :key="item.id" >{{ item.name }}</Option>
    </Select>

    <br><br>

    <Table :loading="table.loading" :columns="table.columns" :data="table.data"></Table>

    <br>

    <Page :total="search.page.total" :current.sync="search.page.current" @on-change="loadPage" show-elevator></Page>

  </div>
</template>

<script>
import { fetchAttributes, fetchParentCategories, deleteAttribute } from "../../../api/product";
export default {
  data() {
    return {
      categories: [],
      search: {
        category_id: "all",
        page: {
          total: 0,
          current: 1
        }
      },
      table: {
        loading: false,
        columns: [
          {
            title: "所属分类",
            key: "category"
          },
          {
            title: "规格名称",
            key: "name"
          },
          {
            title: "规格选项",
            key: "items",
            render: (h, params) => {
              return h(
                "div",
                params.row.items.map(item => {
                  return h("Tag", [item.name]);
                })
              );
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
        this.categories = response.ret_msg;
      })
      .catch(error => {});

    this.initTable();
  },
  methods: {
    initTable() {
      this.table.loading = true;
      fetchAttributes(this.search.category_id, this.search.page.current)
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
    change() {
      this.search.page.current = 1;
      this.initTable();
    },
    loadPage(current = 1){
      this.search.page.current = current;
      this.initTable();
    },
    edit(id) {
      this.$router.push(`/product/attribute/edit/${id}`);
    },
    del(params) {
      deleteAttribute(params.row.id).then(response => {
        if(response.ret_code === 0){
          this.table.data.splice(params.index, 1);
          this.$Message.success('操作成功');
        }else{
          this.$Message.error('操作失败');
        }
      }).catch(error => {
        this.$Message.error('操作失败');
      });
    }
  }
};
</script>

