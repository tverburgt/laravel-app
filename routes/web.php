<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});


Route::get('/about/{id}', function($id){
    return 'This is the about page with parameter: ' . $id;
});

Route::get('/home',array('as'=>'home.page', function(){
    $url = route('home.page');
    return 'This is the url: ' . $url;
}));


//Create a route /test/{id} that calls index methode from PostsController controller
Route::get('/test/{id}', 'PostsController@index');

//This allows us to access all the methods in our controller.
//php artisan route:list will show all the generates routes with alias names.

//Route::resource('posts', 'PostsController');

Route::get('/contact', 'PostsController@show_my_view');

Route::get('/post/{id}/{name}/{password}', 'PostsController@show_post');

//use Illuminate\Support\Facades\DB;


/*
|--------------------------------------------------------------------------
| Using Raw SQL
|--------------------------------------------------------------------------
|
*/



Route::get('/insert', function(){
    DB::insert('insert into posts(title, content) values(?,?)', ['Mr', 'What is your name?']);
});

Route::get('/read', function(){
    $result = DB::select('select * from posts where id=?', [1]);
    foreach($result as $post){
        return $post->title;
    }
});

Route::get('/update', function(){
    $update = DB::update('update post set title="update title" where id=?', [1]);
    return $update;
});

Route::get('/deleted',function(){
    $deleted = DB::delete('delete from post where id=?', [1]);
    return $deleted;
});

/*
|--------------------------------------------------------------------------
| Using Eloquent
|--------------------------------------------------------------------------
|
*/

use App\Post; //We are using the methods from the model class that Post extends.

Route::get('/display', function(){
    //$posts would recieve an array of objects/class.
    $posts = Post::all();

    foreach($posts as $post){
        return $post->title;
    }
});


//
Route::get('/find', function(){
    //$posts would recieve an array of objects/class.
    $posts = Post::find(2);

    return $posts->title;
});

Route::get('/findwhere', function(){
    $posts = Post::where('id', 2)->orderBy('id', 'desc')->take(1)->get();
        return $posts;

    
});

//find the user_count with number less that 50
Route::get('/findmore', function(){
    $posts = Post::where('user_count', '<', 50)->firstorFail();
});

Route::get('/basicinsert', function(){
    $posts = new Post;
    $posts->title = 'laravel';
    $posts->content = 'This is a elequent post';
    $posts -> save();
});

Route::get('/editfield', function(){
    $posts = Post::find(2);
    $posts->title = 'This is new data';
    $posts->save();
});

Route::get('/create', function(){
    Post::create(['title'=>'Mrs', 'content'=>'laravel is awesome']);
    //In order for this create method to work we need to override the $fillable
    //in the model class.
});

Route::get('/update', function(){
    $posts = Post::where('id', 4)->update(['title'=>'using update', 
    'content'=>'update content']);
});

//Delete row with id value of 2
Route::get('/delete', function(){
    $posts = Post::find(2);
    $posts -> delete();
});

//Alternative way of deleting a row with value id 2
Route::get('/delete2', function(){
    Post::destroy(2);
});

//Delete multiple rows with di 2,4,5,10
Route::get('/delete2', function(){
    Post::destroy([2,4,5,10]);
});

//Delete row with specific data
Route::get('delete_specific', function(){
    Post::where('is_admin', 2)->delete();
});