@props([
  'isAdmin' => false,
  'pageTops' => collect(),
  'banners' => collect(),
  ])
{{-- メインビジュアル --}}
<style>
  .conference-page .note-editor.note-frame {
    width: 100% !important;
    max-width: none !important;
}
</style>
<section class="hero">
    <div class="container-fluid px-4 px-md-5">
        <div class="hero-content">
            <x-top.edit-input :id="101" :page-tops="$pageTops" :is-admin="$isAdmin" />
            <span class="hero-label" id="t-display101">
                {{ $pageTops[101]->note ?? '' }}
            </span>


            <x-top.edit-input :id="102" :page-tops="$pageTops" :is-admin="$isAdmin" />
            <h1 id="t-display102" class="w-100" style="white-space: nowrap;">{{ $pageTops[102]->note ?? '' }}</h1>



            <x-top.edit-input :id="103" :page-tops="$pageTops" :is-admin="$isAdmin" />
            <p class="hero-subtitle" id="t-display103">{{ $pageTops[103]->note ?? '' }}</p>

            <x-top.edit-input :id="104" :page-tops="$pageTops" :is-admin="$isAdmin" />
            <div class="hero-info">
                <span  id="t-display104">{{ $pageTops[104]->note ?? '' }}</span>
            </div>
            <div class="d-flex">
              <x-top.edit-input :id="105" :page-tops="$pageTops" :is-admin="$isAdmin"  />
              <x-top.edit-input :id="106" :page-tops="$pageTops" :is-admin="$isAdmin"  />
            </div>
            <div class="hero-actions">
                <a href="{{ url('/top') }}" class="btn btn-outline-light btn-lg" id="t-display105">{{ $pageTops[105]->note ?? '' }}</a>
                <a href="javascript:void(0)" class="btn btn-light btn-lg" id="t-display106">{{ $pageTops[106]->note ?? '' }}</a>
            </div>
        </div>
    </div>
</section>
{{-- バナー --}}
<section class="section-white pb-2">
    <div class="container-fluid px-4 px-md-5">
        <x-top.edit-input :id="107" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-25" />
        <x-top.edit-input :id="108" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-25" />
        <div class="section-heading">
            <span id="t-display107">{{ $pageTops[107]->note ?? '' }}</span>
            <h2 id="t-display108">{{ $pageTops[108]->note ?? '' }}</h2>
        </div>
        <x-top.bunner :is-admin="false" :pageTops=$pageTops :banners="$banners" />
    </div>
</section>
{{-- 講演登録及び、予稿原稿登録 --}}
<section class="section-gray">
    <div class="container-fluid px-4 px-md-5">
      <x-top.edit-input :id="109" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-25" />
      <x-top.edit-input :id="110" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-25" />
      <div class="section-heading">
          <span id="t-display109">{{ $pageTops[109]->note ?? '' }}</span>
          <h2 id="t-display110">{{ $pageTops[110]->note ?? '' }}</h2>
      </div>

      <div class="news-list">
          <x-top.edit-input :id="111" :page-tops="$pageTops" :is-admin="$isAdmin" />
          <x-top.edit-input :id="112" :page-tops="$pageTops" :is-admin="$isAdmin" />
          <x-top.edit-textarea :id="113" :page-tops="$pageTops" :is-admin="$isAdmin" />

          <div class="news-item">
              <span class="news-date" id="t-display111">{{ $pageTops[111]->note ?? '' }}</span>
              <span id="t-display112">{{ $pageTops[112]->note ?? '' }}</span>
          </div>
          <div class=" mt-3" id="t-display113">
            {!! $pageTops[113]->note ?? '' !!}
          </div>
      </div>
    </div>
</section>
<section class="section-white">
    <div class="container-fluid px-4 px-md-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <x-top.edit-input :id="114" :page-tops="$pageTops" :is-admin="$isAdmin" />
                        <h4  id="t-display114">
                            {{ $pageTops[114]->note ?? '' }}
                        </h4>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <x-top.edit-textarea :id="115" :page-tops="$pageTops" :is-admin="$isAdmin" />
                        <div id="t-display115">{!! $pageTops[115]->note ?? '' !!}</div>

                        <x-top.edit-input :id="116" :page-tops="$pageTops" :is-admin="$isAdmin" />
                        <button class="btn btn-primary w-100" id="t-display116" >{{ $pageTops[116]->note ?? '' }}</button>
                    </div>
                    <!-- /.card-body -->
                </div>
            <!-- /.card -->
            </div>
            <!-- ./col -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <x-top.edit-input :id="117" :page-tops="$pageTops" :is-admin="$isAdmin" />
                        <h4 id="t-display117">
                            {{ $pageTops[117]->note ?? '' }}
                        </h4>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <x-top.edit-textarea :id="118" :page-tops="$pageTops" :is-admin="$isAdmin" />
                        <div id="t-display118">
                         {!! $pageTops[118]->note ?? '' !!}
                        </div>
                        <x-top.edit-input :id="119" :page-tops="$pageTops" :is-admin="$isAdmin" />
                        <button class="btn btn-success w-100" id="t-display119">{{ $pageTops[119]->note ?? '' }}</button>
                    </div>
                    <!-- /.card-body -->
                </div>
            <!-- /.card -->
            </div>
            <!-- ./col -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <x-top.edit-input :id="120" :page-tops="$pageTops" :is-admin="$isAdmin" />
                        <h4 id="t-display120">
                            {{ $pageTops[120]->note ?? '' }}
                        </h4>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" >
                        <x-top.edit-textarea :id="121" :page-tops="$pageTops" :is-admin="$isAdmin" />
                        <div id="t-display121">
                            {!! $pageTops[121]->note ?? '' !!}
                        </div>
                        <x-top.edit-input :id="122" :page-tops="$pageTops" :is-admin="$isAdmin" />
                        <button class="btn btn-warning w-100" id="t-display122">{{ $pageTops[122]->note ?? '' }}</button>
                    </div>
                    <!-- /.card-body -->
                </div>
            <!-- /.card -->
            </div>
            <!-- ./col -->
        </div>
    </div>
</section>

<section class="section-gray">
    <div class="container-fluid px-4 px-md-5">

      <div class="news-list">
          <x-top.edit-input :id="123" :page-tops="$pageTops" :is-admin="$isAdmin" />
          <x-top.edit-textarea :id="124" :page-tops="$pageTops" :is-admin="$isAdmin" />

          <div class="news-item">
              <span id="t-display123">{{ $pageTops[123]->note ?? '' }}</span>
          </div>
          <div class=" mt-3" id="t-display124">
            {!! $pageTops[124]->note ?? '' !!}
          </div>
      </div>
    </div>
</section>
<x-top.footer />

