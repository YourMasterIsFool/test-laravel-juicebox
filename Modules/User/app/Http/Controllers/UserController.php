<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\User\Http\Data\LoginData;
use Modules\User\Http\Data\RegisterData;
use Modules\User\Http\Dto\RegisterDto;
use Modules\User\Http\Services\UserService;

use function Pest\Laravel\call;

class UserController extends Controller
{

    private UserService $userService;

    public function __construct(UserService $userService)
    {

        $this->userService =  $userService;
    }

    public function register(Request $request)
    {
        try {
            $validationSchema = RegisterData::from($request);
        } catch (ValidationException $e) {
            return $this->sendErrorResponse($e->errors(), "Error");
        }

        $findByEmail = $this->userService->findByEmail($validationSchema->email);

        if ($findByEmail) {
            return $this->sendErrorResponse([
                'email' => ['Email sudah digunakan']
            ], "Error Input", 400);
        }

        DB::beginTransaction();
        try {


            $dto = new RegisterDto($validationSchema->name, $validationSchema->email, $validationSchema->password);
            $created  =   $this->userService->save($dto);
            DB::commit();

            return $this->sendSuccessResponse($created, "Successfully register user", 201);
        } catch (\Exception $e) {

            DB::rollBack();
            return $this->sendErrorResponse($e, 'Failed save to database', 500);
        }
    }

    public function index(Request $request)
    {


        $data =  $this->userService->getListCursor($request);
        return $this->sendSuccessResponse($data);
    }

    public function login(Request $request)
    {
        try {
            $validationSchema = LoginData::from($request);
        } catch (ValidationException $e) {
            return $this->sendErrorResponse($e->errors(), "Error");
        }

        $checEmailExists =  $this->userService->findByEmail($validationSchema->email);

        if (!$checEmailExists) {
            return $this->sendErrorResponse([
                'email' => ["Email tidak terdaftar"]
            ], "Email tidak terdaftar", 400);
        }

        $checkPasswordIsMatch =  Hash::check($validationSchema->password, $checEmailExists->password);

        if (!$checkPasswordIsMatch) {
            return $this->sendErrorResponse([
                'password' => [
                    'Password Salah'
                ]
            ], 'Password Salah', 400);
        }

        $credential =  [
            'email' => $validationSchema->email,
            'password' => $validationSchema->password
        ];

        Auth::attempt($credential);


        $context = [
            'accessToken' => auth()->user()->createToken('mytoken')->plainTextToken
        ];

        return $this->sendSuccessResponse($context, "Successfully login", 200);
    }

    public function logout(Request $request)
    {

        $request->user()->currentAccessToken->delete();
        Auth::logout();

        return $this->sendSuccessResponse([], "Successfully logout");
    }

    public function getDetail($id)
    {

        $find = $this->userService->findById($id);

        if (!$find) {
            return $this->sendErrorResponse(null, "User tidak tersedia", 404);
        }

        return $this->sendSuccessResponse($find, "Successfully get data", 200);
    }
}
