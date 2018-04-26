<template>
  <div>
    <Button type="primary">
      <Icon type="person-add"></Icon>
      创建用户
    </Button>
    <br><br>
    <Input v-model="keyword" placeholder="请输入用户名" style="width:300px;">
        <Button slot="append" icon="ios-search" type="primary"></Button>
    </Input>
    <br>
    <Table :loading="table.loading" :columns="table.columns" :data="table.data"></Table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      keyword: "",
      table: {
        loading: false,
        columns: [
          {
            title: "Name",
            key: "name"
          },
          {
            title: "Age",
            key: "age"
          },
          {
            title: "Address",
            key: "address"
          }
        ],
        data: [
          {
            name: "John Brown",
            age: 18,
            address: "New York No. 1 Lake Park",
            date: "2016-10-03"
          },
          {
            name: "Jim Green",
            age: 24,
            address: "London No. 1 Lake Park",
            date: "2016-10-01"
          },
          {
            name: "Joe Black",
            age: 30,
            address: "Sydney No. 1 Lake Park",
            date: "2016-10-02"
          },
          {
            name: "Jon Snow",
            age: 26,
            address: "Ottawa No. 2 Lake Park",
            date: "2016-10-04"
          }
        ]
      }
    };
  }
};
</script>
