<?php

namespace App\Http\Controllers;

use App\Http\Resources\SocialPostResource;
use App\Models\SocialPost;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class SocialPostController extends Controller
{
  public function create(Request $request)
  {
      $request->validate([
          'address' => 'required|string',
          'content' => 'required|string',
          'type' => 'required|string',
          
      ]);

      $userProfile = UserProfile::where('user', $request->address)->first();
      if (!$userProfile) {
        return response()->json(['error' => true, 'message' => 'User not found.'], 404);
      }
      $urls = implode(',', $request->urls);
      $socialPost = SocialPost::create([
          'address' => $request->address,
          'user_id' => $userProfile->id,
          'content' => $request->content,
          'likes' => 0,
          'urls' => $urls,
          'dislikes' => 0,
          'republish' => 0,
          'type' => $request->type,
          'event_id' => isset($request->event_id) ? $request->event_id : 0,
          'tag' => isset($request->tag) ? $request->tag : null,
          'is_festival' => isset($request->isFestival) ? $request->isFestival : null,
          'categorie' => isset($request->categorie[0]) ? $request->categorie[0][0] : null,
          'is_rankings' => isset($request->isRanking) ? $request->isRanking : null,
      ]);

      return response()->json($socialPost, 201);
  }

  public function getById($id)
  {
      
      $socialPost = SocialPost::where('address', $id)->get();

      if (!$socialPost) {
          return response()->json(['message' => 'Post not found.'], 404);
      }

      return response()->json($socialPost);
  }

  public function getAllPosts(Request $request)
  {
      $perPage = $request->input('per_page', 30);
      $page = $request->input('page', 1);

      $socialPosts = SocialPost::orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);

      return SocialPostResource::collection($socialPosts);
  }

  public function getPostsByUser($user)
  {

      $userPosts = SocialPost::where('address', $user)->get();
  

      return SocialPostResource::collection($userPosts);
  }


  public function editPost($id, Request $request)
  {
    $request->validate([
      'user' => 'required|string',
      'content' => 'required|string',
    ]);

    $post = SocialPost::where('user_id', $request->user)->where('id', $id)->first();
    if(!$post) {
      return response()->json(['error' => true], 404);
    }
    $post->content = $request->content;
    $post->save();
      return response()->json($post, 201);
  }

  public function removePost($id, Request $request)
  {
    $request->validate([
      'user' => 'required|integer',
    ]);

    echo 'asa', $request->user;

    $post = SocialPost::where('user_id', $request->user)->where('id', $id)->first();
    if(!$post) {
      return response()->json(['error' => true], 404);
    }
    $post->delete();
      return response()->json($post, 201);
  }

  public function getPost($id)
  {
      
      $socialPost = SocialPost::where('id', $id)->get();

      if (!$socialPost) {
          return response()->json(['message' => 'Post not found.'], 404);
      }

      return SocialPostResource::collection($socialPost);
  }

}