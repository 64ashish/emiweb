<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class NewsController extends Controller
{
    public function index()
    {
        // Hämta de senaste 25 nyheterna från databasen
        $latestNews = News::paginate(25);
        // Hämta den senaste nyheten för detaljvyn
        $latestNew = News::latest()->first();

        // Lägg till en rad i news_log-tabellen för den inloggade användaren och den senaste nyheten
        if (Auth::check()) {
            $userId = Auth::id();
            $newsId = $latestNew->id;

            // Kolla om användaren redan har loggat den senaste nyheten, om inte, lägg till i news_log-tabellen
            if (!NewsLog::where('user_id', $userId)->where('news_id', $newsId)->exists()) {
                
                NewsLog::create(['user_id' => $userId, 'news_id' => $newsId]);
            }

            // Sätt sessionens värde till false

            Session::put('user_has_seen_latest_news', true);
        }

        // Visa en lista över nyheter
        return view('news.index', ['latestNews' => $latestNews,'latestNew' =>  $latestNew]);
        
    }


    public function show($id)
    {
        // Försök hitta nyheten baserat på ID
        $latestNew = News::find($id);

        // Om ingen nyhet hittas, omdirigera till /news
        if (!$latestNew) {
            return redirect('/news');
        }

        // Visa enskild nyhet baserat på ID
        return view('news.show', ['latestNew' => $latestNew]);
    }
}
