<template>
  <div>
    <h1>category API test page</h1>
    <hr>
    <section>
      <h2>/categories ・ GET</h2>
      <pre>
      const requestConfig = {
        url: "/categories",
        method: "GET",
      };
      <v-btn @click="getCategories()">全てのカテゴリー情報・取得</v-btn>
      </pre>
      <pre style="color:teal;">{{categories}}</pre>
    </section>
    <hr>
    <section>
      <h2>/category ・ GET</h2>
      <pre>
      const requestConfig = {
        url: "/category",
        method: "GET",
        params: {
          id: 2,
        },
      };
      </pre>
      <v-btn @click="getCategory()">特定のカテゴリー情報・取得</v-btn>
      <pre style="color:teal;">{{category}}</pre>
    </section>
    <hr>
    <section>
      <h2>/category ・ POST</h2>
      <pre>
      const requestConfig = {
        url: "/category",
        method: "POST",
        data: {
          name: "新しいカテゴリー",
          detail: "新しいカテゴリーの詳細新しいカテゴリーの詳細",
        },
      };
      </pre>
      <v-btn @click="postCategory()">特定のカテゴリー情報・作成</v-btn>
    </section>
    <hr>
    <section>
      <h2>/category ・ PUT</h2>
      <pre>
      const requestConfig = {
        url: "/category",
        method: "PUT",
        data: {
          id: 3,
          name: "更新されたカテゴリー",
          detail: "更新されたカテゴリーの詳細",
        },
      };
      </pre>
      <v-btn @click="putCategory()">特定のカテゴリー情報・更新</v-btn>
    </section>
    <hr>
    <section>
      <h2>/category ・ DELETE</h2>
      <pre>
      const requestConfig = {
        url: "/category",
        method: "DELETE",
        data: {
          id: 4,
        },
      };
      </pre>
      <v-btn @click="deleteCategory()">特定のカテゴリー情報・削除</v-btn>
    </section>
    <hr>
  </div>
</template>
<script>
import { myAxios } from "@/plugins/axios";
export default {
  data() {
    return {
      categories: [],
      category: {},
    };
  },
  methods: {
    // 全てのカテゴリー情報・取得
    async getCategories() {
      const requestConfig = {
        url: "/categories",
        method: "GET",
      };
      myAxios(requestConfig)
        .then((res) => {
          this.categories = res.data;
          alert("取得に成功しました");
        })
        .catch(() => {
          alert("取得に失敗しました");
        });
    },

    // 特定のカテゴリー情報・取得
    async getCategory() {
      const requestConfig = {
        url: "/category",
        method: "GET",
        params: {
          id: 2,
        },
      };
      myAxios(requestConfig)
        .then((res) => {
          this.category = res.data;
          alert("取得に成功しました");
        })
        .catch(() => {
          alert("取得に失敗しました");
        });
    },

    // 特定のカテゴリー情報・作成
    async postCategory() {
      const requestConfig = {
        url: "/category",
        method: "POST",
        data: {
          name: "新しいカテゴリー",
          detail: "新しいカテゴリーの詳細新しいカテゴリーの詳細",
        },
      };
      myAxios(requestConfig)
        .then(() => {
          alert("登録に成功しました");
        })
        .catch(() => {
          alert("登録に失敗しました");
        });
    },

    // 特定のカテゴリー情報・更新
    async putCategory() {
      const requestConfig = {
        url: "/category",
        method: "PUT",
        data: {
          id: 3,
          name: "更新されたカテゴリー",
          detail: "更新されたカテゴリーの詳細",
        },
      };
      myAxios(requestConfig)
        .then(() => {
          alert("更新に成功しました");
        })
        .catch(() => {
          alert("更新に失敗しました");
        });
    },

    // 特定のカテゴリー情報・削除
    async deleteCategory() {
      const requestConfig = {
        url: "/category",
        method: "DELETE",
        data: {
          id: 4,
        },
      };
      myAxios(requestConfig)
        .then(() => {
          alert("削除に成功しました");
        })
        .catch(() => {
          alert("削除に失敗しました");
        });
    },
  },
};
</script>

<style lang="scss" scoped>
hr {
  margin: 30px 0;
}
</style>