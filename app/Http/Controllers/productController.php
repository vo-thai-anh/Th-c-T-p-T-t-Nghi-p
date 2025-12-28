<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Stock;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class productController extends Controller
{
    public function indexProduct()
    {
        $products = DB::table('products')
            ->leftJoin('categories', 'categories.cate_id', '=', 'products.category_id')
            ->leftJoin('stocks', 'stocks.product_id', '=', 'products.product_id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'stocks.quantity as stock_quantity'
            )
            ->orderBy('products.product_id', 'desc')
            ->paginate(10);

        return view('admin.indexProduct', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.create', compact('categories'));
    }
    public function store(Request $request)
    {
        
        $request->validate([
            'category_id'     => 'required|integer|exists:categories,cate_id',
            'name'            => 'required|string|max:255|unique:products,name',
            'price'           => 'required|decimal:2|min:0',
            'stock_quantity'  => 'required|integer|min:0',
            'description'     => 'nullable|string',
            'main_image'      => 'required|image|mimes:jpg|max:2048',
        ]);


        $product=Product::create([
            'category_id'    => $request->category_id,
            'name'           => $request->name,
            'price'          => $request->price,
            'description'    => $request->description,
        ]);

            if ($request->hasFile('main_image')) {
                $file = $request->file('main_image');
                $extension = $file->getClientOriginalExtension();
                $fileName = $product->product_id . '.' . $extension;
                $file->move(public_path('images'), $fileName);
            }
        $standarName = getStandardName($request->name);
        $product = Product::where('name', $standarName)->first();
        if ($product) {
            $stock = Stock::where('product_id', $product->product_id)->first();
            if ($stock) {
            $stock->quantity += $request->stock_quantity;
            $stock->updated_by = Auth::user()->fullname;
            $stock->save();
        } else {
            Stock::create([
                'product_id' => $product->product_id,
                'quantity' => $request->stock_quantity,
                'min_stock' => 1,
                'updated_by' => Auth::user()->fullname
            ]);
        }
    }
        return redirect()->route('admin.products.indexProduct')
            ->with('success', 'Thêm hoa thành công!');
    }

    public function search(Request $request)
    {
        $searchItem = trim($request->query('search'));

        if (!$searchItem) {
            return redirect()->route('home');
        }

        $products = Product::where('name', 'like', "%{$searchItem}%")
        ->get();

        return view('products.search', [
            'data' => $products,
            'searchItem' => $searchItem,
        ]);
    }

    public function show(string $id )
    {
            try{
            $data =Product::findOrFail($id);
            $relatedproduct =Product::where('category_id',$data->category_id)
            ->where('product_id','!=',$data->product_id)
            // ->inRandomOrder()
            // ->limit(4)
            ->get();
        }catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return view('/');
        }
        return view('DanhMuc.ChiTiet',[
            'data'=>$data,
            'related'=>$relatedproduct,
        ]);
    }

    public function edit(string $id)
    {
        $product = Product::with('stock')->find($id);
        if (!$product) {
            return redirect()->route('admin.products.indexProduct')->with('alert', [
                'type' => 'warning',
                'title' => 'Không tìm thấy!',
                'message' => 'Sản phẩm không tồn tại.'
            ]);
        }
        $categories = Category::all();
        return view('admin.editProduct', compact('product', 'categories'));
    }

    public function update(Request $request, string $id)
        {

            $product = Product::find($id);
            if (!$product) {
                return back()->with('alert', [
                    'type' => 'warning',
                    'title' => 'Không tìm thấy!',
                    'message' => 'Sản phẩm không tồn tại.'
                ]);
            }

            $validated = $request->validate([
                'category_id'     => 'nullable|integer|exists:categories,cate_id',
                'name'            => 'nullable|string|max:255|unique:products,name,' . $product->product_id . ',product_id',
                'price'           => 'nullable|numeric|min:0',
                'stock_quantity'  => 'nullable|integer|min:0',
                'description'     => 'nullable|string',
                'main_image'      => 'nullable|image|mimes:jpg|max:2048'
            ]);
            DB::beginTransaction();
            try {
                $product->update([
                    'category_id' => $validated['category_id'],
                    'name'        => $validated['name'] ?? $product->name,
                    'price'       => $validated['price'] ?? $product->price,
                    'description' => $validated['description'] ?? $product->description,
                ]);
                Stock::updateOrCreate(
                    ['product_id' => $product->product_id],
                    ['quantity' => $validated['stock_quantity'] ?? 0]
                );
                if ($request->hasFile('main_image')) {
                    $file = $request->file('main_image');
                    $fileName = $product->product_id . '.' . $file->getClientOriginalExtension();

                    $oldImage = public_path('images/' . $fileName);
                    if (file_exists($oldImage)) {
                        unlink($oldImage);
                    }

                    $file->move(public_path('images'), $fileName);
                }

                DB::commit();

                return redirect()->route('admin.products.indexProduct')->with('alert', [
                    'type' => 'success',
                    'title' => 'Cập nhật thành công!',
                    'message' => 'Sản phẩm đã được cập nhật.'
                ]);

            } catch (Exception $e) {
                DB::rollBack();
                return back()->with('alert', [
                    'type' => 'error',
                    'title' => 'Lỗi!',
                    'message' => 'Không thể cập nhật sản phẩm.'
                ]);
            }
        }


    public function delete(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('alert', [
                'type'    => 'warning',
                'title'   => 'Không tìm thấy!',
                'message' => 'Sản phẩm không tồn tại trong hệ thống.'
            ]);
        }

        try {
            $product->stock()->delete();

            $product->delete();

            return redirect()->route('admin.products.indexProduct')->with('alert', [
                'type'    => 'success',
                'title'   => 'Xóa thành công!',
                'message' => 'Sản phẩm và tồn kho đã được xóa.'
            ]);

        } catch (Exception $e) {

            return redirect()->back()->with('alert', [
                'type'    => 'error',
                'title'   => 'Lỗi khi xóa!',
                'message' => 'Không thể xóa sản phẩm vì có ràng buộc dữ liệu.'
            ]);
        }
    }

}
