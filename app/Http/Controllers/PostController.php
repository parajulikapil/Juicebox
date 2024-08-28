<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Models\Post;

class PostController extends AbstractRestController
{
    /**
     * Get all posts
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $params = $this->request->toArray();
        $params['user_id'] = $this->request->user()->id;

        // get all posts
        $posts = Post::fetch($params);        

        /**
         * Can do below code if we don't need to restrict as per logged in user
         * Post::fetch();
         */

        return $this->success($posts);
    }

    /**
     * Get a post
     * 
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $userId = $this->request->user()->id;
        $post = Post::fetch([
            'user_id' => $userId, // can comment out this if we don't need to restrict as per logged in user
            'id' => $id
        ], true);
        if (!$post) {
            return $this->notFound();
        }
        return $this->success($post);
    }

    /**
     * Store new post
     * 
     * @return JsonResponse
     */
    public function store(): JsonResponse
    {
        $data = $this->request->validate([
            'title' => ['required', 'string'],
            'description' => ['string']
        ]);
        $data['user_id'] = $this->request->user()->id;
        $post = Post::create($data);

        if (!$post) {
            return $this->error("Cannot create post, please try again");
        }
        return $this->success("Successfully, created post");
    }

    /**
     * Update existing post
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id): JsonResponse
    {
        $post = Post::fetch([
            'user_id' => $this->request->user()->id,
            'id' => $id
        ], true);

        if (!$post) {
            return $this->notFound();
        }

        $data = $this->request->validate([
            'title' => ['required', 'string'],
            'description' => ['string']
        ]);

        $post = $post->update($data);

        if (!$post) {
            return $this->error("Cannot update post, please try again");
        }
        return $this->success("Successfully, updated post");
    }

    /**
     * Get a post
     * 
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $post = Post::fetch([
            'user_id' => $this->request->user()->id,
            'id' => $id
        ], true);

        if (!$post) {
            return $this->notFound();
        }
        $post = $post->delete();

        if (!$post) {
            return $this->error("Could not delete post, please try again");
        }

        return $this->success("Successfully deleted");
    }
}
