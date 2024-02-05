<?php
namespace App\Http\Controllers;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'img' => 'nullable|image',
            'name' => 'nullable|unique:user_profile,name', 
            'description' => 'nullable',
        ]);

        if ($request->has('name') && UserProfile::where('name', $request->name)->exists()) {
            return response()->json(['error' => true, 'isExist' => true, 'message' => 'Nome já existe.'], 422);
        }
    
        $userProfile = UserProfile::firstOrNew(['user' => $request->user]);
    
        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('user_images', 'public');
            $userProfile->img = $path;
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

    public function get($user)
    {

        $userProfile = UserProfile::where('user', $user)->first();
        if (!$userProfile) {
            return response()->json(['message' => 'Perfil não encontrado'], 404);
        }

        // Se você estiver armazenando o caminho da imagem, pode ser necessário gerar a URL completa
        $userProfile->img = url('storage/' . $userProfile->img);

        return response()->json($userProfile);
    }
}
