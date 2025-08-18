<?php

namespace App\Http\Controllers;
use App\Models\Drop;
use Illuminate\Http\Request;
use App\Models\Category;


class DropController extends Controller
{
     // List all drops
    public function index()
    {
        $drops = Drop::with('category')->get(); // include category details
        return response()->json($drops, 200);
    }

    // View single drop
    public function show($id)
    {
        $drop = Drop::with('category')->findOrFail($id);
        return response()->json($drop, 200);
    }

    // Create a new drop
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'media' => 'nullable|array',
            'campaign_type' => 'nullable|string|max:255',
        ]);

        $drop = Drop::create(array_merge($request->all(), ['user_id' => auth()->id()]));
        return response()->json($drop, 201);
    }

    // Update a drop
    public function update(Request $request, $id)
    {
        $drop = Drop::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'media' => 'nullable|array',
            'campaign_type' => 'nullable|string|max:255',
        ]);

        $drop->update($request->all());
        return response()->json($drop, 200);
    }

    // Delete a drop
    public function destroy($id)
    {
        $drop = Drop::findOrFail($id);
        $drop->delete();
        return response()->json(['message' => 'Drop deleted successfully'], 200);
    }
}
