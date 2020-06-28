<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thought;
use App\User;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\thought\StoreThoughtRequest;

class ThoughtController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $thoughts = Thought::all(); 
        // $thoughts = Thought::orderBy('created_at','DESC')->get();
        $thoughts = Thought::orderBy('created_at','DESC')->paginate(5);
        

       for ($i=0; $i < count($thoughts); $i++) {
           $id = $thoughts[$i]['user_id'];
           $user = User::find($id);
           $contact = [
               'name'=>$user->name,
               'email'=>$user->email
           ];
           $thoughts[$i]['contact'] = $contact;           
       }
      
        return $thoughts;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $thought = Thought::find($id);                
        return $thought;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\thought\StoreThoughtRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreThoughtRequest $request)
    {
        $user = Auth::user();

        $thought = new Thought();
        $thought->user_id = $user->id;
        $thought->description = $request->description;
        $thought->save();        
       
        $contact = [
            'name'=>$user->name,
            'email'=>$user->email,
        ];

        $thought['contact'] = $contact;       
       
        return $thought;
    }   

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\thought\StoreThoughtRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreThoughtRequest $request, $id)    
    {        
        $user = Auth::user()->id;        
        $thought = Thought::find($id);

        if($thought->user_id!=$user)
            abort('403','No autorizado a editar este comentario');

        $thought->description = $request->description;
        $thought->update();

        return $thought;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user()->id;        
        $thought = Thought::find($id);

        if($thought->user_id!=$user)
            abort('403','No autorizado a eliminar este comentario');
                     
        if(!$thought->delete())
            abort('503','El servidor no puede responder, intentelo mas tarde');

        $successfullyEntered = ['success'=>'Eliminado'];
        
        return $successfullyEntered;
    }
}
