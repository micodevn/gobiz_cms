<?php

namespace App\Console\Commands;

use App\Models\Exercise;
use App\Models\Question;
use Illuminate\Console\Command;

class ReCacheExercises extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exercise:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $exercises = Exercise::with(['questions'])->get();

        /** @var Exercise $exercise */
        $this->withProgressBar($exercises, function ($exercise) {
            $exercise->cache();
            echo $exercise->id;
        });

        return 0;
    }
}
