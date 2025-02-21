<?php

namespace Modules\User\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Modules\User\Http\Dto\RegisterDto;

class UserService
{
    public function save(RegisterDto $registerDTO): User
    {

        $user =  new User();
        $user->name = $registerDTO->name;
        $user->email =  $registerDTO->email;
        $user->password = Hash::make($registerDTO->password);
        $user->save();
        return $user;
    }

    public function findByEmail(string $email): User|null
    {
        $findUser =  User::where('email', $email)->first();

        return $findUser;
    }

    public function findAll()
    {
        return User::all();
    }

    public function getListCursor(Request $request)
    {
        return User::orderBy('id')->cursorPaginate(20);
    }

    public function findById(string $id): User|null
    {
        $findUser = User::where('id', $id)->first();

        return $findUser;
    }
}
