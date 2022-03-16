<?php

use App\Http\Controllers\ChatbotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/botman', [ChatbotController::class, "botEngine"]);

Route::post('/osho-contacts', function (Request $request){

   $data = $request->all();

   $values = $data['value'];

   foreach ($values as $value){

       if(\App\Models\OshoContact::where('contactid', $value['contactid'])->exists() == false){

           $osho_contact = new \App\Models\OshoContact();

           $osho_contact->etag = $value['@odata.etag'];
           $osho_contact->address1_county = $value['address1_county'];
           $osho_contact->firstname = $value['firstname'];
           $osho_contact->fullname = $value['fullname'];
           $osho_contact->lastname = $value['lastname'];
           $osho_contact->mobilephone = $value['mobilephone'];
           $osho_contact->contactid = $value['contactid'];

           $osho_contact->save();
       }

       dd('saved');
   }



});





Route::post('/ussd', [ChatbotController::class, "input"]);
