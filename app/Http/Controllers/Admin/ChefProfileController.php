<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chef;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ChefProfileController extends Controller
{
    public function __construct(protected ImageService $images){}
    
    public function index(): View{
        $chefProfile = Auth::user()->chef;
        return view('admin.chef-profile', compact('chefProfile'));
    }

    public function store(Request $request): RedirectResponse{
        $user = Auth::user();

        if ($user->chef){
            return redirect()->route('admin.profile.index')
                ->with('error','Ya tienes un perfil. Usa editar para modificarlo.');
        }

        $data = $this->validateProfile($request);
        if ($request->hasFile('image')){
            $data['image'] = $this->images->store($request->file('image'), 'chefs');
            
        }
    }

}
