<?php

namespace App\Providers;

use App\Models\Adventures;
use App\Models\Campaigns;
use App\Models\Characters;
use App\Models\Explorations;
use App\Models\ExplorationsBoard;
use App\Models\Features;
use App\Models\Interactions;
use App\Models\InteractionsBoard;
use App\Models\Scenarios;
use App\Observers\AdventuresObserver;
use App\Observers\CampaignsObserver;
use App\Observers\CharactersObserver;
use App\Observers\ExplorationsBoardObserver;
use App\Observers\ExplorationsObserver;
use App\Observers\FeaturesObserver;
use App\Observers\InteractionsBoardObserver;
use App\Observers\InteractionsObserver;
use App\Observers\ScenariosObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
  /**
   * Configuração global de observers
   * 
   * @return void
   */
  public function boot()
  {
    Characters::observe(CharactersObserver::class);
    Features::observe(FeaturesObserver::class);
    Campaigns::observe(CampaignsObserver::class);
    Adventures::observe(AdventuresObserver::class);
    Scenarios::observe(ScenariosObserver::class);
    Interactions::observe(InteractionsObserver::class);
    Explorations::observe(ExplorationsObserver::class);
    InteractionsBoard::observe(InteractionsBoardObserver::class);
    ExplorationsBoard::observe(ExplorationsBoardObserver::class);
  }
}
