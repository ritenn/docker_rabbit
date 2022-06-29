<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <button @click="$router.push('/')" class="btn btn-secondary">Wróć do listy</button>
                    </div>
                    <div class="col-lg-12">
                        <form-input
                            label="Email *"
                            type="email"
                            v-model="form.recipient"
                            :is-readonly="true"
                        />
                    </div>
                    <div class="col-lg-12">
                        <form-input
                            label="Tytuł maila *"
                            v-model="form.subject"
                            :is-readonly="true"
                        />
                    </div>
                    <div class="col-lg-12" v-if="form.error_message">
                        <form-input
                            label="Treść błędu"
                            v-model="form.error_message"
                            :is-readonly="true"
                        />
                    </div>
                    <div class="col-lg-12 h-100">
                        <quill-editor
                            v-model:content="form.message"
                            content-type="html"
                            theme="snow"
                            :read-only="true"
                            ref="quill"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import UseEmails from '../../../../composables/Emails/UseEmails';
import FormInput from "../../../../components/form/Input";
import { useRoute, useRouter } from 'vue-router';

export default {
    name: 'EmailsShow',
    components: {
        FormInput,
    },
    setup() {
        const { show, response, errors } = UseEmails();
        const form = ref({
            recipient: '',
            subject: '',
            message: '',
            error_message: ''
        });
        const route = useRoute();
        const router = useRouter();
        const quill = ref(null);

        onMounted(() => {
            show(route.params.id).then(() => {
                if (errors.value === undefined)
                {
                    form.value = response.value.data;
                    quill.value.setHTML(form.value.message);
                } else {
                    router.push('/')
                }
            })
        })


        return {
            form,
            quill,
        }
    }
}
</script>

<style lang="scss" scoped>
.actions {
    white-space: nowrap;
    width: 1%;
}
</style>
