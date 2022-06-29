import { createRouter, createWebHistory } from 'vue-router'

import EmailsList from '../views/pages/emails/Index.vue';
import EmailsCreate from '../views/pages/emails/create/Index.vue';
import EmailsShow from '../views/pages/emails/show/Index.vue';

const routes = [
    {
        path: '/',
        name: 'emails.list',
        component: EmailsList,
        meta: {
            title: 'Lista maili',
            description: 'Lista maili - zadanie rekrutacyjne'
        }
    },
    {
        path: '/create',
        name: 'emails.create',
        component: EmailsCreate,
        meta: {
            title: 'Dodaj nowy email',
            description: 'Nowy email - zadanie rekrutacyjne'
        }
    },
    {
        path: '/show/:id',
        name: 'emails.show',
        component: EmailsShow,
        meta: {
            title: 'Podgląd maila',
            description: 'Podgląd maila - zadanie rekrutacyjne'
        }
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((toRoute, fromRoute, next) => {

    window.scrollTo(0, 0);
    window.document.title = toRoute.meta && toRoute.meta.title ? toRoute.meta.title : 'Sempai test';
    window.document.querySelector('head meta[name="description"]')
        .setAttribute(
            'content',
            toRoute.meta && toRoute.meta.description ? toRoute.meta.description : 'Zadanie rekrutacyjne'
        );

    next();
})

export default router
