
@extends('adminlte::page')

@section('title', '学会公式サイト')

@section('content_header')
@stop

@section('content')
<div class="conference-page">

    {{-- メインビジュアル --}}
    <section class="hero">
        <div class="container-fluid px-4 px-md-5">
            <div class="hero-content">
                <span class="hero-label">ANNUAL CONFERENCE 2026</span>

                <h1>第XX回 学術大会</h1>

                <p class="hero-subtitle">
                    未来を拓く研究と、新たな知の交流
                </p>

                <div class="hero-info">
                    <span>2026年12月10日（木）〜12日（土）</span>
                    <span>仙台国際センター</span>
                </div>

                <div class="hero-actions">
                    <a href="#" class="btn btn-light btn-lg">
                        参加登録
                    </a>
                    <a href="#" class="btn btn-outline-light btn-lg">
                        講演登録
                    </a>
                </div>
            </div>
        </div>
    </section>
    {{-- バナー --}}
    <section class="section-white pb-2">
        <div class="container-fluid px-4 px-md-5">
            <div class="section-heading">
                <span>SPONSORS</span>
                <h2>協賛企業</h2>
            </div>
            <div class="row">
                <div class="col-6 col-md-2 mb-2">
                    <div class="info-card banner-card">
                        <a href="リンク先URL" target="_blank" rel="noopener noreferrer">
                            <img src="https://csjtohoku.jp/img/banner/2_R08hachinohe.png" alt="協賛企業">
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-2 mb-2">
                    <div class="info-card banner-card">
                        <a href="リンク先URL" target="_blank" rel="noopener noreferrer">
                            <img src="https://csjtohoku.jp/img/banner/4-1_R08BCSJ.png" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- 開催概要 --}}
    <section class="section-white">
        <div class="container-fluid px-4 px-md-5">
            <div class="section-heading">
                <span>ABOUT</span>
                <h2>開催概要</h2>
            </div>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="info-card">
                        <div class="info-label">DATE</div>
                        <h3>開催日程</h3>
                        <p>2026年12月10日（木）〜12日（土）</p>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="info-card">
                        <div class="info-label">VENUE</div>
                        <h3>開催会場</h3>
                        <p>仙台国際センター</p>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="info-card">
                        <div class="info-label">ORGANIZER</div>
                        <h3>主催</h3>
                        <p>〇〇学会</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- お知らせ --}}
    <section class="section-gray">
        <div class="container-fluid px-4 px-md-5">
            <div class="section-heading">
                <span>NEWS</span>
                <h2>お知らせ</h2>
            </div>

            <div class="news-list">
                <div class="news-item">
                    <span class="news-date">2026.11.19</span>
                    <span>学術大会公式サイトを公開しました。</span>
                </div>
                <div class="news-item">
                    <span class="news-date">2026.11.19</span>
                    <span>参加登録・講演登録について</span>
                </div>
            </div>
        </div>
    </section>

    {{-- 登録案内 --}}
    <section class="section-white">
        <div class="container-fluid px-4 px-md-5">
            <div class="section-heading">
                <span>REGISTRATION</span>
                <h2>各種お申し込み</h2>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="registration-card">
                        <h3>参加登録</h3>
                        <p>学術大会への参加申し込みはこちら</p>
                        <a href="#" class="btn btn-primary">
                            参加登録へ
                        </a>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="registration-card">
                        <h3>講演登録</h3>
                        <p>研究発表・講演のお申し込みはこちら</p>
                        <a href="#" class="btn btn-primary">
                            講演登録へ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="conference-footer">
        <p>© 2026 〇〇学会 All Rights Reserved.</p>
    </footer>

</div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/top.css') }}">
@stop
