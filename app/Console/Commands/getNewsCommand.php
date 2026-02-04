<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\City;
use App\Models\News;
use Carbon\Carbon;


class getNewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-news-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch news for all cities and remove old news older than 15 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $cities = City::all();
            foreach ($cities as $city) {
                $this->info('Fetching news for city: ' . $city->slug);
                $this->fetchNews($city);
            }

            $this->removeOldNews();
            
        } catch (\Exception $e) {
            $this->error('Error fetching news: ' . $e->getMessage());
        }        
    }

    private function fetchNews($city)
    {
        $apiKey = config('services.newsapi.key');

        $twoHoursAgo = Carbon::now()->subHours(23)->toIso8601String();
        $now = Carbon::now()->toIso8601String();

        $response = Http::get(config('services.newsapi.endpoint') . 'everything', [
            'q'        => $city->slug,
            'language' => 'hi',
            'sortBy'   => 'publishedAt',
            'pageSize' => 100,          // fetch more to cover 2 hours
            'from'     => $twoHoursAgo,
            'to'       => $now,
            'apiKey'   => $apiKey,
        ]);

        if ($response->failed()) {
            $this->error('Failed to fetch news: ' . $response->body());
            return;
        }

        $news = $response->json()['articles'] ?? [];

        $articles = [];
        foreach ($news as $article) {

            $count = News::where('title', $article['title'])->count();
            if ($count > 0) {
                continue; // Skip duplicate
            }

            $articles[] = [
                'city_id'     => $city->id,
                'title'       => $article['title'],
                'description' => $article['description'],
                // 'content'     => $article['content'],
                'image'       => $article['urlToImage'],
                'published_date' => Carbon::parse($article['publishedAt']),
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
                // 'author'      => $article['author'],
                'source_name' => $article['source']['name'],
                'source_link' => $article['url'],
            ];


            // $this->info("Title: " . $article['title']);
            // $this->info("Description: " . $article['description']);
            // $this->info("URL: " . $article['url']);
            // $this->info("Published At: " . $article['publishedAt']);
            // $this->info("---------------------------");
        }
        if (!empty($articles)) {
            News::insert($articles);
            $this->info('Inserted ' . count($articles) . ' articles for city: ' . $city->slug);
        } else {
            $this->info('No news articles found for city: ' . $city->slug);
        }      
        
    }  
    
    private function removeOldNews()
    {
        $thresholdDate = Carbon::now()->subDays(7);
        News::where('created_at', '<', $thresholdDate)->delete();
        $this->info('Old news articles removed.');
    }
}
