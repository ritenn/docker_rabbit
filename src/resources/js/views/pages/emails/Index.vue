<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-end mb-2">
                <button @click="$router.push({name: 'emails.create'})" class="btn btn-primary">Dodaj maila</button>
            </div>
            <div class="col-lg-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Do kogo</th>
                            <th scope="col">Tytuł maila</th>
                            <th scope="col">Status</th>
                            <th scope="col">Akcja</th>
                        </tr>
                    </thead>
                    <tbody v-if="emails.length > 0">
                        <tr v-for="data in emails">
                            <td>{{ data.recipient }}</td>
                            <td>{{ data.subject }}</td>
                            <td>
                                <span class="badge" :class="getStatusBadge(data.status_text).color">{{ getStatusBadge(data.status_text).text }}</span>
                            </td>
                            <td class="actions">
                                <button @click="$router.push({name: 'emails.show', params: {id: data.id}})" class="btn btn-secondary m-1">Podgląd</button>
                                <button @click="deleteEmail(data)" class="btn btn-danger m-1">Usuń</button>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="4">
                                <p class="text-center p-3">Brak danych, dodaj pierwszego maila.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-if="pagination.lastPage > 1" class="col-lg-4 mt-3">
                <label class="form-label select-label"><small>rekordów na stronę:</small></label>
                <select v-model="pagination.perPage" @change="loadList" class="select ms-2">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                </select>
            </div>
            <div v-if="pagination.lastPage > 1" class="col-lg-8 mt-3">
                <nav>
                    <ul class="pagination justify-content-end">
                        <li class="page-item" :class="{'disabled': ! hasPrevPage}">
                            <button @click="changePage(pagination.currentPage - 1)" class="page-link" :disabled="! hasPrevPage">Poprzednia</button>
                        </li>
                        <li v-if="pagination.lastPage < 7" v-for="page in pagination.lastPage" class="page-item" :class="{'active': page === pagination.currentPage}">
                            <button @click="changePage(page)" class="page-link" >{{ page }}</button>
                        </li>
                        <template v-else>
                            <li class="page-item" :class="{'active': 1 === pagination.currentPage}">
                                 <button @click="changePage(1)" class="page-link" >1</button>
                            </li>
                            <li v-if="pagination.currentPage > 1 && pagination.currentPage < pagination.lastPage" class="page-item" :class="{'active': pagination.currentPage < pagination.lastPage}">
                                <button @click="changePage(pagination.currentPage)" class="page-link" >{{ pagination.currentPage }}</button>
                            </li>
                            <li class="page-item disabled">
                                <button :disabled="true" class="page-link" >...</button>
                            </li>
                            <li class="page-item" :class="{'active': pagination.lastPage === pagination.currentPage}">
                                <button @click="changePage(pagination.lastPage)" class="page-link" >{{ pagination.lastPage }}</button>
                            </li>
                        </template>
                        <li class="page-item" :class="{'disabled': ! hasNextPage}">
                            <button @click="changePage(pagination.currentPage + 1)" class="page-link" :disabled="! hasNextPage" >Następna</button>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <DialogWrapper />
    </div>
</template>

<script>
import { ref, computed, onBeforeMount } from 'vue';
import UseEmails from '../../../composables/Emails/UseEmails';
import { DialogWrapper, openDialog } from 'vue3-promise-dialog';
import ConfirmDialog from '../../../components/ConfirmDialog.vue';

export async function confirm(title, text) {
    return await openDialog(ConfirmDialog, {title, text});
}

export default {
    name: 'EmailsList',
    components: {
        DialogWrapper
    },
    setup() {
        const { list, show, destroy, response, errors } = UseEmails();
        const emails = ref([]);
        const pagination = ref({
            perPage: 5,
            currentPage: 1,
            lastPage: 1,
        });

        const hasPrevPage = computed(() => pagination.value.currentPage > 1);
        const hasNextPage = computed(() => pagination.value.currentPage < pagination.value.lastPage);

        const deleteEmail = async (data) => {
            const text = 'Czy chcesz usunąć maila do ' + data.recipient + ' o temacie "' + data.subject + '"?';

            if (await confirm('Czy na pewno ?', text)) {
                destroy(data.id).then(() => {
                    if (errors.value === undefined)
                    {
                        loadList();
                    }
                });
            }
        }

        function getStatusBadge(status)
        {
            switch (status) {
                case 'SENDING': status = {text: 'Wysyłanie', color: 'bg-secondary'}; break;
                case 'SENT': status = {text: 'Wysłany', color: 'bg-success'}; break;
                case 'ERROR': status = {text: 'Błąd', color: 'bg-danger'}; break;
                default:
                    console.log(`Invalid status`);
            }

            return status;
        }
        function loadList()
        {
            list({perPage: pagination.value.perPage, page: pagination.value.currentPage}).then(() => {
                if (errors.value === undefined) {
                    emails.value = response.value.data.data
                    pagination.value.lastPage = response.value.data.last_page;
                }
            })
        }

        function changePage(page)
        {
            pagination.value.currentPage = page;
            loadList();
        }

        onBeforeMount(() => {
            loadList()
        })

        return {
            emails,
            pagination,
            getStatusBadge,
            hasPrevPage,
            hasNextPage,
            deleteEmail,
            loadList,
            changePage
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
