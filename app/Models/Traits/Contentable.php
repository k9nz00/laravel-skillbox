<?php

namespace App\Models\Traits;

trait Contentable
{
    /**
     * Загрузить все комментарии к этой статье с информацией об их авторах
     * В параметре-массиве указываются поля модели юзера
     *
     * @param array $ownerFields
     * @return $this
     */
    public function takeCommentsWithOwners(array $ownerFields = ['*'])
    {
        if (count($ownerFields) > 1 && !in_array('id', $ownerFields)) {
            array_unshift($ownerFields, 'id');
        }
        $this->load([
            'comments' => function ($query) use ($ownerFields) {
                $query->with([
                    'owner' => function ($queryOwner) use ($ownerFields) {
                        $queryOwner->select($ownerFields);
                        return $queryOwner->get();
                    },
                ]);
                return $query->latest();
            },
        ]);

        return $this;
    }
}
