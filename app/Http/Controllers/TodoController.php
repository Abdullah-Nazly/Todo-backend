<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todo = Todo::where('user_id', auth()->id())
            ->select('id', 'title', 'creation_date', 'updated_date', 'status')
            ->get();

        return response()->json($todo);
    }
        
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $todo = Todo::create([
            'user_id' => auth()->id(),
            'title' => $request->input('title'),
            'creation_date' => $request->input('creation_date', now()),
            'updated_date' => null, // ✅ leave empty
            'status' => $request->input('status', false),
        ]);

        return response() -> json ([
            "id" => $todo->id,
            "title" => $todo->title,
            "creation_date" => $todo->creation_date,
            "updated_date" => $todo->updated_date ?? '-', // ✅ show dash if null
            "status" => $todo->status,
        ])->setStatusCode(201, 'Todo created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $todo = Todo::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return response() -> json([
            'id' => $todo->id,
            'title' => $todo->title,
            'creation_date' => $todo->creation_date,
            'updated_date' => $todo->updated_date ?? '-',
            'status' => $todo->status,
        ])->setStatusCode(200, 'Todo retrieved successfully');
    }
        

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $todo = Todo::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $todo = Todo::find($id);
        $todo->title = $request->input('title', $todo->title);
        $todo->creation_date = $request->input('creation_date', $todo->creation_date);
        $todo->updated_date = now();
        $todo->status = $request->input('status', $todo->status);
        $todo->save();

        return response() -> json([
            'id' => $todo->id,
            'title' => $todo->title,
            'creation_date' => $todo->creation_date,
            'updated_date' => $todo->updated_date ?? '-',
            'status' => $todo->status,
        ])->setStatusCode(200, 'Todo updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {   
        $todo = Todo::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $todo->delete();

        return response()->json(['message' => 'Todo deleted successfully']);
        
    }
}
