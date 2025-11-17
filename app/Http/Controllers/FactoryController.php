<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryPost;
use App\Http\Requests\StoreFactoryPost;
use App\Models\Category;
use App\Models\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FactoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $factories = Factory::paginate(10); // Pagina de 10 en 10
        return view('factory.index', compact('factories'));
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
    public function store(StoreFactoryPost $request)
    {
        $typeIcon = "success";
        $title = "Se creo la fabrica";
        $result = true;
        $resultCode = 200;

        $factory = new Factory();
        $factory->name = $request->post('name');
        $factory->contact = $request->post('contact');
        $factory->origin = $request->post('origin');
        try{
            DB::beginTransaction();
            $factory->save();
            DB::commit();
        } catch (\Exception $e){
            Log::error($e->getMessage());
            $typeIcon = "error";
            $title = "No Se grabo la fabrica, pongase en contacto con el administrador: " . $e->getMessage();
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
        $factory = Factory::find($id);

        $typeIcon = "success";
        $title = "Se elimino la fabrica";
        $result = true;
        $resultCode = 200;

        if (!$factory) {
            return response()->json(['error' => 'Fabrica no encontrada'], 404);
        }
        try{
            DB::beginTransaction();
            $factory->delete();
            DB::commit();
        }  catch (\Exception $e){
            Log::error($e->getMessage());
            $typeIcon = "error";
            $title = "No Se elimino la fabrica, pongase en contacto con el administrador: " . $e->getMessage();
            $result = false;
            $resultCode = 422;
            DB::rollBack();
        }

        $request->session()->flash($typeIcon, $title);

        return response()->json(['result' => $result, 'message' => ["typeIcon" => $typeIcon, "title" => $title]], $resultCode);
    }

    public function aGetFormFactory($id=null){
        $factory = null;

        if($id){
            $factory = Factory::find($id);
        }
        return response()->json([
            'success' => true,
            'html' => view('factory.partials._form_factory', compact('factory'))->render()
        ]);
    }

    public function getFactory($id)
    {
        $factory = Factory::find($id);

        if (!$factory) {
            return response()->json(['error' => 'Factory no encontrada'], 404);
        }

        return response()->json([
            'success' => true,
            'factory' => $factory
        ]);

    }

    public function aUpdateFactory(StoreFactoryPost $request)
    {
        $typeIcon = "success";
        $title = "Se actualizo la fabrica";
        $result = true;
        $resultCode = 200;

        $factory = Factory::find($request->post('factory'));
        $factory->name = $request->post('name');
        $factory->contact = $request->post('contact');
        $factory->origin = $request->post('origin');
        try{
            DB::beginTransaction();
            $factory->save();
            DB::commit();
        } catch (\Exception $e){
            Log::error($e->getMessage());
            $typeIcon = "error";
            $title = "No Se grabo la fabrica, pongase en contacto con el administrador: " . $e->getMessage();
            $result = false;
            $resultCode = 422;
            DB::rollBack();
        }

        $request->session()->flash($typeIcon, $title);

        return response()->json(['result' => $result, 'message' => ["typeIcon" => $typeIcon, "title" => $title]], $resultCode);
    }
}
