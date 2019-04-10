<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticlesController extends Controller
{
    public function index() {
        
        return view('articles.list');
        
    }
    
    public function create() {
        
         return view('articles.create');
        
    }
    
    public function edit() {
        
         return view('articles.edit');
        
    }
}
