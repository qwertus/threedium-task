<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ArticlesController extends Controller {

    protected $galleryImageUploadPath		 = 'storage' . DIRECTORY_SEPARATOR . 'article-images' . DIRECTORY_SEPARATOR;
    protected $galleryImageThumbUploadPath	 = 'storage' . DIRECTORY_SEPARATOR . 'thumbs' . DIRECTORY_SEPARATOR;
    
    public function index() {

        return view('articles.list');
    }

    public function create() {

        return view('articles.create');
    }

    public function store(Request $request) {
        
        dd($request);
    }

    public function edit($id) {
        
        $article = Article::where('id',$id)->where('deleted',0)->firstOrFail();
        
        return view('articles.edit',['article' => $article]);
    }
    
    public function singleArticle($id) {
        
        $article = Article::where('id',$id)->where('deleted',0)->firstOrFail();
        
        return view('articles.single',['article' => $article]);
    }

    public function update($id,Request $request) {
        
        $input = Input::all();

//        $storeData = $this->validate($request, [
//                    'title'=>'nullable|string|min:3',
//                    'cover_photo'=>'nullable|mimes:jpeg,jpg,png,gif',
//                    'description'=>'nullable|min:10|max:10000',
//                    'file.*' => 'nullable|image|mimes:jpeg,gif,bmp,png,jpg',
//		]);
//        
        $rules = array(
            'title'=>'nullable|string|min:3',
            'cover_photo'=>'nullable|sometimes|image|mimes:jpeg,jpg,png,gif',
            'description'=>'nullable|min:10|max:10000',
            'file.*' => 'nullable|mimetypes:image/jpeg,image/gif,image/bmp,image/png,image/jpg',
        );
        
        $article = Article::where('id',$id)->where('deleted',0)->firstOrFail();
        
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
        return response()->json(['message'=>'Successfully Edited Article!'], 200);
    }
    
    public function deleteImage($id) {

            $image = \App\Models\Image::where('id', $id)->first();

            $image->delete();

            unlink(public_path() . $image->path);
            unlink(public_path() . $image->thumb);

            return response()->json('success');
	}

}
