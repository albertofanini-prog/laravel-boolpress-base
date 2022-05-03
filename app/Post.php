<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'published_at',
        'slug',
    ];

    public static function getUniqueSlug($title){
        //Creare slug
        $slug = Str::slug( $title );
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

        return $slug;
    }
}
