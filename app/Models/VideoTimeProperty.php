<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class VideoTimeProperty extends Model
{
    use HasFactory;

    const TYPE_TIMESTAMP = 'TIMESTAMP';
    const TYPE_SUBTITLE = 'SUBTITLE';

    const FROM_VIDEO = 'VIDEO';
    const FROM_QUESTION = 'QUESTION';

    public $fillable = [
        'start', 'end', 'title', 'description', 'type', 'file_id', 'fulltext'
    ];

    public function timestampQuestionsFull()
    {
        return $this
            ->belongsToMany(Question::class, 'question_video_times', 'vid_time_property_id', 'question_id')
            ->select([
                'id',
                'name',
                'title',
                'description',
                'thumbnail',
                'metadata_version',
                'response_interaction_type',
                'question_content',
                'answers',
                'platform_id',
                'is_active',
                'created_by',
                'product_id',
                'topic_id',
                'old_question_id',
                'level'
            ])
            ->where('question_video_times.type', VideoTimeProperty::TYPE_TIMESTAMP)
            ->where('question_video_times.from', VideoTimeProperty::FROM_VIDEO);
    }


    public function timestampQuestionsFileList()
    {
        return $this
            ->belongsToMany(Question::class, 'question_video_times', 'vid_time_property_id', 'question_id')
            ->select([
                'id',
                'name',
                'title',
                'description',
                'thumbnail',
                'metadata_version',
                'response_interaction_type',
                'platform_id',
                'is_active',
                'created_by',
                'product_id',
                'topic_id',
                'old_question_id',
                'level'
            ])
            ->where('question_video_times.type', VideoTimeProperty::TYPE_TIMESTAMP)
            ->where('question_video_times.from', VideoTimeProperty::FROM_VIDEO);
    }

    public function timestampQuestions()
    {
        $relateTable = (new Question())->getTable();
        return $this->timestampQuestionsFull()
            ->select('name', "${relateTable}.id", 'question_video_times.type', 'question_video_times.from');
    }

    public function questionVideoTimestamps(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(QuestionVideoTimes::class,'vid_time_property_id','id');
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
