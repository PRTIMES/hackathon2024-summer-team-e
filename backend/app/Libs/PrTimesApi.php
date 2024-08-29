<?php

namespace App\Libs;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

class PrTimesApi
{
    private GuzzleClient $guzzle;
    private array $header;

    private array $industries = [
        1 => "水産・農林業",
        2 => "鉱業",
        3 => "建設業",
        4 => "製造業",
        5 => "電気・ガス業",
        6 => "倉庫・運輸関連業",
        7 => "情報通信",
        8 => "商業（卸売業、小売業）",
        9 => "金融・保険業",
        10 => "不動産業",
        11 => "水産・農林業",
        12 => "官公庁・地方自治体",
        13 => "飲食店・宿泊業",
        14 => "医療・福祉",
        15 => "教育・学習支援業",
        16 => "財団法人・社団法人・宗教法人"
    ];

    public function __construct(
        string $token,
        string $endpoint = "https://hackathon.stg-prtimes.net/"
    )
    {
        $this->header = [
            "Authorization" => "Bearer " . $token
        ];

        $this->guzzle = new GuzzleClient([
            "base_uri" => "https://hackathon.stg-prtimes.net/"
        ]);
    }

    /**
     * @param int $company_id
     * @param int $release_id
     * @return array{
     *             body: string,
     *             company_id: int,
     *             company_name: string,
     *             created_at: string,
     *             lead_paragraph: string,
     *             like: int,
     *             main_category_id: int,
     *             main_category_name: string,
     *             main_image: string,
     *             main_image_fastly: string,
     *             release_id: int,
     *             release_type: string,
     *             sub_category_id: string,
     *             sub_category_name: string,
     *             subtitle: string,
     *             title: string,
     *             url: string
     *         }
     * @throws GuzzleException
     * @throws Exception
     */
    public function release(int $company_id, int $release_id): array
    {
        $response = $this->guzzle->get("/api/companies/$company_id/releases/$release_id", ["headers" => $this->header]);

        if ($response->getStatusCode() !== 200)
            throw new Exception("PR TIMES API Error");

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param int $per_page
     * @param int $page
     * @param string $from_date
     * @return array<array{
     *             body: string,
     *             company_id: int,
     *             company_name: string,
     *             created_at: string,
     *             lead_paragraph: string,
     *             like: int,
     *             main_category_id: int,
     *             main_category_name: string,
     *             main_image: string,
     *             main_image_fastly: string,
     *             release_id: int,
     *             release_type: string,
     *             sub_category_id: string,
     *             sub_category_name: string,
     *             subtitle: string,
     *             title: string,
     *             url: string
     *         }>
     * @throws GuzzleException
     * @throws Exception
     */
    public function releases(
        int $per_page = 10,
        int $page = 0,
        string $from_date = "2020-01-01"
    ): array
    {
        $response = $this->guzzle->get("/api/releases?per_page=$per_page&page=$page&from_date=$from_date", ["headers" => $this->header]);

        if ($response->getStatusCode() !== 200)
            throw new Exception("PR TIMES API Error");

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param int $company_id
     * @return array{
     *     company_id: int,
     *     company_name: string,
     *     president_name: string,
     *     address: string,
     *     phone: string,
     *     description: string,
     *     industry: string,
     *     industry_id: int,
     *     ipo_type: string,
     *     capital: int,
     *     foundation_date: string,
     *     url: string,
     *     twitter_screen_name: string
     *         }
     * @throws GuzzleException
     * @throws Exception
     */
    public function company(
        int $company_id
    ): array
    {
        $response = $this->guzzle->get("/api/companies/$company_id", ["headers" => $this->header]);

        if ($response->getStatusCode() !== 200)
            throw new Exception("PR TIMES API Error");

        $industries = array_flip($this->industries);

        $company_data = json_decode($response->getBody()->getContents(), true);
        if (!array_key_exists($company_data["industry"], $industries))
            $company_data["industry_id"] = 17;
        else
            $company_data["industry_id"] = $industries[$company_data["industry"]];
        return $company_data;
    }
}