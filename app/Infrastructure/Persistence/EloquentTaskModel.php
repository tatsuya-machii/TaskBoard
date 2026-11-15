<?php

namespace App\Infrastructure\Persistence;

use Illuminate\Database\Eloquent\Model;

/** tasks テーブル専用の永続化モデル。ドメインのエンティティではない。 */
class EloquentTaskModel extends Model
{
    protected $table = 'tasks';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];
}
