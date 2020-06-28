import Vue from 'vue'
import Router from 'vue-router'
import Base_Pagina1 from './views/Page1Component.vue';
import Base_Pag from './views/IncrementComponent.vue';
import Base_Comentarios from './components/MyThoughtsComponent.vue';
import Base_Contacto from './views/ContactComponent.vue';

Vue.use(Router)

export default new Router({
    routes:[
        {
            path:'/',
            name:'menu-home',
            component: ()=>import(/*webpackChunkName:"menu-home"*/'./views/HomeComponent.vue')
        },
        {
            path:'/pagina1',
            name:'menu-page1',
            component: ()=>import(/*webpackChunkName:"menu-page1"*/'./views/Page1Component.vue')
        },
        {
            path:'/pagina2',
            name:'menu-page2',
            component: ()=>import(/*webpackChunkName:"menu-page2"*/'./views/IncrementComponent.vue')
        },
        {
            path:'/comentarios',
            name:'menu-comments',
            component: ()=>import(/*webpackChunkName:"menu-comments"*/'./components/MyThoughtsComponent.vue')
        },
        {
            path:'/contacto',
            name:'menu-contact',
            component: ()=>import(/*webpackChunkName:"menu-contact"*/'./views/ContactComponent.vue')
        }
    ],
    mode: 'history'
})