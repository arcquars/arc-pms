<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFactoryPost;
use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Factory;
use App\Models\Measure;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $measures = Measure::getAllMeasureDropBox();
        $unitServiceId = Measure::UNIT_SERVICE_ID;

        $factories = Factory::getAllFactoryDropBox();
        $categories = Category::getAllCategoryDropBox();

        return view('product.create', compact('measures', 'unitServiceId', 'factories', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $product = new Product();
        $product->name = $request->input('name');
        $product->code = $request->input('code');
        $product->price_reference = $request->input('price_reference');
        $product->price_minimum = $request->input('price_minimum');
        $product->coste = $request->input('coste');
        $product->measure = $request->input('measure');
        $product->description = $request->input('description');
        $product->active = $request->input('active')? $request->input('active') : false;
        $product->category = $request->input('category');
        $product->factory = $request->input('factory');

        if($product->save()){
            $this->saveImageProduct($request, $product);
        }

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $measures = Measure::getAllMeasureDropBox();
        $unitServiceId = Measure::UNIT_SERVICE_ID;

        $factories = Factory::getAllFactoryDropBox();
        $categories = Category::getAllCategoryDropBox();

        return view('product.edit', compact('product', 'measures', 'unitServiceId', 'categories', 'factories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->update([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'price_reference' => $request->input('price_reference'),
            'price_minimum' => $request->input('price_minimum'),
            'coste' => $request->input('coste'),
            'measure' => $request->input('measure'),
            'description' => $request->input('description'),
            'active' => $request->input('active'),
            'category' => $request->input('category'),
            'factory' => $request->input('factory'),
        ]);

        if($request->hasFile('image_product')){
            $this->saveImageProduct($request, $product);
        }

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return void
     */
    private function saveImageProduct($request, &$product){
        if($request->hasFile('image_product')){
            $image = $request->file('image_product');
            $fileName = time() . '.' . $image->getClientOriginalExtension();

            // 3️⃣ Definir directorios
            $originalPath = "uploads/products/{$product->id}/original/";
            $resizedPath = "uploads/products/{$product->id}/resized/";

            // 4️⃣ Crear directorios si no existen
            Storage::makeDirectory($originalPath);
            Storage::makeDirectory($resizedPath);

            // 5️⃣ Guardar la imagen original
            Storage::putFileAs($originalPath, $image, $fileName);

            // 6️⃣ Redimensionar la imagen a 500px de ancho y guardar
            $resizedImage = Image::make($image)->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg', 90);

            Storage::put($resizedPath . $fileName, (string) $resizedImage);

            // 7️⃣ Guardar rutas en la base de datos
            $product->update([
                'filename' => $originalPath . $fileName,
                'filename500' => $resizedPath . $fileName,
            ]);

        }
    }

    public function aDeleteFilename(Request $request)
    {
        $typeIcon = "success";
        $title = "Se actualizo el producto";
        $result = true;
        $resultCode = 200;

        $product = Product::find($request->post('productId'));

        $filename = $product->filename;
        $filename500 = $product->filename500;

        $product->filename = null;
        $product->filename500 = null;
        try{
            DB::beginTransaction();
            $product->save();

            if (Storage::exists($filename)) {
                Storage::delete($filename);
            }
            if (Storage::exists($filename500)) {
                Storage::delete($filename500);
            }

            DB::commit();
        } catch (\Exception $e){
            Log::error($e->getMessage());
            $typeIcon = "error";
            $title = "No Se elimino las imagenes, pongase en contacto con el administrador: " . $e->getMessage();
            $result = false;
            $resultCode = 422;
            DB::rollBack();
        }

        $request->session()->flash($typeIcon, $title);

        return response()->json(['result' => $result, 'message' => ["typeIcon" => $typeIcon, "title" => $title]], $resultCode);
    }

    public function aGetProduct(Request $request)
    {
        $product = Product::find($request->post('productId'));

        return response()->json(['product' => $product], 200);
    }
}
