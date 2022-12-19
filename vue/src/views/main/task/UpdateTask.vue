<template>
  <v-card>
    <v-card-title>編集（{{task.task_name}} ID:{{task.task_id}}）</v-card-title>
    <Loading v-if="isLoading" />
    <p v-else-if="tag === null">通信エラー</p>
    <v-card-text class="px-4" v-else>
      <v-card-subtitle>タスク情報</v-card-subtitle>
      <section>
        <ul>
          <li class="mb-3">
            <v-text-field :value="task.task_name" @input="onUpdateName" label="タスク名" dense outlined color="primary"></v-text-field>
            <p v-if="updateTaskNameError" class="error-text">{{updateTaskNameError}}</p>
          </li>
          <li class="mb-3">
            <v-textarea :value="task.task_detail" @input="onUpdateDetail" label="詳細" dense outlined color="primary"></v-textarea>
            <p v-if="updateTaskDetailError" class="error-text">{{updateTaskDetailError}}</p>
          </li>
        </ul>
        <ul class="d-flex align-center mb-3">
          <li style="width:180px;">
            <v-text-field :value="task.task_date_start" @click="startDateDialog = true" @click:clear="onChangeStart" label="開始日" placeholder="指定なし" prepend-inner-icon="mdi-calendar" color="primary" readonly outlined dense clearable></v-text-field>
            <v-dialog :value="startDateDialog" @click:outside="startDateDialog = false">
              <v-date-picker :value="task.task_date_start" @change="onUpdateStartDate" color="primary" locale="ja"></v-date-picker>
            </v-dialog>
          </li>
          <li>~</li>
          <li class="mr-3" style="width:180px;">
            <v-text-field :value="task.task_date_end" @click="endDateDialog = true" @click:clear="onChangeEnd" label="期限日" placeholder="指定なし" prepend-inner-icon="mdi-calendar" color="primary" readonly outlined dense clearable></v-text-field>
            <v-dialog :value="endDateDialog" @click:outside="endDateDialog = false">
              <v-date-picker :value="task.task_date_end" @change="onUpdateEndDate" color="primary" locale="ja"></v-date-picker>
            </v-dialog>
          </li>
          <li class="mr-3" style="width:180px;">
            <v-text-field :value="task.task_predicted_hours" @input="onUpdateScheduledTime" label="予定時間(hours)" placeholder="予定時間を入力" prepend-inner-icon="mdi-clock-time-nine-outline" outlined dense clearable color="primary"></v-text-field>
          </li>
          <li class="mr-3" style="width:180px;">
            <v-text-field :value="task.task_actual_hours" @input="onUpdateActualTime" label="実際の時間(hours)" placeholder="実際の時間を入力" prepend-inner-icon="mdi-clock-time-nine" outlined dense clearable color="primary"></v-text-field>
          </li>
        </ul>
      </section>
      <section>
        <ul class="d-flex mb-2">
          <li class="mr-3" style="width:180px;">
            <v-select :items="formCategories" :value="task.task_category_id" @change="onUpdateCategory" label="カテゴリー" item-value="category_id" item-text="category_name" prepend-inner-icon="mdi-shape" outlined dense color="primary"></v-select>
          </li>
          <li class="mr-3" style="width:180px;">
            <v-select :value="task.task_tag_id" :items="formTags" @change="onUpdateTag" label="タグ" item-value="tag_id" item-text="tag_name" prepend-inner-icon="mdi-tag" outlined dense color="primary"></v-select>
          </li>
          <li class="mr-3" style="width:180px;">
            <v-select :value="task.task_requested_user_id" :items="formUserData" @change="onUpdateRequested" label="担当者" item-value="id" item-text="name" prepend-inner-icon="mdi-account" outlined dense color="primary"></v-select>
          </li>
          <li class="mr-3" style="width:180px;">
            <v-select :value="task.task_requester_user_id" :items="formUserData" @change="onUpdateRequester" label="依頼者" item-value="id" item-text="name" prepend-inner-icon="mdi-account" outlined dense color="primary"></v-select>
          </li>
        </ul>
        <ul>
          <li class="d-flex align-center my-4">
            <p class="mr-2">状態&emsp;：</p>
            <v-radio-group :value="task.task_status" @change="onUpdateStatus" color="primary" :column="false">
              <v-radio v-for="status in STATUS" :value="status.value" :label="status.label" :key="status.value"></v-radio>
            </v-radio-group>
          </li>
          <li class="d-flex align-center my-4">
            <p class="mr-2">優先度：</p>
            <v-radio-group :value="task.task_priority" @change="onUpdatePriority" color="primary" :column="false">
              <v-radio v-for="priority in PRIORITIES" :value="priority.value" :label="priority.label" :key="priority.value"></v-radio>
            </v-radio-group>
          </li>
        </ul>
      </section>
    </v-card-text>
    <v-card-actions>
      <v-btn :disabled="isLoading" :loading="Loading" @click="deleltedTask()" color="error">
        <span>削除</span>
        <v-icon>mdi-delete</v-icon>
      </v-btn>
      <v-spacer></v-spacer>
      <v-btn :disabled="isLoading" :loading="Loading" @click="changeTask()" color="primary">
        <span>登録</span>
        <v-icon>mdi-send</v-icon>
      </v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
import Loading from "@/components/Loading.vue";
import { myAxios } from "@/plugins/axios";
import { STATUS } from "@/plugins/const";
import { PRIORITIES } from "@/plugins/const";
export default {
  components: {
    Loading,
  },
  data() {
    return {
      task: {},
      STATUS: STATUS,
      PRIORITIES: PRIORITIES,
      startDateDialog: false,
      endDateDialog: false,
      updateTaskNameError: "",
      updateTaskDetailError: "",
      Loading: false,
      isLoading: false,
    };
  },
  computed: {
    formCategories() {
      return [
        {
          category_id: 0,
          category_name: "全て",
        },
      ].concat(this.$store.state.categories);
    },
    formTags() {
      return [
        {
          tag_id: 0,
          tag_name: "全て",
        },
      ].concat(this.$store.state.tags);
    },
    formUserData() {
      return [
        {
          id: 0,
          name: "全て",
        },
      ].concat(this.$store.state.users);
    },
  },
  methods: {
    onUpdatePriority(id) {
      this.task.task_priority = id;
    },
    onUpdateStatus(id) {
      this.task.task_status = id;
    },
    onUpdateName(taskName) {
      this.task.task_name = taskName;
    },
    onUpdateDetail(taskDetail) {
      this.task.task_detail = taskDetail;
    },
    onUpdateStartDate(startDate) {
      this.task.task_date_start = startDate;
      this.startDateDialog = false;
    },
    onChangeStart() {
      this.task.task_date_start = null;
      this.startDateDialog = false;
    },
    onUpdateEndDate(endDate) {
      this.task.task_date_end = endDate;
      this.endDateDialog = false;
    },
    onChangeEnd() {
      this.task.task_date_end = null;
      this.endDateDialog = false;
    },
    onUpdateScheduledTime(scheduledTime) {
      this.task.task_predicted_hours = scheduledTime;
    },
    onUpdateActualTime(actualTime) {
      this.task.task_actual_hours = actualTime;
    },
    onUpdateCategory(id) {
      this.task.task_category_id = id;
    },
    onUpdateTag(id) {
      this.task.task_tag_id = id;
    },
    onUpdateRequested(id) {
      this.task.task_requested_user_id = id;
    },
    onUpdateRequester(id) {
      this.task.task_requester_user_id = id;
    },
    async getTask() {
      const requestConfig = {
        url: "/task",
        method: "GET",
        params: {
          id: this.$route.query.taskId,
        },
      };
      myAxios(requestConfig)
        .then((res) => {
          this.task = res.data;
        })
        .finally(() => {});
    },
    async deleltedTask() {
      if (!confirm("本当に削除しますか？")) return;
      const requestConfig = {
        url: "/task",
        method: "DELETE",
        data: {
          id: this.$route.query.taskId,
        },
      };
      myAxios(requestConfig).then(() => {
        this.$router.push("/main/task");
      });
    },
    async changeTask() {
      let isError = false;
      this.updateTaskNameError = "";
      this.updateTaskDetailError = "";
      if (this.task.task_name === "") {
        isError = true;
        this.updateTaskNameError = "入力してください";
      }
      if (this.task.task_detail === "") {
        isError = true;
        this.updateTaskDetailError = "入力してください";
      }
      if (isError) return;
      const requestConfig = {
        url: "/task",
        method: "PUT",
        data: {
          id: this.$route.query.taskId,
          name: this.task.task_name,
          detail: this.task.task_detail,
          dateStart: this.task.task_date_start,
          dateEnd: this.task.task_date_end,
          predictedSeconds: this.task.task_predicted_hours,
          actualSeconds: this.task.task_actual_hours,
          categoryId: this.task.task_category_id,
          tagId: this.task.task_tag_id,
          requestedUserId: this.task.task_requested_user_id,
          requesterUserId: this.task.task_requester_user_id,
          status: this.task.task_status,
          priority: this.task.task_priority,
        },
      };
      this.Loading = true;
      myAxios(requestConfig)
        .then(() => {
          this.$router.push("/main/task");
        })
        .catch(() => {
          alert("失敗しました！");
        })
        .finally(() => {
          this.Loading = false;
        });
    },
  },
  async mounted() {
    this.isLoading = true;
    this.getTask();
    await this.$store.dispatch("getUsers");
    this.$store.dispatch("getCategories");
    this.$store.dispatch("getTags");
    this.isLoading = false;
  },
};
</script>