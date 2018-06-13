<template>
    <div>
        <form action="#">
            <van-search
                v-model="keyword"
                placeholder="请输入商品名称"
                show-action
                @search="onSearch"
                @cancel="onCancel"
            />
        </form>

        <p>一堆搜索结果</p>
    </div>
</template>

<script>
export default {
  data() {
    return {
      keyword: ""
    };
  },
  methods: {
    onSearch() {},
    onCancel() {}
  }
};
</script>

