<template>
  <div v-if="$store.state.loginInfo">

    <!-- sp -->
    <div v-if="$vuetify.breakpoint.xs">
      <v-app-bar app class="header sp">
        <v-container class="d-flex align-center">
          <div style="width:45px;height:45px;">
            <v-img :src="$store.state.loginInfo.img" aspect-ratio="1" class="rounded-circle main_img"></v-img>
          </div>
          <div class="pl-2">{{$store.state.loginInfo.name}}</div>
          <v-spacer></v-spacer>
          <v-btn @click="logout()" class="pa-0" color="primary" small text>ログアウト</v-btn>
        </v-container>
      </v-app-bar>
      <v-main>
        <v-container>
          <router-view />
        </v-container>
      </v-main>
      <v-bottom-navigation app fixed color="primary">
        <v-btn v-for="(nav,i) in navs" :key="i" :style="`width:calc(100% / ${navs.length}); height:100%;background-color:white;`" :to="nav.to" router exact-path>
          <span>{{nav.ttl}}</span>
          <v-badge :value="false" :content="0" color="primary" offset-x="5" offset-y="15">
            <v-icon>{{nav.icon}}</v-icon>
          </v-badge>
        </v-btn>
      </v-bottom-navigation>
    </div>

    <!-- pc -->
    <div v-else>
      <v-navigation-drawer width="200px" app permanent>
        <v-list-item>
          <v-list-item-avatar>
            <v-img :src="$store.state.loginInfo.img"></v-img>
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title class="px-1 pt-2">{{$store.state.loginInfo.name}}</v-list-item-title>
            <v-btn max-width="75px" class="pa-0" color="primary" small text @click="logout()">ログアウト</v-btn>
          </v-list-item-content>
        </v-list-item>
        <v-list nav dense>
          <v-list-item style="border-bottom:none;" v-for="nav in navs" :key="nav.ttl" :to="nav.to" router exact-path>
            <v-list-item-icon>
              <v-badge :value="false" :content="0" color="primary" offset-x="5" offset-y="15">
                <v-icon>{{nav.icon}}</v-icon>
              </v-badge>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>{{ nav.ttl }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>
      <v-main>
        <v-container>
          <router-view />
        </v-container>
      </v-main>
    </div>

  </div>
</template>

<script>
export default {
  computed: {
    navs() {
      let returnNavs = [
        {
          to: "/main/task",
          icon: "mdi-playlist-check",
          ttl: "タスク",
        },
        {
          to: "/main/schedule",
          icon: "mdi-calendar",
          ttl: "スケジュール",
        },
        {
          to: "/main/user",
          icon: "mdi-account-group",
          ttl: "ユーザー",
        },
        {
          to: "/main/category",
          icon: "mdi-shape",
          ttl: "カテゴリー",
        },
        {
          to: "/main/tag",
          icon: "mdi-tag",
          ttl: "タグ",
        },
      ];
      if (process.env.NODE_ENV === "development") {
        const devNavs = [
          {
            to: "/main/test/category",
            ttl: "test/category",
          },
          {
            to: "/main/test/tag",
            ttl: "test/tag",
          },
          {
            to: "/main/test/task",
            ttl: "test/task",
          },
          {
            to: "/main/test/user",
            ttl: "test/user",
          },
        ];
        returnNavs = returnNavs.concat(devNavs);
      }
      return returnNavs;
    },
  },
  methods: {
    logout() {
      if (!confirm("ログアウトしますか？")) return;
      this.$store.dispatch("logout");
    },
  },
};
</script>
<style lang="scss" scoped>
.header {
  ::v-deep {
    .v-toolbar__content {
      padding: 0 !important;
    }
  }
}
</style>
