<template>
  <div>
    <h1>user API test page</h1>
    <hr>
    <section>
      <h2>/users ・ GET</h2>
      <pre>
      const requestConfig = {
        url: "/users",
        method: "GET",
      };
      </pre>
      <v-btn @click="getUsers()">全てのユーザー情報・取得</v-btn>
      <pre style="color:teal;">{{users}}</pre>
    </section>
    <hr>
    <section>
      <h2>/user ・ GET</h2>
      <pre>
      const requestConfig = {
        url: "/user",
        method: "GET",
        params: {
          id: 2,
        },
      };
      </pre>
      <v-btn @click="getUser()">特定のユーザー情報・取得</v-btn>
      <pre style="color:teal;">{{user}}</pre>
    </section>
    <hr>
    <section>
      <h2>/user ・ POST</h2>
      <pre>
      const requestConfig = {
        url: "/user",
        method: "POST",
        data: {
          name: "新しいユーザー",
          email: "newemail@gmail.com",
          password: "password",
          img: "https://picsum.photos/500/300?image=3",
        },
      };
      </pre>
      <v-btn @click="postUser()">特定のユーザー情報・作成</v-btn>
    </section>
    <hr>
    <section>
      <h2>/user ・ PUT</h2>
      <pre>
      const requestConfig = {
        url: "/user",
        method: "PUT",
        data: {
          id: 5,
          name: "更新されたユーザー",
          email: "updateemail@gmail.com",
          password: "password",
          img: "https://picsum.photos/500/300?image=30",
        },
      };
      </pre>
      <v-btn @click="putUser()">特定のユーザー情報・更新</v-btn>
    </section>
    <hr>
    <section>
      <h2>/user ・ DELETE</h2>
      <pre>
      const requestConfig = {
        url: "/user",
        method: "DELETE",
        data: {
          id: 6,
        },
      };
      </pre>
      <v-btn @click="deleteUser()">特定のユーザー情報・削除</v-btn>
    </section>
    <hr>
  </div>
</template>
<script>
import { myAxios } from "@/plugins/axios";
export default {
  data() {
    return {
      users: [],
      user: {},
    };
  },
  methods: {
    // 全てのユーザー情報・取得
    async getUsers() {
      const requestConfig = {
        url: "/users",
        method: "GET",
      };
      myAxios(requestConfig)
        .then((res) => {
          this.users = res.data;
          alert("取得に成功しました");
        })
        .catch(() => {
          alert("取得に失敗しました");
        });
    },

    // 特定のユーザー情報・取得
    async getUser() {
      const requestConfig = {
        url: "/user",
        method: "GET",
        params: {
          id: 2,
        },
      };
      myAxios(requestConfig)
        .then((res) => {
          this.user = res.data;
          alert("取得に成功しました");
        })
        .catch(() => {
          alert("取得に失敗しました");
        });
    },

    // 特定のユーザー情報・作成
    async postUser() {
      const requestConfig = {
        url: "/user",
        method: "POST",
        data: {
          name: "新しいユーザー",
          email: "newemail@gmail.com",
          password: "password",
          img: "https://picsum.photos/500/300?image=3",
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

    // 特定のユーザー情報・更新
    async putUser() {
      const requestConfig = {
        url: "/user",
        method: "PUT",
        data: {
          id: 5,
          name: "更新されたユーザー",
          email: "updateemail@gmail.com",
          password: "password",
          img: "https://picsum.photos/500/300?image=30",
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

    // 特定のユーザー情報・削除
    async deleteUser() {
      const requestConfig = {
        url: "/user",
        method: "DELETE",
        data: {
          id: 6,
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