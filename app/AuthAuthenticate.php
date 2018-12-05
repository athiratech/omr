<?php 

namespace App;

use  Illuminate\Auth\Authenticatable;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Session;
use DB;
use App\Token;
use App\Employee;
    
use Illuminate\Support\Facades\Hash;

trait AuthAuthenticable {
    use Authenticatable {
        Authenticatable::getRememberTokenName as fgetRememberTokenName;
    }
    use Authenticatable {
        Authenticatable::setRememberToken as fsetRememberToken;
    }

    use Authenticatable {
        Authenticatable::getRememberToken as fgetRememberToken;
    }

     public function setAttribute($key, $value)
  {
    $isRememberTokenAttribute = $key == $this->getRememberTokenName();
    if (!$isRememberTokenAttribute)
    {
      parent::setAttribute($key, $value);
    }
  }
    public function getRememberTokenName()
    {
       
        return null;
    }
     public function setRememberToken($value)
    {
        return null;
    }
     public function getRememberToken()
    {
        return null;
    }

}



?>