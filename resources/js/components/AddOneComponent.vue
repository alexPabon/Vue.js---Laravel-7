<template>
    <div class="container">
        <div class="row justify-content-center text-dark">
            <div class="col-md-8">
                <div class="card p-3">
                    <div id="example1">
                        <button v-if="add" class="btn bg-primary btn-gradient text-light mb-2 col-3 col-md-2 col-lg-1" v-on:click="onClickAdd">+</button>
                        <button v-if="subtract" class="btn bg-success btn-gradient text-light mb-2 col-3 col-md-2 col-lg-1" v-on:click="onClickSubtract">-</button>
                        <button class="btn btn-gradient bg-danger text-light mb-2 col-12 col-md-5 col-lg-4" v-on:click="onClickRestart">Reset</button>
                        <p class="lead mt-1">Se ha hecho clic en el botón de arriba <b class="px-3 rounded bg-secondary text-warning">{{cont.contador}}</b> veces.</p>
                        <h5>Creado desde <b>Component.vue</b></h5>
                        <small class="text-info">El contadordor llegara hasta 10</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default{        
        data(){
            return {
                cont:{
                    contador:0,
                },
                add:true,
                subtract:false,
            };
        },
        mounted() {
            console.log('NewComp mounted.')
        },
        methods:{
            onClickAdd(){
                this.cont.contador+=1;

                if(this.cont.contador>0)
                    this.subtract=true;
                
                if(this.cont.contador>=10)
                    this.add=false;                
            },
            onClickSubtract(){
                this.cont.contador-=1;

                if(this.cont.contador<=0)
                    this.subtract=false;

                if(this.cont.contador<=10)
                    this.add=true;
            },
            onClickRestart(){
                this.cont.contador=0;
                this.add=true;
                this.subtract=false;
            }
        }            
    }
    
</script>