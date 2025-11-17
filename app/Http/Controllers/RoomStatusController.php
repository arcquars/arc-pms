<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomStatusCloseRequest;
use App\Http\Requests\StoreRoomStatusRequest;
use App\Models\RoomStatus;
use App\Models\RoomStatusAction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoomStatusController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    function aSaveRoomStatus(StoreRoomStatusRequest $request){
        $typeIcon = "success";
        $title = "Se realizo la reserva";
        $result = true;
        $resultCode = 200;

        $roomStatus = new RoomStatus();
        $roomStatus->name = $request->post('room-status-name');
        $roomStatus->start_date = $request->post('start_date');
        $roomStatus->end_date = $request->post('end_date');
        $roomStatus->room_id = $request->post('roomId');
        $roomStatus->user_id = Auth::id();

        try{
            $roomStatus->save();
        } catch (\Exception $e){
            $typeIcon = "error";
            $title = "No Se grabo el estado de la habitacion, pongase en contacto con el administrador: " . $e->getMessage();
            $result = false;
            $resultCode = 422;
        }

        return response()->json(['result' => $result, 'message' => ["typeIcon" => $typeIcon, "title" => $title]], $resultCode);
    }

    function aCloseRoomStatus(StoreRoomStatusCloseRequest $request){
        $typeIcon = "success";
        $title = "Se realizo la Accion";
        $result = true;
        $resultCode = 200;

        $roomStatus = RoomStatus::find($request->post('room_status_id'));
        $roomStatusAction = new RoomStatusAction();
        $roomStatusAction->action = "CLOSE";
        $roomStatusAction->assigned_to = $request->post('assigned_to');
        $roomStatusAction->action_date = $request->post('action_date');
        $roomStatusAction->user_id = Auth::id();
        $roomStatusAction->room_status_id = $request->post('room_status_id');

        try{
            DB::beginTransaction();
            $roomStatusAction->save();
            $roomStatus->active = 0;
            $roomStatus->save();
            DB::commit();
        } catch (\Exception $e){
            $typeIcon = "error";
            $title = "No Se grabo el estado de la habitacion, pongase en contacto con el administrador: " . $e->getMessage();
            $result = false;
            $resultCode = 422;
            DB::rollBack();
        }

        return response()->json(['result' => $result, 'message' => ["typeIcon" => $typeIcon, "title" => $title]], $resultCode);
    }

    function aGetRoomStatusById(Request $request){
        $roomStatusId = $request->post('roomStatusId');

        $roomStatus = RoomStatus::find($roomStatusId);
        $room = $roomStatus->room;
        $now = Carbon::now()->format('Y-m-d\TH:i');

        $users = User::all()->pluck('name', 'id');
        return response()->json([
            'roomStatus' => $roomStatus,
            'room' => $room,
            'now' => $now,
            'users' => $users
        ]);
    }
}
