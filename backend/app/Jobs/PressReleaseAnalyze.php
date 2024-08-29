<?php

namespace App\Jobs;

use App\Libs\Bedrock;
use App\Libs\OpenAI;
use App\Libs\PrTimesApi;
use App\UseCases\Company\CreateOrFirstAction as CompanyCreateOrFirstAction;
use App\UseCases\Keyword\CreateOrFirstAction as KeywordCreateOrFirstAction;
use App\UseCases\PressRelease\CreateAction as PressReleaseCreateAction;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class PressReleaseAnalyze implements ShouldQueue
{
    use Queueable;

    const EXACT_MATCH_WEIGHT = 2;

    /**
     * @param int $company_id
     * @param int $release_id
     */
    public function __construct(
        private readonly int $company_id,
        private readonly int $release_id
    )
    {}

    /**
     * @return void
     * @throws GuzzleException
     * @throws Exception
     */
    public function handle(): void
    {
        $openai = new OpenAI(config("services.openai.token"));

        $bedrock = new Bedrock();

        $prtimes = new PrTimesApi(config("services.prtimes.token"));

        $release_data = $prtimes->release($this->company_id, $this->release_id);
        $company_data = $prtimes->company($this->company_id);

        CompanyCreateOrFirstAction::run(
            company_id: $this->company_id,
            name: $company_data["company_name"],
            industry_id: $company_data["industry_id"]
        );

        $body = strip_tags($release_data["body"]);

        $summary = $openai->answer(
            question: $body,
            background: "あなたは、プレスリリースの内容を元にして、若者に興味を持ってもらえる文章を生成するエージェントです。\n
                         以下の条件を満たしてください。\n
                         1. 生成した文章は100文字以内\n
                         2. 絵文字は用いない\n
                         3. 内容に基づく。感想を含めない。"
        );

        $press_release = PressReleaseCreateAction::run(
            company_id: $this->company_id,
            release_id: $this->release_id,
            title: $release_data["title"],
            summary: $summary,
            release_created_at: $release_data["created_at"]
        );

        $keywords_string = $bedrock->answer(
            question: "以下の文章から重要なキーワードを抜き出せ \n
                       指示 \n
                       名詞や固有名詞のみ出力すること \n
                       年月日は重要ではないので出力しないこと \n
                       以下のようなJSONの配列形式で出力すること \n
                       [\"キーワード\", \"キーワード\", ...] \n
                       JSONデータ以外一切出力しないこと \n\n" . $body
        );
        $keywords = json_decode($keywords_string) ?? [];

        foreach ($keywords as $keyword) {

            $keyword = KeywordCreateOrFirstAction::run($keyword);

            $press_release->keywords()
                          ->syncWithPivotValues(
                              $keyword->id,
                              [
                                  "weight" => self::EXACT_MATCH_WEIGHT
                              ],
                              false
                          );
        }

        // @todo さらに形態素解析をかまして、低い重みでキーワードを登録する。

        // ChatGPTのレート制限回避用
        sleep(20);
    }

    public function failed($exception = null)
    {
        dd($exception);
    }
}
