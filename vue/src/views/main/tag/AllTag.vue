<template>
  <v-card>
    <v-card-title>
      <span>タグ 一覧</span>
      <v-spacer></v-spacer>
      <v-btn @click="$router.push(`/main/tag/create`)" height="35px" width="35px" fab>
        <v-icon color="primary">mdi-plus</v-icon>
      </v-btn>
    </v-card-title>
    <v-card-text class="pa-0">
      <Loading v-if="isLoading" />
      <p v-else-if="$store.state.tags === null">通信エラー</p>
      <p v-else-if="!$store.state.tags">データはありません</p>
      <v-simple-table v-else>
        <thead>
          <tr>
            <th>ID</th>
            <th>タグ名</th>
          </tr>
        </thead>
        <tbody>
          <tr v-ripple @click="$router.push(`/main/tag/read?tagId=${tag.tag_id}`)" v-for="(tag, index) in $store.state.tags" :key="index">
            <td>{{tag.tag_id}}</td>
            <td>{{tag.tag_name}}</td>
          </tr>
        </tbody>
      </v-simple-table>
    </v-card-text>
  </v-card>
</template>

<script>
import Loading from "@/components/Loading.vue";
export default {
  components: {
    Loading,
  },
  data() {
    return {
      isLoading: false,
    };
  },
  methods: {},
  async mounted() {
    this.isLoading = true;
    await this.$store.dispatch("getTags");
    this.isLoading = false;
  },
};
</script>

<style scoped lang="scss">
</style>