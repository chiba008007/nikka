
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
<style>
    .main-sidebar,
    .main-header,
    .main-footer,
    .content-header {
        display: none !important;
    }

    .content-wrapper {
        margin-left: 0 !important;
        min-height: 100vh !important;
        background: #fff;
    }

    .content,
    .content > .container-fluid {
        padding: 0 !important;
    }

    .conference-page {
        width: 100%;
        color: #243247;
        font-family: "Helvetica Neue", Arial, sans-serif;
    }

    .hero {
        min-height: 520px;
        display: flex;
        align-items: center;
        background:
            radial-gradient(circle at 85% 20%,
                rgba(68, 145, 196, .35), transparent 45%),
            linear-gradient(120deg, #071c36, #123e65);
        color: #fff;
    }

    .hero-content {
        max-width: 850px;
        padding: 90px 0;
    }

    .hero-label {
        display: inline-block;
        font-size: 13px;
        letter-spacing: 3px;
        color: #8ed1ef;
        margin-bottom: 25px;
    }

    .hero h1 {
        font-size: clamp(36px, 5vw, 64px);
        font-weight: 700;
        letter-spacing: 2px;
        margin-bottom: 22px;
    }

    .hero-subtitle {
        font-size: 20px;
        opacity: .85;
        margin-bottom: 32px;
    }

    .hero-info {
        display: flex;
        flex-wrap: wrap;
        gap: 12px 30px;
        font-size: 17px;
        margin-bottom: 38px;
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .hero-actions .btn {
        min-width: 190px;
        border-radius: 5px;
        font-weight: 600;
    }

    .section-white,
    .section-gray {
        padding: 85px 0;
    }

    .section-gray {
        background: #f3f6fa;
    }

    .section-heading {
        margin-bottom: 38px;
    }

    .section-heading span {
        color: #2678af;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 3px;
    }

    .section-heading h2 {
        font-size: 30px;
        font-weight: 700;
        margin-top: 10px;
    }

    .info-card,
    .registration-card {
        background: #fff;
        border: 1px solid #e4eaf0;
        border-radius: 10px;
        padding: 35px;
        height: 100%;
        box-shadow: 0 8px 25px rgba(17, 45, 75, .04);
    }

    .info-label {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 2px;
        color: #2678af;
        margin-bottom: 16px;
    }

    .info-card h3,
    .registration-card h3 {
        font-size: 21px;
        font-weight: 700;
        margin-bottom: 16px;
    }

    .info-card p,
    .registration-card p {
        color: #617084;
        line-height: 1.9;
    }

    .news-list {
        background: #fff;
        border-radius: 10px;
        padding: 10px 30px;
    }

    .news-item {
        display: flex;
        gap: 30px;
        padding: 23px 0;
        border-bottom: 1px solid #e9edf2;
    }

    .news-item:last-child {
        border-bottom: none;
    }

    .news-date {
        color: #2678af;
        font-weight: 600;
        white-space: nowrap;
    }

    .registration-card .btn {
        background: #164c78;
        border-color: #164c78;
        padding: 10px 28px;
    }

    .conference-footer {
        padding: 35px 20px;
        background: #081d36;
        color: #b9c8d7;
        text-align: center;
        font-size: 13px;
    }

    .conference-footer p {
        margin: 0;
    }

    @media (max-width: 767px) {
        .hero {
            min-height: 450px;
        }

        .hero-content {
            padding: 65px 0;
        }

        .hero-subtitle {
            font-size: 16px;
        }

        .section-white,
        .section-gray {
            padding: 55px 0;
        }

        .news-item {
            flex-direction: column;
            gap: 7px;
        }
    }
</style>
@stop
