<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements UserRepositoryInterface {

	public function getAllUsers()
	{
		$user = User::get();

		return $user;
	}

	public function getUserById(int $id)
	{
		$user = User::findOrFail($id);

		return $user;
	}

	public function storeUser(object $request){

		User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password)
		]);

		return "Successfully Added user.";
	}

	public function updateUser(int $id, object $request){

		User::where('id', $id)->update([
			'name' => $request->name,
			'email' => $request->emai,
			'password' => bcrypt($request->password)
		]);

		return "Successfully Updated user.";

	}

	public function deleteUser(int $id){

		User::where('id', $id)->delete();

		return "Successfully deleted user.";

	}
}