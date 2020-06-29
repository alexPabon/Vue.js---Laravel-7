<template>
    <div class="hg-10-container bg-gradient pt-5 bg-blue">
        <div class="container">
            <h2 class="text-center bg-gradient bg-purple border border-secondary rounded">Pagina de Ejemplo para implementar componentes <b class="font-weight-bold h1">Vue.js</b> en <b class="font-weight-bold h1">Laravel</b></h2>
            <div class="container bg-gradient bg-info p-3 rounded">               
                <p class="p-2 lead text-justify">
                   Vue ofrece una variedad de maneras para aplicar efectos de transición cuando los elementos son
                   insertados, actualizados o eliminados del DOM. Este Framework de Javascript incluye herramientas para:
                </p>
                <ul class="p-0 pl-4">
                    <li>
                        aplicar clases para transiciones y animaciones CSS automáticamente
                    </li>
                    <li>
                        integrar librerías externas de animación CSS, por ejemplo Animate.css
                    </li>
                    <li>
                        usar JavaScript para manipular directamente el DOM durante hooks de transición                        
                    </li>
                    <li>
                        integrar librerías externas de animación por JavaScript, como Velocity.js
                    </li>
                </ul>
                <p class="lead text-justify">En esta pagina vamos a implementar componentes de Vue para crear un CRUD para comentarios</p>
                <div class="p-2 bg-light-blue bg-gradient rounded">
                    <h5>Que encotraremos en esta interfaz:</h5>
                    
                    <ul class="p-0 pl-4">
                        <li>
                            <span>Un menu lateral con las vistas Vue</span>
                        </li>
                        <li>
                            <span>Se ha definido las Vue Router</span>
                        </li>
                        <li>
                            <span>La base de datos es con SQLITE, por su facil portabildad</span>    
                        </li>                        
                        <li>
                            <router-link :to="{name:'menu-page1'}">
                                <span>Una vista de ejemplo insertando un componente vue</span>
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{name:'menu-page2'}">
                                <span>Una vista con un componente reactivo</span>
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{name:'menu-comments'}">
                                <span>CRUD de comentarios</span><small>(debes de estar registrado)</small>
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{name:'menu-contact'}">
                                <span>Un vista de contacto</span>
                            </router-link>
                        </li>
                        <li>
                            <span>Antes de subir a produccion, se realiza pruebas con PHPUNIT</span>
                        </li>
                    </ul>
                </div>
                <P class="py-2 lead text-justify">
                	Puedes ver mas informacion en el repositrio 
                	<a class="link font-weight-bold" href="https://github.com/alexPabon/Vue.js---Laravel-7" target="_blank">GITHUB</a>
            	</P>
            </div>
        </div>
    </div>
</template>

<script>
export default {
   
}
</script>