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
            // Se o usuário não existe, retornar um erro
            return response()->json(['error' => true, 'message' => 'User not found.'], 404);
        }

        // Criar o post social
        $socialPost = SocialPost::create([
            'address' => $request->address,
            'user_id' => $userProfile->id,
            'content' => $request->content,
            'likes' => 0,
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

        $socialPosts = SocialPost::paginate($perPage, ['*'], 'page', $page);

        return SocialPostResource::collection($socialPosts);
    }
    

}