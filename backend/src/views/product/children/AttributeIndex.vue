<template>
  <div>
    
    <router-link :to="{ path: '/product/attribute/create' }">
      <Button type="primary">
        <Icon type="plus-round"></Icon>
        创建规格
      </Button>
    </router-link>
    <br><br>

    <Table :loading="table.loading" :columns="table.columns" :data="table.data"></Table>

  </div>
</template>

<script>
import { fetchAttributes } from "../../../api/product";
export default {
  data() {
    return {
      table: {
        loading: true,
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
    fetchAttributes()
      .then(response => {
        this.table.data = response.ret_msg;
        this.$nextTick(function() {
          this.table.loading = false;
        });
      })
      .catch();
  },
  methods: {
    edit(id) {
      this.$router.push(`/product/attribute/edit/${id}`);
    },
    del() {}
  }
};
</script>

