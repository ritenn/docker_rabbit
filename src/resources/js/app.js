import './bootstrap';

import { createApp } from 'vue'
import router from './router'
import App from './views/layout/Index.vue';
import { PromiseDialog } from 'vue3-promise-dialog';
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
const app = createApp(App)

app.use(router)
    .use(PromiseDialog)
    .use(QuillEditor)
    .component('QuillEditor', QuillEditor)
    .mount('#app');
