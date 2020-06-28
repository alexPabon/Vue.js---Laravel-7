<template>
    <div class="bg-blue bg-gradient hg-10-container py-5 px-2">                           
        <h4 class="mt-3 p-2 rounded bg-gradient text-center mt-3">Formulario de contacto</h4>
        <div class="my-3">
            <h2>contacto:</h2>
            <form id="formContacto" autocomplete="off" class="col-12 col-sm-7 col-lg-6 mx-auto border border-light p-3 rounded" method="post" action="" v-on:submit.prevent="contactEmail()">            
                <ul class="list-group p-0">
                    <li class="list-group lead">
                        <b>Alexander Pabon: alepabon@gmail.com</b><br>
                    </li>
                    <li class="list-group py-2">        			
                        <label style="visibility: hidden;" for="nombre">Nombre</label>
                        <input v-on:focus.passive="viewLabel('nombre')" 
                            v-on:blur.passive="verifyInput('nombre')"
                            v-model="nombre"                            
                            class="entradas bg-light form-control" id="nombre" type="text" name="nombre" 
                            placeholder="Nombre" value="">
                        <small class="text-danger" v-for="nombre in errores.nombre" :key="nombre">{{nombre}}</small>
                    </li>
                    <li class="list-group py-2">
                        <label style="visibility: hidden;" for="email">Email</label>                        
                        <input v-on:focus.passive="viewLabel('email')"
                            v-on:blur.passive="verifyInput('email')"
                            v-model="email"
                            class="entradas bg-light form-control" id="email" type="email" name="email" 
                            placeholder="Email" value="">
                        <small class="text-danger" v-for="email in errores.email" :key="email">{{email}}</small>
                    </li>
                    <li class="d-flex justify-content-between p-0 py-2">
                        <div class="col-6 list-group">
                            <label style="visibility: hidden;" for="empresa">Empresa</label>
                            <input v-on:focus.passive="viewLabel('empresa')" 
                                v-on:blur.passive="verifyInput('empresa')"
                                v-model="empresa"
                                class="entradas bg-light form-control border-0" id="empresa" type="text" name="empresa" 
                                placeholder="Empresa" value="">                            
                        </div>
                        <div class="col-6 list-group">
                            <label style="visibility: hidden;" for="tel">Telefono</label>
                            <input v-on:focus.passive="viewLabel('tel')" 
                                v-on:blur.passive="verifyInput('tel')"
                                v-model="tel"
                                class="entradas bg-light form-control border-0" id="tel" type="number" name="tel" 
                                placeholder="Telefono" maxlength="15" value="">                            
                        </div>
                    </li>
                    <li class="list-group py-2">
                        <label style="visibility: hidden;" for="asunto">Asunto</label>
                        <input v-on:focus.passive="viewLabel('asunto')" 
                            v-on:blur.passive="verifyInput('asunto')"
                            v-model="asunto"
                            class="entradas bg-light form-control" id="asunto" type="text" name="asunto" 
                            placeholder="Asunto" value="">
                        <small class="text-danger" v-for="asunto in errores.asunto" :key="asunto">{{asunto}}</small>
                    </li>
                    <li class="list-group py-3">
                        <label style="visibility: hidden;" for="mensaje">Mensaje</label>
                        <textarea v-on:focus.passive="viewLabel('mensaje')" 
                            v-on:blur.passive="verifyInput('mensaje')"
                            v-model="mensaje"
                            id="mensaje" class="entradas bg-light form-control" rows="8" name="mensaje" maxlength="500" 
                            placeholder="Mensaje"></textarea>
                        <small class="text-danger" v-for="mensaje in errores.mensaje" :key="mensaje">{{mensaje}}</small>
                    </li>
                    <li class="list-group p-0 py-2">
                        <div class="d-flex justify-content-left align-content-center">
                            <input v-model="acepto" id="privacidad" class="custom-checkbox" type="checkbox" name="acepto">
                            <label id="condiciones" class="m-0 mx-1" for="acepto">Acepto la <a href=""><b>POLITICA DE PRIVACIDAD</b></a></label>
                        </div>
                        <small class="text-danger" v-for="acepto in errores.acepto" :key="acepto">{{acepto}}</small>                      
                    </li>
                    <li class="list-group">        			
                        <input type="submit" class="mt-2 btn btn-primary" name="contacto" value="Enviar">
                        <input v-on:click="resetInputs" type="reset" class="mt-2 btn btn-secondary" value="Borrar datos">                        
                    </li>                    
                </ul>
            </form>
            <div id="msnError" class="col-12 col-sm-7 col-lg-6 mx-auto p-0"></div>
            <div v-if="mostrarSuccess" v-on:click="mostrarSuccess=!mostrarSuccess" class="col-12 col-sm-7 col-lg-6 mx-auto p-0">
                <p class='alert alert-success m-0'>{{msnSuccess}}</p>
            </div>
            <div v-if="mostrarErrors" v-on:click="mostrarErrors=!mostrarErrors" class="col-12 col-sm-7 col-lg-6 mx-auto p-0">
                <p class='alert alert-danger m-0'>{{msn}}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                pepe:'Mi nombre',
                nombre:'',
                email:'',
                empresa:'',
                tel:'',
                asunto:'',
                mensaje:'',
                acepto:'',
                errores:'',
                msn:'',
                mostrarErrors:false,
                mostrarSuccess:false,
                msnSuccess:'',                
            }
        },
        mounted() {
            console.log('Contact mounted.')
                        
        },
        methods:{
            viewLabel(id){
                let nombeId = document.getElementById(id);
                
                nombeId.previousElementSibling.style.visibility="visible";
                nombeId.removeAttribute('placeholder');                              
            },
            contactEmail(){                
                var formularioContacto = document.getElementById('formContacto');
                var entradas = formContacto.getElementsByClassName('entradas');	
                var errorEntradas = document.getElementById('msnError');                

                var todoCorrecto = true;
                var nombreEntrada = ""
                var privacidad = document.getElementById('privacidad');
                errorEntradas.innerHTML="";	
                this.mostrarSuccess=false;	
                
                for(var i=0; i<entradas.length; i++){
                    if(entradas[i].value ==""){
                        nombreEntrada = entradas[i].getAttribute('name')
                        
                        if(nombreEntrada=="empresa" || nombreEntrada=="tel"){			
                        }else{
                            entradas[i].previousElementSibling.style.visibility="hidden";
                            entradas[i].classList.add('is-invalid');                            
                            todoCorrecto = false;
                            let pepe='';                            
                            errorEntradas.innerHTML="<p class='alert alert-danger m-0'>los campos que estan en rojo son obligatorios</p>";
                        }
                    }
                    else{
                        entradas[i].classList.remove('is-invalid');
                        entradas[i].previousElementSibling.style.visibility="visible";			
                    }
                }

                if(!privacidad.checked){
                    todoCorrecto = false;
                    errorEntradas.innerHTML+="<p class='alert alert-danger m-0'>Debe aceptar la politica de privacidad</p>";
                }

                // Despues de comprobar que todo este correcto, se envia los datos
                // de las entradas
                if(todoCorrecto){
                    const params ={
                        nombre:this.nombre,
                        email:this.email,
                        empresa:this.empresa,
                        tel:this.tel,
                        asunto:this.asunto,
                        mensaje:this.mensaje,
                        acepto:this.acepto?true:'',
                    }                   
                    
                    this.mostrarErrors =false;
                    this.mostrarSuccess=true;
                    this.msnSuccess='Enviando...';
                    
                    axios.post('/contact', params)
                        .then((response)=>{
                            // console.log(response.data.success)
                            this.msnSuccess = response.data.success;                                                        
                            this.mostrarSuccess=true;
                            this.resetInputs();
                        })
                        .catch(err =>{
                            let msnErrores = err.response.data;
                            // console.log(msnErrores);
                            this.errores = msnErrores.errors;
                            this.msn = msnErrores.message;
                            this.mostrarSuccess=false;
                            this.mostrarErrors =true;                                                        
                        });
                }
                    
            },
            verifyInput(valor){                
                let nombeId = document.getElementById(valor);

                if(nombeId.value==""){
                    let valorLabel = nombeId.previousElementSibling.innerHTML;
                    nombeId.previousElementSibling.style.visibility="hidden";
                    nombeId.setAttribute('placeholder',valorLabel);
                }else{
                    nombeId.removeAttribute('placeholder');
                    nombeId.previousElementSibling.style.visibility="visible";
                }
            },
            resetInputs(){
                var formularioContacto = document.getElementById('formContacto');
                var entradas = formContacto.getElementsByClassName('entradas');                

                for(var i=0; i<entradas.length; i++){
                    let valorLabel = entradas[i].previousElementSibling.innerHTML;
                    entradas[i].previousElementSibling.style.visibility="hidden";
                    entradas[i].setAttribute('placeholder',valorLabel);                   
                }

                this.nombre='';
                this.email='';
                this.empresa='';
                this.tel='';
                this.asunto='';
                this.mensaje='';
                this.acepto='';
                this.errores='';
            }            
        }
    }
</script>