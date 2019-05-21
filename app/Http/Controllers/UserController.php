<?php 

namespace App\Http\Controllers;

use App\Repositories\User as UserRepository;
use App\Http\Requests\User as UserRequest;

class UserController extends Controller {

    /*
     * @param mixed $message
     * @param int $code 
     * @return object
    */
    private function response($message, int $code): object
    {
        return response()->json($message, $code);
    }

    /*
     * @param UserRepository $user
     * @return object
    */
    public function index(UserRepository $user): object
    {
        return $this->response($user->getAll(), 200);
    }

    /*
     * @param UserRequest $request
     * @param UserRepository $user
     * @return object
    */
    public function show(UserRequest $request, UserRepository $user): object
    {
        return $this->response($user->getById($request->only('id')), 200);
    }

    /*
     * @param UserRequest $request
     * @param UserRepository $user
     * @return object
    */
    public function store(UserRequest $request, UserRepository $user): object
    {
        return $this->response($user->create($request->all()), 200);
    }

    /*
     * @param UserRequest $request
     * @param UserRepository $user
     * @return object
    */
    public function edit(UserRequest $request, UserRepository $user): object
    {
        return $this->response($user->update($request->all()), 200);
    }

    /*
     * @param UserRequest $request
     * @param UserRepository $user
     * @return object
    */
    public function destroy(UserRequest $request, UserRepository $user): object
    {
        return $this->response($user->delete($request->only('id')), 200);
    }
}