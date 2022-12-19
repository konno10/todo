<template>
  <v-card>
    <v-card-title>新しいタグを登録</v-card-title>
    <v-card-text>
      <section class="tag_info">
        <v-card-subtitle>タグ情報</v-card-subtitle>
        <ul>
          <li class="mb-3">
            <v-text-field label="タグ名" dense outlined color="primary" :value="newTagName" @input="onCreateName"></v-text-field>
            <p v-if="newTagNameError" class="error-text">{{newTagNameError}}</p>
          </li>
          <li>
            <v-textarea label="詳細" dense outlined color="primary" :value="newTagDetail" @input="onCreateDetail"></v-textarea>
            <p v-if="newTagDetailError" class="error-text">{{newTagDetailError}}</p>
          </li>
        </ul>
      </section>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn :loading="isLoading" color="primary" @click="getTag()">
        <span>登録</span>
        <v-icon>mdi-send</v-icon>
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import { myAxios } from "@/plugins/axios";
export default {
  data() {
    return {
      isLoading: false,
      newTagName: "",
      newTagNameError: "",
      newTagDetail: "",
      newTagDetailError: "",
    };
  },

  methods: {
    onCreateName(tagName) {
      this.newTagName = tagName;
    },
    onCreateDetail(tagDetail) {
      this.newTagDetail = tagDetail;
    },
    async getTag() {
      let isError = false;
      this.newTagNameError = "";
      this.newTagDetailError = "";
      if (this.newTagName === "") {
        isError = true;
        this.newTagNameError = "タグ名を入力してください";
      }
      if (this.newTagDetail === "") {
        isError = true;
        this.newTagDetailError = "詳細を入力してください";
      }
      if (isError) return;

      const requestConfig = {
        url: "/tag",
        method: "POST",
        data: {
          name: this.newTagName,
          detail: this.newTagDetail,
        },
      };
      this.isLoading = true;
      myAxios(requestConfig)
        .then(() => {
          this.$router.push("/main/tag");
        })
        .catch(() => {
          alert("失敗しました！");
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
  },
};
</script>
