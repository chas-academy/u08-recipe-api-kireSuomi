<?php

namespace App\Http\Controllers;
use App\Models\RecipeList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipelistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userID =  auth()->user()['id'];
        $lists = RecipeList::where('userID', $userID)->get();
        return $lists ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newList = false;

        if ($request['name'] !== '') {
            $newList = RecipeList::create([
                'name' => $request['name'],
                'userID' => auth()->user()['id'],
                'recipes' => json_encode([])
            ]);
        }
  
        return $newList;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return RecipeList::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $recipelist = RecipeList::find($id);
        $recipelist->update($request->all());
        return $recipelist;
    }

    public function update_add(Request $request, $id) {

        $recipelist = RecipeList::firstWhere(['id' => $id]);

        $recipies = json_decode($recipelist['recipes']);

        $recipies[] = $request['recipeID'];
        $recipelist['recipes'] = json_encode($recipies);

        $r = $recipelist->update([$recipelist]);

        return  $recipelist;
    }

    public function update_remove(Request $request, $id) {

        $recipelist = RecipeList::firstWhere(['id' => $id]);

        $recipies = json_decode($recipelist['recipes']);

        $newArr = [];
        foreach ($recipies as $key => $value) {
            if ($value !== $request['recipeID']) $newArr[] = $value;
        }


        $recipelist['recipes'] = json_encode($newArr);
        $r = $recipelist->update([$recipelist]);

        return  $recipelist;
    }   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return RecipeList::destroy($id);
    }
}
