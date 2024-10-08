<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\ChecklistItem;
use Illuminate\Http\Request;

class ChecklistItemController extends Controller
{
    public function index($checklistId)
    {
        $checklist = Checklist::find($checklistId);
        $items = $checklist->checklistItems; // Ambil item checklist yang terkait

        return response()->json($items);
    }

    public function store(Request $request, $checklistId)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
        ]);

        $checklist = Checklist::findOrFail($checklistId); // Pastikan checklist ada

        $item = ChecklistItem::create([
            'checklist_id' => $checklist->id,
            'item_name' => $request->input('item_name'),
        ]);

        return response()->json(['message' => 'Checklist item created successfully', 'data' => $item], 201);
    }

    public function show($checklistId, $itemId)
    {
        $checklist = Checklist::findOrFail($checklistId);
        $item = $checklist->checklistItems()->findOrFail($itemId); // Pastikan item ada dalam checklist

        return response()->json($item);
    }

    public function updateStatus($checklistId, $itemId)
    {
        $checklist = Checklist::findOrFail($checklistId);
        $item = $checklist->checklistItems()->findOrFail($itemId); // Pastikan item ada dalam checklist

        $item->completed = !$item->completed;
        $item->save();

        return response()->json(['message' => 'Checklist item status updated', 'data' => $item]);
    }

    public function destroy($checklistId, $itemId)
    {
        $checklist = Checklist::findOrFail($checklistId);
        $item = $checklist->checklistItems()->findOrFail($itemId); // Pastikan item ada dalam checklist

        $item->delete();

        return response()->json(['message' => 'Checklist item deleted successfully']);
    }

    public function rename(Request $request, $checklistId, $itemId)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
        ]);

        $checklist = Checklist::findOrFail($checklistId);
        $item = $checklist->checklistItems()->findOrFail($itemId); // Pastikan item ada dalam checklist

        $item->item_name = $request->input('item_name');
        $item->save();

        return response()->json(['message' => 'Checklist item renamed successfully', 'data' => $item]);
    }
}
