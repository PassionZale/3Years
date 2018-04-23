<template>
  <form>
    <Input v-model="form_login_data.username" placeholder="Enter something..." clearable style="width: 300px"></Input>    
  </form>
</template>
<script>
export default {
  data() {
    return {
      form_login_data: {
        username: "",
        password: ""
      }
    };
  }
};
</script>
