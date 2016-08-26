<?php

namespace App\Http\Controllers\Admin;

use View;
use Flash;
use Input;
use Response;
use Redirect;
use Illuminate\Http\Request;
use App\Services\Pagination;
use App\Http\Controllers\Controller;
use App\Repositories\Post\PostInterface;
use App\Repositories\Category\CategoryInterface;
use App\Models\Attachment;
use App\Exceptions\Validation\ValidationException;
use App\Repositories\Post\PostRepository as Post;
use App\Repositories\Category\CategoryRepository as Category;

class PostController extends Controller
{
    
    protected $post;
    protected $category;
    protected $perPage;
    protected $yt;

    public function __construct(PostInterface $post, CategoryInterface $category)
    {
        View::share('active', 'blog');
        $this->post = $post;
        $this->category = $category;
        $this->perPage = 10;//config('fully.modules.post.per_page');
        $this->yt = new \App\Lib\Youtube(new \Google_Client);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $code = $request->get('code', '');
        if ($code != '') {
            $yt = new \App\Lib\Youtube(new \Google_Client);
            $accessToken = $yt->authenticate($code);
            $yt->saveAccessTokenToDB($accessToken);
            // $accessToken = $accessToken['access_token'];
            // return View::make('backend.post.youtubeupload')->with(compact('accessToken'));
        }
        $pagiData = $this->post->paginate(Input::get('page', 1), $this->perPage, true);
        $posts = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);

        return view('backend.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->category->lists();

        return view('backend.post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        try {
            $this->post->create(Input::all());
            flash()->message('Post was successfully added');

            return langRedirectRoute('admin.post.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.post.create')->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $post = $this->post->find($id);

        return view('backend.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $post = $this->post->find($id);
        $tags = null;

        foreach ($post->tags as $tag) {
            $tags .= ','.$tag->name;
        }

        $tags = substr($tags, 1);
        $categories = $this->category->lists();
        $attachments = $post->attachments()->first();

        return view('backend.post.edit', compact('post', 'tags', 'categories', 'attachments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id)
    {
        try {
            $this->post->update($id, Input::all());
            flash()->message('Post was successfully updated');

            return langRedirectRoute('admin.post.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.post.edit')->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->post->delete($id);
        flash()->message('Post was successfully deleted');

        return langRedirectRoute('admin.post.index');
    }

    public function confirmDestroy($id)
    {
        $post = $this->post->find($id);

        return view('backend.post.confirm-destroy', compact('post'));
    }

    public function togglePublish($id)
    {
        return $this->post->togglePublish($id);
    }

    /**
     * [publish video to youtube]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function publish($id) {
        $accessToken = $this->yt->getLatestAccessTokenFromDB();
        if ($accessToken === null) {
            $yt = new \App\Lib\Youtube(new \Google_Client);
            $authUrl = $yt->createAuthUrl();
            return view('backend.post.publish', compact('authUrl'));
        }
        \Log::info('AdminPostController|access_token: ' . json_encode($this->yt->getLatestAccessTokenFromDB()) . '::' . json_encode($accessToken));
        $post = $this->post->find($id);
        if ($post->youtube_id !== null || $post->fb_post_id !== null) {
            $youtubeVideo = 'https://www.youtube.com/embed/' . $post->youtube_id;
            return view('backend.post.publish', compact('youtubeVideo'));
        }
        $attachments = $post->attachments()->first();
        return view('backend.post.publish', compact('post', 'attachments', 'accessToken'));
    }

    /**
     * [uploadYoutube description]
     * @return [type] [description]
     */
    public function uploadYoutube() {
        try {
            $id = Input::get('id');
            $title = Input::get('title');

            $yt = new \App\Lib\Youtube(new \Google_Client);
            $result = $yt->upload(Input::all());
            if ($result !== false) {
                \Log::info('Youtube upload result:' . json_encode($result));
                try {
                    //update attachment
                    $attachment = Attachment::where('post_id', $id)->first();
                    $attachment->title = $title;
                    $attachment->src = 'http://youtube.com/watch?v=' . $result['id'];
                    $attachment->thumb = 'http://img.youtube.com/vi/' . $result['id'] . '/0.jpg';
                    $attachment->save();                    
                } catch (Exception $e) {
                    \Log::error('Admin_postcontroller|message:' . $e->getMessage());
                }
                
                //update to posts table
                $this->post->update($id, array('youtube_id'=>$result['id'], 'title'=>Input::get('title'), 'content'=>Input::get('description')));
                flash()->message('Publish was successfully');
            }  else {
                flash()->message('Publish was failure');    
            }
            
            return langRedirectRoute('admin.post.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.post.publish')->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * load form share post to fanpage
     * before: video was uploaded to youtube
     * 
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function shareFb ($id) {
        $post = $this->post->find($id);
        return view('backend.post.postfacebook', compact('post'));
    }

    /**
     * method POST
     * 
     */
    public function postToFacebook () {
        $id = Input::get('id');
        $url = config('cc.facebook_api.graph_url') . config('cc.facebook_api.fanpage_id') . '/feed';
        $result = postData($url, Input::all());
        \Log::info('facebook upload result:' . json_encode($result));
        if ($result !== false && isset($result->id)) {
            //update fb_post_id
            try {
                $post = Post::find($id);
                $post->fb_post_id = $result->id;
                $post->save();
                flash()->message('Publish was successfully');
                return view('backend.post.postfacebook', compact('post'));
            } catch (Exception $e) {
                \Log::error('Admin_postcontroller|message:' . $e->getMessage());
            }

        }  else {
            flash()->message('Publish was failure');    
        }
        flash()->message('Publish was failure');
        return langRedirectRoute('admin.post.index');
    }
}
