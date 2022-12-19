<template>
  <v-card>
    <v-card-title>新しいカテゴリーを登録</v-card-title>
    <v-card-text>
      <section class="category_info">
        <v-card-subtitle>カテゴリー情報</v-card-subtitle>
        <ul>
          <li class="mb-3">
            <v-text-field label="カテゴリー名" :value="newCategoryName" @change="(text)=>{newCategoryName = text}" dense outlined color="primary"></v-text-field>
            <p v-if="newCategoryNameError" class="error-text">{{newCategoryNameError}}</p>
          </li>
          <li>
            <v-textarea label="詳細" :value="newCategoryDetail" @change="(text)=>{newCategoryDetail = text}" dense outlined color="primary"></v-textarea>
            <p v-if="newCategoryDetailError" class="error-text">{{newCategoryDetailError}}</p>
          </li>
        </ul>
      </section>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn :loading="isLoading" color="primary" @click="getCategory()">
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
      newCategoryName: "",
      newCategoryNameError: "",
      newCategoryDetail: "",
      newCategoryDetailError: "",
    };
  },
  methods: {
    async getCategory() {
      let isError = false;
      this.newCategoryNameError = "";
      this.newCategoryDetailError = "";
      if (this.newCategoryName === "") {
        isError = true;
        this.newCategoryNameError = "カテゴリー名を入力してください";
      }
      if (this.newCategoryDetail === "") {
        isError = true;
        this.newCategoryDetailError = "詳細を入力してください";
      }
      if (isError) return;
      const requestConfig = {
        url: "/category",
        method: "POST",
        data: {
          name: this.newCategoryName,
          detail: this.newCategoryDetail,
        },
      };
      this.isLoading = true;
      myAxios(requestConfig)
        .then(() => {
          this.$router.push("/main/category");
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