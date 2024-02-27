<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Validator;

class ApiTodoController extends Controller
{


    public function index()
    {
        $todos = Todo::latest()->get();

        $name = [ 
            'name'=> 'becouif',
            'others' => $todos
        ];

        $data = [
            'status'=> 200,
            'message' => $name,
        ];
        return response()->json($data,200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'todo' => 'required|string',
        ]);

        // this fail method/function only works on validator 
        // read more about it 
        if($validator->fails()){
            return response()->json('(todo) is not validated',422);
        } else {
            $userTodo = $request->get('todo');

            $todo = Todo::create([
                'todo' => $userTodo
            ]);

            // check to see if creating operation is successfull 

            if(!$todo){
                return response()->json('Unable to save todo to database try again later',422);
            } else {
                return response()->json([
                    'status' => 200,
                    'message'=> 'todo successfully added'
                ],200);
            }

            
    //    close bracket for the end of if validator      
        }

    }

    public function delete(string $id)
    {
        
        $todo = Todo::find($id);
        $todo->delete();
        return response()->json('deleted succesfull',200);
    }
}
