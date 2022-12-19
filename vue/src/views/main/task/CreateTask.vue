<template>
  <v-card>
    <v-card-title>
      <span>タスク 登録</span>
    </v-card-title>
    <v-card-text class="px-4">
      <v-card-subtitle>タスク情報</v-card-subtitle>
      <section>
        <ul>
          <li class="mb-3">
            <v-text-field label="タスク名" :value="newTaskName" @input="onCreateName" dense outlined color="primary"></v-text-field>
            <p v-if="newTaskNameError" class="error-text">{{newTaskNameError}}</p>
          </li>
          <li class="mb-3">
            <v-textarea label="詳細" :value="newTaskDetail" @input="onCreateDetail" dense outlined color="primary"></v-textarea>
            <p v-if="newTaskDetailError" class="error-text">{{newTaskDetailError}}</p>
          </li>
        </ul>
        <ul class="d-flex align-center mb-3">
          <li style="width:180px;">
            <v-text-field :value="startDate" @click="startDateDialog = true" @click:clear="onChangeStart" label="開始日" placeholder="指定なし" prepend-inner-icon="mdi-calendar" color="primary" readonly outlined dense clearable></v-text-field>
            <v-dialog :value="startDateDialog" @click:outside="startDateDialog = false">
              <v-date-picker :value="startDate" @change="onChangeStartDate" color="primary" locale="ja"></v-date-picker>
            </v-dialog>
          </li>
          <li>~</li>
          <li class="mr-3" style="width:180px;">
            <v-text-field :value="endDate" @click="endDateDialog = true" @click:clear="onChangeEnd" label="期限日" placeholder="指定なし" prepend-inner-icon="mdi-calendar" color="primary" readonly outlined dense clearable></v-text-field>
            <v-dialog :value="endDateDialog" @click:outside="endDateDialog = false">
              <v-date-picker :value="endDate" @change="onChangeEndDate" color="primary" locale="ja"></v-date-picker>
            </v-dialog>
          </li>
          <li class="mr-3" style="width:180px;">
            <v-text-field :value="scheduledTime" @input="onCreateScheduledTime" label="予定時間(hours)" placeholder="予定時間を入力" prepend-inner-icon="mdi-clock-time-nine-outline" outlined dense clearable color="primary"></v-text-field>
          </li>
          <li class="mr-3" style="width:180px;">
            <v-text-field :value="actualTime" @input="onCreateActualTime" label="実際の時間(hours)" placeholder="実際の時間を入力" prepend-inner-icon="mdi-clock-time-nine" outlined dense clearable color="primary"></v-text-field>
          </li>
        </ul>
      </section>
      <section>
        <ul class="d-flex mb-2">
          <li class="mr-3" style="width:180px;">
            <v-select :items="formCategories" :value="categoryId" @change="onChangeCategory" label="カテゴリー" item-value="category_id" item-text="category_name" prepend-inner-icon="mdi-shape" outlined dense color="primary"></v-select>
          </li>
          <li class="mr-3" style="width:180px;">
            <v-select :items="formTags" :value="tagId" @change="onChangeTag" label="タグ" item-value="tag_id" item-text="tag_name" prepend-inner-icon="mdi-tag" outlined dense color="primary"></v-select>
          </li>
          <li class="mr-3" style="width:180px;">
            <v-select :items="formUserData" :value="requestedId" @change="onChangeRequested" label="担当者" item-value="id" item-text="name" prepend-inner-icon="mdi-account" outlined dense color="primary"></v-select>
          </li>
          <li class="mr-3" style="width:180px;">
            <v-select :items="formUserData" :value="requesterId" @change="onChangeRequester" label="依頼者" item-value="id" item-text="name" prepend-inner-icon="mdi-account" outlined dense color="primary"></v-select>
          </li>
        </ul>
        <ul>
          <li class="d-flex align-center my-4">
            <p class="mr-2">状態&emsp;：</p>
            <v-radio-group :value="statusId" @change="onChangeStatus" color="primary" :column="false">
              <v-radio v-for="status in STATUS" :value="status.value" :label="status.label" :key="status.value"></v-radio>
            </v-radio-group>
          </li>
          <li class="d-flex align-center my-4">
            <p class="mr-2">優先度：</p>
            <v-radio-group :value="priorityId" @change="onChangePriority" color="primary" :column="false">
              <v-radio v-for="priority in PRIORITIES" :value="priority.value" :label="priority.label" :key="priority.value"></v-radio>
            </v-radio-group>
          </li>
        </ul>
      </section>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn :loading="isLoading" color="primary" @click="getTask()">
        <span>登録</span>
        <v-icon>mdi-send</v-icon>
      </v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
import { myAxios } from "@/plugins/axios";
import { STATUS } from "@/plugins/const";
import { PRIORITIES } from "@/plugins/const";
export default {
  data() {
    return {
      STATUS: STATUS,
      PRIORITIES: PRIORITIES,
      statusId: 0,
      priorityId: 0,
      startDateDialog: false,
      endDateDialog: false,
      startDate: "2022-12-12",
      endDate: "2022-12-12",
      isLoading: false,
      newTaskName: "",
      newTaskNameError: "",
      newTaskDetail: "",
      newTaskDetailError: "",
      scheduledTime: "12",
      actualTime: "12",
      categoryId: 0,
      tagId: 0,
      requestedId: 0,
      requesterId: 0,
    };
  },
//   テスト
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
    onChangePriority(id) {
      this.priorityId = id;
    },
    onChangeStatus(id) {
      this.statusId = id;
    },
    onCreateName(userName) {
      this.newTaskName = userName;
    },
    onCreateDetail(userDetail) {
      this.newTaskDetail = userDetail;
    },
    onChangeStartDate(startDate) {
      this.startDate = startDate;
      this.startDateDialog = false;
    },
    onChangeStart() {
      this.startDate = null;
      this.startDateDialog = false;
    },
    onChangeEndDate(endDate) {
      this.endDate = endDate;
      this.endDateDialog = false;
    },
    onChangeEnd() {
      this.endDate = null;
      this.endDateDialog = false;
    },
    onCreateScheduledTime(scheduledTime) {
      this.scheduledTime = scheduledTime;
    },
    onCreateActualTime(actualTime) {
      this.actualTime = actualTime;
    },
    onChangeCategory(id) {
      this.categoryId = id;
    },
    onChangeTag(id) {
      this.tagId = id;
    },
    onChangeRequested(id) {
      this.requestedId = id;
    },
    onChangeRequester(id) {
      this.requesterId = id;
    },
    async getTask() {
      let isError = false;
      this.newTaskNameError = "";
      this.newTaskDetailError = "";
      if (this.newTaskName === "") {
        isError = true;
        this.newTaskNameError = "入力してください";
      }
      if (this.newTaskDetail === "") {
        isError = true;
        this.newTaskDetailError = "入力してください";
      }
      if (isError) return;
      const requestConfig = {
        url: "/task",
        method: "POST",
        data: {
          name: this.newTaskName,
          detail: this.newTaskDetail,
          dateStart: this.startDate,
          dateEnd: this.endDate,
          predictedSeconds: this.scheduledTime,
          actualSeconds: this.actualTime,
          categoryId: this.categoryId,
          tagId: this.tagId,
          requestedUserId: this.requestedId,
          requesterUserId: this.requesterId,
          status: this.statusId,
          priority: this.priorityId,
        },
      };
      this.isLoading = true;
      myAxios(requestConfig)
        .then(() => {
          this.$router.push("/main/task");
        })
        .catch((err) => {
          this.newTaskEmailError = err?.response?.data?.errorMessage;
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
  },
  async mounted() {
    this.isLoading = true;
    await this.$store.dispatch("getUsers");
    this.$store.dispatch("getCategories");
    this.$store.dispatch("getTags");
    this.isLoading = false;
  },
};
</script>

<style>
</style>