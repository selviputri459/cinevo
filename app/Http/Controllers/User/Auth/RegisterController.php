<?php 
 
namespace App\Http\Controllers\User\Auth; 
 
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request; 
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 
 
class RegisterController extends Controller 
{ 
    public function create() 
    { 
        return view('user.auth.register'); 
    } 
 
    public function store(Request $request) 
    { 
        $validated = $request->validate([ 
            'name' => ['required', 'string', 'max:255'], 
            'email' => ['required', 'email', 'unique:users,email'], 
            'password' => ['required', 'confirmed', 'min:8'], 
        ]);  
 
        $user = User::create([ 
            'name' => $validated['name'], 
            'email' => $validated['email'], 
            'password' => $validated['password'], 
        ]); 
 
        Auth::login($user); 
        return redirect()->intended(route('home')); 
    } 
} 