<?php

namespace Tests\Feature\thought;

use App\User;
use App\Thought;
use Faker\Factory;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DestroyThoughtTest extends TestCase
{
    use RefreshDatabase;

    /**
     * authenticate user
     *  @test */
    public function guest_users_can_not_destroy_thoughts(){
        
        // 2.When=>cuando hace un delete a thought
        $response = $this->delete(route('thought.destroy',1));
           
        
        $response->assertRedirect('login'); 
    }

    /**
     * delete thought
     *  @test */
    public function user_can_destroy_thoughts(){
        
        // Evitar que laravel maneje las excepciones
        $this->withoutExceptionHandling();

        // 1.Given=>teniendo un usuario autenticado
            $user = factory(User::class)->create();
            $this->actingAs($user);     //que el usuario tenga su sesion activa

            // 1.1 teniendo un thought
            $thought = factory(Thought::class)
                        ->create([
                            'user_id'=>$user->id,
                            'description'=>'Mi primer thought'
                        ]);           

            // dd($thought);

        // 2.When=>cuando hace un put request a thought
        $response = $this->delete(route('thought.destroy',$thought->id));        
        
        $response->assertJson(['success'=>'Eliminado']);

        // Then=>Entonces veo un nuevo estado en la base de datos
        $this->assertDatabaseMissing('thoughts',[
            'id'=>$thought->id,
            'user_id'=>$user->id,
            'description'=>'Mi primer thought'
        ]);    //verificar datos en la base de datos        
    }

    
    /**
     * _________________________________________________________________
     * Comprobano las policies
     * =================================================================
     * Comprobar que el comentario que se elimina pertenece al usuario
     * 
     * Si no corresponde, el error será el 403
     * 
    */
    
    /**
     * Policies 
    * @test */
    public function update_a_thought_of_different_owner(){       

        // 1.Given=>teniendo un usuario autenticado
            $user = factory(User::class)->create();
            $this->actingAs($user);     //que el usuario tenga su sesion activa


            // 1.1 teniendo un comentario con otro usuario
            $anotherUser = factory(User::class)->create();
            $thought = factory(Thought::class)
                        ->create([
                            'user_id'=>$anotherUser->id,
                            'description'=>'Mi primer description'
                        ]);           

            // dd($thought);

        // 2.When=>cuando hace un put request a thought
        $response = $this->delete(route('thought.destroy',$thought->id));
        
        // dd($response->content());
        $response->assertStatus(403);        
    }

    //================== FIN POLICIES ==================================
}
