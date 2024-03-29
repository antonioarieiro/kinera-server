<?php
namespace App\Http\Controllers;
use App\Models\UserProfile;
use App\Models\SocialPost;
use App\Models\Follower;
use App\Models\Following;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
  public function create(Request $request)
  {
      $request->validate([
          'user' => 'required',
       
          'name' => 'nullable|string', 
          'description' => 'nullable',
      ]);
  
      // Verifica se o nome já existe e se o nome não é o mesmo do usuário existente
      if ($request->has('name') && UserProfile::where('name', $request->name)->where('user', '!=', $request->user)->exists()) {
          return response()->json(['error' => true, 'isExist' => true, 'message' => 'Nome já existe.'], 422);
      }
  
      // Cria ou atualiza o perfil do usuário
      $userProfile = UserProfile::firstOrNew(['user' => $request->user]);
  
      if ($request->hasFile('img')) {
          $path = $request->file('img')->store('user_images', 'public');
          $userProfile->img = $path;
      }

      if ($request->hasFile('cover')) {
        $path = $request->file('cover')->store('user_cover', 'public');
        $userProfile->cover = $path;
      }

      
  
      if ($request->has('name')) {
          $userProfile->name = $request->name;
      }
  
      if ($request->has('description')) {
          $userProfile->description = $request->description;
      }
  
      $userProfile->save();
  
      return response()->json(['message' => 'Perfil criado ou atualizado com sucesso!', 'data' => $userProfile]);
  }

  public function follow($target, $follow)
  {

    $userProfile = UserProfile::where('user', $target)->first();
    $addFollowing = UserProfile::where('user', $follow)->first();
    if (!$userProfile) {
        return response()->json(['message' => 'Perfil não encontrado'], 404);
    }

    
    if($addFollowing) {
      $addFollowing->following += 1;
      $addFollowing->save();
    }

    $userProfile->followers += 1;
  
    Following::create([
      'user_id' => $userProfile->id,
      'address' => $userProfile->user,
      'name' => $userProfile->name,
      'img' => $addFollowing->img,
      'follow_name' => $addFollowing->name,
      'follower_id' => $addFollowing->id
    ]);

    Follower::create([
    'user_id' => $userProfile->id,
    'address' => $follow,
    'name' => $userProfile->name,
    'img' => $addFollowing->img,
    'follow_name' => $addFollowing->name,
    'follower_id' => $addFollowing->id
    ]);
    $userProfile->save();
    return response()->json($userProfile);  
  }

  public function unfollow($id, $follow)
  {

      $userProfile = UserProfile::where('user', $id)->first();

      if (!$userProfile) {
          return response()->json(['message' => 'Perfil não encontrado'], 404);
      }

      $addFollowing = UserProfile::where('user', $follow)->first();
      if($addFollowing) {
        $addFollowing->following =  $addFollowing->following -  1;
        $addFollowing->save();
      }

      $userProfile->followers >= 0 ??  $userProfile->followers -= 1;
      $userProfile->save();

      
      Following::where('user_id', $userProfile->id)->where('address',$addFollowing->user)->delete();
      Follower::where('user_id', $userProfile->id)->where('address',$addFollowing->user)->delete();

      return response()->json($userProfile);
  }

  public function verifyFollow($id, $follow)
  {
      $userProfile = UserProfile::where('user', $id)->first();
      if ($userProfile) {
          $exists = Follower::where('user_id', $userProfile->id)
              ->where('followers.address', $follow)
              ->first();
          return response()->json(['exists' => $exists]);
      } else {
          return response()->json(['exists' => false]);
      }
  }

  public function get($user)
  {

      $userProfile = UserProfile::where('user', $user)->first();
      if (!$userProfile) {
          return response()->json(['message' => 'Perfil não encontrado'], 404);
      }

      // Se você estiver armazenando o caminho da imagem, pode ser necessário gerar a URL completa
      $userProfile->img = url('storage/' . $userProfile->img);
      $userProfile->cover = url('storage/' . $userProfile->cover);
      return response()->json($userProfile);
  }

  public function getFollowers(Request $request, $user)
  {
      $currentPage = $request->input('currentPage', 1);
      $perPage = 50;
      $userProfile = UserProfile::where('user', $user)->first();
      $followers = Follower::where('user_id', $userProfile->id)->paginate($perPage, ['*'], 'page', $currentPage);

      // Mapeia os seguidores para ajustar a URL da imagem
      $followers->getCollection()->transform(function ($follower) {
          $follower->img = url('storage/' . $follower->img);
          return $follower;
      });

      return response()->json($followers);
  }

  public function getFollowings(Request $request, $user)
  {
      $currentPage = $request->input('currentPage', 1);
      $perPage = 50;

      $userProfile = UserProfile::where('user', $user)->first();

      $followers = Following::where('follower_id', $userProfile->id)->paginate($perPage, ['*'], 'page', $currentPage);

      // Mapeia os seguidores para ajustar a URL da imagem
      $followers->getCollection()->transform(function ($follower) {
          $follower->img = url('storage/' . $follower->img);
          return $follower;
      });

      return response()->json($followers);
  }
}
