<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray($request)
    {
        $userProfile = $this->userProfile;
     
        $imgUrl = $userProfile->img ? url('storage/' . $userProfile->img) : null;

        return [
            'content' => $this->content,
            'dislikes' => $this->dislikes,
            'id' => $this->id,
            'likes' => $this->likes,
            'owner' => $this->address,
            'parentCommentId' => $this->parent,
            'postId' => $this->post_id,
            'name' => $userProfile->name,
            'imageLink' => $imgUrl,
        ];
    }
}
