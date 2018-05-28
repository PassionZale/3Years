<template>
    <div>

    <router-link :to="{ path: '/shop/banner/create' }">
      <Button type="primary">
        <Icon type="plus-round"></Icon>
        创建轮播图
      </Button>
    </router-link>

    <br><br>

    <Table :load="table.loading" :columns="table.columns" :data="table.data"></Table>

    </div>
</template>

<script>
import { fetchBanner, deleteBanner } from "../../../api/shop";
export default {
  data() {
    return {
      table: {
        loading: false,
        columns: [
          {
            title: "轮播图",
            key: "imgurl",
            render: (h, params) => {
              return h(
                "div",
                {
                  class: "banner-img-wrapper"
                },
                [
                  h("img", {
                    attrs: {
                      src: params.row.imgurl,
                      title: "轮播图",
                      alt: "轮播图"
                    }
                  })
                ]
              );
            }
          },
          {
            title: "跳转链接",
            key: "redirect"
          },
          {
            title: "排序",
            key: "sort"
          },
          {
            title: "创建时间",
            key: "created_at"
          },
          {
            title: "最后修改",
            key: "updated_at"
          },
          {
            title: "操作",
            key: "CRUD",
            render: (h, params) => {
              return h("div", [
                h(
                  "Button",
                  {
                    props: {
                      type: "primary",
                      size: "small"
                    },
                    style: {
                      marginRight: "5px"
                    },
                    on: {
                      click: () => {
                        this.edit(params.row.id);
                      }
                    }
                  },
                  "编辑"
                ),
                h(
                  "Button",
                  {
                    props: {
                      type: "error",
                      size: "small"
                    },
                    on: {
                      click: () => {
                        this.del(params);
                      }
                    }
                  },
                  "删除"
                )
              ]);
            }
          }
        ],
        data: []
      },
      banners: []
    };
  },
  created() {
    fetchBanner()
      .then(response => {
        this.table.data = response.ret_msg;
      })
      .catch(error => {});
  },
  methods: {
    edit(id) {
      this.$router.push(`/shop/banner/edit/${id}`);
    },
    del(params) {
      deleteBanner(params.row.id).then(response => {
        if(response.ret_code === 0){
          this.$Message.success('删除成功');
          this.table.data.splice(params.row.index, 1);
        }else{
          this.$Message.error('删除失败');
        }
      }).catch(error => {});
    }
  }
};
</script>

<style lang="less">
.banner-img-wrapper {
  display: inline-block;
  width: 100px;
  height: auto;
  padding: 10px 0;
  img {
    display: block;
    max-width: 100%;
    height: auto;
  }
}
</style>
