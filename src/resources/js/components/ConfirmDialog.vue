<template>
    <div class="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ text }}</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button @click="closeDialog(false)" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    <button @click="closeDialog()" type="button" class="btn btn-danger">Tak</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue';
import {closeDialog} from 'vue3-promise-dialog';

export default defineComponent({
    props: {
        title: {
            type: String
        },
        text: {
            type: String
        }
    },
    setup() {
        function returnValue() {
            return true;
        }
        return {
            returnValue,
            closeDialog
        };
    }
});
</script>

<style scoped>
.dialog {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.3);
}

.center {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 20px;
}

.btn {
    margin: 10px;
}
</style>
