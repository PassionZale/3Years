<template>
  <div>
    <router-link :to="{ path: '/system/users/create' }">
      <Button type="primary">
        <Icon type="plus-round"></Icon>
        创建用户
      </Button>
    </router-link>
    <br><br>
    <Table :loading="table.loading" :columns="table.columns" :data="table.data"></Table>
  </div>
</template>

<script>
import { fetchUsers, deleteUser } from "../../../api/system";
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
            title: "用户名",
            key: "username"
          },
          {
            title: "邮箱",
            key: "email"
          },
          {
            title: "角色",
            key: "role",
            render: (h, params) => {
              let role = params.row.role;
              let color = "default";
              if (params.row.is_superuser == 1) {
                role = "SUPERUSER";
                color = "red";
              }
              if (role) {
                return h("Tag", { props: { color: color } }, [role]);
              }
            }
          },
          {
            title: "权限",
            key: "permissions",
            render: (h, params) => {
              if (params.row.is_superuser == 1) {
                return h("Tag", { props: { color: "red" } }, ["全部权限"]);
              }
              return h(
                "div",
                params.row.permissions.map(item => {
                  return h("Tag", { props: { color: "green" } }, [item.name]);
                })
              );
            }
          },
          {
            title: "状态",
            key: "is_active",
            render: (h, params) => {
              let text = params.row.is_active == 1 ? "启用" : "禁用";
              return h("strong", text);
            }
          },
          {
            title: "最后登录",
            key: "last_login"
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
                        this.delete(params);
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
    fetchUsers()
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
    edit(user_id) {
      this.$router.push(`/system/users/edit/${user_id}`);
    },
    delete(params) {
      deleteUser(params.row.id)
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
