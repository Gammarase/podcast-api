<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\GuestResource;
use App\Http\Resources\TopicResource;
use App\Http\Response;
use App\Models\Category;
use App\Models\Guest;
use App\Models\Topic;

class ResourceController extends Controller
{
    public function getTopics()
    {
        return Response::success(TopicResource::collection(
            Topic::limit(200)->get()
        ));
    }

    public function getCategories()
    {
        return Response::success(CategoryResource::collection(
            Category::limit(200)->get()
        ));
    }

    public function getGeusts()
    {
        return Response::success(GuestResource::collection(
            Guest::limit(200)->get()
        ));
    }
}
