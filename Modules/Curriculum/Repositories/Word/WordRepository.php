<?php

namespace Modules\Curriculum\Repositories\Word;

use App\Repositories\BaseRepository;
use Modules\Curriculum\Entities\Unit;
use Modules\Curriculum\Entities\Word;

class WordRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'text',
        'description',
        'is_active',
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Word::class;
    }

    public function baseQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->newQuery()
            ->where('deleted_at', null)
            ->orderBy('id', 'desc');
    }
}
