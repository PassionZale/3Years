<template>
    <div class="form-item-wrapper">
      <Table :load="table.loading" :columns="table.columns" :data="table.data"></Table>
      <br>
      <Page :total="page.total" :current.sync="search.page" @on-change="loadPage" show-elevator></Page>
    </div>
</template>

<script>
import { fetchFollows } from "../../../api/wechat";
export default {
  data() {
    return {
      page: {
        total: 0
      },
      search: {
        page: 1
      },
      table: {
        loading: false,
        columns: [
          {
            title: "头像",
            key: "headimgurl",
            render: (h, params) => {
              return h(
                "div",
                {
                  class: "avatar-wrapper"
                },
                [
                  h("img", {
                    attrs: {
                      src: params.row.headimgurl,
                      title: "粉丝头像",
                      alt: "粉丝头像"
                    }
                  })
                ]
              );
            }
          },
          {
            title: "昵称",
            key: "nickname"
          },
          {
            title: "性别",
            key: "sex",
            render: (h, params) => {
              let text = "未知";
              let color = "default";
              params.row.sex === "1" && ((text = "男"), (color = "green"));
              params.row.sex === "2" && ((text = "女"), (color = "red"));
              return h("Tag", { props: { color: color } }, [text]);
            }
          },
          {
            title: "所在位置",
            key: "location",
            render: (h, params) => {
              return h(
                "div",
                `${params.row.country} ${params.row.province} ${
                  params.row.city
                }`
              );
            }
          },
          {
            title: "关注状态",
            key: "subscribe",
            render: (h, params) => {
              let text = "未关注";
              let color = "default";
              params.row.subscribe === "1" &&
                ((text = "已关注"), (color = "blue"));
              return h("Tag", { props: { color: color } }, [text]);
            }
          },
          {
            title: "最后关注时间",
            key: "subscribe_time"
          },
          {
            title: "渠道来源",
            key: "subscribe_scene",
            render: (h, params) => {
              let text = "";
              switch (params.row.subscribe_scene) {
                case "ADD_SCENE_SEARCH":
                  text = "公众号搜索";
                  break;
                case "ADD_SCENE_ACCOUNT_MIGRATION":
                  text = "公众号迁移";
                  break;
                case "ADD_SCENE_PROFILE_CARD":
                  text = "名片分享";
                  break;
                case "ADD_SCENE_QR_CODE":
                  text = "扫描二维码";
                  break;
                case "ADD_SCENEPROFILE_LINK":
                  text = "图文页内名称点击";
                  break;
                case "ADD_SCENE_PROFILE_ITEM":
                  text = "图文页右上角菜单";
                  break;
                case "ADD_SCENE_PAID":
                  text = "支付后关注";
                  break;
                case "ADD_SCENE_OTHERS":
                  text = "其他";
                  break;
                default:
                  text = "";
              }
              return h("div", text);
            }
          }
        ],
        data: []
      }
    };
  },

  created() {
    this.initTable();
  },
  methods: {
    loadPage(current = 1) {
      this.search.page = current;
      this.initTable();
    },
    initTable() {
      this.table.loading = true;
      fetchFollows(this.search)
        .then(response => {
          this.table.data = response.ret_msg.data;
          this.page.total = response.ret_msg.paginate.total;
          this.$nextTick(function() {
            this.table.loading = false;
          });
        })
        .catch(error => {
          this.table.loading = false;
        });
    }
  }
};
</script>

<style lang="less">
.avatar-wrapper {
  display: inline-block;
  width: 60px;
  height: auto;
  padding: 10px 0;
  img {
    display: block;
    max-width: 100%;
    height: auto;
  }
}
</style>