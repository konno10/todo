import axios from "axios";
import store from '@/store/index'

export const myAxios = axios.create({
    baseURL: process.env.VUE_APP_API_BASE_URL,
});

myAxios.interceptors.request.use((req) => {
    if (req.headers) {
        req.headers.token = localStorage.getItem("token") ?? "";
    }
    return req;
});

myAxios.interceptors.response.use(
    async (res) => {
        if(process.env.NODE_ENV === 'development'){
            await new Promise(resolve => setTimeout(resolve, 1000))
        }
        if (res.config.baseURL) {
            console.log(res.config.baseURL + res.config.url, res);
        }
        return res;
    },
    (err) => {
        if (axios.isCancel(err)) {
            console.error("リクエストがキャンセルされました");
        } else {
            console.error(err.response);
        }
        if (err.response?.status == 429) {
            alert("一定時間にアクセスが集中したため、しばらくアクセスできません");
        }
        if (err.response?.status == 401) {
            store.dispatch("logout")
        }
        throw err;
    }
);
