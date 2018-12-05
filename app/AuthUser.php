<?php 

namespace App;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Session;
use DB;
use App\Token;
use App\Employee;

use Illuminate\Support\Facades\Hash;

trait AuthUser {
    use AuthenticatesUsers {
        AuthenticatesUsers::login as frameworkReplaceMe;
        AuthenticatesUsers::username as fusername;
    }

    // use AuthenticatesUsers {
    //     AuthenticatesUsers::username as fusername;
    // }
     public function username()
    {
        return 'payroll_id';
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
         // $product = \App\Usersrole::where('payrole_id',$request->payrole_id)->get();

$product = DB::select('SELECT roles.name FROM `roles` INNER Join usersroles on roles.id=usersroles.role_id inner join employees on employees.id=usersroles.user_id WHERE employees.payroll_id="'.$request->payroll_id.'"');

// $product=json_encode($users);

        // foreach ($user as $role) {
        //     echo $role->pivot->created_at;
        // }
     
        Session::push('cart', $product);
         $user = \App\Employee::where('payroll_id', $request->payroll_id)
                  ->where('password',md5($request->password))
                  ->first();
        // $token=Token::create([
        //     'user_id'=>$user->id,
        //     'expiry_time'=>'1',
        //     'access_token' => Hash::make($request->password)
        // ]);
                  if($user){
                     Auth::login($user);
                 }
                 else{
                    Session::flush();
                    $errors = new \stdClass();
                    $errors->payroll_id="These credentials do not match our records.";

                    Session::push('error',$errors);
                 }
     return redirect('/home');
        /*// If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }*/

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        // $this->incrementLoginAttempts($request);

        // return $this->sendFailedLoginResponse($request);
    }


}



?>