/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('addone-component', require('./components/AddOneComponent.vue').default);
Vue.component('thought-component', require('./components/ThoughtComponent.vue').default);
Vue.component('form-component', require('./components/FormComponent.vue').default);
Vue.component('mythoughts-component', require('./components/MyThoughtsComponent.vue').default);
Vue.component('menu-component', require('./components/MenuComponent.vue').default);

Vue.component('page-component', require('./pagination/PageComponent.vue').default);

Vue.component('home-component', require('./views/HomeComponent.vue').default);
Vue.component('contact-component', require('./views/ContactComponent.vue').default);
Vue.component('page1-component', require('./views/Page1Component.vue').default);
Vue.component('page2-component', require('./views/IncrementComponent.vue').default);

// componente exterior para hacer pagian infinitaa
Vue.component('infinite-loading', require('vue-infinite-loading').default);

// Vue.component('observer', require('./components/Observer.vue').default);


import auth from './mixins/auth';
import router from './routes';

Vue.mixin(auth);

const app = new Vue({
    el: '#app',
    router,
    data: {
        counter : 0        
    }   
});