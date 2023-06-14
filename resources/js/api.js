import axios from "axios";

export default {
    get(url, config = null) {
        return axios.get(url, {withCredentials: true, ...config});
    },

    post(url, data = [], config = null) {
        return axios.post(url, data);
    },

    put(url, data = [], config = null) {
        return axios.put(url, data);
    },

    delete(url, data = []) {
        return axios.delete(url, { data });
    },
}