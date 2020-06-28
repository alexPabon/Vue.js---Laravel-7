<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use phpDocumentor\Reflection\Types\This;
use Tests\TestCase;

class CreateStatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_users_can_not_create_statuses(){        

        // 2.When=>cuando hace un post request a status
        $response = $this->post(route('statuses.store'),['body'=>'Mi primer status']);
                
        $response->assertRedirect('login');            
    }

    /** @test */
    public function user_can_create_statuses(){
        
        // Evitar que laravel maneje las excepciones
        $this->withoutExceptionHandling();

        // 1.Given=>teniendo un usuario autenticado
            $user = factory(User::class)->create();
            $this->actingAs($user);     //que el usuario tenga su sesion activa

        // 2.When=>cuando hace un post request a status
        $response = $this->post(route('statuses.store'),['body'=>'Mi primer status']);

        $response->assertJson(['body'=>'Mi primer status']);

        // Then=>Entonces veo un nuevo estado en la base de datos
        $this->assertDatabaseHas('statuses',[
            'user_id'=>$user->id,
            'body'=>'Mi primer status'
        ]);    //verificar datos en la base de datos
    }

    /**
     *______________________________________________________________________
     * Probando las reglas de validacion
     *======================================================================
     * por cada regla de validacion debemos crear un test
     * 
     * 'body'=>'required|min:3|max:20'
     *
     */
    
    /** @test */
    public function create_a_status_requires_body(){
        
        $user = factory(User::class)->create();
        $this->actingAs($user);     //que el usuario tenga su sesion activa

        
        $response = $this->postJson(route('statuses.store'),['body'=>'']);
                                                        

        // dd($response->getContent());
        
        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors'=>[
                'body'
            ]
        ]);
    }

    /** @test */
    public function create_a_status_body_requiress_a_minimum_length(){
        
        $user = factory(User::class)->create();
        $this->actingAs($user);     //que el usuario tenga su sesion activa

        
        $response = $this->postJson(route('statuses.store'),['body'=>'jp']);
                                                        

        // dd($response->getContent());
        
        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors'=>[
                'body'
            ]
        ]);
    }

    /** @test */
    public function create_a_status_body_requiress_a_maximum_length(){
        
        $user = factory(User::class)->create();
        $this->actingAs($user);     //que el usuario tenga su sesion activa

        
        $response = $this->postJson(route('statuses.store'),['body'=>'kdkdkkdkdkkdkdkkdddkdk']);
                                                        

        // dd($response->getContent());
        
        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors'=>[
                'body'
            ]
        ]);
    }

    /**
     * ================== FIN REGLA DE VALIDACION BODY ========================
     */
}
