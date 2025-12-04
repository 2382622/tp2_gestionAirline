import './bootstrap'
import { createApp } from 'vue'
import router from './router'
import App from './App.vue'
import i18n from './i18n'

const app = createApp(App)

app.provide('i18n', i18n)
app.config.globalProperties.$t = i18n.t
app.config.globalProperties.$lang = i18n.lang
app.config.globalProperties.$setLang = i18n.setLang
app.config.globalProperties.$dir = i18n.direction

app.use(router).mount('#app')
