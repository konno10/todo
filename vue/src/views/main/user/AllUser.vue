<template>
  <div>
    <v-card>
      <v-card-title>
        <span>ユーザー 一覧</span>
        <v-spacer></v-spacer>
        <v-btn router to="/main/user/create" height="35px" width="35px" fab>
          <v-icon color="primary">mdi-plus</v-icon>
        </v-btn>
      </v-card-title>
      <Loading v-if="isLoading" />
      <p v-else-if="showUsers === null">通信エラー</p>
      <v-card-text class="pa-0" v-else>
        <div class="pt-4 px-4 pb-2">
          <v-form class="d-flex">
            <v-text-field dense label="ユーザー名" placeholder="ユーザー名を入力" prepend-inner-icon="mdi-magnify" outlined color="primary" :value="keyword" @input="onSearch"></v-text-field>
          </v-form>
          <div class="d-flex align-end">
            <p v-if="showUsers.length" style="wirth:250px;">全 {{afterFilter.length}} 件中 {{pageFirstUser}} 件 〜 {{pageLastUser}} 件を表示</p>
            <p v-else>全 0 件</p>
            <div style="width:calc(100% - 250px);padding:0 100px 0 150px;">
              <v-pagination @input="onClickPaginate" :value="currentPage" :length="maxPage" color="primary" dense></v-pagination>
            </div>
          </div>
        </div>
        <v-divider></v-divider>
        <v-simple-table>
          <thead>
            <tr>
              <th>ID</th>
              <th>名前</th>
              <th>メール</th>
            </tr>
          </thead>
          <p v-if="!showUsers.length">データはありません</p>
          <tbody>
            <tr v-for="(user, index) in showUsers" :key="index" @click="$router.push(`/main/user/read?userId=${user.id}`)" v-ripple>
              <td>{{user.id}}</td>
              <td>
                <v-avatar size="30px" class="mr-1">
                  <v-img :src="user.img"></v-img>
                </v-avatar>
                <span>{{user.name}}</span>
              </td>
              <td>{{user.email}}</td>
            </tr>
          </tbody>
        </v-simple-table>
      </v-card-text>
    </v-card>
  </div>
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
      currentPage: 1,
      perPage: 10,
      keyword: "",
    };
  },
  computed: {
    usersNum(){
      return this.afterFilter.length;
    },
    maxPage(){
      return Math.ceil(this.usersNum / this.perPage);
    },
    afterFilter(){
      if(!this.$store.state.users)return [];
      return this.$store.state.users.filter(
        (a) => a.name.indexOf(this.keyword) !== -1
      );
    },
    showUsers(){
      return this.afterFilter.slice(
        (this.currentPage - 1) * this.perPage,
        this.currentPage * this.perPage
      );
    },
    pageFirstUser() {
      return (this.currentPage - 1) * this.perPage + 1;
    },
    perPageLastUser() {
      return this.currentPage * this.perPage;
    },
    pageLastUser() {
      if (this.perPageLastUser <= this.afterFilter.length) {
        return this.perPageLastUser;
      } else {
        return this.afterFilter.length;
      }
    },
  },
  methods: {
    onSearch(userSearch){
      this.keyword = userSearch;
      this.currentPage = 1;
    },
    onClickPaginate(page) {
      this.currentPage = page;
    },
  },
  async mounted() {
    this.isLoading = true;
    await this.$store.dispatch("getUsers");
    this.isLoading = false;
  },
};
</script>

<style>
</style>