<template>
  <div :class="{'is-sp':$vuetify.breakpoint.xs}">
    <v-card>
      <v-card-title>詳細（{{user.name}} ID:{{user.id}}）</v-card-title>
      <Loading v-if="isLoading" />
      <p v-else-if="user === null">通信エラー</p>
      <v-card-text v-else>
        <section class="user_info">
          <v-card-subtitle>ユーザー情報</v-card-subtitle>
          <ul>
            <li class="mb-5 mr-3">
              <v-avatar size="40px">
                <v-img :src="user.img"></v-img>
              </v-avatar>
            </li>
            <li>
              <v-text-field label="名前" :value="user.name" prepend-inner-icon="mdi-account" dense readonly outlined color="primary" class="mr-2"></v-text-field>
            </li>
            <li>
              <v-text-field label="メールアドレス" :value="user.email" prepend-inner-icon="mdi-email" dense readonly outlined color="primary" class="mr-2"></v-text-field>
            </li>
          </ul>
        </section>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn :disabled="isLoading" @click="$router.push(`/main/user/update?userId=${user.id}`)" color="orange" class="orange white--text">
            <span>編集</span>
            <v-icon>mdi-pencil</v-icon>
          </v-btn>
        </v-card-actions>
        <section>
          <v-card-subtitle>タスク情報（{{user.name}} ID:{{user.id}}）</v-card-subtitle>
          <v-card outlined style="border:1px solid rgba(0, 0, 0, 0.3);">
            <TaskList :tasks="tasks" />
            <div>
              <v-divider></v-divider>
              <div class="d-flex justify-center">
                <v-btn v-if="addTaskShow" @click="addTaskRead" text color="primary" class="my-2">続きを読み込む</v-btn>
                <v-btn v-if="closeTaskShow" @click="closeTaskRead" text color="primary" class="my-2">閉じる</v-btn>
              </div>
            </div>
          </v-card>
        </section>
      </v-card-text>
    </v-card>
  </div>
</template>
<script>
import Loading from "@/components/Loading.vue";
import { myAxios } from "@/plugins/axios";
import TaskList from "@/components/TaskList.vue";
export default {
  components: {
    Loading,
    TaskList,
  },
  data() {
    return {
      user: {},
      isLoading: false,
      tasks: [],
      paginate: { currentPage: 1 },
      addTaskShow: true,
      closeTaskShow: false,
    };
  },
  methods: {
    async getUser() {
      this.isLoading = true;
      const requestConfig = {
        url: "/user",
        method: "GET",
        params: {
          id: this.$route.query.userId,
        },
      };
      myAxios(requestConfig)
        .then((res) => {
          this.user = res.data;
          this.getTasks();
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
    async getTasks() {
      this.isLoading = true;
      const requestConfig = {
        url: "/tasks",
        method: "GET",
        params: {
          page: 1,
          requestedUserId: this.user.id,
        },
      };
      myAxios(requestConfig)
        .then((res) => {
          this.paginate = res.data.paginate;
          this.tasks = res.data.tasks;
          if (this.paginate.currentPage === this.paginate.lastPage) {
            this.addTaskShow = false;
          }
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
    async addTaskRead() {
      this.isLoading = true;
      const requestConfig = {
        url: "/tasks",
        method: "GET",
        params: {
          page: this.paginate.currentPage + 1,
          requestedUserId: this.user.id,
        },
      };
      myAxios(requestConfig)
        .then((res) => {
          this.paginate = res.data.paginate;
          this.tasks = this.tasks.concat(res.data.tasks);
          if (this.paginate.currentPage === this.paginate.lastPage) {
            this.addTaskShow = false;
            this.closeTaskShow = true;
          }
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
    closeTaskRead() {
      this.paginate.currentPage = 1;
      this.tasks.splice(20, this.paginate.total - 20);
      this.addTaskShow = true;
      this.closeTaskShow = false;
    },
  },
  mounted() {
    this.getUser();
  },
};
</script>

<style lang="scss" scoped>
.user_info {
  ul {
    display: flex;
    li {
      display: flex;
    }
  }
}
.is-sp {
  .user_info {
    ul {
      display: block;
      li {
        justify-content: center;
      }
    }
  }
}
.v-card__subtitle {
  padding: 5px 10px 16px;
}
</style>