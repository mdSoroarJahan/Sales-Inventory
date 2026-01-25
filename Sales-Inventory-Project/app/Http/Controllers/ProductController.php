<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\call;

class ProductController extends Controller
{
    public function productPage()
    {
        return view('pages.dashboard.product-page');
    }

    //Product create
    public function createProduct(Request $request)
    {
        $user_id = $request->header('user_id');
        $request->validate([
            'name' => 'required|string|max:50',
            'price' => 'required|numeric|min:0|max:999999.99',
            'unite' => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $filePath = null;

        // Prepare and store file
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $user_id . '_' . time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');

            if (!$filePath) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Failed to upload image'
                ], 500);
            }
        }

        // Save to database
        try {
            $product = Product::create([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'unite' => $request->input('unite'),
                'img_url' => $filePath,
                'user_id' => $user_id,
                'category_id' => $request->input('category_id')
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Product created successfully',
                'data' => $product
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to create product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Product list
    public function productList(Request $request)
    {
        $user_id = $request->header('user_id');
        try {
            $products = Product::where('user_id', $user_id)
                ->with('category:id,name')
                ->get();
            return response()->json([
                'status' => 'success',
                'data' => $products
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to retrieve products'
            ], 500);
        }
    }

    // Find a single product
    public function productById(Request $request)
    {
        $user_id = $request->header('user_id');
        $request->validate([
            'id' => 'required|integer'
        ]);

        $product_id = $request->input('id');

        try {
            $product = Product::where('id', $product_id)->where('user_id', $user_id)->with('category:id,name')->first();
            if (!$product) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Product not found'
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Product found successfully',
                'data' => $product
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to retrieve product',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Product Delete
    public function productDelete(Request $request)
    {
        $user_id = $request->header('user_id');
        $request->validate([
            'id' => 'required|integer'
        ]);

        $product_id = $request->input('id');

        try {
            $product = Product::where('id', $product_id)->where('user_id', $user_id)->first();

            if (!$product) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Product not found'
                ], 404);
            }

            // Check if product is used in any invoices or not
            if ($product->invoiceProducts()->count() > 0) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Cannot delete product. It is used in one or more invoices'
                ], 400);
            }
            // Delete image file if exists
            if ($product->img_url && Storage::disk('public')->exists($product->img_url)) {
                Storage::disk('public')->delete($product->img_url);
            }

            // Delete product from database
            $product->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Product deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to delete product',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // Product Update
    public function productUpdate(Request $request)
    {
        $user_id = $request->header('user_id');
        $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string|max:50',
            'price' => 'required|numeric|min:0|max:999999.99',
            'unite' => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product_id = $request->input('id');

        try {
            $product = Product::where('id', $product_id)->where('user_id', $user_id)->first();
            if (!$product) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Product not found'
                ], 404);
            }

            $filePath = $product->img_url; // Keep existing image by default

            // Handle new image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($product->img_url && Storage::disk('public')->exists($product->img_url)) {
                    Storage::disk('public')->delete($product->img_url);
                }

                // Upload new image
                $file = $request->file('image');
                $fileName = $user_id . '_' . time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');

                if (!$filePath) {
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'Failed to upload image'
                    ], 500);
                }
            }

            // Update product
            $product->update([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'unite' => $request->input('unite'),
                'img_url' => $filePath,
                'category_id' => $request->input('category_id')
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Product updated successfully',
                'data' => $product
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to update product',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
