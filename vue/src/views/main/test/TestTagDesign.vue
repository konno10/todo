<template>
  <div :class="{'is-sp':$vuetify.breakpoint.xs}">

    <!-- タグ登録 -->
    <v-card>
      <v-card-title>新しいタグを登録</v-card-title>
      <v-card-text>
        <section class="tag_info">
          <v-card-subtitle>タグ情報</v-card-subtitle>
          <ul>
            <li>
              <v-text-field label="タグ名" value="" dense outlined color="primary"></v-text-field>
            </li>
            <li>
              <v-textarea label="詳細" value="" dense outlined color="primary"></v-textarea>
            </li>
          </ul>
        </section>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn router to="/main/tag" color="primary">
          <span>登録</span>
          <v-icon>mdi-send</v-icon>
        </v-btn>
      </v-card-actions>
    </v-card>

    <!-- タグ詳細 -->
    <v-card>
      <v-card-title>詳細（バグ修正 ID:1）</v-card-title>
      <v-card-text>
        <section class="tag_info">
          <v-card-subtitle>タグ情報</v-card-subtitle>
          <ul>
            <li>
              <v-text-field label="タグ名" value="バグ修正" dense readonly outlined color="primary"></v-text-field>
            </li>
            <li>
              <v-textarea label="詳細" value="バグ修正の詳細バグ修正の詳細バグ修正の詳細バグ修正の詳細バグ修正の詳細バグ修正の詳細バグ修正の詳細バグ修正の詳細バグ修正の詳細" dense readonly outlined color="primary"></v-textarea>
            </li>
          </ul>
        </section>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn router to="/main/tag/update?userId=2" color="orange" dark>
          <span>編集</span>
          <v-icon>mdi-pencil</v-icon>
        </v-btn>
      </v-card-actions>
    </v-card>

    <!-- タグ編集 -->
    <v-card>
      <v-card-title>編集（バグ修正 ID:1）</v-card-title>
      <v-card-text>
        <section class="tag_info">
          <v-card-subtitle>タグ情報</v-card-subtitle>
          <ul>
            <li>
              <v-text-field label="タグ名" value="バグ修正" dense outlined color="primary"></v-text-field>
            </li>
            <li>
              <v-textarea label="詳細" value="バグ修正の詳細バグ修正の詳細バグ修正の詳細バグ修正の詳細バグ修正の詳細バグ修正の詳細バグ修正の詳細バグ修正の詳細バグ修正の詳細" dense outlined color="primary"></v-textarea>
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
        <v-btn router to="/main/tag" color="primary">
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