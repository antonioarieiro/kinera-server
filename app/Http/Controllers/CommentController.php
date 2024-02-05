<?php

namespace App\Http\Controllers;

use App\Http\Resources\SocialPostResource;
use App\Models\SocialPost;
use App\Models\UserProfile;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'post_id' => 'required|integer',
            'content' => 'required|string',
            'address' => 'required|string',
        ]);

        $userProfile = UserProfile::where('user', $request->input('address'))->first();

        if ($userProfile && is_object($userProfile)) {
            $userImg = url('storage/' . $userProfile->img);

            $comment = new Comment([
                'post_id' => $request->input('post_id'),
                'content' => $request->input('content'),
                'likes' => 0,
                'dislikes' => 0,
                'address' => $request->input('address'),
                'img' => $userImg,
                'user_id' => $userProfile->id,
                'name' => $userProfile->name,
            ]);

            $comment->save();

            // Agora que o comentário foi salvo, vamos retornar o recurso.
            return new CommentResource($comment);
        }

        // Se não encontrarmos o perfil do usuário, pode retornar uma resposta adequada, como um erro.
        return response()->json(['error' => 'User profile not found'], 404);
    }

    public function getById($id, Request $request)
    {
        // Validar a entrada
        $request->validate([
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:100',
        ]);
    
        // Definir valores padrão se não fornecidos
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 10);
    
        // Obter os comentários paginados associados ao post_id
        $comments = Comment::where('post_id', $id)->paginate($perPage, ['*'], 'page', $page);
    
        return CommentResource::collection($comments);
    }
}
