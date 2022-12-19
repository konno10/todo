import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '@/store/index'
import { myAxios } from "@/plugins/axios";

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        redirect: '/main'
    },
    {
        path: '/login',
        meta: { isPublic: true },
        component: () => import('../views/login/Login.vue'),
        children: [
            {
                path: '/login',
                redirect: '/login/signin'
            },
            {
                path: '/login/signin',
                component: () => import('../views/login/signin/Signin.vue'),
            },
        ],
    },
    {
        path: '/main',
        meta: { isPublic: false },
        component: () => import('../views/main/Main.vue'),
        children: [
            {
                path: '/main',
                redirect: '/main/task'
            },
            {
                path: '/main/task',
                component: () => import('../views/main/task/AllTask.vue'),
            },
            {
                path: '/main/task/create',
                component: () => import('../views/main/task/CreateTask.vue'),
            },
            {
                path: '/main/task/read',
                component: () => import('../views/main/task/ReadTask.vue'),
            },
            {
                path: '/main/task/update',
                component: () => import('../views/main/task/UpdateTask.vue'),
            },
            {
                path: '/main/user',
                component: () => import('../views/main/user/AllUser.vue'),
            },
            {
                path: '/main/user/create',
                component: () => import('../views/main/user/CreateUser.vue'),
            },
            {
                path: '/main/user/read',
                component: () => import('../views/main/user/ReadUser.vue'),
            },
            {
                path: '/main/user/update',
                component: () => import('../views/main/user/UpdateUser.vue'),
            },
            {
                path: '/main/schedule',
                component: () => import('../views/main/schedule/AllSchedule.vue'),
            },
            {
                path: '/main/category',
                component: () => import('../views/main/category/AllCategory.vue'),
            },
            {
                path: '/main/category/create',
                component: () => import('../views/main/category/CreateCategory.vue'),
            },
            {
                path: '/main/category/read',
                component: () => import('../views/main/category/ReadCategory.vue'),
            },
            {
                path: '/main/category/update',
                component: () => import('../views/main/category/UpdateCategory.vue'),
            },
            {
                path: '/main/tag',
                component: () => import('../views/main/tag/AllTag.vue'),
            },
            {
                path: '/main/tag/create',
                component: () => import('../views/main/tag/CreateTag.vue'),
            },
            {
                path: '/main/tag/read',
                component: () => import('../views/main/tag/ReadTag.vue'),
            },
            {
                path: '/main/tag/update',
                component: () => import('../views/main/tag/UpdateTag.vue'),
            },
            {
                path: '/main/test/category',
                component: () => import('../views/main/test/TestCategory.vue'),
            },
            {
                path: '/main/test/user',
                component: () => import('../views/main/test/TestUser.vue'),
            },
            {
                path: '/main/test/tag',
                component: () => import('../views/main/test/TestTag.vue'),
            },
            {
                path: '/main/test/task',
                component: () => import('../views/main/test/TestTask.vue'),
            },
            {
                path: '/main/test',
                component: () => import('../views/main/test/Test.vue'),
            },
            {
                path: '/main/test2',
                component: () => import('../views/main/test/Test2.vue'),
            },
            {
                path: '/main/test3',
                component: () => import('../views/main/test/Test3.vue'),
            },
        ],
    },
    {
        path: '*',
        component: () => import('../views/404.vue'),
    },
]

const router = new VueRouter({
    mode: 'hash',
    base: process.env.BASE_URL,
    routes
})

router.beforeEach(async (to, from, next) => {

    //存在しないページへのアクセス
    if (!to.matched.length) {
        next();
        return;
    }
    // トークンを持っている &&  認証していない
    if (localStorage.getItem("token") && !store.state.loginInfo) {
        const requestConfig = {
            url: `/user/auth`,
            method: "GET",
        };
        await myAxios(requestConfig)
            .then((res) => {
                store.commit("setLoginInfo", res.data)
            })
            .catch(() => {
                localStorage.removeItem("token");
            })
    }
    // 認証不要のページ && 認証している
    if (to.matched[0].meta.isPublic && store.state.loginInfo) {
        next({ path: '/' });
        return;
    }
    // 認証必要のページ && 認証していない
    if (!to.matched[0].meta.isPublic && !store.state.loginInfo) {
        next({ path: '/login/signin' });
        return;
    }
    next();
});

export default router
