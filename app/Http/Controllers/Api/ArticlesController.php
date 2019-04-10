<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Http\Resources\ArticleResource;

use \App\Models\Article;

use \App\Models\User;

class ArticlesController extends Controller
{
    public function index(Request $request) {
        
        $validated = $request->validate([
            'filters' => 'nullable',
            'pagelimit'   => 'nullable|in:5,10,15,20',
        ]);
        
        $filter = $validated['filters'];
        $perpage = 5;

        $articles = Article::where('deleted', '=', 0);

        
        if(!empty($filter)){
            
            $articles->where('user_id', $filter);
            
        }
        
        if (!empty($validated['pagelimit'])){
            $perpage = $validated['pagelimit'];
        }
        
        $articles = $articles->paginate($perpage);

        return ArticleResource::collection($articles)->additional([
                    'message' => 'ok'
        ]);
    }

    public function destroy($id) {

            try {
                $article = Article::findOrFail($id);
            } catch (ModelNotFoundException $e) {
                return response()->json([
                            'message' => 'Article does not exist',
                            'status' => 0
                ]);
            }
            if ($article->deleted == 0) {
                if ($article->save()) {
                    $article->deleted = 1;
                    foreach ($article->images as $image){
                        $image->delete();
                    }
                    $article->save();
                    return response()->json(['message' => 'Article successfully deleted!',
                                'status' => 200]);
                } else {
                    return response()->json(['message' => 'Article does not exist',
                                'status' => 0]);
                }
            } else {
                return response()->json(['message' => 'Article does not exist',
                            'status' => 0]);
            }
        } 
    
}
