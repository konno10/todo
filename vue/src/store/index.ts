import Vue from 'vue'
import Vuex from 'vuex'
import router from "../router/index";
import { myAxios } from "@/plugins/axios";

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        loginInfo: null,
        categories: null,
        tags: null,
        users: null,
    },
    mutations: {
        setLoginInfo(state, loginInfo) {
            state.loginInfo = loginInfo
        },
        setCategories(state, categories) {
            state.categories = categories;
        },
        setTags(state, tags) {
            state.tags = tags;
        },
        setUsers(state, users) {
            state.users = users;
        },
    },
    actions: {
        async getCategories({ commit }) {
            const requestConfig = {
                url: "/categories",
                method: "GET",
            };
            await myAxios(requestConfig)
                .then((res) => {
                    commit("setCategories", res.data);
                })
        },
        async getTags({ commit }) {
            const requestConfig = {
                url: "/tags",
                method: "GET",
            };
            await myAxios(requestConfig)
                .then((res) => {
                    commit("setTags", res.data);
                })
        },
        async getUsers({ commit }) {
            const requestConfig = {
                url: "/users",
                method: "GET",
            };
            await myAxios(requestConfig)
                .then((res) => {
                    commit("setUsers", res.data.users);
                })
        },
        logout({ commit }) {
            localStorage.removeItem("token");
            commit("setLoginInfo", null)
            router.push("/login/signin")
        }
    },
    modules: {
    }
})
