<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\User\CreateUpdateUserRequest;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Policies\UserPolice;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index() 
    {
        return Response(['data' => User::all()], 200);
    }
    
    public function store(CreateUpdateUserRequest $request)
    {
        if(!is_null($request)) {
            $request['password'] = bcrypt($request['password']);

            User::create($request->all());

            return Response(['data' => 'Usuário criado com sucesso'], 200);
        }

        return Response(['data' => 'Erro ao criar usuário'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if($id) {
            $user = DB::table('users')
                ->select('*')
                ->where('id', $id)
                ->get();

            if(sizeof($user) > 0)
                return Response(['data' => $user], 200);
        }

        return Response(['data' => 'Erro ao encontrar usuário'], 500);
    }

    public function update(Request $request, $id) 
    {
        $user = User::find($id);

        if($user) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->is_admin = $request->is_admin;

            $user->save();

            return Response(['data' => 'Usuário atualizado com sucesso'], 200);
        }
        
        return Response(['data' => 'Erro ao atualizar usuario ou usuario não encontrado'], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if($user) {
            User::destroy($id);

            return Response(['data' => 'Usuario apagado com sucesso'], 200);
        }
        
        return Response(['data' => 'Usuario nao encontrado'], 500);
    }

    public function oauthUser() {
        if (Auth::check()) {
            return Response(['data' => Auth::user()], 200);
        }

        return Response(['data' => 'Unauthorized'], 401);
    }

    public function login(LoginUserRequest $request): Response
    {
        if(Auth::attempt($request->all())) {
            $user = Auth::user();
            $success =  $user->createToken('AccessToken')->plainTextToken; 
        
            return Response(['token' => $success], 200);
        }

        return Response(['message' => 'E-mail ou senha incorretos'], 401);
    }
    
    public function logout(): Response
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        
        return Response(['data' => 'Usuario deslogado'], 200);
    }
}