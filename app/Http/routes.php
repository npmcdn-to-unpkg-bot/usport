<?php
// header('Access-Control-Allow-Origin: http://arunranga.com');
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', array( 'as'=>'home', 'uses'=>function () {
    return view('app');
}));
Route::get('/top', array( 'as'=>'top', 'uses'=>function () {
    return view('app');
}));
Route::get('/category/{categorySlug}', function () {
    return view('app');
});
Route::get('/post/{postId}', function () {
    return view('app');
});
Route::get('/user/{userId}', function () {
    return view('app');
});

Route::group(['middleware' => ['web']], function () {
    Route::resource('post', 'PostCtrl');
});
// Templates
Route::group(array('prefix'=>'/templates/'), function() {
    Route::get('{template}', array(function($template) {
        $template = str_replace(".html", "", $template);
        View::addExtension('html', 'php');
        return View::make('templates.' . $template);
    }));

    Route::get('home/{template}', array(function($template) {
        $template = str_replace(".html","", $template);
        View::addExtension('html', 'php');
        return View::make('templates.home.' . $template);
    }));

    Route::get('user/{template}', array(function($template) {
        $template = str_replace(".html","", $template);
        View::addExtension('html', 'php');
        return View::make('templates.user.' . $template);
    }));

    Route::get('post/{template}', array(function($template) {
        $template = str_replace(".html","", $template);
        View::addExtension('html', 'php');
        return View::make('templates.post.' . $template);
    }));

    Route::get('chat/{template}', array(function($template) {
        $template = str_replace(".html","", $template);
        View::addExtension('html', 'php');
        return View::make('templates.chat.' . $template);
    }));
});

/*API*/
Route::group(array('prefix'=>'/api/'), function() {
	/*User*/
	Route::get('/user/getlistusers/{offset?}/{limit?}/{order?}/{by?}', 'UserController@getList');
    Route::get('/user/getuserbyid/{userId}', 'UserController@getUserById');
    Route::get('/user/getuserbyfbid/{fbId}', 'UserController@getUserByFbId');
    Route::get('/user/sociallogin/{token}', 'UserController@socialLogin');
    Route::get('/user/logout', 'UserController@socialLogout');
    Route::post('/user/savefbuser', 'UserController@saveFacebookUser');

	/*Post*/
	Route::get('/post/getlistposts', 'PostController@getPosts');
    Route::get('/post/gettopposts/{offset?}/{limit?}', 'PostController@getTopPosts');
    Route::get('/post/gethotposts/{offset?}/{limit?}', 'PostController@getHotPosts');

    Route::get('/post/getpostbyid/{postId}', 'PostController@getPostById');
    Route::get('/post/getpostbyslug/{postSlug}', 'PostController@getPostBySlug');

    Route::get('/post/gethotpostsbycategoryid/{categoryId}/{offset?}/{limit?}', 'PostController@getHotPosts');
	Route::get('/post/getpostsbycategoryid/{categoryId}/{offset?}/{limit?}/{order?}/{by?}', 'PostController@getPostsByCategoryId');
	Route::get('/post/getpostsbycategoryslug/{categorySlug}/{offset?}/{limit?}/{order?}/{by?}', 'PostController@getPostsByCategorySlug');

    Route::get('/post/getpostsbyuserid/{userId}/{offset?}/{limit?}', 'PostController@getPostByUserId');    

    Route::post('/post/createpost', 'PostController@createPost');
    Route::post('/post/newpost', 'PostController@newPost');

	/*Category*/
	Route::get('/category/getlistcategories', 'CategoryController@getList');

	/*Tags*/
	Route::get('/tag/getlisttags', 'TagController@getList');
	Route::get('/tag/getpostsbytagid/{tagId}', 'TagController@getPostsByTagId');
	Route::get('/tag/getpostsbytagslug/{tagSlug}', 'TagController@getPostsByTagSlug');

    /*Channel*/
    Route::get('/channel/getmatch/{source?}', 'ChannelController@getmatch');
    Route::get('/channel/getmatchlink/url/{source?}', 'ChannelController@getmatchlink');
    Route::get('/channel/getlivematch/{sport?}', 'ChannelController@getlivematch');

    /*like*/
    Route::post('/post/likecomment', 'PostController@likeComment');
    Route::post('/post/likepost', 'PostController@likePost');
    Route::post('/post/unlikepost/', 'PostController@unlikePost');
    Route::get('/post/getlistlike/{$postId}/{offset?}/{limit?}', 'PostController@getListLike');

    /*comment*/
    Route::get('/post/getcommentsbypostid/{postId}/{offset?}/{limit?}', 'PostController@getCommentsByPostId');
    Route::post('/post/commentpost', array('as' => 'api.post.comment', 'uses' => 'PostController@commentPost'));

    /*share*/
    Route::post('post/sharepost', array('as'=>'api.post.share', 'uses'=>'PostController@sharePost'));

    /*gcm*/
    Route::get('/gcm', 'GcmController@index');
    Route::post('/gcm/registerdevice', 'GcmController@registerDevice');
    Route::post('/gcm/pushnotification', 'GcmController@pushNotification');

    /*upload video*/
    Route::post('/post/upload', 'PostController@upload');
});

// login
Route::get('/admin/login', array(
    // 'as' => 'admin.login',
    function () {
        // if (!Sentinel::check()) {
        //     return view('backend/auth/login');
        // }
        return Redirect::route('admin.dashboard');
    }, ));

Route::get('/facebook', array('as'=>'facebook.login', 'uses'=>'FacebookController@facebookLogin'));
Route::get('/callback', array('as'=>'facebook.callback', 'uses'=>'FacebookController@facebookLoginCallback'));

Route::group(array('prefix' => '/admin',
                       'namespace' => 'Admin',
                       'middleware' => ['before', 'sentinel.auth', 'sentinel.permission'] ), function () {


    // admin dashboard
    Route::get('/', array('as' => 'admin.dashboard', 'uses' => 'DashboardController@index'));

    // category
    Route::resource('category', 'CategoryController', array('before' => 'hasAccess:category'));
    Route::get('category/{id}/delete', array('as' => 'admin.category.delete',
                                                 'uses' => 'CategoryController@confirmDestroy', ))->where('id', '[0-9]+');

    // post
    Route::resource('post', 'PostController', array('before' => 'hasAccess:post'));
    Route::get('post/{id}/delete', array('as' => 'admin.post.delete',
                                                 'uses' => 'PostController@confirmDestroy', ))->where('id', '[0-9]+');
    Route::get('post/{id}/publish', array('as' => 'admin.post.publish',
                                                 'uses' => 'PostController@publish', ))->where('id', '[0-9]+');
    Route::post('post/uploadyoutube', array('as' => 'admin.post.uploadyoutube',
                                                 'uses' => 'PostController@uploadYoutube', ));
    Route::get('post/{id}/postfacebook', array('as' => 'admin.post.sharefb',
                                                 'uses' => 'PostController@shareFb', ))->where('id', '[0-9]+');
    Route::post('post/{id}/postfacebook', array('as' => 'admin.post.postfacebook',
                                                 'uses' => 'PostController@postToFacebook', ))->where('id', '[0-9]+');
    Route::post('post/{id}/toggle-publish', array('as' => 'admin.post.toggle-publish',
                                                         'uses' => 'PostController@togglePublish', ))->where('id', '[0-9]+');

    // user
    Route::resource('user', 'UserController');
    Route::get('/user/{id}/delete', array('as' => 'admin.user.delete',
                                         'uses' => 'UserController@confirmDestroy', ))->where('id', '[0-9]+');

    // role
    Route::resource('/role', 'RoleController');
    Route::get('/role/{id}/delete', array('as' => 'admin.role.delete',
                                          'uses' => 'RoleController@confirmDestroy', ))->where('id', '[0-9]+');
});


Route::auth();

Route::get('/home', 'HomeController@index');

Route::group(array('namespace' => 'Admin'), function () {

    // admin auth
    Route::get('admin/logout', array('as' => 'admin.logout', 'uses' => 'AuthController@getLogout'));
    Route::get('admin/login', array('as' => 'admin.login', 'uses' => 'AuthController@getLogin'));
    Route::post('admin/login', array('as' => 'admin.login.post', 'uses' => 'AuthController@postLogin'));

    // admin password reminder
    Route::get('admin/forgot-password', array('as' => 'admin.forgot.password',
                                              'uses' => 'AuthController@getForgotPassword', ));
    Route::post('admin/forgot-password', array('as' => 'admin.forgot.password.post',
                                               'uses' => 'AuthController@postForgotPassword', ));

    Route::get('admin/{id}/reset/{code}', array('as' => 'admin.reset.password',
                                                'uses' => 'AuthController@getResetPassword', ))->where('id', '[0-9]+');
    Route::post('admin/reset-password', array('as' => 'admin.reset.password.post',
                                              'uses' => 'AuthController@postResetPassword', ));
});

if (App::environment() != 'production') {
    Route::get('/admin/youtubeupload/get-access-token', function() {
        $yt = new \App\Lib\Youtube(new Google_Client);
        $authUrl = $yt->createAuthUrl();
        return View::make('backend.post.youtubeupload')->with(compact('authUrl'));
    });
    Route::get('/admin/youtubeupload/oauth2-callback', function() {
        if (!isset($_GET['code']))
        {
            return Redirect::to('/admin/youtubeupload/get-access-token')->with('message', '$_GET[code] not set');
        }
        $yt = new \App\Lib\Youtube(new Google_Client);
        $accessToken = $yt->authenticate($_GET['code']);
        $yt->saveAccessTokenToDB($accessToken);
        $accessToken = $accessToken['access_token'];
        return View::make('backend.post.youtubeupload')->with(compact('accessToken'));
    });
    Route::get('/admin/youtubeupload', function() {
        $yt = new \App\Lib\Youtube(new Google_Client);
        if ($yt->getLatestAccessTokenFromDB() === null) {
            return Redirect::to('/admin/youtubeupload/get-access-token')->with('message', 'Need to get an access token first');
        }
        return View::make('backend.post.youtubeupload');
    });
    Route::get('/admin/youtubeupload/get-uploads/{maxResults?}', function($maxResults = 50) {
        $yt = new \App\Lib\Youtube(new Google_Client);
        if ($yt->getLatestAccessTokenFromDB() === null) {
            return Redirect::to('/admin/youtubeupload/get-access-token')->with('message', 'Need to get an access token first');
        }
        return Response::json($yt->getUploads($maxResults));
    });
    Route::post('/admin/youtubeupload', function() {
        $rules = array(
            'title' => 'required',
            'status' => 'required|in:public,private,unlisted',
            'video' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return Redirect::to('/admin/youtubeupload')->withInput()->withErrors($validator);
        }
        try {
            $yt = new \App\Lib\Youtube(new Google_Client);
            $youtubeVideoId = $yt->upload(Input::all());
            if ($youtubeVideoId) {
                Session::put('youtubeVideoId', $youtubeVideoId);
                return Redirect::to('/admin/youtubeupload')->with('message', 'Video uploaded successfully, it\'s probably still processing, so keep refreshing');
            } else {
                return Redirect::to('/admin/youtubeupload')->with('message', 'upload is failure');
            }
            
        } catch (Exception $e) {
            return Redirect::to('/admin/youtubeupload')->with('message', $e->getMessage());
        }
    });
}

/*Test*/
Route::get('/test', function ($accessToken) {
    echo 1; die;
    /*// Initialize Guzzle client
    $client = new GuzzleHttp\Client();

    // Create a POST request
    // update post
    $response = $client->request(
        'POST',
        'https://graph.facebook.com/dancing.channel/590267971145079',
        [
            'form_params' => [
                'message' => 'the updated message',
                'access_token' => $accessToken
            ]
        ]
    );

    // Parse the response object, e.g. read the headers, body, etc.
    $headers = $response->getHeaders();
    $body = $response->getBody();

    // Output headers and body for debugging purposes
    var_dump($headers, $body);*/
    die;
});

/*end test*/
