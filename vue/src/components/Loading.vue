<template>
  <div class="loading_wrap">
    <v-progress-circular indeterminate color="primary"></v-progress-circular>
  </div>
</template>

<script>
export default {
  name: "Loading",
};
</script>

<style lang="scss" scoped>
.loading_wrap {
  height: 100px;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>