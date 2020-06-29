<template>
    <div class="mx-auto container mt-2">              
        <div class="row justify-content-center text-dark">
            <div class="mx-auto col-md-8">
                <div class="card lead">
                    <div class="panel-heading border" v-if="user.id==thought.user_id">
                        <span class="pl-3 pr-1 m-0 bg-dark text-light d-inline-block col-12 text-center font-weight-bold">Mi comentario</span>                        
                    </div>
                    <div v-else>
                        <span class="pl-3 pr-1 m-0 bg-light-blue d-inline-block">Comentario escrito por:</span>
                        <strong class="p-0 m-0 text-primary">{{thought.contact.name}}   &nbsp; </strong>                            
                    </div>
                    <div class="panel-heading border">
                        <span class="pl-3 pr-1 m-0 bg-light-blue d-inline-block">Publicado en:</span>
                        <strong class="p-0 px-1 m-0">{{thought.created_at}}</strong>
                    </div>                    

                    <div class="panel-body bg-pink bg-light border p-3" v-if="editMode">
                        <input type="text" class="form-control" v-model="thought.description">
                        <div class="pt-3 text-danger" v-if="mostrarErrors">                    
                            <small class="p-0 m-0">-{{msn}}</small>                    
                            <div v-for="value in errores">
                                <small class="p-0 m-0 d-block" v-for="err in value" :key="err">- {{err}} </small>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body border p-2" v-else>
                        <input type="text" class="form-control" v-if="editMode" v-model="thought.description">
                        <p class="text-justify">
                            {{thought.description}}
                        </p>                        
                    </div>
                    <div class="panel-footer p-2 text-center text-md-left" v-if="user.id==thought.user_id">                        
                        <div v-if="editMode">
                            <button class="col-11 col-md-5 col-lg-3 btn-gradient btn btn-success m-1" v-on:click="onClickUpdate">Guardar cambios</button>
                            <button class="col-11 col-md-5 col-lg-3 btn-gradient btn btn-secondary m-1" v-on:click="onClickCancel">Cancelar</button>
                        </div>
                        <div v-else>    
                            <button class="col-11 col-md-5 col-lg-3 btn-gradient btn btn-primary m-1" v-on:click="onClickEdit">Editar</button>                        
                            <button class="col-11 col-md-4 col-lg-3 btn-gradient btn btn-danger m-1" v-on:click="onClickDelete()">Eliminar</button>
                        </div>                                                
                    </div>
                </div>
            </div>
        </div>        
    </div>
</template>

<script>
    export default {
        props:['thought'],
        data(){
            return {                
                editMode:false,
                errores:'',
                msn:'',
                mostrarErrors:false,                                
            };
        },
        mounted() {
            console.log('thought mounted.')            
        },
        methods:{
            onClickDelete(){
                this.$emit('delete',this.thought.id);                
            },
            onClickEdit(){
                this.mostrarErrors =false;
                this.editMode = true;
            },
            onClickUpdate(){                 
               
                this.editMode = false; 
                
                axios.put('/thought/'+this.thought.id,this.thought)
                    .then((response)=>{                                        
                        this.thought.description = response.data.description;                                                                                   
                        console.log('update MyThoughts mounted.')                        
                    })
                    .catch(err =>{
                        let msnErrores = err.response.data;
                        console.log(msnErrores);
                        this.errores = msnErrores.errors;
                        this.msn = msnErrores.message;
                        
                        this.mostrarErrors =true;
                        this.editMode=true;
                    });
            },
            onClickCancel(){
                this.thought.description ='';
                this.editMode = false;

                axios.get('/thought/'+this.thought.id)
                    .then((response)=>{                                        
                        this.thought.description = response.data.description;                                                                                   
                        console.log('update MyThoughts mounted.')
                        console.log(response.data);
                    })
                    .catch(err =>{
                        let msnErrores = err.response.data;
                        console.log(msnErrores);
                        this.errores = msnErrores.errors;
                        this.msn = msnErrores.message;
                        
                        this.mostrarErrors =true;
                        this.editMode=true;
                    });                
            }
        }
    }
</script>