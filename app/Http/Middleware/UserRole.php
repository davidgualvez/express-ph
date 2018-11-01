<?php

namespace App\Http\Middleware;

use Closure;
use App\Account;

class UserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ... $roles)
    {    
        //dd( $request->header('token') );
        $account = Account::findByToken( $request->header('token') );
        if(is_null($account) || $request->header('token') == null){  // check the token
            return response()->json([
                'success'   => false,
                'status'    => 401,
                'message'   => 'Unauthorized Access'
            ],200);
        } 
         
        foreach ($roles as $role) {
          // if user has given role, continue processing the request 
            $r = $this->returnRole($role); 
            if($account->employee->LoyaltyEmployeeTypeID == $r){  
                return $next($request);
            }
        }

        return response()->json([
            'success'   => false,
            'status'    => 401,
            'message'   => 'Unauthorized User'
        ],200); 
    }

    private function returnRole($role){
        if($role == 'ho'){
            return 4;
        }
        if($role == 'cashier'){
            return 1;
        }
        if($role == 'dealer'){
            return 3;
        }

        if($role == 'manager'){
            return 2;
        }
    }
}
