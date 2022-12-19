<template>
  <v-card>
    <v-card-title>
      <span>タスク 一覧</span>
      <v-spacer></v-spacer>
      <v-btn router to="/main/task/create" height="35px" width="35px" fab>
        <v-icon color="primary">mdi-plus</v-icon>
      </v-btn>
    </v-card-title>
    <v-card-text class="pa-0">
      <div class="px-4 pt-4">
        <section>
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
              <v-text-field :value="keyword" @input="onChangeKeyword" label="タスク名" placeholder="タスク名を入力" prepend-inner-icon="mdi-magnify" validate-on-blur required outlined dense color="primary"></v-text-field>
            </li>
          </ul>
        </section>
        <section>
          <ul class="d-flex mb-2">
            <li class="mr-3" style="width:180px;">
              <v-select :items="formCategories" :value="categoryId" @change="onChangeCategory" label="カテゴリー" item-value="category_id" item-text="category_name" prepend-inner-icon="mdi-shape" outlined dense color="primary">
              </v-select>
            </li>
            <li class="mr-3" style="width:180px;">
              <v-select :items="formTags" :value="tagId" @change="onChangeTag" label="タグ" item-value="tag_id" item-text="tag_name" prepend-inner-icon="mdi-tag" outlined dense color="primary">
              </v-select>
            </li>
            <li class="mr-3" style="width:180px;">
              <v-select :items="formUserData" :value="requestedId" @change="onChangeRequested" label="担当者" item-value="id" item-text="name" prepend-inner-icon="mdi-account" outlined dense color="primary">
              </v-select>
            </li>
            <li class="mr-3" style="width:180px;">
              <v-select :items="formUserData" :value="requesterId" @change="onChangeRequester" label="依頼者" item-value="id" item-text="name" prepend-inner-icon="mdi-account" outlined dense color="primary"></v-select>
            </li>
          </ul>
          <ul>
            <li class="d-flex align-center my-4">
              <p class="mr-2">状態&emsp;：</p>
              <v-radio-group :value="statusId" @change="onChangeStatus" color="primary" :column="false">
                <v-radio v-for="status in STATUS" :value="status.value" :label="status.label" :key="status.value" :class="status.class"></v-radio>
              </v-radio-group>
            </li>
            <li class="d-flex align-center my-4">
              <p class="mr-2">優先度：</p>
              <v-radio-group :value="priorityId" @change="onChangePriority" color="primary" :column="false">
                <v-radio v-for="priority in PRIORITIES" :value="priority.value" :label="priority.label" :key="priority.value" :class="priority.class"></v-radio>
              </v-radio-group>
            </li>
          </ul>
        </section>
      </div>
      <div class="task_list">
        <div class="d-flex align-end pb-2 px-4">
          <p style="wirth:250px;">全 {{taskData.paginate.total}} 件中 {{taskData.paginate.firstItem}} 件 〜 {{taskData.paginate.lastItem}} 件を表示</p>
          <div style="width:calc(100% - 250px);padding:0 100px 0 150px;">
            <v-pagination :value="taskData.paginate.currentPage" @input="onClickPaginate" :length="taskData.paginate.lastPage" color="primary" dense></v-pagination>
          </div>
        </div>
        <v-divider></v-divider>
        <TaskList :tasks="taskData.tasks" />
        <Loading v-if="isLoading" />
        <p v-else-if="taskData.tasks === null">通信エラー</p>
        <p v-else-if="!taskData.tasks">データはありません</p>
      </div>
    </v-card-text>
  </v-card>
</template>

<script>
import Loading from "@/components/Loading.vue";
import TaskList from "@/components/TaskList.vue";
import { myAxios } from "@/plugins/axios";
import { PRIORITIES } from "@/plugins/const";
import { STATUS } from "@/plugins/const";
export default {
  components: {
    TaskList,
    Loading,
  },
  data() {
    return {
      PRIORITIES: PRIORITIES,
      STATUS: STATUS,
      currentPage: 1,
      priorityId: 0,
      statusId: 0,
      categoryId: 0,
      tagId: 0,
      requestedId: 0,
      requesterId: 0,
      startDateDialog: false,
      endDateDialog: false,
      startDate: "",
      endDate: "",
      keyword: "",
      taskData: {
        tasks: [],
        paginate: {},
      },
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
    onClickPaginate(page) {
      this.currentPage = page;
      this.getTasks();
    },
    onChangePriority(id) {
      this.priorityId = id;
      this.getTasks();
    },
    onChangeStatus(id) {
      this.statusId = id;
      this.getTasks();
    },
    onChangeCategory(id) {
      this.categoryId = id;
      this.getTasks();
    },
    onChangeTag(id) {
      this.tagId = id;
      this.getTasks();
    },
    onChangeRequested(id) {
      this.requestedId = id;
      this.getTasks();
    },
    onChangeRequester(id) {
      this.requesterId = id;
      this.getTasks();
    },
    onChangeStartDate(id) {
      this.startDate = id;
      this.startDateDialog = false;
      this.getTasks();
    },
    onChangeStart() {
      this.startDate = null;
      this.startDateDialog = false;
    },
    onChangeEndDate(id) {
      this.endDate = id;
      this.endDateDialog = false;
      this.getTasks();
    },
    onChangeEnd() {
      this.endDate = null;
      this.endDateDialog = false;
    },
    onChangeKeyword(id) {
      this.keyword = id;
      this.getTasks();
    },
    async getTasks() {
      const requestConfig = {
        url: "/tasks",
        method: "GET",
        params: {
          page: this.currentPage,
          priority: this.priorityId,
          status: this.statusId,
          categoryId: this.categoryId,
          tagId: this.tagId,
          requestedUserId: this.requestedId,
          requesterUserId: this.requesterId,
          dateStart: this.startDate,
          dateEnd: this.endDate,
          isPerfect: true,
          keyword: this.keyword,
        },
      };
      myAxios(requestConfig).then((res) => {
        this.currentPage = 1;
        this.taskData = res.data;
      });
    },
  },
  async mounted() {
    this.isLoading = true;
    this.getTasks();
    await this.$store.dispatch("getUsers");
    this.$store.dispatch("getCategories");
    this.$store.dispatch("getTags");
    this.isLoading = false;
  },
};
</script>

<style lang="scss" scoped>
::v-deep {
  .v-input--radio-group__input .red--text {
    .theme--light.v-label {
      color: red;
    }
  }
  .v-input--radio-group__input .orange--text {
    .theme--light.v-label {
      color: orange;
    }
  }
  .v-input--radio-group__input .light-green--text {
    .theme--light.v-label {
      color: yellowgreen;
    }
  }
  .v-input--radio-group__input .green--text {
    .theme--light.v-label {
      color: green;
    }
  }
  .v-input--radio-group__input .blue--text {
    .theme--light.v-label {
      color: blue;
    }
  }
  .v-input--radio-group__input .amber--text {
    .theme--light.v-label {
      color: #ffc107;
    }
  }
}
</style>