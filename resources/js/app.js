require('./bootstrap');
 import { createApp, h } from 'vue';
 import { App, plugin } from '@inertiajs/inertia-vue3';

 const el = document.getElementById('app');

 createApp({
    redner: ()=> h(App,{
        initialPage: JSON.parse(el.dataset.page),
        resolveComponent: name => require(`./Pages/${name}`),
    })
 }).use(plugin).mount(el);