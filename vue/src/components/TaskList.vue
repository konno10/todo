<template>
  <v-simple-table>
    <thead>
      <tr>
        <th>ID</th>
        <th>タスク名</th>
        <th>優先度</th>
        <th>状態</th>
        <th>期限日</th>
        <th>カテゴリー</th>
        <th>タグ</th>
        <th>担当者</th>
        <th>依頼者</th>
      </tr>
    </thead>
    <tbody>
      <tr @click="$router.push(`/main/task/read?taskId=${task.task_id}`)" v-ripple v-for="(task,index) in tasks" :key="index">
        <td>{{task.task_id}}</td>
        <td>{{task.task_name}}</td>
        <td :class="PRIORITIES.find(priority => priority.value == task.task_priority)?.class">{{PRIORITIES.find(priority => priority.value == task.task_priority)?.label}}</td>
        <td :class="STATUS.find(status => status.value == task.task_status)?.class">{{STATUS.find(status => status.value == task.task_status)?.label}}</td>
        <td>{{task.task_date_end}}</td>
        <td>{{task.category.name}}</td>
        <td>{{task.tag.name}}</td>
        <td>
          <v-avatar size="25px" class="mr-1 mb-1">
            <v-img :src="task.requestedUser.img"></v-img>
          </v-avatar>
          <span>{{task.requestedUser.name}}</span>
        </td>
        <td>
          <v-avatar size="25px" class="mr-1 mb-1">
            <v-img :src="task.requesterUser.img"></v-img>
          </v-avatar>
          <span>{{task.requesterUser.name}}</span>
        </td>
      </tr>
    </tbody>
  </v-simple-table>
</template>

<script>
import { PRIORITIES } from "@/plugins/const";
import { STATUS } from "@/plugins/const";
export default {
  props: ["tasks"],
  data() {
    return {
      PRIORITIES: PRIORITIES,
      STATUS: STATUS,
    };
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