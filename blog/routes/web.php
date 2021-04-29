<?php

use App\Models\Post;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Spatie\YamlFrontMatter\YamlFrontMatter;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    $files = File::files(resource_path("posts"));

    $posts = [];

    foreach ($files as $file) {
        $document = YamlFrontMatter::parseFile($file);

        $posts[] = new Post(
            $document->title,
            $document->excerpt,
            $document->date,
            $document->body(),
            $document->slug,
        );

    }

    return view('posts', [
       'posts' => $posts
    ]);


   // $document = YamlFrontMatter::parseFile(
   //     resource_path('posts/my-4th-post.html')
   // );
   // ddd($document->date);

    //return Post::find('my-1st-post');
    //ddd(Post::all());

    //return view('posts', [
    //    'posts' => Post::all()
    //]);

});


/*Route::get('posts/{post}', function ($slug) {
    $path = __DIR__ . "/../resources/posts/{$slug}.html";

    //ddd($path);

    if(! file_exists($path)){
        //dd('page does not exist');
        //ddd('page does not exist');
        //abort(404);
        return redirect('/');
    }

    $post = cache()->remember('posts.{$slug}' , now()->addMinutes(20), function () use ($path){
        var_dump('file_get_content');
        return file_get_contents($path);
    });



    return view('post', [
     //'post' => '<h1>Hello World</h1>' //$post
       'post' => $post
    ]);
})->where('post','[A-z_\-\0-9]+'); //security, no end user can enter weird characters in the url.
//->whereAlphaNumeric('post');*/

Route::get('posts/{post}', function ($slug) {
    //find a post by it's slug and pass it to a view called "post".

    return view('post',[
        'post' => Post::find($slug)
    ]);

})->where('post','[A-z_\-\0-9]+');
