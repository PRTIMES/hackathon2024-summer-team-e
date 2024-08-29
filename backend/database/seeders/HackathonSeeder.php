<?php

namespace Database\Seeders;

use App\Jobs\PressReleaseAnalyze;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Seeder;

class HackathonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=Database\\Seeders\\HackathonSeeder
     * @throws GuzzleException
     * @throws Exception
     */
    public function run(): void
    {
        // PRTIMES HACKATHON 2024用のSeeder
        // 提供されるAPIは特定時点でのスナップショットのため、最初に取り込めるだけ取り込む。

        $headers = [
            "Authorization" => "Bearer " . config("services.prtimes.token")
        ];

        $guzzle_client = new Client([
            "base_uri" => "https://hackathon.stg-prtimes.net/"
        ]);

        for ($i = 0; $i < 1; $i++) {

            $response = $guzzle_client->get("/api/releases?per_page=1&page=$i&from_date=2000-01-01", ["headers" => $headers]);

            if ($response->getStatusCode() !== 200)
                throw new Exception("PR TIMES API Error");

            /* @var array<array{
             *     body: string,
             *     company_id: int,
             *     company_name: string,
             *     created_at: string,
             *     lead_paragraph: string,
             *     like: int,
             *     main_category_id: int,
             *     main_category_name: string,
             *     main_image: string,
             *     main_image_fastly: string,
             *     release_id: int,
             *     release_type: string,
             *     sub_category_id: string,
             *     sub_category_name: string,
             *     subtitle: string,
             *     title: string,
             *     url: string
             *     }> $data
             */
            $list = json_decode($response->getBody()->getContents(), true);

            foreach ($list as $data) {

                PressReleaseAnalyze::dispatch($data["company_id"], $data["release_id"]);
            }
        }
    }
}
