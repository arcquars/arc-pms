// require('./bootstrap');
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';

window.Calendar = Calendar;
window.dayGridPlugin = dayGridPlugin;
window.timeGridPlugin = timeGridPlugin;
window.listPlugin = listPlugin;

// createInertiaApp({
//     resolve: name => {
//
//         const pages = import.meta.glob('./Pages1/**/*.vue', { eager: true })
//         return pages[`./Pages1/${name}.vue`]
//     },
//     setup({ el, App, props, plugin }) {
//         createApp({ render: () => h(App, props) })
//             .use(plugin)
//             .mount(el)
//     },
// })

createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
})
