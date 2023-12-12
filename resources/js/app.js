import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import 'maz-ui/css/main.css'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
// import { VDatePicker } from 'vuetify/labs/VDatePicker'
//  import { VDataTable } from 'vuetify/labs/VDataTable'
// import { VuetifyDateAdapter } from 'vuetify/labs/date/adapters/vuetify'
import MazPhoneNumberInput from 'maz-ui/components/MazPhoneNumberInput'
import {Link} from '@inertiajs/vue3'
import {Head} from '@inertiajs/vue3'
import vue3GoogleLogin from 'vue3-google-login'
import {auth} from './firebase.js'

const vuetify = createVuetify({
    components,
    directives,
    theme: {
      defaultTheme: 'light'
    }
    // date: {
    //   adapter: VuetifyDateAdapter,
    // }
})

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  title: title => `${title} - Guestease`,
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .component('Link', Link)
      .component('Head', Head)
      .component('MazPhoneNumberInput', MazPhoneNumberInput)
      .use(vue3GoogleLogin, {
        clientId: '778324553177-j9gqho3k6qvotg04m4hvcle26mto0vl5.apps.googleusercontent.com'
      })
      .use(vuetify)
      .use(plugin)
      .mount(el)
  },
})