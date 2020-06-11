<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class TagServices
{
    /**
     * Создает новые теги из request  и возвращает из id
     * @param FormRequest $formRequest
     * @return array
     */
    public function getTagIdsForAttach(FormRequest $formRequest) : array
    {
        $tagsIds = [];
        $tagsToAttach = explode(', ', $formRequest->tags);
        foreach ($tagsToAttach as $tagToAttach) {
            $tagToAttach = Tag::firstOrCreate(['name' => $tagToAttach]);
            $tagsIds[] = $tagToAttach->id;
        }
        return $tagsIds;
    }

    /**
     * Создает новые теги из request
     * @param FormRequest $formRequest
     * @param Model $model
     * @return array
     */
    public function getTagIdsForUpdate(FormRequest $formRequest, Model $model) : array
    {
        $existTagsFromModel = $model->tags->keyBy('name');
        $tagsFromRequest = collect(explode(', ', $formRequest->tags))
            ->keyBy(function ($item) {
                return $item;
            });
        $tagsIdsForSync = $existTagsFromModel
            ->intersectByKeys($tagsFromRequest)
            ->pluck('id')
            ->toArray();

        $tagsToAttach = $tagsFromRequest->diffKeys($existTagsFromModel);
        foreach ($tagsToAttach as $tagToAttach) {
            $tagToAttach = Tag::firstOrCreate(['name' => $tagToAttach]);
            $tagsIdsForSync[] = $tagToAttach->id;
        }
        return $tagsIdsForSync;
    }

}
