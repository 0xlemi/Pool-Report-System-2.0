<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention;
use Storage;

class imageVariousSizes  extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:imageToVariousSizes {folder} {maxNum} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Size and Move the image in S3, ready for use in migrations.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $folder = $this->argument('folder');
        $maxNum = $this->argument('maxNum');

        $bar = $this->output->createProgressBar($maxNum );

        for ($i=1; $i <= $maxNum; $i++) {
            // get the contents back from S3 temp
            $contents = Storage::get("migrations/images/{$folder}/{$i}.jpg");

            // Process image to get different sizes
            $img = Intervention::make($contents);
            // big
            $streamBig = (string) $img->fit(1200, null, function ($constraint){
                    $constraint->upsize();
                })->stream('jpg');
            // medium
            $streamMedium = (string) $img->fit(600, null, function ($constraint){
                    $constraint->upsize();
                })->stream('jpg');
            // thumbnail
            $streamThumbnail = (string) $img->fit(250, null, function ($constraint){
                    $constraint->upsize();
                })->stream('jpg');
            // icon
            $streamIcon = (string) $img->fit(64, null, function ($constraint){
                    $constraint->upsize();
                })->stream('jpg');

            // Store final Images in S3
            $pathBig = Storage::put("migrations/images/{$folder}/big/{$i}.jpg", $streamBig);
            $pathMedium = Storage::put("migrations/images/{$folder}/medium/{$i}.jpg", $streamMedium);
            $pathThumbnail = Storage::put("migrations/images/{$folder}/thumbnail/{$i}.jpg", $streamThumbnail);
            $pathIcon = Storage::put("migrations/images/{$folder}/icon/{$i}.jpg", $streamIcon);

            // update the bar
            $bar->advance();
        }

        $bar->finish();
    }
}
