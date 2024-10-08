<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checklist;

class ChecklistController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $checklists = $user->checklists; // Mengambil checklist yang dimiliki oleh user

        return response()->json($checklists);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $checklist = Checklist::create([
            'name' => $request->input('name'),
            'user_id' => auth()->user()->id, 
        ]);
    
        return response()->json(['message' => 'Checklist created successfully', 'data' => $checklist], 201);
    }
    

    public function destroy($id)
    {
        $user = auth()->user();
        $checklist = $user->checklists()->find($id); 

        if (!$checklist) {
            return response()->json(['message' => 'Checklist not found or not authorized'], 404);
        }

        $checklist->delete();

        return response()->json(['message' => 'Checklist deleted successfully']);
    }
}
