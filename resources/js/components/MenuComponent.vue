<template>    
    <div class="bg-dark">
        <span class="p-1 m-0 rounded bg-light btn-menu" type="button" aria-controls="navbarSupportedContent" v-on:click="show = !show; fotoPerfil=false;">           
            <div class="border border-primary my-1 bg-menu bg-success rounded col-12"></div>
            <div class="border border-primary my-1 bg-menu bg-success rounded col-12"></div>                      
            <div class="border border-primary my-0 bg-menu bg-success rounded col-12"></div>            
        </span>        
        <div v-if="!show" class="p-0 m-0 bg-light position-fixed fixed-top">
            <!-- Barra superior -->
            <div class="d-flex p-0 m-0 justify-content-end align-content-center">
                 <router-link v-if="seemenu" :to="{name:'menu-home'}" class="mr-3"> 
                    <span>Inicio</span>                   
                    <span class="foto-mini foto-home"></span>                                       
                </router-link>                
                <div>
                    <div class="navbar navbar p-0 m-0 text-left">                                  
                        <div class="nav-link p-0 m-0" v-if="!isAuthenticated">
                            <a class="nav-link p-0 mr-3" href="/login">Login</a>
                        </div>                
                        <div class="nav-link p-0 m-0" v-if="!isAuthenticated">
                            <a class="nav-link p-0 mr-5" href="/register">Registrar</a>
                        </div>                
                        <div class="dropdown p-0 m-0" v-if="isAuthenticated">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle p-0 mr-5" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ user.name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item col-12" v-on:click="onClickLogout">
                                Logout
                                </a>                              
                            </div>
                        </div>                        
                    </div>                    
                </div>               
            </div>           
        </div>
        <!-- foto de perfil ampliada -->
        <div v-if="fotoPerfil" class="p-1 rounded bg-light pb-4 imagen col-10 col-md-7 col-lg-6">
            <div class="text-right text-light p-1">
                <span id="cerrar" class="btn btn-sm btn-secondary p-0 px-2 text-white" v-on:click="fotoPerfil=!fotoPerfil">Cerrar</span>
            </div>
            <img class="rounded col-12" src="/./storage/images/perfil/fotoPerfil.jpg" alt="foto de perfil" title="Alexander">
        </div>
        <div v-if="fotoPerfil" v-on:click="fotoPerfil=!fotoPerfil" class="hg-10-container w-100 bg-gradient position-fixed fixed-top text-center d-flex justify-content-center align-items-center"></div> 
        
        <transition name="fade">           
            <div v-if="show" key="ver-todo" class="lead hg-fixed position-fixed fixed-top col-9 col-md-4 col-lg-2 p-0 pt-4 m-0  text-right text-info bg-light">                
                <!-- MODULO1 -->
                <!-- foto de perfi en circulo -->                
                <div class="rounded-circle foto-perfil">
                    <img v-on:click="fotoPerfil=!fotoPerfil; show=!show" class="bg-dark" src="/./storage/images/perfil/perfil-mini.png" alt="foto de perfil" title="Alexander">
                </div>                
                
                <div v-on:click="show=!show;" class="nav-item d-flex justify-content-between pl-2 pr-1 mb-2 align-items-center border-bottom border-lightgray" >
                    <a class="nav-link font-weight-bold" href="/">{{titulo}}</a>                    
                        <span v-on:click="onclickHome()" class="d-inline-block foto-mini foto-home"></span>                    
                </div>
                
                <!-- =============== Menu de vistas MODULO2 ============================ -->
                <div v-if="seemenu" key="menu">                    
                    <div v-on:click="show=!show; ">
                        <router-link :to="{name:'menu-page1'}" :class="pageActive('/pagina1')" class="links d-flex justify-content-between align-items-center px-2 py-1 my-3 badge-pill">
                            <span>Pagina 1</span>
                            <span class="foto-mini foto-plus"></span>                                       
                        </router-link>
                    </div>
                    <div v-on:click="show=!show; ">
                        <router-link :to="{name:'menu-page2'}" :class="pageActive('/pagina2')" class="links d-flex justify-content-between align-items-center px-2 py-1 my-3 badge-pill">
                            <span>Pagina 2</span>
                            <span class="foto-mini foto-plus"></span>                                                
                        </router-link>
                    </div>
                    <div v-on:click="show=!show; ">
                        <router-link :to="{name:'menu-comments'}" :class="pageActive('/comentarios')" class="links d-flex justify-content-between align-items-center px-2 py-1 my-3 badge-pill">
                            <span>Comentarios</span>
                            <span class="foto-mini foto-guardar"></span>                                                
                        </router-link>
                    </div>
                    <div v-on:click="show=!show; ">
                        <router-link :to="{name:'menu-contact'}" :class="pageActive('/contacto')" class="links d-flex justify-content-between align-items-center px-2 py-1 my-3 badge-pill">
                            <span>Contacto</span>
                            <span class="foto-mini foto-contact"></span>                                                
                        </router-link>
                    </div>
                    <div>
                    	<a class="links d-flex justify-content-between align-items-center px-2 py-1 my-3 badge-pill" href="https://github.com/alexPabon/Vue.js---Laravel-7" target="_blank">
                    		GITHUB
                    		<span class="foto-mini foto-github"></span>
                		</a>                    	
                    </div>
                    <hr>                    
                </div>               
                <!-- =============== fin Menu de vistas ============================ -->
                <!-- MODULO3 -->
                <div>
                    <ul class="d-block text-left">                                
                        <li class="nav-item" v-if="!isAuthenticated">
                            <a class="nav-link" href="/login">Login</a>
                        </li>
                
                            <li class="nav-item" v-if="!isAuthenticated">
                                <a class="nav-link" href="/register">Registrar</a>
                            </li>
                
                        <li class="nav-item dropdown mb-4" v-if="isAuthenticated">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ user.name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item col-12" v-on:click="onClickLogout">
                                Logout
                                </a>                              
                            </div>
                        </li>                        
                    </ul>
                </div>                
            </div>                                                                  
        </transition>
        <transition name="slide-fade">
            <!-- Sombra de pantalla -->
            <div v-if="show" v-on:click="show=!show" class="bg-gradient hg-fixed w-100 fondo-fixed"></div> 
        </transition>
        
    </div>     
</template>


<script>    
    export default {
        props:['titulo','seemenu'],
        data(){
            return {                
               show:false,
               msnInicial:'Pagian Inicial',
               fotoPerfil:false,
               inicio:true,
               inicialUrl: '/',                            
            };
        },
        mounted() { 
                      
            console.log('boton mounted')            
        },
        methods:{
            onclickHome(){                
                window.location.replace('/');
            },
            onClickLogout(){
                axios.post('/logout')
                    .then((response)=>{
                        console.log(response)                                              
                        location.replace('/');
                    })
                    .catch(err =>{
                        let msnErrores = err.response.data;
                        console.log(msnErrores);                         
                    });
            },
            verPath(dir){
                return (window.location.pathname==dir);
            },
            pageActive(dir){
                let pag = window.location.pathname;
                return (pag==dir)?['active']:'';
            },           
        }                
    }
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active {
    transition: opacity .6s   
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0    
    }

    /* Las animaciones de entrada y salida pueden usar */
    /* funciones de espera y duración diferentes.      */
    .slide-fade-enter-active {
        transition: all 0.3s ease;
    }
    .slide-fade-leave-active {
        transition: all .5s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active below version 2.1.8 */ {
        transform: translateX(10px);
        opacity: 0;
    }
    
    .hg-fixed{
        height: 100vh;
        overflow:auto;   
    }
    .fondo-fixed{
        position: fixed;
        left: 0;
        top: 0;
        z-index: 100;
    }       
    .bg-menu{ background: linear-gradient(52deg, #0b012af6, #0853cc);}    
    .w-20-menu{width: 25px; text-align: right; padding: 0;}
    .foto-mini{
        width: 25px;
        height:25px;                                   
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
    } 
    .foto-perfil{
        max-width: 100px;
        max-height: 100px;
        overflow: hidden;
        margin: 3px auto;        
    }

    .foto-perfil img{
        max-width: 500px;
        width: 150px;
        transform: translateX(-14%) translateY(-4%);
        cursor:pointer;
    }

    .imagen{
        position: fixed;
        left: 50%;
        top: 50%;
        z-index: 4001;
        transform: translateX(-50%) translateY(-50%);      
    }    
    .foto-guardar{background-image:url('/./storage/images/guardar2.ico');}
    .foto-contact{background-image:url('/./storage/images/contacto1.ico');}
    .foto-home{background-image:url('/./storage/images/home1.png');}
    .foto-plus{background-image:url('/./storage/images/plus.png');}
    .foto-github{background-image:url('/./storage/images/Github-icon.png');}       

    .btn-menu{
        position: fixed;
        left: 0;
        right: 0;
        width: 50px;
        height: 30px;
        z-index: 2000;        
    }

    .border-lightgray{
        border-color: lightgray;
    }

    .links{
        font-family: sans-serif;
        color: #0277d0;
        text-decoration-line: none;

        transition: color 0.5s ease-in-out, 
            background-color 0.5s ease-in-out, 
            border-color 0.15s ease-in-out, 
            box-shadow 0.15s ease-in-out;
    }

    .links.active{
        background:#c3dfefad;
    }

    .links:hover{
        cursor: pointer;
        font-weight: bold;
        background: #539ee4;
        color:white;
    }

    .links:active{
        cursor: pointer;
        font-weight: bold;
        background: #32015f;
        color:white;
    }

    .btn-menu:hover{background: radial-gradient(#97e5f796, #14d3ffbd);}

    .foto-mini:hover{                
        width: 20px;
        height:20px; 
        cursor: pointer;                  
    }

</style>