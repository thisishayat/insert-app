<?php

namespace App\Http\Middleware;

use App\ApiToken;
use Closure;

class RouteTokenAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle( $request, Closure $next ) {
        //dump($this->checkToken( $request ));
        if ( ! $this->checkToken( $request ) ) {
            return response()->json( [ 'error' => 'Unauthorized' ], 401 );
        }

        return $next( $request );
    }

    public function checkToken( $request ) {

        $client = $request->header( 'API-CLIENT' );
        $token  = $request->header( 'AUTH-TOKEN' );

        return ApiToken::where( 'client', $client )
            ->where( 'token', $token )->exists();
    }
}
