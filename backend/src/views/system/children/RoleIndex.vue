<template>
  <div>
    <router-link :to="{ path: '/system/roles/create' }">
      <Button type="primary">
        <Icon type="plus-round"></Icon>
        创建角色
      </Button>
    </router-link>
    <br><br>
    <Table :loading="table.loading" :columns="table.columns" :data="table.data"></Table>
  </div>
</template>

<script>
import { fetchRoles, deleteRole } from "../../../api/system";
export default {
  data() {
    return {
      table: {
        loading: true,
        columns: [
          {
            title: "#",
            key: "id"
          },
          {
            title: "名称",
            key: "name"
          },
          {
            title: "别名",
            key: "alias"
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
    fetchRoles()
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
  methods: {
    edit(role_id) {
      this.$router.push({
        path: `/system/roles/edit/${role_id}`
      });
    },
    del(params) {
      deleteRole(params.row.id)
        .then(response => {
          if (response.ret_code === 0) {
            this.table.data.splice(params.index, 1);
          } else {
            this.$Message.error("操作失败");
          }
        })
        .catch(error => {});
    }
  }
};
</script>

