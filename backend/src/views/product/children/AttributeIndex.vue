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
export default {
  data() {
    return {
      table: {
        loading: false,
        columns: [
          {
            title: "名称",
            key: "name"
          }
        ],
        data: []
      }
    };
  }
};
</script>

