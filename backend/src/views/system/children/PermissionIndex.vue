<template>
  <div>
    <router-link :to="{ path: '/system/permissions/create' }">
      <Button type="primary">
        <Icon type="plus-round"></Icon>
        创建权限
      </Button>
    </router-link>
    <br><br>
    <div style="background:#eee;padding: 20px">
        <Card :bordered="false">
            <p slot="title">
              <Icon type="ios-film-outline"></Icon>
              权限介绍
            </p>
            <p>系统设置 | system：对应“系统设置”菜单下的所有操作</p>
            <p>商品设置 | product：对应“商品设置”菜单下的所有操作</p>
            <p>个人中心 | user：点击“头像”后，用户可以修改自己的账户信息</p>
            <p>上传图片 | upload：系统全部需要上传图片的操作，如商品、轮播图等</p>
        </Card>
    </div>
    <br>

    <Table :loading="table.loading" :columns="table.columns" :data="table.data"></Table>
  </div>
</template>

<script>
import { fetchPermissions, deletePermission } from "../../../api/system";
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
            title: "资源",
            key: "resource"
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
                        this.edit_permission(params.row.id);
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
                        this.delete_permission(params);
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
    fetchPermissions()
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
    edit_permission(permission_id) {
      this.$router.push({
        path: `/system/permissions/edit/${permission_id}`
      });
    },
    delete_permission(params) {
      deletePermission(params.row.id)
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

