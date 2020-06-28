<template>
   <div class="bg-blue bg-gradient hg-10-container p-5" style="width:100vw">
        <p class="lead">
            Pruebas con componentes de vue.js<br>
            Componente en el cual, cada vez que das click en el boton, sumará la cantidad de clicks dados
        </p>

        <addone-component></addone-component>                
        
        <div class="container mt-3 p-2 rounded border border-secondary bg-gradient bg-indigo">
            <h4 class="text-center mt-3">Creado sin renderizar</h4>
            <div class="row justify-content-center text-dark">
                <div class="col-md-8">
                    <div class="card p-3 bg-gradient bg-primary rounded">
                        <div id="example1">
                            <button class="btn bg-primary text-light m-1 col-12 col-md-5 col-lg-4" v-on:click="counter += 1">Add 1</button>
                            <button class="btn btn-gradient bg-danger text-light m-1 col-12 col-md-5 col-lg-4" v-on:click="counter = 0">Reset</button>
                            <p>Se ha hecho clic en el botón de arriba <b class="px-2 bg-dark rounded">{{counter}}</b> veces.</p>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</template>

<script>
export default {
    data(){
        return{
            counter:0,
        };
    }
}
</script>