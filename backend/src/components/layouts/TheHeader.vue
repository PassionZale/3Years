<template>
    <Header :style="{padding:'0 16px',background: '#fff',borderBottom:'1px solid #eee'}">
      <Row>
        <Col span="12" :style="{textAlign:'left'}">
          <router-link :to="{ path: '/user' }">
            <Avatar src="//tvax1.sinaimg.cn/crop.0.0.1342.1342.180/006OyqbNly8fka2xep3duj311a11ajv9.jpg" />
            <span style="color:#495060;">{{ user.username }}</span>
          </router-link>
        </Col>
        <Col span="12" :style="{textAlign:'right'}">
          <Button type="primary" icon="log-out" @click="logout">
            注销
          </Button>
        </Col>
      </Row>
    </Header>
</template>

<script>
import { mapGetters } from "vuex"
export default {
  computed: {
    ...mapGetters(["user"])
  },
  methods: {
    logout() {
      this.$store.dispatch("LogOut").then(() => {
        location.reload();
      });
    }
  }
};
</script>
