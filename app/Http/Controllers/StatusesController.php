<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\status\UpdateStatusRequest; 



class StatusesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function store(StoreStatusRequest $request){
        $status = Status::create([            
            'body'=>request('body'),
            'user_id'=> auth()->id()
        ]);

        return $status;
    }

    public function update(UpdateStatusRequest $request, $id){
        
        $status = Status::find($id);
        $status->body = $request->body;
        $status->update();

        return $status;
    }

    public function destroy($id){
        $status = Status::find($id);

        if(!$status->delete())
        abort('503','El servidor no puede responder, intentelo mas tarde');

        $successfullyEntered = ['success'=>'Eliminado'];
        
        return $successfullyEntered;
    }
}
