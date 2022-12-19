<template>
  <div :class="{'is-sp':$vuetify.breakpoint.xs}">
    <v-card>
      <v-card-title>編集（{{user.name}} ID:{{user.id}}）</v-card-title>
      <Loading v-if="isLoading" />
      <p v-else-if="tag === null">通信エラー</p>
      <v-card-text v-else>
        <section class="user_info">
          <v-card-subtitle>ユーザー情報</v-card-subtitle>
          <ul>
            <li class="mb-5 mr-3">
              <v-avatar size="40px">
                <v-img @click="isShowImagePicker = true" :src="user.img"></v-img>
              </v-avatar>
            </li>
            <li>
              <v-text-field label="名前" v-model="user.name" prepend-inner-icon="mdi-account" dense outlined color="primary" class="mr-2"></v-text-field>
              <p v-if="newUserNameError" class="error-text">{{newUserNameError}}</p>
            </li>
            <li>
              <v-text-field label="メールアドレス" v-model="user.email" prepend-inner-icon="mdi-email" dense outlined color="primary" class="mr-2"></v-text-field>
              <p v-if="newUserEmailError" class="error-text">{{newUserEmailError}}</p>
            </li>
            <li>
              <v-text-field label="新しいパスワード" v-model="newUserPass" prepend-inner-icon="mdi-lock" dense outlined color="primary" class="mr-2"></v-text-field>
              <p v-if="newUserPassError" class="error-text">{{newUserPassError}}</p>
            </li>
          </ul>
        </section>
      </v-card-text>
      <v-card-actions>
        <v-btn :disabled="isLoading" @click="deleltedUser()" color="error">
          <span>削除</span>
          <v-icon>mdi-delete</v-icon>
        </v-btn>
        <v-spacer></v-spacer>
        <v-btn :disabled="isLoading" @click="changeUser()" color="primary">
          <span>登録</span>
          <v-icon>mdi-send</v-icon>
        </v-btn>
      </v-card-actions>
    </v-card>

    <ImagePicker :isShowImagePicker="isShowImagePicker" :onSelectedImg="onSelectedImg" :onCloseMyself="onCloseMyself" />

    <!-- コメントアウトを外すとイメージピッカーが出現します -->

    <!-- <v-dialog :value="true" scrollable>
      <v-card class="image_picker">
        <v-card-title>アイコン画像を選択してください</v-card-title>
        <v-divider></v-divider>
        <v-card-text class="pa-3" style="min-height:30vh;">
          <ul>
            <li v-for="n in 99" :key="n">
              <v-card v-ripple>
                <v-img :src="`https://picsum.photos/500/300?image=${n}`"></v-img>
              </v-card>
            </li>
          </ul>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn>
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog> -->

  </div>
</template>
<script>
import ImagePicker from "@/components/ImagePicker.vue";
import Loading from "@/components/Loading.vue";
import { myAxios } from "@/plugins/axios";
export default {
  components: {
    Loading,
    ImagePicker,
  },
  data() {
    return {
      isShowImagePicker: false,
      user: {},
      isLoading: false,
      newUserName: "",
      newUserNameError: "",
      newUserEmail: "",
      newUserEmailError: "",
      newUserPass: "",
      newUserPassError: "",
    };
  },

  methods: {
    onSelectedImg(path) {
      this.user.img = path;
      this.isShowImagePicker = false;
    },
    onCloseMyself() {
      this.isShowImagePicker = false;
    },
    async getUser() {
      this.isLoading = true;
      const requestConfig = {
        url: "/user",
        method: "GET",
        params: {
          id: this.$route.query.userId,
        },
      };
      myAxios(requestConfig)
        .then((res) => {
          this.user = res.data;
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
    async deleltedUser() {
      if (!confirm("本当に削除しますか？")) return;
      const requestConfig = {
        url: "/user",
        method: "DELETE",
        data: {
          id: this.$route.query.userId,
        },
      };
      myAxios(requestConfig).then(() => {
        this.$router.push("/main/user");
      });
    },
    async changeUser() {
      let isError = false;
      this.newUserNameError = "";
      this.newUserEmailError = "";
      this.newUserPassError = "";
      if (this.user.name === "") {
        isError = true;
        this.newUserNameError = "入力してください";
      }
      if (!/.+@.+\..+/.test(this.user.email)) {
        isError = true;
        this.newUserEmailError = "正しいメールアドレスの形式で入力してください";
      }
      if (this.newUserPass.length < 8) {
        isError = true;
        this.newUserPassError = "パスワードは8文字以上で入力してください";
      }
      if (isError) return;
      const requestConfig = {
        url: "/user",
        method: "PUT",
        data: {
          id: this.$route.query.userId,
          name: this.user.name,
          email: this.user.email,
          pass: this.user.pass,
          img: this.user.img
        },
      };
      this.isLoading = true;
      myAxios(requestConfig)
        .then(() => {
          this.$router.push("/main/user");
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
  },
  mounted() {
    this.getUser();
  },
};
</script>

<style lang="scss" scoped>
.image_picker {
  ul {
    padding: 0 !important;
    display: flex;
    flex-wrap: wrap;
    li {
      list-style: none;
      width: 31%;
      margin-right: 3.5%;
      margin-bottom: 3.5%;
      &:nth-child(3n) {
        margin-right: 0;
      }
    }
  }
}
.user_info {
  ul {
    display: flex;
    li {
      margin-right: 20px;
      &:last-child {
        margin-right: 0;
      }
    }
  }
}
.is-sp {
  .user_info {
    ul {
      display: block;
      li {
        justify-content: center;
      }
    }
  }
}
</style>