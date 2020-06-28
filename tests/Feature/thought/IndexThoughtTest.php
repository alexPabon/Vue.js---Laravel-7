<?php

namespace Tests\Feature\thought;

use App\Thought;
use App\User;
use Faker\Factory;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexThoughtTest extends TestCase
{
    use RefreshDatabase;

    /**
    * Authenticate user
    *  @test */
    public function guest_users_can_not_see_thoughts(){        

        // 2.When=>cuando hace un get request a thought
        $response = $this->get(route('thought.index'));
                
        $response->assertRedirect('login');            
    }

    /**
     * view thoughts
     *  @test*/
    public function a_guest_can_see_the_thoughts(){

        $user = factory(User::class)->create();
        $this->actingAs($user);
        $thought = factory(Thought::class)->create(['user_id'=>$user->id]);        
        
        $response = $this->get(route('thought.index'));

        // dd($response->assertJson([]));

        $response->assertJson([            
            'data'=>[
                [
                    'id'=>$thought->id,
                    'description'=>$thought->description,            
                    'user_id'=>$user->id,
                    'contact'=>[
                        'name'=>$user->name,
                        'email'=>$user->email,
                    ]
                ],
            ],
        ]);
    }
}
