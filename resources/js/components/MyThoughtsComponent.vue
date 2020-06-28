<template>        
    <div id="coment" class="bg-indigo bg-gradient hg-10-container px-2 py-4">                    
        <h2 class="text-center bg-gradient p-3 badge-pill">CRUD para subir Comentarios</h2>        
        <form-component
            @new="addThought">            
        </form-component>         
        <div v-if="isAuthenticated"> 
            <div class="container">
                <nav aria-label="Page navigation">                    
                    <ul class="pagination mt-2">
                        <li class="page-item" v-if="!(currentPage<=1)" v-on:click="goPage(currentPage-1)">
                            <a class="page-link" href="#" aria-label="Previous"  v-on:click.prevent>
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>

                        <page-component 
                            v-for="num in lastPage" 
                            :key="num"
                            :class="pageCurrentActive(num)"
                            :num="num"
                            @go="goPage">
                        </page-component>
                        
                        <li class="page-item" v-if="!(currentPage>=lastPage)" v-on:click="goPage(currentPage+1)">
                            <a class="page-link" href="#" aria-label="Next"  v-on:click.prevent>
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                    <p class="p-0 m-0 lead font-weight-bold">Comentario: {{from}} de {{total}}</p>   
                </nav>                    
            </div> 
                      
            <transition-group name="slide-fade">                   
                <thought-component                
                    v-for="(thought,index) in thoughts" 
                    :key="thought.id"
                    :thought="thought"                                              
                    @delete="deleteThought(index, ...arguments)">
                </thought-component>                                            
            </transition-group> 
            <div align="center">{{msnErro}}</div>          
            <infinite-loading @infinite="infiniteHandler">                
                <div slot="no-more">-- No hay mas comentarios --</div>
                <div slot="spinner">Cargando...</div>
                <div slot="no-results">Sin resultados</div>
            </infinite-loading>
            <!-- <observer v-on:intersect="intersected" /> --> 
            
        </div>
    </div>
        
    
</template>

<script>        
    export default {           
        data() {
            return {
                // array vacio de comentarios que se llenara con la respuesta get
                thoughts:[] ,
                thoughtsPage:[],
                verifyPage:false,
                page:1,                
                currentPage:1,                
                lastPage:1,
                from:'',
                total:'',
                msnErro:''
            }
        },        
        mounted() {

            console.log('MyThoughts mounted');            
        },
        methods: {
            pageCurrentActive(page){
                return (this.currentPage==page)?['active']:'';
            },
            goPage(nPage){
                axios.get(`/thought?page=${nPage}`)
                    .then((response)=>{
                        this.thoughts = response.data.data
                        this.page=nPage;
                        this.lastPage = response.data.last_page;
                        this.currentPage=response.data.current_page;                        
                        this.from= response.data.from;
                        this.total= response.data.total;
                        this.verifyPage=true;                                            
                    })                
            },
            infiniteHandler($state) { 
                
                // Metodo para hacer que la pagina se recargue sin elegir pagina
                let url = `/thought?page=${this.page++}`;             
                
                if(this.verifyPage){
                    this.thoughts=[];
                    this.verifyPage=false;                    
                }

                axios.get(url)
                .then(response => {
                    let allThoughts = response.data.data;                    

                    if(allThoughts.length){
                        this.thoughts = this.thoughts.concat(allThoughts)
                        $state.loaded()
                    }else{
                        $state.complete()
                        console.log('estado completo');
                    }                   
                    
                    // Modifamos los valores con los de response.data
                    this.lastPage = response.data.last_page;                    
                    this.total= response.data.total;
                    if(response.data.current_page<=response.data.last_page){
                        this.from= response.data.from;
                        this.currentPage=response.data.current_page;
                    }                                                                   
                    
                    // console.log('respuesta del servidor /thought');
                    // console.log(response.data);                    
                })
                .catch(err =>{
                        let msnErrores = err.response.data;
                        console.log('errores al cargar comentarios');                        
                        console.log(msnErrores);                         
                        this.msnErro='Error al cargar los comentarios';
                        this.msnErro+=err.response.data.message;                        

                        if(err.response.status==403)
                            location.replace('/home');
                    });                
            },                    
            intersected(){
                // Otro metodo para que la pagina se recarge sin elegir pagina
                /** Esta comentado el componente para que funcione, solo debe 
                 *  actuar un metodo, intersed() o infiniteHandler($state),
                 *  de lo contrario habra un error de duplicidad de id.
                 */
                console.log('enviado desde my thoughts');
                
                axios.get(`/thought?page=${this.page++}`)
                .then((response)=>{
                    this.thoughts = response.data.data
                    console.log(this.thoughts);
                    
                    console.log('GET MyThoughts bajando.');
                    // console.log(response.data);
                    console.log(response.data.per_page);
                                          
                })                
            },
            addThought(thought){
                /** Añadir elemento al final del array */
                // this.thoughts.push(thought);

                /**Añadir elemento al principio del array, se puede añadir mas de 1 elemento. */
                this.thoughts.unshift(thought);
                this.total++;
            },           
            deleteThought(index,thought){
                
                axios.delete('/thought/'+thought)
                .then((response)=>{                    
                    this.thoughts.splice(index, 1);
                    this.total--;
                    console.log('DELETE MyThoughts mounted.')
                });
            }           
        }
    }
</script>

<style scoped>
    /** Las animaciones de entrada y salida pueden usar 
    * funciones de espera y duración diferentes.
    */
    
    .slide-fade-enter-active {
    transition: all .5s ease;
    }
    .slide-fade-leave-active {
    transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
    /* .slide-fade-leave-active below version 2.1.8 */ {
    transform: translateX(10px);
    opacity: 0;
    }
</style>