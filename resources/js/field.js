Nova.booting((Vue, router, store) => {
  Vue.component('index-text-inline', require('./components/IndexField'))
  Vue.component('detail-text-inline', require('./components/DetailField'))
  Vue.component('form-text-inline', require('./components/FormField'))
})
