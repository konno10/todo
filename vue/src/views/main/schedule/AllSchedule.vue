<template>
  <div class="calendar">
    <!-- カレンダー -->
    <v-card>
      <v-card-title>スケジュール</v-card-title>
      <v-card-text class="pa-0">
        <Loading v-if="isLoading" />
        <p v-else-if="taskData.tasks === null">通信エラー</p>
        <p v-else-if="!taskData.tasks.length">データはありません</p>
        <div class="px-4 pt-4" v-else>
          <section>
            <ul class="mb-3">
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
                <v-radio-group :value="statusId" @change="onChangeStatus" :column="false">
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
          <v-card-title class="pagenation">
            <v-spacer></v-spacer>
            <div class="d-flex">
              <v-btn icon @click="previousMonth()">
                <v-icon color="black">mdi-chevron-left</v-icon>
              </v-btn>
              <h1>{{year}}年 {{month}}月</h1>
              <v-btn icon @click="nextMonth()">
                <v-icon color="black">mdi-chevron-right</v-icon>
              </v-btn>
            </div>
            <v-spacer></v-spacer>
          </v-card-title>
          <v-divider></v-divider>
          <v-simple-table class="schedule">
            <thead>
              <tr>
                <th>タスク名</th>
                <th>担当者</th>
                <th>
                  <ul>
                    <li v-for="day in EOM" :key="day" style="text-align:center;">
                      <div style="font-size:10px;">
                        {{day}}<br>
                        <span style="font-size:5px;">({{DOW[day - 1]}})</span>
                      </div>
                    </li>
                  </ul>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr @click="$router.push(`/main/task/read?taskId=${task.task_id}`)" v-ripple v-for="(task,index) in taskData.tasks" :key="index">
                <td>{{task.task_name}}</td>
                <td>
                  <v-avatar size="30px" class="mr-1">
                    <v-img :src="task.requestedUser.img"></v-img>
                  </v-avatar>
                  <span>{{task.requestedUser.name}}</span>
                </td>
                <td>
                  <ul>
                    <li v-for="day in EOM" :key="day" :class="{'color-blue': isBlue(day,task.task_date_start,task.task_date_end)}">
                      {{day}}
                    </li>
                  </ul>
                </td>
              </tr>
            </tbody>
          </v-simple-table>
        </div>
      </v-card-text>
    </v-card>
  </div>
</template>
<script>
import Loading from "@/components/Loading.vue";
import { myAxios } from "@/plugins/axios";
import { PRIORITIES } from "@/plugins/const";
import { STATUS } from "@/plugins/const";
import dayjs from "dayjs";
import ja from "dayjs/locale/ja";
dayjs.locale(ja);
export default {
  components: {
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
      targetMonth: "2022-12",
      keyword: "",
      taskData: {
        tasks: [],
        paginate: {},
      },
      isLoading: false,
    };
  },
  computed: {
    year() {
      return dayjs(this.targetMonth).format("YYYY");
    },
    month() {
      return dayjs(this.targetMonth).format("MM");
    },
    startDate() {
      return dayjs(this.targetMonth).startOf("month").format("YYYY-MM-DD");
    },
    endDate() {
      return dayjs(this.targetMonth).endOf("month").format("YYYY-MM-DD");
    },
    EOM() {
      return Number(dayjs(this.endDate).format("D"));
    },
    DOW() {
      const returnData = [];
      for (let i = 0; i < this.EOM; i++) {
        returnData.push(dayjs(this.startDate).add(i, "d").format("ddd"));
      }
      return returnData;
    },
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
    onChangeKeyword(id) {
      this.keyword = id;
      this.getTasks();
    },
    isBlue(day, start, end) {
      return dayjs(start).format("D") <= day && dayjs(end).format("D") >= day;
    },
    previousMonth() {
      this.targetMonth = dayjs(this.targetMonth)
        .subtract(1, "month")
        .format("YYYY-MM");
      this.getTasks();
      this.DOW = [];
      for (let i = 0; i < this.EOM; i++) {
        this.DOW.push(dayjs(this.startDate).add(i, "d").format("ddd"));
      }
    },
    nextMonth() {
      this.targetMonth = dayjs(this.targetMonth)
        .add(1, "month")
        .format("YYYY-MM");
      this.getTasks();
      this.DOW = [];
      for (let i = 0; i < this.EOM; i++) {
        this.DOW.push(dayjs(this.startDate).add(i, "d").format("ddd"));
      }
    },
    async getTasks() {
      const requestConfig = {
        url: "/tasks",
        method: "GET",
        params: {
          priority: this.priorityId,
          status: this.statusId,
          categoryId: this.categoryId,
          tagId: this.tagId,
          requestedUserId: this.requestedId,
          requesterUserId: this.requesterId,
          dateStart: this.startDate,
          dateEnd: this.endDate,
          isPerfect: false,
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
.schedule {
  th {
    &:nth-child(1) {
      width: 150px;
    }
    &:nth-child(2) {
      width: calc(100% - 150px);
    }
  }
  td {
    &:nth-child(1) {
      width: 150px;
    }
    &:nth-child(2) {
      width: calc(100% - 150px);
    }
  }
  ul {
    display: flex;
    li {
      display: flex;
      justify-content: center;
      align-items: center;
      width: calc(100% / 31);
      height: 30px;
      border-left: 1px solid rgba($color: #000000, $alpha: 0.3);
      &:last-child {
        border-right: 1px solid rgba($color: #000000, $alpha: 0.3);
      }
      &.color-blue {
        background-color: rgba($color: #1976d2, $alpha: 0.5);
        color: rgba($color: #000000, $alpha: 0.5);
      }
    }
  }
  tbody {
    li {
      color: rgba($color: #000000, $alpha: 0.3);
      border-top: 1px solid rgba($color: #000000, $alpha: 0.3);
      border-bottom: 1px solid rgba($color: #000000, $alpha: 0.3);
    }
  }
}

.pagenation {
  background-color: white;
  font-size: 15px;
  color: black;
  h1 {
    width: 183px;
    text-align: center;
  }
  ::v-deep {
    .v-icon {
      color: white;
      font-size: 30px;
      position: relative;
      bottom: 1.5px;
    }
  }
}

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
      color: #FFC107;
    }
  }
}
</style>