<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserRepositoryInterface {

	public function getAllUsers()
	{
		$user = User::get();

		return $user;
	}

	public function storeUser(array $request){

		try {

			$user = User::create([
				'name' => $request['name'],
				'email' => $request['email'],
				'password' => bcrypt($request['password'])
			]);

		} catch (\Exception $exception) {

			Log::error($exception->getMessage());

			return false;
		}
		
		return $user;
	}

	public function updateUser(int $id, array $data){
		
		try {

			$user = User::find($id);

			$user->fill($data);

			if (isset($data['password'])) {
				$user->password = bcrypt($data['password']);
			}
		
			$user->save();

		} catch (\Exception $exception) {

			Log::error($exception->getMessage());

			return false;
		}
		
		return $user;
	}

	public function deleteUser(int $id){

		try {

			User::where('id', $id)->delete();

		} catch (\Exception $exception) {

			Log::error($exception->getMessage());

			return false;
		}
		
		return true;
	}
}