<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <button @click="$router.push('/')" class="btn btn-secondary">Wróć do listy</button>
                    </div>
                    <div v-if="errors.errors" class="col-lg-12">
                        <div class="alert alert-danger" role="alert">
                            <ul class="m-0">
                                <li v-for="error in errors.errors">{{ error.join(', ') }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <form-input
                            label="Email *"
                            type="email"
                            v-model="form.recipient"
                            :validator="v$"
                            :errors="v$.recipient.$errors"
                        />
                    </div>
                    <div class="col-lg-12">
                        <form-input
                            label="Tytuł maila *"
                            type="email"
                            v-model="form.subject"
                            :validator="v$"
                            :errors="v$.subject.$errors"
                        />
                    </div>
                    <div class="col-lg-12 h-100">
                        <quill-editor
                            v-model:content="form.message"
                            content-type="html"
                            theme="snow"
                            class="ql-container ql-snow"
                            :class="{
                        'is-invalid': v$.message.$errors.length > 0
                    }"
                        />
                        <div v-if="v$.message.$errors.length" class="invalid-feedback">
                            <ul>
                                <li v-for="error in v$.message.$errors">{{ error.$message }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-12 text-end mt-4">
                        <button @click="sendForm" class="btn btn-primary">Wyślij</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive } from 'vue';
import UseEmails from '../../../../composables/Emails/UseEmails';
import FormInput from "../../../../components/form/Input";
import useValidate from "@vuelidate/core";
import { helpers, required, email } from "@vuelidate/validators";
import { useRouter } from 'vue-router';

export default {
    name: 'EmailsCreate',
    components: {
        FormInput,
    },
    setup() {
        const { store, response, errors } = UseEmails();
        const router = useRouter();
        const form = reactive({
            recipient: '',
            subject: '',
            message: ''
        });

        const rules = {
            recipient: {
                required: helpers.withMessage('Pole nie może być puste.', required),
                email: helpers.withMessage('Podany adres e-mail jest nieprawidłowy.', email)
            },
            subject: {
                required: helpers.withMessage('Pole nie może być puste.', required),
            },
            message: {
                required: helpers.withMessage('Pole nie może być puste.', required),
            }
        }
        const v$ = useValidate(rules, form);

        function sendForm()
        {
            v$.value.$validate().then(isValid => {
                if (isValid)
                {
                    store(form).then(() => {
                        if (errors.value === undefined)
                        {
                            router.push({name: 'emails.show', params: {id: response.value.data.id}})
                        }
                    })
                }
            })
        }

        return {
            v$,
            form,
            sendForm,
            errors
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
