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

        //Creare slug
        $slug = Str::slug( $data['title'] );
        // dd($slug);

        //Variabile di appoggio per alleggerire while
        $slug_base = $slug;

        //Contatore per slug
        $counter = 1;

        //Controllare che non sia doppio
            //Cercare il primo slug creato con quel determinato titolo
        $post_present = Post::where('slug', $slug)->first();

        //Ciclo while per controllare che slug sia disponibile
            //In caso aggiunge $counter
        while( $post_present ){

            $slug = $slug_base . '-' . $counter;
            $counter++;
            $post_present = Post::where('slug', $slug)->first();
        }

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
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
