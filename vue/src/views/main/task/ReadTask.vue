<template>
  <v-card>
    <v-card-title>詳細（{{task.task_name}} ID:{{task.task_id}}）</v-card-title>
    <Loading v-if="isLoading" />
    <p v-else-if="tag === null">通信エラー</p>
    <v-card-text class="px-4" v-else>
      <v-card-subtitle>タスク情報</v-card-subtitle>
      <section>
        <ul>
          <li class="mb-3">
            <v-text-field :value="task.task_name" label="タスク名" dense outlined color="primary" readonly></v-text-field>
          </li>
          <li class="mb-3">
            <v-textarea :value="task.task_detail" label="詳細" dense outlined color="primary" readonly></v-textarea>
          </li>
        </ul>
        <ul class="d-flex align-center mb-3">
          <li style="width:180px;">
            <v-text-field :value="task.task_date_start" label="開始日" prepend-inner-icon="mdi-calendar" color="primary" readonly outlined dense></v-text-field>
          </li>
          <li>~</li>
          <li style="width:180px; margin-right:13px;">
            <v-text-field :value="task.task_date_end" label="期限日" prepend-inner-icon="mdi-calendar" color="primary" readonly outlined dense></v-text-field>
          </li>
          <li class="mr-3" style="width:180px;">
            <v-text-field :value="task.task_predicted_hours" label="予定時間(hours)" prepend-inner-icon="mdi-clock-time-nine-outline" readonly outlined dense color="primary"></v-text-field>
          </li>
          <li class="mr-3" style="width:180px;">
            <v-text-field :value="task.task_actual_hours" label="実際の時間(hours)" prepend-inner-icon="mdi-clock-time-nine" readonly outlined dense color="primary"></v-text-field>
          </li>
        </ul>
      </section>
      <section>
        <ul class="d-flex mb-2">
          <li class="mr-3" style="width:180px;">
            <v-select :value="task.task_category_id" :items="formCategories" label="カテゴリー" item-value="category_id" item-text="category_name" prepend-inner-icon="mdi-shape" outlined dense color="primary" readonly></v-select>
          </li>
          <li class="mr-3" style="width:180px;">
            <v-select :value="task.task_tag_id" :items="formTags" label="タグ" item-value="tag_id" item-text="tag_name" prepend-inner-icon="mdi-tag" outlined dense color="primary" readonly></v-select>
          </li>
          <li class="mr-3" style="width:180px;">
            <v-select :value="task.task_requested_user_id" :items="formUserData" label="担当者" item-value="id" item-text="name" prepend-inner-icon="mdi-account" outlined dense color="primary" readonly></v-select>
          </li>
          <li class="mr-3" style="width:180px;">
            <v-select :value="task.task_requester_user_id" :items="formUserData" label="依頼者" item-value="id" item-text="name" prepend-inner-icon="mdi-account" outlined dense color="primary" readonly></v-select>
          </li>
        </ul>
        <ul>
          <li class="d-flex align-center my-4">
            <p class="mr-2">状態&emsp;：</p>
            <v-radio-group :value="task.task_status" color="primary" :column="false" readonly>
              <v-radio v-for="status in STATUS" :value="status.value" :label="status.label" :key="status.value"></v-radio>
            </v-radio-group>
          </li>
          <li class="d-flex align-center my-4">
            <p class="mr-2">優先度：</p>
            <v-radio-group :value="task.task_priority" color="primary" :column="false" readonly>
              <v-radio v-for="priority in PRIORITIES" :value="priority.value" :label="priority.label" :key="priority.value"></v-radio>
            </v-radio-group>
          </li>
        </ul>
      </section>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn :disabled="isLoading" @click="$router.push(`/main/task/update?taskId=${task.task_id}`)" class="orange white--text">
        <span>編集</span>
        <v-icon>mdi-pencil</v-icon>
      </v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
import Loading from "@/components/Loading.vue";
import { myAxios } from "@/plugins/axios";
import { PRIORITIES } from "@/plugins/const";
import { STATUS } from "@/plugins/const";
export default {
  components: {
    Loading,
  },
  data() {
    return {
      task: {},
      isLoading: false,
      startDate: "",
      endDate: "",
      PRIORITIES: PRIORITIES,
      STATUS: STATUS,
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
    async getTask() {
      this.isLoading = true;
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
        .finally(() => {
          this.isLoading = false;
        });
    },
  },
  async mounted() {
    this.isLoading = true;
    this.getTask();
    await this.$store.dispatch("getCategories");
    this.$store.dispatch("getTags");
    this.$store.dispatch("getUsers");
    this.isLoading = false;
  },
};
</script>