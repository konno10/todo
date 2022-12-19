<template>
  <div>
    <h1>This is an test2 page</h1>
    <v-text-field :value="'こんにちは'" @change="onChange" label="キーワード" placeholder="キーワード" outlined color="primary" class="pt-5"></v-text-field>
  </div>
</template>
<script>
import { myAxios } from "@/plugins/axios";
export default {
  data() {
    return {
      test: {},
    };
  },
  methods: {
    updateQuery(key, value) {
      if (value) {
        this.$router.push({ query: { ...this.$route.query, [key]: value } });
      } else {
        let query = Object.assign({}, this.$route.query);
        delete query[key];
        this.$router.push({ query: query });
      }
    },
    onChange(text) {
      this.updateQuery("keyword", text);
    },
    getData() {
      const requestConfig = {
        url: "/tasks",
        method: "GET",
        params: {
          page: 1,
          status: 1,
          priority: 1,
          requestedUserId: this.$route.query.requestedUserId,
          requesterUserId: this.$route.query.requestedUserId,
          categoryId: this.$route.query.categoryId,
          keyword: this.$route.query.keyword,
        },
      };
      myAxios(requestConfig).then((res) => {
        this.test = res.data;
      });
    },
  },
  mounted() {
    this.getData();
  },
};
</script>

<style lang="scss" scoped>
hr {
  margin: 30px 0;
}
</style>