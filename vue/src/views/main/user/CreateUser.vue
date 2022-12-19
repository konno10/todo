<template>
  <div :class="{'is-sp':$vuetify.breakpoint.xs}">
    <v-card>
      <v-card-title>新しいユーザーを登録</v-card-title>
      <v-card-text>
        <section class="user_info">
          <v-card-subtitle>ユーザー情報</v-card-subtitle>
          <ul>
            <li class="mb-5 mr-3">
              <v-avatar size="40px">
                <v-img @click="isShowImagePicker = true" :src="newUserImage"></v-img>
              </v-avatar>
            </li>
            <li>
              <v-text-field label="名前" :value="newUserName" @input="onCreateName" prepend-inner-icon="mdi-account" dense outlined color="primary" class="mr-2"></v-text-field>
              <p v-if="newUserNameError" class="error-text">{{newUserNameError}}</p>
            </li>
            <li>
              <v-text-field label="メールアドレス" :value="newUserEmail" @input="onCreateEmail" prepend-inner-icon="mdi-email" dense outlined color="primary" class="mr-2"></v-text-field>
              <p v-if="newUserEmailError" class="error-text">{{newUserEmailError}}</p>
            </li>
            <li>
              <v-text-field label="パスワード" :value="newUserPass" @input="onCreatePass" prepend-inner-icon="mdi-lock" dense outlined color="primary" class="mr-2"></v-text-field>
              <p v-if="newUserPassError" class="error-text">{{newUserPassError}}</p>
            </li>
          </ul>
        </section>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="primary" :loading="isLoading" @click="getUser()">
          <span>登録</span>
          <v-icon>mdi-send</v-icon>
        </v-btn>
      </v-card-actions>
    </v-card>

    <ImagePicker :isShowImagePicker="isShowImagePicker" :onSelectedImg="onSelectedImg" :onCloseMyself="onCloseMyself" />

  </div>
</template>
<script>
import ImagePicker from "@/components/ImagePicker.vue";
import { myAxios } from "@/plugins/axios";
export default {
  components: {
    ImagePicker,
  },
  data() {
    return {
      isShowImagePicker: false,
      isLoading: false,
      newUserImage: "https://picsum.photos/500/300?image=1",
      newUserName: "",
      newUserNameError: "",
      newUserEmail: "",
      newUserEmailError: "",
      newUserPass: "",
      newUserPassError: "",
    };
  },
  methods: {
    onCreateName(userName) {
      this.newUserName = userName;
    },
    onCreateEmail(userEmail) {
      this.newUserEmail = userEmail;
    },
    onCreatePass(userPass) {
      this.newUserPass = userPass;
    },
    onSelectedImg(path) {
      this.newUserImage = path;
      this.isShowImagePicker = false;
    },
    onCloseMyself() {
      this.isShowImagePicker = false;
    },
    async getUser() {
      let isError = false;
      this.newUserNameError = "";
      this.newUserEmailError = "";
      this.newUserPassError = "";
      if (this.newUserName === "") {
        isError = true;
        this.newUserNameError = "入力してください";
      }
      if (!/.+@.+\..+/.test(this.newUserEmail)) {
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
        method: "POST",
        data: {
          name: this.newUserName,
          email: this.newUserEmail,
          password: this.newUserPass,
          img: this.newUserImage,
        },
      };
      this.isLoading = true;
      myAxios(requestConfig)
        .then(() => {
          this.$router.push("/main/user");
        })
        .catch((err) => {
          this.newUserEmailError = err?.response?.data?.errorMessage;
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
  },
};
</script>

<style lang="scss" scoped>
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