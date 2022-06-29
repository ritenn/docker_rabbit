import { ref } from 'vue'
import useApi from "../Api/UseApi";

export default function useEmails() {
    const { get, post, del, response, errors } = useApi();

    const list = async (params) => {
        return get('emails', params);
    }

    const store = async (data) => {
        return post('emails', data);
    }

    const show = async (id) => {
        return get('emails/' + id);
    }

    const destroy = async (id) => {
        return del('emails/' + id);
    }

    return {
        errors,
        response,
        list,
        store,
        show,
        destroy
    }
}
