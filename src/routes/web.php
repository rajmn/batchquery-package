<?php
Route::group(['namespace'=>'Rajbatch\Batchquery\Controllers'],function(){
	Route::get('batchquery','Batchquery@batchUpdate');
});
Route::get('batch',function(){
	return "package route";
});