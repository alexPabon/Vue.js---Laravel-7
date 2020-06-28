<?php

namespace Tests\Feature\thought;

use App\models\Thought;
use App\User;
use Faker\Factory;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreThoughtTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Authenticate user
     *  @test */
    public function guest_users_can_not_create_thoughts(){        

        // 2.When=>cuando hace un post request a thought
        $response = $this->post(route('thought.store'),['description'=>'Mi primer thought']);
                
        $response->assertRedirect('login');            
    }

    /**
     * create thought
     *  @test */
    public function user_can_create_thoughts(){
        
        // Evitar que laravel maneje las excepciones
        $this->withoutExceptionHandling();

        // 1.Given=>teniendo un usuario autenticado
            $user = factory(User::class)->create();
            $this->actingAs($user);     //que el usuario tenga su sesion activa

        // 2.When=>cuando hace un post request a thought
        $response = $this->post(route('thought.store'),['description'=>'Mi primer thought']);

        $response->assertJson(['description'=>'Mi primer thought']);

        // Then=>Entonces veo un nuevo estado en la base de datos
        $this->assertDatabaseHas('thoughts',[
            'user_id'=>$user->id,
            'description'=>'Mi primer thought'
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
    public function create_a_thought_requires_description(){
        
        $user = factory(User::class)->create();
        $this->actingAs($user);     //que el usuario tenga su sesion activa

        
        $response = $this->postJson(route('thought.store'),['description'=>'']);
                                                        

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
    public function create_a_thought_string_description(){
        
        $user = factory(User::class)->create();
        $this->actingAs($user);     //que el usuario tenga su sesion activa

        
        $response = $this->postJson(route('thought.store'),['description'=>22]);
                                                        

        // dd($response->getContent());        
        
        $response->assertstatus(422);

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
    public function create_a_thought_description_requiress_a_minimum_length(){
        
        $user = factory(User::class)->create();
        $this->actingAs($user);     //que el usuario tenga su sesion activa

        
        $response = $this->postJson(route('thought.store'),['description'=>'jjkp']);
                                                        

        // dd($response->getContent());
        
        $response->assertstatus(422);

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
    public function store_a_thought_description_requiress_a_maximum_length(){
        
        $user = factory(User::class)->create();
        $this->actingAs($user);     //que el usuario tenga su sesion activa              

        $textFaker = $this->faker()->text($minNbChars=900);
        // $pepe = strlen($textFaker);
        // dd($pepe);
        $response = $this->postJson(route('thought.store'),['description'=>$textFaker]);                                                       

        // dd($response->getContent());
        
        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors'=>[
                'description'
            ]
        ]);
    }

    
    // ================== FIN REGLA DE VALIDACION description ========================
     
}
