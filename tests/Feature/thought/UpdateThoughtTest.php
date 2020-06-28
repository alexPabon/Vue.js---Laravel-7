<?php

namespace Tests\Feature\thought;

use App\Thought;
use App\User;
use Faker\Factory;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateThoughtTest extends TestCase
{
    use RefreshDatabase; 
    use WithFaker;   

    /**
     * authenticate user
     *  @test */
    public function guest_users_can_not_update_thoughts(){        

        // 2.When=>cuando hace un put request a thought
        $response = $this->put(route('thought.update',1),['body'=>'Mi primer thought']);
                
        $response->assertRedirect('login');            
    }

    /** @test */
    public function user_can_update_thoughts(){
        
        // Evitar que laravel maneje las excepciones
        $this->withoutExceptionHandling();

        // 1.Given=>teniendo un usuario autenticado
            $user = factory(User::class)->create();
            $this->actingAs($user);     //que el usuario tenga su sesion activa

            // 1.1 teniendo un comentario
            $thought = factory(Thought::class)
                        ->create([
                            'user_id'=>$user->id,
                            'description'=>'Mi primer description'
                        ]);           

            // dd($thought);

        // 2.When=>cuando hace un put request a thought
        $response = $this->put(route('thought.update',$thought->id),['description'=>'Actualizando thought']);
        
        // dd($response->content());
        $response->assertJson(['description'=>'Actualizando thought']);

        // Then=>Entonces veo un nuevo estado en la base de datos
        $this->assertDatabaseHas('thoughts',[
            'user_id'=>$user->id,
            'description'=>'Actualizando thought'
        ]);    //verificar datos en la base de datos
    }

    /**
     *______________________________________________________________________
     * Probando las reglas de validacion
     *======================================================================
     * por cada regla de validacion debemos crear un test
     * 
     * 'description'=> 'required|string|min:5'
     *
    */
    
    /**
     * 'description'=>required
     *  @test */
    public function update_a_thought_requires_description(){
        
        $user = factory(User::class)->create();
        $this->actingAs($user);     //que el usuario tenga su sesion activa

        $thought = factory(Thought::class)
                    ->create([
                        'user_id'=>$user->id,
                        'description'=>'Mi primer description'
        ]);

        $response = $this->putJson(route('thought.update',$thought->id),['description'=>'']);                                                       

        // dd($response->getContent());
        
        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors'=>[
                'description'
            ]
        ]);
    }

    /**
     * 'description'=>string
     *  @test */
    public function update_a_thought_string_description(){
        
        $user = factory(User::class)->create();
        $this->actingAs($user);     //que el usuario tenga su sesion activa

        $thought = factory(Thought::class)
                    ->create([
                        'user_id'=>$user->id,
                        'description'=>'Mi primer description'
        ]);

        $response = $this->putJson(route('thought.update',$thought->id),['description'=>22]);                                                       

        // dd($response->getContent());
        
        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors'=>[
                'description'
            ]
        ]);
    }

    /**
     * 'description'=>min:5
     *  @test */
    public function update_a_thought_description_requiress_a_minimum_length(){
        
        $user = factory(User::class)->create();
        $this->actingAs($user);     //que el usuario tenga su sesion activa

        $thought = factory(Thought::class)
                    ->create([
                        'user_id'=>$user->id,
                        'description'=>'Mi primer description'
        ]);

        $response = $this->putJson(route('thought.update',$thought->id),['description'=>'fsff']);                                                       

        // dd($response->getContent());
        
        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors'=>[
                'description'
            ]
        ]);
    }
    
     /**
     * 'description'=>max:700
     *  @test */
    public function update_a_thought_description_requiress_a_maximum_length(){
        
        $user = factory(User::class)->create();
        $this->actingAs($user);     //que el usuario tenga su sesion activa

        $thought = factory(Thought::class)
                    ->create([
                        'user_id'=>$user->id,
                        'description'=>'Mi primer description'
        ]);       

        $textFaker = $this->faker()->text($minNbChars=900);
        $pepe = strlen($textFaker);
        // dd($pepe);
        $response = $this->putJson(route('thought.update',$thought->id),['description'=>$textFaker]);                                                       

        // dd($response->getContent());
        
        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors'=>[
                'description'
            ]
        ]);
    }
    
    //================== FIN REGLA DE VALIDACION description ========================

    /**
     * _________________________________________________________________
     * Comprobano las policies
     * =================================================================
     * Comprobar que el comentario que se actualiza pertenece al usuario
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
        $response = $this->put(route('thought.update',$thought->id),['description'=>'Actualizando thought']);
        
        // dd($response->content());
        $response->assertStatus(403);        
    }

    //================== FIN POLICIES ==================================
}
