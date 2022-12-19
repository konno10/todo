<template>
  <v-card>
    <v-card-title>編集（{{tag.tag_name}} ID:{{tag.tag_id}}）</v-card-title>
    <Loading v-if="isLoading" />
    <p v-else-if="tag === null">通信エラー</p>
    <v-card-text v-else>
      <section class="tag_info">
        <v-card-subtitle>タグ情報</v-card-subtitle>
        <ul>
          <li class="mb-3">
            <v-text-field label="カテゴリー名" :value="tag.tag_name" @input="onUpdateName" dense outlined color="primary"></v-text-field>
            <p v-if="newTagNameError" class="error-text">{{newTagNameError}}</p>
          </li>
          <li>
            <v-textarea label="詳細" :value="tag.tag_detail" @input="onUpdateDetail" dense outlined color="primary"></v-textarea>
            <p v-if="newTagDetailError" class="error-text">{{newTagDetailError}}</p>
          </li>
        </ul>
      </section>
    </v-card-text>
    <v-card-actions>
      <v-btn :disabled="isLoading" :loading="Loading" @click="deleltedTag()" color="error">
        <span>削除</span>
        <v-icon>mdi-delete</v-icon>
      </v-btn>
      <v-spacer></v-spacer>
      <v-btn :disabled="isLoading" :loading="Loading" @click="changeTag()" color="primary">
        <span>登録</span>
        <v-icon>mdi-send</v-icon>
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import Loading from "@/components/Loading.vue";
import { myAxios } from "@/plugins/axios";
export default {
  components: {
    Loading,
  },
  data() {
    return {
      tag: {},
      isLoading: false,
      Loading: false,
      newTagName: "",
      newTagNameError: "",
      newTagDetail: "",
      newTagDetailError: "",
    };
  },

  methods: {
    onUpdateName(tagName) {
      this.tag.tag_name = tagName;
    },
    onUpdateDetail(tagDetail) {
      this.tag.tag_detail = tagDetail;
    },
    async getTag() {
      this.isLoading = true;
      const requestConfig = {
        url: "/tag",
        method: "GET",
        params: {
          id: this.$route.query.tagId,
        },
      };
      myAxios(requestConfig)
        .then((res) => {
          this.tag = res.data;
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
    async deleltedTag() {
      if (!confirm("本当に削除しますか？")) return;
      const requestConfig = {
        url: "/tag",
        method: "DELETE",
        data: {
          id: this.$route.query.tagId,
        },
      };
      myAxios(requestConfig).then(() => {
        this.$router.push("/main/tag");
      });
    },
    async changeTag() {
      let isError = false;
      this.newTagNameError = "";
      this.newTagDetailError = "";
      if (this.tag.tag_name === "") {
        isError = true;
        this.newTagNameError = "入力してください";
      }
      if (this.tag.tag_detail === "") {
        isError = true;
        this.newTagDetailError = "入力してください";
      }
      if (isError) return;
      const requestConfig = {
        url: "/tag",
        method: "PUT",
        data: {
          id: this.$route.query.tagId,
          name: this.tag.tag_name,
          detail: this.tag.tag_detail,
        },
      };
      this.Loading = true;
      myAxios(requestConfig)
        .then(() => {
          this.$router.push("/main/tag");
        })
        .catch(() => {
          alert("失敗しました！");
        })
        .finally(() => {
          this.Loading = false;
        });
    },
  },
  mounted() {
    this.getTag();
  },
};
</script>

<style>
</style>