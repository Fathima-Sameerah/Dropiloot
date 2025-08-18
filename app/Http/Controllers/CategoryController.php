<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Drop;
use Illuminate\Http\Request;




class CategoryController extends Controller
{
    // Get all categories
    public function index()
    {
        return response()->json(Category::all(), 200);
    }

    // Assign category to a drop
    public function assign(Request $request, $dropId)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id'
        ]);

        $drop = Drop::findOrFail($dropId);
        $drop->category_id = $request->category_id;
        $drop->save();

        return response()->json([
            'message' => 'Category assigned successfully',
            'drop' => $drop
        ], 200);
    }

}
