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
        $theme = config('blog.blog_theme', 'default');

        view()->composer('themes.'.$theme.'.partials.categories', function($view) {
            $categories = \App\Category::all();
            $view->with('categories', $categories);
        });

        view()->composer('themes.'.$theme.'.partials.tags', function($view) {
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
