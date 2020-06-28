<?php

namespace Tests\Feature\status;

use App\User;
use App\models\Status;
use Faker\Factory;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DestroyStatusTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function guest_users_can_not_destroy_statuses(){
        
        // 2.When=>cuando hace un delete request a status
        $response = $this->delete(route('statuses.destroy',1));
           
        
        $response->assertRedirect('login'); 
    }

    /** @test */
    public function user_can_destroy_statuses(){
        
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
        $response = $this->delete(route('statuses.destroy',$status->id));        
        
        $response->assertJson(['success'=>'Eliminado']);

        // Then=>Entonces veo un nuevo estado en la base de datos
        $this->assertDatabaseMissing('statuses',[
            'id'=>$status->id,
            'user_id'=>$user->id,
            'body'=>'Mi primer status'
        ]);    //verificar datos en la base de datos)        
    }
}
