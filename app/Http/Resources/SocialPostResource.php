<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SocialPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $userProfile = $this->userProfile;

        // Construa a URL completa para a imagem, se estiver armazenando o caminho da imagem
        $imgUrl = $userProfile->img ? url('storage/' . $userProfile->img) : null;

        return [
            'avatarSrc' => $imgUrl,
            'username' => $userProfile->name,
            'time' => null, // Altere conforme necessário
            'message' => $this->content,
            'video' => false, // Altere conforme necessário
            'id' => $this->id,
            'likes' => $this->likes,
            'dislikes' => $this->dislikes,
            'polkadotUserName' => '',
            'address' => $this->address,
            'type' => $this->type
        ];
    }
}
