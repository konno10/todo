<template>
  <div>
    <h1>tag API test page</h1>
    <hr>
    <section>
      <h2>/tags ・ GET</h2>
      <pre>
      const requestConfig = {
        url: "/tags",
        method: "GET",
      };
      </pre>
      <v-btn @click="getTags()">全てのタグ情報・取得</v-btn>
      <pre style="color:teal;">{{tags}}</pre>
    </section>
    <hr>
    <section>
      <h2>/tag ・ GET</h2>
      <pre>
      const requestConfig = {
        url: "/tag",
        method: "GET",
        params: {
          id: 2,
        },
      };
      </pre>
      <v-btn @click="getCategory()">特定のタグ情報・取得</v-btn>
      <pre style="color:teal;">{{tag}}</pre>
    </section>
    <hr>
    <section>
      <h2>/tag ・ POST</h2>
      <pre>
      const requestConfig = {
        url: "/tag",
        method: "POST",
        data: {
          name: "新しいタグ",
          detail: "新しいタグの詳細新しいタグの詳細",
        },
      };
      </pre>
      <v-btn @click="postCategory()">特定のタグ情報・作成</v-btn>
    </section>
    <hr>
    <section>
      <h2>/tag ・ PUT</h2>
      <pre>
      const requestConfig = {
        url: "/tag",
        method: "PUT",
        data: {
          id: 3,
          name: "更新されたタグ",
          detail: "更新されたタグの詳細",
        },
      };
      </pre>
      <v-btn @click="putCategory()">特定のタグ情報・更新</v-btn>
    </section>
    <hr>
    <section>
      <h2>/tag ・ DELETE</h2>
      <pre>
      const requestConfig = {
        url: "/tag",
        method: "DELETE",
        data: {
          id: 4,
        },
      };
      </pre>
      <v-btn @click="deleteCategory()">特定のタグ情報・削除</v-btn>
    </section>
    <hr>
  </div>
</template>
<script>
import { myAxios } from "@/plugins/axios";
export default {
  data() {
    return {
      tags: [],
      tag: {},
    };
  },
  methods: {
    // 全てのタグ情報・取得
    async getTags() {
      const requestConfig = {
        url: "/tags",
        method: "GET",
      };
      myAxios(requestConfig)
        .then((res) => {
          this.tags = res.data;
          alert("取得に成功しました");
        })
        .catch(() => {
          alert("取得に失敗しました");
        });
    },

    // 特定のタグ情報・取得
    async getCategory() {
      const requestConfig = {
        url: "/tag",
        method: "GET",
        params: {
          id: 2,
        },
      };
      myAxios(requestConfig)
        .then((res) => {
          this.tag = res.data;
          alert("取得に成功しました");
        })
        .catch(() => {
          alert("取得に失敗しました");
        });
    },

    // 特定のタグ情報・作成
    async postCategory() {
      const requestConfig = {
        url: "/tag",
        method: "POST",
        data: {
          name: "新しいタグ",
          detail: "新しいタグの詳細新しいタグの詳細",
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

    // 特定のタグ情報・更新
    async putCategory() {
      const requestConfig = {
        url: "/tag",
        method: "PUT",
        data: {
          id: 3,
          name: "更新されたタグ",
          detail: "更新されたタグの詳細",
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

    // 特定のタグ情報・削除
    async deleteCategory() {
      const requestConfig = {
        url: "/tag",
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