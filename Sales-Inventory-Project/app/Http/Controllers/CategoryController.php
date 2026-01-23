<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function categoryPage()
    {
        return view('pages.dashboard.catagory-page');
    }

    // Single users all category
    public function categoryList(Request $request)
    {
        $user_id = $request->header('user_id');

        try {
            $categories = Category::where('user_id', $user_id)->get();
            return response()->json([
                'status' => 'success',
                'data' => $categories
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to retrieve categories'
            ], 500);
        }
    }

    //Create category
    public function createCategory(Request $request)
    {
        $user_id = $request->header('user_id');
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ]);

        try {
            $category = Category::create([
                'name' => $request->input('name'),
                'user_id' => $user_id
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Category created Successfully',
                'data' => $category
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Category Creation failed'
            ], 500);
        }
    }

    // Delete
    function categoryDelete(Request $request)
    {
        $user_id = $request->header('user_id');

        $request->validate([
            'id' => 'required|integer'
        ]);
        $cat_id = $request->input('id');

        try {
            $category = Category::where('id', $cat_id)->where('user_id', $user_id)->first();
            if (!$category) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Category not found'
                ], 404);
            }

            if ($category->products()->count() > 0) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Cannot delete Category. It belongs to one or more products'
                ], 400);
            }

            $category->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Category deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Category deletion failed'
            ], 500);
        }
    }

    // Find category by specific id
    public function categoryById(Request $request)
    {
        $user_id = $request->header('user_id');
        $request->validate([
            'id' => 'required|integer'
        ]);
        $cat_id = $request->input('id');

        try {
            $category = Category::where('id', $cat_id)->where('user_id', $user_id)->first();

            if (!$category) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Category not found'
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Category found',
                'data' => $category
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to retrieve category'
            ], 500);
        }
    }

    // Update category
    public function categoryUpdate(Request $request)
    {
        $user_id = $request->header('user_id');
        $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string|max:255'
        ]);

        $cat_id = $request->input('id');

        try {
            $category = Category::where('id', $cat_id)->where('user_id', $user_id)->first();
            if (!$category) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Category not found'
                ], 404);
            }

            // Check if name is unique (excluding current category)
            $existingCategory = Category::where('name', $request->input('name'))
                ->where('id', '!=', $cat_id)
                ->first();
            
            if ($existingCategory) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Category name already exists'
                ], 400);
            }

            $category->update([
                'name' => $request->input('name')
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Category updated successfully',
                'data' => $category
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Category update failed'
            ], 500);
        }
    }
}
