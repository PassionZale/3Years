<template>
<Sider :style="{position: 'fixed', height: '100vh',background:'#fff', left: 0, overflow: 'auto'}">
    <Menu width="200px" theme="light" active-name="1" :style="{height: '100%'}">
        <MenuGroup title="内容管理">
            <MenuItem name="1">
                <Icon type="document-text"></Icon>
                文章管理
            </MenuItem>
            <MenuItem name="2">
                <Icon type="chatbubbles"></Icon>
                评论管理
            </MenuItem>
        </MenuGroup>
        <MenuGroup title="统计分析">
            <MenuItem name="3">
                <Icon type="heart"></Icon>
                用户留存
            </MenuItem>
            <MenuItem name="4">
                <Icon type="heart-broken"></Icon>
                流失用户
            </MenuItem>
        </MenuGroup>
    </Menu>
</Sider>
</template>

<script>
export default {};
</script>