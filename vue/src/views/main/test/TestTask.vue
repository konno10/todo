<template>
  <div>
    <h1>task API test page</h1>
    <hr>
    <section>
      <h2>/tasks ・ GET</h2>
      <pre>
      const requestConfig = {
        url: "/tasks",
        method: "GET",
        params: {
          keyword: 2, //キーワード
          dateStart: "2022-11-01", //タスクの開始日
          dateEnd: "2022-11-30", //タスクの終了日
          requestedUserId: 2, //担当者のユーザーID
          requesterUserId: 2, //依頼者のユーザーID
          categoryId: 2, //カテゴリーのID
          tagId: 2, //タグのID
          priority: 2, //優先度
          status: 2, //状態
          isPerfect: true, //trueなら日付期間の内側のみ
          page: 1, //ページ
        },
      };
      </pre>
      <v-btn @click="getTasks()">全てのタスク情報・取得</v-btn>
      <pre style="color:teal;">{{tasks}}</pre>
    </section>
    <hr>
    <section>
      <h2>/task ・ GET</h2>
      <pre>
      const requestConfig = {
        url: "/task",
        method: "GET",
        params: {
          id: 2, //タスクのID
        },
      };
      </pre>
      <v-btn @click="getTask()">特定のタスク情報・取得</v-btn>
      <pre style="color:teal;">{{task}}</pre>
    </section>
    <hr>
    <section>
      <h2>/task ・ POST</h2>
      <pre>
      const requestConfig = {
        url: "/task",
        method: "POST",
        data: {
          name: "新しいタスク", //タスクの名前
          detail: "新しいタスクの詳細新しいタスクの詳細新しいタスクの詳細", //タスクの詳細
          dateStart: "2022-11-1", //タスクの開始日
          dateEnd: "2022-11-3", //タスクの終了日
          categoryId: 1, //カテゴリーID
          tagId: 1, //タグID
          priority: 1, //優先度
          status: 1, //状態
          predictedSeconds: 7200, //予測時間（秒）
          actualSeconds: 3600, //稼働時間（秒）
          requesterUserId: 1, //依頼者のユーザーID
          requestedUserId: 2, //担当者のユーザーID
        },
      };
      </pre>
      <v-btn @click="postTask()">特定のタスク情報・作成</v-btn>
    </section>
    <hr>
    <section>
      <h2>/task ・ PUT</h2>
      <pre>
      const requestConfig = {
        url: "/task",
        method: "PUT",
        data: {
          id: 1,
          name: "更新されたタスク", //タスクの名前
          detail: "更新されたタスクの詳細更新されたタスクの詳細", //タスクの詳細
          dateStart: "2022-11-1", //タスクの開始日
          dateEnd: "2022-11-3", //タスクの終了日
          categoryId: 1, //カテゴリーID
          tagId: 1, //タグID
          priority: 1, //優先度
          status: 1, //状態
          predictedSeconds: 7200, //予測時間（秒）
          actualSeconds: 3600, //稼働時間（秒）
          requesterUserId: 1, //依頼者のユーザーID
          requestedUserId: 2, //担当者のユーザーID
        },
      };
      </pre>
      <v-btn @click="putTask()">特定のタスク情報・更新</v-btn>
    </section>
    <hr>
    <section>
      <h2>/task ・ DELETE</h2>
      <pre>
      const requestConfig = {
        url: "/task",
        method: "DELETE",
        data: {
          id: 4,
        },
      };
      </pre>
      <v-btn @click="deleteTask()">特定のタスク情報・削除</v-btn>
    </section>
    <hr>
  </div>
</template>
<script>
import { myAxios } from "@/plugins/axios";
export default {
  data() {
    return {
      tasks: [],
      task: {},
    };
  },
  methods: {
    // 全てのタスク情報・取得
    async getTasks() {
      const requestConfig = {
        url: "/tasks",
        method: "GET",
        params: {
          keyword: 2, //キーワード
          dateStart: "2022-11-01", //タスクの開始日
          dateEnd: "2022-11-30", //タスクの終了日
          requestedUserId: 2, //担当者のユーザーID
          requesterUserId: 2, //依頼者のユーザーID
          categoryId: 2, //カテゴリーのID
          tagId: 2, //タグのID
          priority: 2, //優先度
          status: 2, //状態
          isPerfect: true, //trueなら日付期間の内側のみ
          page: 1, //ページ
        },
      };
      myAxios(requestConfig)
        .then((res) => {
          this.tasks = res.data;
          alert("取得に成功しました");
        })
        .catch(() => {
          alert("取得に失敗しました");
        });
    },

    // 特定のタスク情報・取得
    async getTask() {
      const requestConfig = {
        url: "/task",
        method: "GET",
        params: {
          id: 2, //タスクのID
        },
      };
      myAxios(requestConfig)
        .then((res) => {
          this.task = res.data;
          alert("取得に成功しました");
        })
        .catch(() => {
          alert("取得に失敗しました");
        });
    },

    // 特定のタスク情報・作成
    async postTask() {
      const requestConfig = {
        url: "/task",
        method: "POST",
        data: {
          name: "新しいタスク", //タスクの名前
          detail: "新しいタスクの詳細新しいタスクの詳細新しいタスクの詳細", //タスクの詳細
          dateStart: "2022-11-1", //タスクの開始日
          dateEnd: "2022-11-3", //タスクの終了日
          categoryId: 1, //カテゴリーID
          tagId: 1, //タグID
          priority: 1, //優先度
          status: 1, //状態
          predictedSeconds: 7200, //予測時間（秒）
          actualSeconds: 3600, //稼働時間（秒）
          requesterUserId: 1, //依頼者のユーザーID
          requestedUserId: 2, //担当者のユーザーID
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

    // 特定のタスク情報・更新
    async putTask() {
      const requestConfig = {
        url: "/task",
        method: "PUT",
        data: {
          id: 1,
          name: "更新されたタスク", //タスクの名前
          detail: "更新されたタスクの詳細更新されたタスクの詳細", //タスクの詳細
          dateStart: "2022-11-1", //タスクの開始日
          dateEnd: "2022-11-3", //タスクの終了日
          categoryId: 1, //カテゴリーID
          tagId: 1, //タグID
          priority: 1, //優先度
          status: 1, //状態
          predictedSeconds: 7200, //予測時間（秒）
          actualSeconds: 3600, //稼働時間（秒）
          requesterUserId: 1, //依頼者のユーザーID
          requestedUserId: 2, //担当者のユーザーID
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

    // 特定のタスク情報・削除
    async deleteTask() {
      const requestConfig = {
        url: "/task",
        method: "DELETE",
        data: {
          id: 2, //タスクのID
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