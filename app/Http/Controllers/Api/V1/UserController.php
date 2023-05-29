<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = UserResource::collection($this->userRepository->getAllUsers());

        return response()->success($users,"User Lists",200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = $this->userRepository->storeUser($validated);

        if ($user) {
            return response()->success(null, "Successfully Create User", 200);

        } else {
            return response()->error("User Create Failed", 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $data = new UserResource($user);

        return response()->success($data, "Successfully User Details", 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
        public function update(Request $request, User $user)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:6|confirmed',
            ]);

            $data = $request->only('name', 'email');

            if ($request->filled('password')) {
                
                $data['password'] = bcrypt($request->password);
            }

            $updatedUser = $this->userRepository->updateUser($user->id,$data);

            if ($updatedUser) {
                return response()->success(null, "Successfully Updated User", 200);
            } else {
                return response()->error("User Update Failed", 500);
            }
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($this->userRepository->deleteUser($user->id)) {

            return response()->success(null, "Successfully Create User", 204);

        } else {
            return response()->error("User Create Failed", 500);
        }
    }
}
