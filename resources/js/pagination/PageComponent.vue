<template>     
    <li v-on:click="onClickGoPage(num)" class="page-item">
        <a class="page-link" href="#" v-on:click.prevent>{{num}}</a>
    </li>
</template>

<script>
export default {
    props:['num'],
    methods:{
        onClickGoPage(numberPage){
            this.$emit('go',numberPage);             
        },
    }
}
</script>