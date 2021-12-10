<?php


use App\Http\Controllers\RecipelistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


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

//Route::middleware('auth:sanctum')->get('/recipelist', [RecipelistController::class, 'index']);

Route::get('/', function()  {
    return 'API working';
});


// ---------- User operations ----------
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function ()  {

    // ---------- Recipelist operations ----------

        //Return all recipelists, this is test only.
        Route::get('/recipelist', [RecipelistController::class, 'index']);

        //Create a new recipelist
        Route::post('/recipelist', [RecipelistController::class, 'store']);

        //Get a single recipelist
        Route::get('/recipelist/{id}', [RecipelistController::class, 'show']);

        //Add a recipe to a list
        Route::put('/recipelist/add/{id}', [RecipelistController::class, 'update_add']);

        //remove a recipe to a list
        Route::put('/recipelist/remove/{id}', [RecipelistController::class, 'update_remove']);

        //Remove recipe list
        //remove a recipe to a list
        Route::delete('/recipelist/{id}', [RecipelistController::class, 'destroy']);
});