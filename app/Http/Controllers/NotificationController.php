<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\UserProfile;


class NotificationController extends Controller
{
  public function create(Request $request)
  {
      $request->validate([
          'user' => 'required',
          'type' => 'required|integer', 
          'content' => 'required|string',
          'status' => 'required|boolean',
      ]);

      $existNotification = false;

      $user = UserProfile::where('user', $request->user)->first();
 
      if(!$user) {
        return response()->json(['message' => 'User not found!', 'error' => true],404);
      }

      if($request->id) {
        $updateNotification = Notification::where('user_id', $user->id)->where('id', $request->id)->first();
        $updateNotification->status = 1;
        $updateNotification->save();
        return response()->json(['data' => $updateNotification], 200);
      }
   
      if(!$request->id) {
        $newNotification = Notification::create([
          'user_id' => $user->id,
          'type' => $request->type,
          'content' => $request->content,
          'status' => $request->status,
        ]);
    
        return response()->json(['data' => $newNotification], 200);
      }
  }

  public function viewAll(Request $request)
  {
      $request->validate([
        'user' => 'required',
      ]);

      $existNotification = false;

      $user = UserProfile::where('id', $request->user)->first();
 
      if(!$user) {
        return response()->json(['message' => 'User not found!', 'error' => true],404);
      }

      $notification = Notification::where('user_id', $user->id)->orderBy('status', 'asc')->get();
   
     
  
      return response()->json(['data' => $notification], 200);
  }

  public function getById(Request $request)
  {
      $request->validate([
        'user' => 'required',
        'id' => 'required',
      ]);

      $existNotification = false;

      $user = UserProfile::where('id', $request->user)->first();
 
      if(!$user) {
        return response()->json(['message' => 'User not found!', 'error' => true],404);
      }

      $notification = Notification::where('user_id', $user->id)->where('id', $request->id)->get();
   
     
  
      return response()->json(['data' => $notification], 200);
  }

  public function removeAll(Request $request)
  {
      $request->validate([
        'user' => 'required'
      ]);


      $user = UserProfile::where('user', $request->user)->first();
 
      if(!$user) {
        return response()->json(['message' => 'User not found!', 'error' => true],404);
      }

      Notification::where('user_id', $user->id)->delete();
      return response()->json(['message' => 'success', 'error' => false], 200);
      
  }
}
