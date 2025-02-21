<?php

namespace Modules\Post\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Modules\Post\Http\Data\PostData;
use Modules\Post\Http\Dto\PostDto;
use Modules\Post\Http\Dto\UpdatePostDto;
use Modules\Post\Http\Services\PostService;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private PostService $postService;

    public function __construct(PostService $postService)
    {

        $this->postService =  $postService;
    }

    public function index(Request $request)
    {
        $data =  $this->postService->getListCursorPaginate($request);
        return $this->sendSuccessResponse($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        try {
            $validationSchema = PostData::from($request);
        } catch (ValidationException $e) {
            return $this->sendErrorResponse($e->errors(), "Error", 400);
        }

        DB::beginTransaction();
        try {
            $dto = new PostDto($validationSchema->title, $validationSchema->description, $request->user()->id);
            $created  =   $this->postService->save($dto);
            DB::commit();

            return $this->sendSuccessResponse($created, "Successfully register user", 201);
        } catch (\Exception $e) {

            DB::rollBack();
            return $this->sendErrorResponse($e, 'Failed save to database', 500);
        }
    }


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $find =  $this->postService->findById($id);
        if (!$find) {
            return $this->sendErrorResponse([], "Data post tidak ada", 404);
        }

        return $this->sendSuccessResponse($find, "Successfully get detail post");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('post::edit');
    }

    /**
     */
    public function update(Request $request, $id)
    {
        //


        try {
            $validationSchema = PostData::from($request);
        } catch (ValidationException $e) {
            return $this->sendErrorResponse($e->errors(), "Error");
        }

        $checkData = $this->postService->findById($id);

        if (!$checkData) {
            return $this->sendErrorResponse([], "Post tidak ada", 404);
        }

        if ($checkData->user_id != $request->user()->id) {
            return $this->sendErrorResponse([], "Tidak tidak berhak mengupdate data ini", 403);
        }

        DB::beginTransaction();
        try {


            $dto = new UpdatePostDto($validationSchema->title, $validationSchema->description);
            $created  =   $this->postService->update($dto, $id);
            DB::commit();

            return $this->sendSuccessResponse($created, "Successfully register user", 201);
        } catch (\Exception $e) {

            DB::rollBack();
            return $this->sendErrorResponse($e, 'Failed save to database', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $findPost =  $this->postService->findById($id);

        if ($findPost->user_id != auth()->user()->id) {
            return $this->sendErrorResponse(null, "Tidak memilik menghapus post ini karena anda bukan author", 403);
        }

        try {
            $deletePost =  $this->postService->delete($id);

            return $this->sendSuccessResponse(null, "Successfully delete post");
        } catch (\Exception $e) {
            return $this->sendErrorResponse(null, "Error delete post", 500);
        }
    }
}
