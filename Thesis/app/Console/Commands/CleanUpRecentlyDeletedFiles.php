<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Models\DeletedFile;

class CleanUpRecentlyDeletedFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:recentlydeleted';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete files from recently deleted folder older than 30 days';

    /**
     * Execute the console command.
     */

     public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $deletedFiles = DeletedFile::where('deleted_at', '<', Carbon::now()->subDays(30))->get();

        foreach ($deletedFiles as $deletedFile) {
            $deletedFilePath = storage_path('app/' . $deletedFile->path);

            if (File::exists($deletedFilePath)) {
                File::delete($deletedFilePath);
            }

            $deletedFile->delete();
        }

        $this->info('Old files cleaned up successfully!');
        return 0;
    }
}
