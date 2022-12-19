<template>
  <v-dialog :value="true" scrollable hide-overlay persistent no-click-animation>
    <v-card class="mx-auto">
      <v-card-title>ログイン</v-card-title>
      <v-divider></v-divider>
      <v-card-text>
        <v-form v-model="noError" ref="form" class="pt-5">
          <v-text-field validate-on-blur @keyup.enter="login()" :rules="emailRules" required label="メールアドレス" placeholder="メールアドレス" prepend-inner-icon="mdi-email" outlined v-model="form.email" color="primary" class="pt-5"></v-text-field>
          <v-text-field validate-on-blur @keyup.enter="login()" :rules="passwordRules" required label="パスワード" placeholder="パスワード" prepend-inner-icon="mdi-lock" :append-icon="passwordShow ? 'mdi-eye' : 'mdi-eye-off'" :type="passwordShow ? 'text' : 'password'" outlined v-model="form.password" @click:append="passwordShow = !passwordShow" color="primary"></v-text-field>
        </v-form>
        <p v-if="errorMessage && noError" class="error_message mb-2">{{errorMessage}}</p>
      </v-card-text>

      <v-divider></v-divider>
      <v-card-actions>
        <v-btn @click="testAuthentication()" :loading="testAuthenticationLoading" :disabled="loginLoading">
          <span>テストユーザーでログイン</span>
          <v-icon>mdi-send</v-icon>
        </v-btn>
        <v-spacer></v-spacer>
        <v-btn @click="login()" :loading="loginLoading" :disabled="testAuthenticationLoading" color="primary">
            <span>ログイン</span>
            <v-icon>mdi-send</v-icon>
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { myAxios } from "@/plugins/axios";
export default {
  data() {
    return {
      testAuthenticationLoading: false,
      loginLoading: false,
      noError: false,
      errorMessage: "",
      form: {
        email: "",
        password: "",
      },
      emailRules: [
        (v) => !!v || "メールアドレスは必須です",
        (v) => /.+@.+\..+/.test(v) || "正しい形式で入力してください",
      ],
      passwordRules: [
        (v) => !!v || "パスワードは必須です",
        (v) => (v && v.length >= 8) || "パスワードは8桁以上で設定してください",
      ],
      passwordShow: false,
    };
  },
  methods: {
    async testAuthentication() {
      this.testAuthenticationLoading = true;
      let apiParam = {
        email: "test@gmail.com",
        password: "password",
      };
      const requestConfig = {
        url: `/user/signin`,
        method: "POST",
        data: apiParam,
      };
      await myAxios(requestConfig)
        .then((res) => {
          localStorage.setItem("token", res.data.token);
          this.$router.push("/");
        })
        .catch((err) => {
          if (err.response?.data.errorMessage) {
            this.errorMessage = err.response?.data.errorMessage;
          }
        })
        .finally(() => {
          this.testAuthenticationLoading = false;
        });
    },
    async login() {
      const form = this.$refs.form;
      form.validate();
      this.$nextTick(async () => {
        if (!this.noError) {
          return;
        }
        this.loginLoading = true;
        this.errorMessage = "";
        let apiParam = {
          email: this.form.email,
          password: this.form.password,
        };
        const requestConfig = {
          url: `/user/signin`,
          method: "POST",
          data: apiParam,
        };
        await myAxios(requestConfig)
          .then((res) => {
            localStorage.setItem("token", res.data.token);
            this.$router.push("/");
          })
          .catch((err) => {
            if (err.response?.data.errorMessage) {
              this.errorMessage = err.response?.data.errorMessage;
            }
          })
          .finally(() => {
            this.loginLoading = false;
          });
      });
    },
  },
};
</script>