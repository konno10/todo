<template>
  <v-card>
    <v-card-title>編集（{{category.category_name}} ID:{{category.category_id}}）</v-card-title>
    <Loading v-if="isLoading" />
    <p v-else-if="category === null">通信エラー</p>
    <v-card-text v-else>
      <section class="category_info">
        <v-card-subtitle>カテゴリー情報</v-card-subtitle>
        <ul>
          <li class="mb-3">
            <v-text-field label="カテゴリー名" :value="category.category_name" @input="onUpdateName" dense outlined color="primary"></v-text-field>
            <p v-if="newCategoryNameError" class="error-text">{{newCategoryNameError}}</p>
          </li>
          <li>
            <v-textarea label="詳細" :value="category.category_detail" @input="onUpdateDetail" dense outlined color="primary"></v-textarea>
            <p v-if="newCategoryDetailError" class="error-text">{{newCategoryDetailError}}</p>
          </li>
        </ul>
      </section>
    </v-card-text>
    <v-card-actions>
      <v-btn :disabled="isLoading" :loading="Loading" @click="delelteCategory()" color="error">
        <span>削除</span>
        <v-icon>mdi-delete</v-icon>
      </v-btn>
      <v-spacer></v-spacer>
      <v-btn :disabled="isLoading" :loading="Loading" @click="changeCategory()" color="primary">
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
      category: {},
      isLoading: false,
      Loading: false,
      newCategoryName: "",
      newCategoryNameError: "",
      newCategoryDetail: "",
      newCategoryDetailError: "",
    };
  },

  methods: {
    onUpdateName(categoryName) {
      this.category.category_name = categoryName;
    },
    onUpdateDetail(categoryDetail) {
      this.category.category_detail = categoryDetail;
    },
    async getCategory() {
      this.isLoading = true;
      const requestConfig = {
        url: "/category",
        method: "GET",
        params: {
          id: this.$route.query.categoryId,
        },
      };
      myAxios(requestConfig)
        .then((res) => {
          this.category = res.data;
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
    async delelteCategory() {
      if (!confirm("本当に削除しますか？")) return;
      const requestConfig = {
        url: "/category",
        method: "DELETE",
        data: {
          id: this.$route.query.categoryId,
        },
      };
      myAxios(requestConfig).then(() => {
        this.$router.push("/main/category");
      });
    },
    async changeCategory() {
      let isError = false;
      this.newCategoryNameError = "";
      this.newCategoryDetailError = "";
      if (this.category.category_name === "") {
        isError = true;
        this.newCategoryNameError = "入力してください";
      }
      if (this.category.category_detail === "") {
        isError = true;
        this.newCategoryDetailError = "入力してください";
      }
      if (isError) return;
      const requestConfig = {
        url: "/category",
        method: "PUT",
        data: {
          id: this.$route.query.categoryId,
          name: this.category.category_name,
          detail: this.category.category_detail,
        },
      };
      this.Loading = true;
      myAxios(requestConfig)
        .then(() => {
          this.$router.push("/main/category");
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
    this.getCategory();
  },
};
</script>

<style>
</style>