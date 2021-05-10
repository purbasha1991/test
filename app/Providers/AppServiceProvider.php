<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//use  App\User;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
  //       $this->app['auth']->viaRequest('api', function ($request) {
		// 	if ($request->header('Authorization')) {
		// 		$key = explode(' ',$request->header('Authorization'));
		// 		$user = User::where('api_key', $request->header('Authorization'))->first();
		// 		dd($user);
		// 		if(!empty($user)){
		// 			$request->request->add(['userid' => $user->id]);
		// 		}
		// 		return $user;
		// 	}
		// });
    }
}
