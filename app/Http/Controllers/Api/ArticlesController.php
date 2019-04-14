<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use App\Http\Resources\ArticleResource;

use \App\Models\Article;

use \App\Models\User;

class ArticlesController extends Controller
{
    protected $galleryImageUploadPath		 = 'storage' . DIRECTORY_SEPARATOR . 'article-images' . DIRECTORY_SEPARATOR . 'galery' . DIRECTORY_SEPARATOR;
    protected $coverImageUploadPath		 = 'storage' . DIRECTORY_SEPARATOR . 'article-images' . DIRECTORY_SEPARATOR . 'covers' . DIRECTORY_SEPARATOR;
    protected $galleryImageThumbUploadPath	 = 'storage' . DIRECTORY_SEPARATOR . 'thumbs' . DIRECTORY_SEPARATOR;
    
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
        
        $articles = $articles->orderBy('created_at','desc')->paginate($perpage);

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
    public function store(Request $request){
        
        $input = Input::all();

        $rules = array(
            'title'=>'required|string|min:3',
            'cover_photo'=>'required|mimetypes:image/jpeg,image/gif,image/bmp,image/png,image/jpg',
            'description'=>'required|min:10|max:10000',
            'file.*' => 'mimetypes:image/jpeg,image/gif,image/bmp,image/png,image/jpg',
        );
        $article = new Article();
        
        $validation = Validator::make($input, $rules);
        if ($validation->fails()) {
            return Response::make(['message'=> $validation->errors()->first()], 400);
        }
        
        if(!empty(Input::file('cover_photo'))){
        $mime2 = Input::file('cover_photo')->getMimeType(); // getting file extension
        
            if (preg_match('/^image\//', $mime2)) {
                $destinationPath = $this->coverImageUploadPath; // upload path
                $fileName = str_random(10) . '_'
                        . str_slug(preg_replace('/(\.[^\.{2,5}])$/', '', Input::file('cover_photo')->getClientOriginalName()))
                        . '.' . Input::file('cover_photo')->guessExtension(); // renameing video

                $upload_success = Input::file('cover_photo')->move($destinationPath, $fileName); // uploading file to given path
                
                $article->cover_photo = DIRECTORY_SEPARATOR . $destinationPath . $fileName;
                
            }
        }
            
            
        $article->user_id = auth()->user()->id;
        $article->title = $request->title;
        $article->description = $request->description;
        $article->save();
        
        if(!empty(Input::file('file'))){
        foreach(Input::file('file') as $file){
            $image = new \App\Models\Image();
            $mime = $file->getMimeType(); // getting file extension
        
            if (preg_match('/^image\//', $mime)) {
                $destinationPath = $this->galleryImageUploadPath; // upload path
                $fileName = str_random(10) . '_'
                        . str_slug(preg_replace('/(\.[^\.{2,5}])$/', '', $file->getClientOriginalName()))
                        . '.' . $file->guessExtension(); // renameing video

                $upload_success = $file->move($destinationPath, $fileName); // uploading file to given path

                if (!is_dir($this->galleryImageThumbUploadPath)) {

                    mkdir($this->galleryImageThumbUploadPath);
                }
                $thumb = Image::make($upload_success)->fit(200, 133)->save($this->galleryImageThumbUploadPath . str_random(32) . '.jpg');

                $image->article_id = $article->id;
                $image->path = DIRECTORY_SEPARATOR . $destinationPath . $fileName;
                $image->thumb = DIRECTORY_SEPARATOR . $this->galleryImageThumbUploadPath . $thumb->basename;
                $image->save();

            }
        }
        }
        
        return Response::json(['message'=>'Successfully created Article!'], 200);
            
    }
}
