<template>
  <v-card>
    <v-card-title>詳細（{{tag.tag_name}} ID:{{tag.tag_id}}）</v-card-title>
    <Loading v-if="isLoading" />
    <p v-else-if="tag === null">通信エラー</p>
    <v-card-text v-else>
      <section>
        <v-card-subtitle>タグ情報</v-card-subtitle>
        <ul>
          <li class="mb-3">
            <v-text-field label="タグ名" dense readonly outlined color="primary" :value="tag.tag_name"></v-text-field>
          </li>
          <li>
            <v-textarea label="詳細" dense readonly outlined color="primary" :value="tag.tag_detail"></v-textarea>
          </li>
        </ul>
      </section>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn :disabled="isLoading" @click="$router.push(`/main/tag/update?tagId=${tag.tag_id}`)" class="orange white--text">
          <span>編集</span>
          <v-icon>mdi-pencil</v-icon>
        </v-btn>
      </v-card-actions>
      <section>
        <v-card-subtitle>タスク情報（{{tag.tag_name}} ID:{{tag.tag_id}}）</v-card-subtitle>
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
      tag: {},
      isLoading: false,
      tasks: [],
      paginate: { currentPage: 1 },
      addTaskShow: true,
      closeTaskShow: false,
    };
  },
  methods: {
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
          tagId: this.tag.tag_id,
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
          tagId: this.tag.tag_id,
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
    this.getTag();
  },
};
</script>

<style lang="scss" scoped>
.v-card__subtitle {
  padding: 5px 10px 16px;
}
</style>