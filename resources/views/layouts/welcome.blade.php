<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="App laravel con Vue.js"> 
        <meta name="keywords" content="web, anuncios, laravel, publicar, Alexander, Pabon, pabon,alexander">
        <meta name="author" content="Alexander Pabon">        	

        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}"> 
        
        <meta name="user" content="{{ Auth::user() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- Fonts --}}
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        {{-- Styles --}}
        <link rel="stylesheet" href="{{asset('./css/app.css')}}">
       <style>
       
       </style>
        
    </head>
    <body>        
        <div id="app" class="imagenFondo">
        	<header>
        		<menu-component titulo="{{ config('app.name', 'Laravel') }}" seemenu="true"></menu-component>
        	</header>                                                              
            <router-view></router-view> 
            
        </div>
        
        <script src="./js/app.js"></script>
    </body>
</html>
