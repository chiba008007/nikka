
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
                <div class=" mt-3" id="news1">
                    １．令和８年度化学系学協会東北大会は、対面開催を予定しております。<br />
                    ２．化学系学協会東北大会（以下、東北大会）参加ポリシーをご確認ください。<br />
                    <ul>
                        <li>東北大会参加者には，他者の発表内容の取り扱いに関して，研究者倫理を遵守することが求められる。</li>
                        <li>東北大会参加者は、著作物および知的財産の保護の観点から講演及びポスター発表<li>内容の保存（画面キャプチャ含む）、動画・音声の録画・録音をしてはならない。</li>
                        <li>東北大会は有料・無料問わず参加登録した本人のみが参加できるものであり、参加に伴い得た情報のSNSへの投稿等により第三者への開示を禁止とする。</li>
                        <li>東北大会参加者は、事前に東北大会使用予定ツールの動作確認を行い、動作環境等に問題がないことを確認した上で参加すること。</li>
                        <li>本ポリシーに定めた条項への違反、またそれ以外のイベントへの妨害行為やルール違反があった場合、事務局は参加資格を剥奪することができるものとする。</li>
                        <li>東北大会参加者は、上記の条件を理解・同意したうえで参加すること。</li>
                    </ul>
                    <br />
                    ３．宿泊施設の早期確保について<br />
                    当日は会場周辺で別のイベントが開催されるため、宿泊施設の混雑が予想されます。ご参加予定の皆様におかれましては、早めの宿泊予約をおすすめいたします。
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
                        <p>化学系学協会東北大会</p>
                    </div>
                </div>
                <div class="col-md-12 mb-12">
                    <div class="info-card">
                        <div class="info-label">Attendee Guide</div>
                        <h3>参加登録・懇親会</h3>
                        <p>事前参加登録申込み締切：2026年8 月14日（金）⇒締め切りました</p>
                        <p>当日参加登録受付開始　：2026年9月4日（金）⇒受付中</p>
                        <ul>
                            <li>web予稿集の閲覧には参加登録IDが必要です。無料の場合もご登録をお願いします。</li>
                            <li>高校生の引率として参加される先生は”教育（小・中・高校教員）”へ登録をお願いします。</li>
                        </ul>
                        ※必ず参加者本人のお名前で お申し込み下さい※
                        <div class="row  align-items-center">
                            <div class="col-12 col-md-auto">
                                <p class="h4  mb-0">参加登録費（課税）</p>
                            </div>
                            <div class="col-12 col-md-auto">
                                <p class="text-danger  mb-0">※クレジット払いのみ</p>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped text-center w-100">
                            <thead class="thead-light">
                                <tr>
                                    <th></th>
                                    <th>事前登録</th>
                                    <th>当日登録</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>一般</th>
                                    <td>4,000円</td>
                                    <td>5,000円</td>
                                </tr>
                                <tr>
                                    <th>小・中・高校・高専教員ブース出展企業</th>
                                    <td>0円</td>
                                    <td>0円</td>
                                </tr>
                                <tr>
                                    <th>大学院生・教育（日本化学会教育会員）</th>
                                    <td>2,000円</td>
                                    <td>3,000円</td>
                                </tr>
                                <tr>
                                    <th>中学生・高校生・高専生・学部生</th>
                                    <td>0円</td>
                                    <td>0円</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row  align-items-center">
                            <div class="col-12 col-md-auto">
                                <p class="h4  mb-0">懇親会</p>
                            </div>
                        </div>
                        <table class="table table-bordered text-center w-100">
                            <tbody >
                                <tr>
                                    <th class="table-secondary align-middle">日時</th>
                                    <td class="align-middle" colspan=2>２０２６年９月５日（土）１８：００～</td>
                                </tr>
                                <tr>
                                    <th class="table-secondary align-middle">会場</th>
                                    <td class="align-middle" colspan=2>弘前パークホテル</td>
                                </tr>
                                <tr>
                                    <th class="table-secondary align-middle">会費</th>
                                    <td class="table-secondary align-middle">事前登録</td>
                                    <td class="table-secondary align-middle">当日登録</td>
                                </tr>
                                <tr>
                                    <th class="table-secondary align-middle">一般</th>
                                    <td class="align-middle">9,000円</td>
                                    <td class="align-middle">10,000円</td>
                                </tr>
                                <tr>
                                    <th class="table-secondary align-middle">学生</th>
                                    <td class="align-middle">4,000円</td>
                                    <td class="align-middle">5,000円</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
