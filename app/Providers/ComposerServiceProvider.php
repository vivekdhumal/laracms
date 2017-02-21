<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('themes.default.partials.categories', function($view) {
            $categories = \App\Category::all();
            $view->with('categories', $categories);
        });

        view()->composer('themes.default.partials.tags', function($view) {
            $tags = \App\Tag::all();
            $view->with('tags', $tags);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
