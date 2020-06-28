<?php

namespace Tests\Feature\status;

use App\models\Status;
use App\User;
use Faker\Factory;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateStatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_users_can_not_update_statuses(){        

        // 2.When=>cuando hace un put request a status
        $response = $this->put(route('statuses.update',1),['body'=>'Mi primer status']);
                
        $response->assertRedirect('login');            
    }

    /** @test */
    public function user_can_update_statuses(){
        
        // Evitar que laravel maneje las excepciones
        $this->withoutExceptionHandling();

        // 1.Given=>teniendo un usuario autenticado
            $user = factory(User::class)->create();
            $this->actingAs($user);     //que el usuario tenga su sesion activa

            // 1.1 teniendo un estatus
            $status = factory(Status::class)
                        ->create([
                            'user_id'=>$user->id,
                            'body'=>'Mi primer status'
                        ]);           

            // dd($status);

        // 2.When=>cuando hace un put request a status
        $response = $this->put(route('statuses.update',$status->id),['body'=>'Actualizando status']);
        
        // dd($response->content());
        $response->assertJson(['body'=>'Actualizando status']);

        // Then=>Entonces veo un nuevo estado en la base de datos
        $this->assertDatabaseHas('statuses',[
            'user_id'=>$user->id,
            'body'=>'Actualizando status'
        ]);    //verificar datos en la base de datos
    }

    /**
     *______________________________________________________________________
     * Probando las reglas de validacion
     *======================================================================
     * por cada regla de validacion debemos crear un test
     * 
     * 'body'=>'required|min:3|max:30'
     *
    */
    
    /** @test */
    public function update_a_status_requires_body(){
        
        $user = factory(User::class)->create();
        $this->actingAs($user);     //que el usuario tenga su sesion activa

        $status = factory(Status::class)
                        ->create([
                            'user_id'=>$user->id,
                            'body'=>'Mi primer status'
                        ]);

        
        $response = $this->putJson(route('statuses.update',$status->id),['body'=>'']);
                                                        

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
    public function update_a_status_body_requiress_a_minimum_length(){
        
        $user = factory(User::class)->create();
        $this->actingAs($user);     //que el usuario tenga su sesion activa

        $status = factory(Status::class)
                        ->create([
                            'user_id'=>$user->id,
                            'body'=>'Mi primer status'
                        ]);
        
        $response = $this->putJson(route('statuses.update',$status->id),['body'=>'jp']);
                                                        

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
    public function update_a_status_body_requiress_a_maximum_length(){
        
        $user = factory(User::class)->create();
        $this->actingAs($user);     //que el usuario tenga su sesion activa

        $status = factory(Status::class)
                        ->create([
                            'user_id'=>$user->id,
                            'body'=>'Mi primer status'
                        ]);
        
        $response = $this->putJson(route('statuses.update',$status->id),['body'=>'kdkdkkdkdkkdkdkkdddkdkkdkdkkdkdkkdkdkkdddkdk']);
                                                        

        // dd($response->getContent());
        
        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors'=>[
                'body'
            ]
        ]);
    }

    
    //================== FIN REGLA DE VALIDACION BODY ========================
    
}
