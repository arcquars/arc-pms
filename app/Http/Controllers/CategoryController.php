<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryPost;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(10); // Pagina de 10 en 10
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryPost $request)
    {
        $typeIcon = "success";
        $title = "Se creo la categoria";
        $result = true;
        $resultCode = 200;

        $category = new Category();
        $category->name = $request->post('name');
        try{
            DB::beginTransaction();
            $category->save();
            DB::commit();
        } catch (\Exception $e){
            Log::error($e->getMessage());
            $typeIcon = "error";
            $title = "No Se grabo la categoria, pongase en contacto con el administrador: " . $e->getMessage();
            $result = false;
            $resultCode = 422;
            DB::rollBack();
        }

        $request->session()->flash($typeIcon, $title);

        return response()->json(['result' => $result, 'message' => ["typeIcon" => $typeIcon, "title" => $title]], $resultCode);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        dd($id);
        exit(1);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $category = Category::find($id);

        $typeIcon = "success";
        $title = "Se elimino la categoria";
        $result = true;
        $resultCode = 200;

        if (!$category) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }
        try{
            DB::beginTransaction();
            $category->delete();
            DB::commit();
        }  catch (\Exception $e){
            Log::error($e->getMessage());
            $typeIcon = "error";
            $title = "No Se elimino la categoria, pongase en contacto con el administrador: " . $e->getMessage();
            $result = false;
            $resultCode = 422;
            DB::rollBack();
        }

        $request->session()->flash($typeIcon, $title);

        return response()->json(['result' => $result, 'message' => ["typeIcon" => $typeIcon, "title" => $title]], $resultCode);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCategory($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        return response()->json([
            'success' => true,
            'category' => $category
        ]);

    }

    public function aGetFormCategory($id){
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }
        return response()->json([
            'success' => true,
            'html' => view('category.partials._form_category', compact('category'))->render()
        ]);
    }

    public function aUpdateCategory(StoreCategoryPost $request)
    {
        $typeIcon = "success";
        $title = "Se actualizo la categoria";
        $result = true;
        $resultCode = 200;

        $category = Category::find($request->post('category'));
        $category->name = $request->post('name');
        try{
            DB::beginTransaction();
            $category->save();
            DB::commit();
        } catch (\Exception $e){
            Log::error($e->getMessage());
            $typeIcon = "error";
            $title = "No Se grabo la categoria, pongase en contacto con el administrador: " . $e->getMessage();
            $result = false;
            $resultCode = 422;
            DB::rollBack();
        }

        $request->session()->flash($typeIcon, $title);

        return response()->json(['result' => $result, 'message' => ["typeIcon" => $typeIcon, "title" => $title]], $resultCode);
    }
}
