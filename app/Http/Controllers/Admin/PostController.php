<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Post;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

// use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->limit(20)->get();

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title'=>'required|string|max:150',
            'content'=>'required|string',
            'published_at'=>'nullable|before_or_equal:today'
        ]);

        $data = $request->all();

        $slug = Post::getUniqueSlug($data['title']);

        dd($slug);

        $post = new Post();
        $post->fill( $data ); 
        $post->slug = $slug;

        $post->save();

        return redirect()->route('admin.posts.index');

        // dd($request->all());
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {   
        //Validare i dati
        $request->validate([
            'title'=>'required|string|max:150',
            'content'=>'required|string',
            'published_at'=>'nullable|before_or_equal:today'
        ]);
        //Prendere id dati
        $data = $request->all();

        //Se il titolo nuovo è diverso dal titolo salvato
        if( $post->title != $data['title']){
            $post = new Post();
            //nuovo slug
            $slug = Post::getUniqueSlug($data['title']);

        }

        $data['slug'] = $slug;

        //Aggiornare i dati
        $post->update($data);
        //Reindirizzare su index
        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index');
    }
}
