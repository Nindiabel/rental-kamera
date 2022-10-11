<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('/alat', function () {
        $alat = DB::table('alats')
                ->join('categories', 'categories.id','alats.kategori_id')
                ->get(['alats.id','kategori_id','nama_alat','harga24','harga12','harga6','nama_kategori']);
        return response()->json([
            'message' => 'success',
            'data' => $alat
        ],200, [
            'Content-Type' => 'application/json'
        ]);
    });
});

Route::get('/kalender-alat', function() {
    $order = DB::table('orders')
    ->join('alats', 'alats.id','=','orders.alat_id')
    ->join('payments','payments.id','=','orders.payment_id')
    ->where('orders.status', 2)
    ->where('payments.status', 3)
    ->get(['nama_alat AS title','starts AS start','ends AS end']);
    return json_encode($order);
});

Route::get('/kalender-alat/{id}', function($id) {
    $order = DB::table('orders')
    ->join('alats', 'alats.id','=','orders.alat_id')
    ->join('payments','payments.id','=','orders.payment_id')
    ->where('alats.id', $id)
    ->where('orders.status', 2)
    ->where('payments.status', 3)
    ->get(['nama_alat AS title','starts AS start','ends AS end']);

    return json_encode($order);
});
