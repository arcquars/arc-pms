<?php

namespace App\Http\Controllers;

use App\Models\RoomLevel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomlevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $data=RoomLevel::all();
        return view('roomlevel.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('roomlevel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:room_levels',
//            'detail' => 'required',
        ]);

        $model = new RoomLevel();
        $model->fill($request->all());
        $model->save();

        return redirect()->route('roomlevel.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roomlevel = RoomLevel::find($id);
        return view('roomlevel.edit',compact('roomlevel'));
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
        $validated = $request->validate([
            'name' => 'required|max:255|unique:room_levels,name,'.$id,
//            'detail' => 'required',
        ]);
        $roomlevel = RoomLevel::find($id);
        $roomlevel->name = $request->get('name');
        $roomlevel->detail = $request->get('detail');

        $roomlevel->save();

        return redirect()->route('roomlevel.index');
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
}
