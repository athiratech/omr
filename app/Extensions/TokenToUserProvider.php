<?php 
namespace App\Extensions;

use App\Token;
use App\User;
use App\Employee;
use App\BaseModels\Student;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Str;

class TokenToUserProvider implements UserProvider
{
	private $token;
	private $user;

	public function __construct (User $user, Token $token) {
		$this->user = $user;
		$this->token = $token;
	
	}

	public function retrieveById ($identifier) {
		return $this->user->find($identifier);
	}

	public function retrieveByToken ($identifier, $token) {
		$uc=$this->token->where($identifier, $token)->where('created_at', '<', Carbon::now()->subDay())->delete();
  
		$token =Token::where('access_token',$token)->first();
		if(!count($token)){
			return null;
		}
		if(!Employee::whereRaw('id ="'.$token->user_id.'"')->first()){
			if(!Student::whereRaw('ADM_NO ="'.$token->user_id.'"')->first()){
			// return Student::whereRaw('ADM_NO ="'.$token->user_id.'"')->get();
				// return $token->parent;
			return Student::whereRaw('ADM_NO ="'.$token->user_id.'"')->first();

			
		}
			return Student::whereRaw('ADM_NO ="'.$token->user_id.'"')->first();
		
			// return $token->student;

		}

		// return Employee::whereRaw('PAYROLL_ID ="'.$token->user_id.'"')->first();
		return $token->user;
	}

	public function updateRememberToken (Authenticatable $user, $token) {
		// update via remember token not necessary
	}

	public function retrieveByCredentials (array $credentials) {
		// implementation upto user.
		// how he wants to implement -
		// let's try to assume that the credentials ['username', 'password'] given
		$user = $this->user;
		foreach ($credentials as $credentialKey => $credentialValue) {
			if (!Str::contains($credentialKey, 'password')) {
				$user->where($credentialKey, $credentialValue);
			}
		}

		return $user->first();
	}

	public function validateCredentials (Authenticatable $user, array $credentials) {
		$plain = $credentials['password'];

		return app('hash')->check($plain, $user->getAuthPassword());
	}
}