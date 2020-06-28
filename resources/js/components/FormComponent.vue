<template>
    <div class="container" v-if="isAuthenticated">        
        <div class="card text-dark p-3">                      
            <form action="" v-on:submit.prevent="newThought()">
                <div class="form-group">
                    <label for="thought font-italic">Escribe tu comentario:</label>
                    <input type="text" class="form-control" name="thought" v-model="description">
                </div>
                <transition name="bounce">
                <button v-if="show" v-on:click="show=!show"  type="submint" class="btn btn-primary btn-gradient">Publicar Comentario</button>                
                </transition>
                <div class="pt-3 text-danger" v-if="mostrarErrors">                    
                    <small class="p-0 px-2 m-0 bg-warning rounded">{{msn}}</small>                    
                    <div v-for="value in errores">
                        <small class="p-0 pl-3 m-0 d-block" v-for="err in value" :key="err">- {{err}} </small>
                    </div>
                </div>
            </form>            
        </div>        
    </div>
    <div v-else class="text-center p-0 py-2">
        <a class="text-center bg-gradient py-2 px-3 bg-danger badge-pill" href="/login">Inicia sesion para ver este contenido</a>
    </div>
    
</template>

<script>
    export default {
        data(){
            return {
                description:'',
                errores:'',
                msn:'',
                show:true,
                mostrarErrors:false
            }
        },
        mounted() {
            console.log('form mounted.')
        },
        methods:{
            newThought(){

                const params ={
                    description: this.description
                }               
                
                this.mostrarErrors =false;
                
                axios.post('/thought', params)
                    .then((response)=>{
                        console.log('response')
                        const thought = response.data;
                        this.$emit('new',thought);
                        this.description='';
                        this.show=true;
                    })
                    .catch(err =>{
                        let msnErrores = err.response.data;
                        console.log(msnErrores);
                        this.errores = msnErrores.errors;
                        this.msn = msnErrores.message;

                        this.mostrarErrors =true;
                        this.show=true;
                         
                    });

                // let thought = {
                //     id:2,
                //     description: this.description,
                //     create_at:'10/02/2020'
                // };
                                
                
            }
        }
    }
</script>

<style scoped>
.bounce-enter-active {
  animation: bounce-in .5s;
}
.bounce-leave-active {
  animation: bounce-in .5s reverse;
}
@keyframes bounce-in {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(1.5);
  }
  100% {
    transform: scale(1);
  }
}
</style>