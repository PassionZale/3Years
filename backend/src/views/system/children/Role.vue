<template>
  <Table :loading="table.loading" :columns="table.columns" :data="table.data"></Table>
</template>

<script>
import { fetchRoles } from "../../../api/system";
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
  }
};
</script>

