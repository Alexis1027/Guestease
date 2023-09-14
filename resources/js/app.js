import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { VDatePicker } from 'vuetify/labs/VDatePicker'
import {Link} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3'
import vue3GoogleLogin from 'vue3-google-login'

const vuetify = createVuetify({
    components,
    directives,
    // theme: {
    //   defaultTheme: 'dark'
    // }
})

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .component('Link', Link)
      .component('Head', Head)
      .component('VDatePicker', VDatePicker)
      .use(vue3GoogleLogin, {
        clientId: '778324553177-j9gqho3k6qvotg04m4hvcle26mto0vl5.apps.googleusercontent.com'
      })
      .use(vuetify)
      .use(plugin)
      .mount(el)
  },
})