<template>
<Sider :style="{position: 'fixed', height: '100vh',background:'#fff', left: 0, overflow: 'auto'}">
    <Menu width="200px" theme="light" active-name="1" :style="{height: '100%'}">
        <MenuGroup title="内容管理">
            <MenuItem name="1">
                <Icon type="document-text"></Icon>
                dashboard
            </MenuItem>
            <MenuItem name="2">
                <Icon type="chatbubbles"></Icon>
                user
            </MenuItem>
        </MenuGroup>
        <MenuGroup title="统计分析">
            <MenuItem name="3">
                <Icon type="heart"></Icon>
                follow
            </MenuItem>
            <MenuItem name="4">
                <Icon type="heart-broken"></Icon>
                product
            </MenuItem>
        </MenuGroup>
    </Menu>
</Sider>
</template>

<script>
export default {};
</script>