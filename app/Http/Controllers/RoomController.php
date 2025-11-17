<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\RoomLevel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\Room;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Room::all();
        return view('room.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roomtypes = RoomType::all();
        $roomLevels = RoomLevel::all();
        return view('room.create',['roomtypes'=>$roomtypes, 'roomLevels' => $roomLevels]);
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
            'rt_id' => 'required',
            'rlevel_id' => 'required',
            'title' => 'required|max:255'
        ]);

        $data = new Room;
        $data->room_type_id = $request->rt_id;
        $data->room_level_id = $request->rlevel_id;
        $data->title = $request->title;
        $data->save();

        return redirect('admin/rooms')->with('success','Data has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=Room::find($id);
        return view('room.show',['data'=>$data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roomtypes=RoomType::all();
        $roomLevels = RoomLevel::all();
        $data=Room::find($id);
        return view('room.edit',['data'=>$data,'roomtypes'=>$roomtypes, 'roomLevels' => $roomLevels]);
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
            'rt_id' => 'required',
            'rlevel_id' => 'required',
            'title' => 'required|max:255'
        ]);

        $data=Room::find($id);
        $data->room_type_id=$request->rt_id;
        $data->room_level_id = $request->rlevel_id;
        $data->title=$request->title;
        $data->save();

        return redirect('admin/rooms/'.$id.'/edit')->with('success','Data has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Room::where('id',$id)->delete();
       return redirect('admin/rooms')->with('success','Data has been deleted.');
    }

     function aGetRoomStatusById(Request $request){
        $roomId = $request->post('roomId');
        $bookingId = $request->post('bookingId');
        $status = $request->post('status');

        $room = Room::find($roomId);
        $booking = Booking::find($bookingId);

        $startDate = Carbon::now()->format('Y-m-d\TH:i');
        $endDate = Carbon::now()->addHours(1)->format('Y-m-d\TH:i');

        return response()->json([
            'room' => $room,
            'booking' => $booking,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }
}
