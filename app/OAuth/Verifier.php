<?php
namespace CodeProject\OAuth;

use Illuminate\Support\Facades\Auth;
//use Auth;

class Verifier
{
	public function verify($username, $password)
  {
      $credentials = [
        'email'    => $username,
        'password' => $password,
      ];

      if(Auth::validate($credentials))
      {
        $user = \CodeProject\Entities\User::where('email', $username)->first();
        return $user->id;
      }
/*      if (Auth::once($credentials)) {
          return Auth::user()->id;
      }*/

      return false;
  }
}