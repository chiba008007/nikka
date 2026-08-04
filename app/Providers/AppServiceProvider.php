<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFour();
        //
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {

            // 参加管理画面
            if (request()->routeIs('sanka.*')) {

                // $event->menu->add([
                //     'header' =>  __('sanka.header.list'),
                // ]);

                $event->menu->add([
                    'text'  => __('sanka.title.dashboard'),
                    'route' => 'dashboard',
                    'icon'  => 'fas fa-fw fa-share',
                ]);
                $event->menu->add([
                    'text'  => __('sanka.title.list'),
                    'route' => 'sanka.list.index',
                    'icon'  => 'fas fa-fw fa-user',
                ]);

                $event->menu->add([
                    'text'  => __('sanka.title.create'),
                    'route'   => 'sanka.list.create',
                    'icon'  => 'fas fa-fw fa-edit',
                ]);

                $event->menu->add([
                    'text'  => __('sanka.title.editform'),
                    'icon'  => 'fas fa-fw fa-barcode',
                    // 配下にサブメニューを定義
                    'submenu' => [
                        [
                            'text'  => '入力ページ',
                            'route' => 'sanka.list.editform',
                            'icon'  => 'far fa-fw fa-circle',
                        ],
                        [
                            'text'  => '確認ページ',
                            'route' => 'sanka.list.editform',
                            'icon'  => 'far fa-fw fa-circle',
                        ],
                        [
                            'text'  => '完了ページ',
                            'route' => 'sanka.list.editform',
                            'icon'  => 'far fa-fw fa-circle',
                        ],
                        [
                            'text'  => '参加者申込完了ページ',
                            'route' => 'sanka.list.editform',
                            'icon'  => 'far fa-fw fa-circle',
                        ],
                    ],
                ]);
            }

            // 講演管理画面
            if (request()->routeIs('koen.*')) {

                $event->menu->add([
                    'header' => '講演管理',
                ]);

                $event->menu->add([
                    'text'  => '講演一覧',
                    'route' => 'dashboard',
                    'icon'  => 'fas fa-fw fa-microphone',
                ]);
            }
        });
    }
}
