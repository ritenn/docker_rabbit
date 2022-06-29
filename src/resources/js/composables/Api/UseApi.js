import {ref} from 'vue'
import axios from 'axios'

export default function useApi() {
    const errors = ref({})
    const response = ref({})

    const post = async (endpoint, data) => {
        return await request('post', endpoint, data);
    }

    const get = async (endpoint, params = {}) => {
        return await request('get', endpoint, {}, params);
    }

    const put = async (endpoint, data) => {
        return await request('put', endpoint, data);
    }

    const del = async (endpoint, data) => {
        return await request('delete', endpoint, data);
    }

    async function request(method = 'get', endpoint, data = {}, params = {})
    {
        response.value = undefined;
        errors.value = undefined;

        return await axios({
            method: method,
            url: '/api/' + endpoint,
            data,
            params
        }).then(responseData => {
            response.value = {
                data: responseData.data.data,
                message: responseData.data.message,
                code: responseData.status,
                status: responseData.data.status
            }
        })
        .catch(error => {
            errors.value = error.response.data
        })
    }

    return {
        post,
        get,
        put,
        del,
        response,
        errors
    }
}
