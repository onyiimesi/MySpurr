<?php

namespace App\Console\Commands;

use App\Models\V1\CountryTwo;
use App\Models\V1\State;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchCountriesAndStates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:countries-states';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and store countries and states from the API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::withHeaders([
            'X-CSCAPI-KEY' => config('services.country_city')
        ])->get('https://api.countrystatecity.in/v1/countries');

        $countries = $response->json();

        foreach ($countries as $country) {
            $countryModel = CountryTwo::updateOrCreate(
                ['iso2' => $country['iso2']],
                ['name' => $country['name'], 'iso3' => $country['iso3']]
            );

            $stateResponse = Http::withHeaders([
                'X-CSCAPI-KEY' => config('services.country_city')
            ])->get("https://api.countrystatecity.in/v1/countries/{$country['iso2']}/states");

            $states = $stateResponse->json();

            foreach ($states as $state) {
                State::updateOrCreate(
                    ['iso2' => $state['iso2'], 'country_id' => $countryModel->id],
                    ['name' => $state['name']]
                );
            }
        }

        $this->info('Countries and states fetched and stored successfully.');
    }
}
