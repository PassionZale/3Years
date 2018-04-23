<template>
    <Header :style="{padding:'0 16px',background: '#fff',borderBottom:'1px solid #eee'}">
        <Button type="primary" @click.native.prevent="logout">注销</Button>
    </Header>
</template>

<script>
export default {
    methods: {
        logout() {
            this.$store.dispatch('Logout').then(() => {
                this.$router.push('/login');
            });
        }
    }
};
</script>
