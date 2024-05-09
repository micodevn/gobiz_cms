<?php

namespace App\Listeners;

use App\Repositories\ExerciseRepository;
use Prettus\Repository\Events\RepositoryEntityUpdated;

class SyncModelAfterUpdate
{
    private ExerciseRepository $exerciseRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ExerciseRepository $exerciseRepo)
    {
        $this->exerciseRepository = $exerciseRepo;
    }

    /**
     * Handle the event.
     *
     * @param  RepositoryEntityUpdated  $event
     * @return void
     */
    public function handle(RepositoryEntityUpdated $event)
    {
        $repo = $event->getRepository();
        $model = $event->getModel();
        switch ($model->getTable()) {
            case 'part':
                $inputs = request()->input();
                if ($inputs['exercises']) {
                    $this->exerciseRepository->newQuery()->where('part_id', $model->id)->update([
                        'part_id' => null
                    ]);
                    $this->exerciseRepository->newQuery()->whereIn('id', $inputs['exercises'])->update([
                        'part_id' => $model->id
                    ]);
                }
                break;
        }
    }
}
