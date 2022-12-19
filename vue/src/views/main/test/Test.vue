<template>
  <div :class="{'is-sp':$vuetify.breakpoint.xs}">

    <!-- カテゴリー登録 -->
    <v-card>
      <v-card-title>新しいカテゴリーを登録</v-card-title>
      <v-card-text>
        <section class="category_info">
          <v-card-subtitle>カテゴリー情報</v-card-subtitle>
          <ul>
            <li>
              <v-text-field label="カテゴリー名" value="" dense outlined color="primary"></v-text-field>
            </li>
            <li>
              <v-textarea label="詳細" value="" dense outlined color="primary"></v-textarea>
            </li>
          </ul>
        </section>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn router to="/main/category" color="primary">
          <span>登録</span>
          <v-icon>mdi-send</v-icon>
        </v-btn>
      </v-card-actions>
    </v-card>

    <!-- カテゴリー詳細 -->
    <v-card>
      <v-card-title>詳細（デザイン ID:1）</v-card-title>
      <v-card-text>
        <section class="category_info">
          <v-card-subtitle>カテゴリー情報</v-card-subtitle>
          <ul>
            <li>
              <v-text-field label="カテゴリー名" value="デザイン" dense readonly outlined color="primary"></v-text-field>
            </li>
            <li>
              <v-textarea label="詳細" value="デザインの詳細デザインの詳細デザインの詳細デザインの詳細デザインの詳細デザインの詳細デザインの詳細デザインの詳細デザインの詳細" dense readonly outlined color="primary"></v-textarea>
            </li>
          </ul>
        </section>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn router to="/main/category/update?userId=2" color="orange" dark>
          <span>編集</span>
          <v-icon>mdi-pencil</v-icon>
        </v-btn>
      </v-card-actions>
    </v-card>

    <!-- カテゴリー編集 -->
    <v-card>
      <v-card-title>編集（デザイン ID:1）</v-card-title>
      <v-card-text>
        <section class="category_info">
          <v-card-subtitle>カテゴリー情報</v-card-subtitle>
          <ul>
            <li>
              <v-text-field label="カテゴリー名" value="デザイン" dense outlined color="primary"></v-text-field>
            </li>
            <li>
              <v-textarea label="詳細" value="デザインの詳細デザインの詳細デザインの詳細デザインの詳細デザインの詳細デザインの詳細デザインの詳細デザインの詳細デザインの詳細" dense outlined color="primary"></v-textarea>
            </li>
          </ul>
        </section>
      </v-card-text>
      <v-card-actions>
        <v-btn color="error" dark>
          <span>削除</span>
          <v-icon>mdi-delete</v-icon>
        </v-btn>
        <v-spacer></v-spacer>
        <v-btn router to="/main/category" color="primary">
          <span>登録</span>
          <v-icon>mdi-send</v-icon>
        </v-btn>
      </v-card-actions>
    </v-card>

  </div>
</template>
<style lang="scss" scoped>
::v-deep {
  .v-card {
    margin-bottom: 30px !important;
  }
}
</style>