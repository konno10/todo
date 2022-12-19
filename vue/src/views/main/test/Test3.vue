<template>
  <div>
    <h1>This is an test2 page</h1>
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
    getData() {
      const requestConfig = {
        url: "/categories",
        method: "GET",
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