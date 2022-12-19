<template>
  <v-card>
    <v-card-title>
      <span>カテゴリー 一覧</span>
      <v-spacer></v-spacer>
      <v-btn @click="$router.push(`/main/category/create`)" height="35px" width="35px" fab>
        <v-icon color="primary">mdi-plus</v-icon>
      </v-btn>
    </v-card-title>
    <v-card-text class="pa-0">
      <Loading v-if="isLoading" />
      <p v-else-if="$store.state.categories === null">通信エラー</p>
      <p v-else-if="!$store.state.categories.length">データはありません</p>
      <v-simple-table v-else>
        <thead>
          <tr>
            <th>ID</th>
            <th>カテゴリー名</th>
          </tr>
        </thead>
        <tbody>
          <tr v-ripple v-for="(category, index) in $store.state.categories" :key="index" @click="$router.push(`/main/category/read?categoryId=${category.category_id}`)">
            <td>{{category.category_id}}</td>
            <td>{{category.category_name}}</td>
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
    await this.$store.dispatch("getCategories");
    this.isLoading = false;
  },
};
</script>

<style lang="scss" scoped>
</style>