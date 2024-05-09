<?php

namespace Modules\Contest\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;
use Modules\Contest\Entities\Contest;
use Modules\Contest\Entities\Exam;
use Modules\Contest\Entities\Round;
use Prettus\Repository\Eloquent\BaseRepository;

class ContestRepository extends BaseRepository
{
    public function model()
    {
        return Contest::class;
    }

    public function getContestRounds($id)
    {
        $contest = $this->model::query()->findOrFail($id);

        return $contest->rounds();
    }

    public function create($attributes, int $id = null)
    {
        $contest = parent::create($attributes);
        $contestRounds = $this->groupContestRounds($attributes, $id);
        foreach ($contestRounds as &$contestRound) {
            $contestRound['contest_id'] = $contest->id;
        }
        $this->saveContestRoundInfo($contestRounds);
        Redis::rpush('k12:product:cms:system:data:cache:queue', json_encode([
            'action' => 'UPDATE_ALL',
            'eventName' => 'k12_contest',
            'data' => $contest->id
        ]));
        return $contest;
    }



    public function update(array $attributes, $id): mixed
    {
        $contestRounds = $this->groupContestRounds($attributes,$id);
        $contest = parent::update($attributes, $id);
        $savedContestRounds = $this->saveContestRoundInfo($contestRounds);
// TODO push to queue
        // Remove unused Contest Round
        $savedContestRoundIds = $savedContestRounds->pluck('id')->toArray();
        $savedContestRoundIds = array_filter($savedContestRoundIds);
        $this->removeUnusedContestRound($contest, $savedContestRoundIds);
        // TODO push to queue
        Redis::rpush('k12:product:cms:system:data:cache:queue', json_encode([
            'action' => 'UPDATE_ALL',
            'eventName' => 'k12_contest',
            'data' => $contest->id
        ]));
        return $contest;
    }

    protected function removeUnusedContestRound($contest, $contestRoundIds): int
    {
        $contestRoundIds = is_array($contestRoundIds) ? $contestRoundIds : [$contestRoundIds];
        $contest = is_numeric($contest) ? Contest::query()->find($contest) : $contest;
        return $contest->rounds()->whereNotIn('id', $contestRoundIds)->delete();
    }

    protected function groupContestRounds($attributes, $id = null): array
    {
        $contestRoundIds = Arr::get($attributes, 'contest_round_id', []);
        $contestRounds = [];
        foreach ($contestRoundIds as $idx => $value) {
            $contestRound = [
                'id' => $value,
                'title' => Arr::get($attributes, 'contest_round_info.' . $idx),
                'round_id' => Arr::get($attributes, 'contest_round_id.' . $idx),
                'contest_id' => Arr::get($attributes, 'contest_id.' . $idx),
                'thumbnail' => Arr::get($attributes, 'thumbnail.' . $idx),
                'start_time' => Arr::get($attributes, 'round_start_time.' . $idx),
                'end_time' => Arr::get($attributes, 'round_end_time.' . $idx),
                'is_active' => 1,
            ];
            $contestRounds[] = $contestRound;
        }
        return $contestRounds;
    }

    public function saveContestRoundInfo($contestRounds): Collection
    {
        $contestRoundData = [];
        foreach ($contestRounds as $contestRound) {
            if (Arr::get($contestRound, 'id')) {
                $id = Arr::get($contestRound, 'id');
                $contestRoundModel = Round::query()->find($id);
                $contestRoundModel->update($contestRound);
                $contestRoundData[] = $contestRoundModel;
                continue;
            }
            unset($contestRound['id']);
            $contestRoundModel = Round::query()->create($contestRound);

            $contestRoundData[] = $contestRoundModel;
        }

        return collect($contestRoundData);
    }
}
