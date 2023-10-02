<?php

namespace App\Http\Resources\Blog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'slug' => $this->slug,
            'title' => $this->title,
            'intro' => $this->intro,
            'content' => $this->content,
            'img' => asset('storage/images/blog') . '/' . $this->img, // asset('storage/images/blog/')
            'site_description' => $this->site_description,
            'site_keyword' => $this->site_keyword,
            'approved' => $this->approved,
            'published' => $this->published,
            'comments_allowed' => $this->comments_allowed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
