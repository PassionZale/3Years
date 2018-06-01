<template>
    <p>follow</p>
</template>

<script>
import { fetchFollows } from "../../../api/wechat";
export default {
  data() {
    return {
      search: {},
      table: {
        colunms: [],
        data: []
      }
    };
  },
  created() {
    fetchFollows(this.search)
      .then(response => {
        this.data = response.ret_msg;
      })
      .catch();
  }
};
</script>

