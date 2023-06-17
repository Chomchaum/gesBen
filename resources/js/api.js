import axios from "axios";

function handle_errors(err) {
    let status = err.response.status;
    if (status >= 500) {
        console.log("Everything's fine")
    } else {
        console.log("Nani")
    }
}

export default {
    get(url, data = null) {
        return axios.get(url, {data}).catch(handle_errors);
    },

    post(url, data = [], config = null) {
        return axios.post(url, data).catch(handle_errors);
    },

    put(url, data = [], config = null) {
        return axios.put(url, data).catch(handle_errors);
    },

    delete(url, data = []) {
        return axios.delete(url, {data}).catch(handle_errors);
    },
}