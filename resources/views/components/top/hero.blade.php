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
            <x-top.edit-input :id="1" :page-tops="$pageTops" :is-admin="$isAdmin" />
            <span class="hero-label" id="t-display1">{{ $pageTops[0]->note ?? '' }}</span>

            <x-top.edit-input :id="2" :page-tops="$pageTops" :is-admin="$isAdmin" />
            <h1 id="t-display2" class="w-100" style="white-space: nowrap;">{{ $pageTops[1]->note ?? '' }}</h1>



            <x-top.edit-input :id="3" :page-tops="$pageTops" :is-admin="$isAdmin" />
            <p class="hero-subtitle" id="t-display3">{{ $pageTops[2]->note ?? '' }}</p>

            <x-top.edit-input :id="4" :page-tops="$pageTops" :is-admin="$isAdmin" />
            <div class="hero-info">
                <span  id="t-display4">{{ $pageTops[3]->note ?? '' }}</span>
            </div>
            <div class="d-flex">
              <x-top.edit-input :id="5" :page-tops="$pageTops" :is-admin="$isAdmin"  />
              <x-top.edit-input :id="6" :page-tops="$pageTops" :is-admin="$isAdmin"  />
            </div>
            <div class="hero-actions">
                <a href="#" class="btn btn-light btn-lg" id="t-display5">{{ $pageTops[4]->note ?? '' }}</a>
                <a href="#" class="btn btn-outline-light btn-lg" id="t-display6">{{ $pageTops[5]->note ?? '' }}</a>
            </div>
        </div>
    </div>
</section>
{{-- バナー --}}
<section class="section-white pb-2">
    <div class="container-fluid px-4 px-md-5">
        <x-top.edit-input :id="7" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-25" />
        <x-top.edit-input :id="8" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-25" />
        <div class="section-heading">
            <span id="t-display7">{{ $pageTops[6]->note ?? '' }}</span>
            <h2 id="t-display8">{{ $pageTops[7]->note ?? '' }}</h2>
        </div>
        <div class="row">
            @foreach ($banners as $banner)
                <div class="col-6 col-md-2 mb-2">
                    <div class="info-card banner-card">
                        @if ($banner->url)
                            <a href="{{ $banner->url }}"
                            target="_blank" rel="noopener noreferrer">
                                <img src="{{ asset('storage/' . $banner->image) }}"
                                    alt="協賛企業">
                            </a>
                        @else
                            <img src="{{ asset('storage/' . $banner->image) }}"
                                alt="協賛企業">
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
    {{-- お知らせ --}}
<section class="section-gray">
    <div class="container-fluid px-4 px-md-5">
      <x-top.edit-input :id="9" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-25" />
      <x-top.edit-input :id="10" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-25" />
      <div class="section-heading">
          <span id="t-display9">{{ $pageTops[8]->note ?? '' }}</span>
          <h2 id="t-display10">{{ $pageTops[9]->note ?? '' }}</h2>
      </div>

      <div class="news-list">
          <x-top.edit-input :id="11" :page-tops="$pageTops" :is-admin="$isAdmin" />
          <x-top.edit-input :id="12" :page-tops="$pageTops" :is-admin="$isAdmin" />
          <x-top.edit-textarea :id="13" :page-tops="$pageTops" :is-admin="$isAdmin" />

          <div class="news-item">
              <span class="news-date" id="t-display11">{{ $pageTops[10]->note ?? '' }}</span>
              <span id="t-display12">{{ $pageTops[11]->note ?? '' }}</span>
          </div>
          <div class=" mt-3" id="t-display13">
              {!! $pageTops[12]->note ?? '' !!}
          </div>
      </div>
    </div>
</section>
{{-- 開催概要 --}}
<section class="section-white">
    <div class="container-fluid px-4 px-md-5">
        <div class="section-heading">
          <div >
            <x-top.edit-input :id="14" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-50" />
            <x-top.edit-input :id="15" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-50" />
          </div>
          <span id="t-display14">{{ $pageTops[13]->note ?? '' }}</span>
          <h2 id="t-display15">{{ $pageTops[14]->note ?? '' }}</h2>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="info-card">
                    <x-top.edit-input :id="16" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                    <x-top.edit-input :id="17" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                    <x-top.edit-input :id="18" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                    <div class="info-label" id="t-display16" >{{ $pageTops[15]->note ?? '' }}</div>
                    <h3 id="t-display17">{{ $pageTops[16]->note ?? '' }}</h3>
                    <p id="t-display18">{{ $pageTops[17]->note ?? '' }}</p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="info-card">
                  <x-top.edit-input :id="19" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                  <x-top.edit-input :id="20" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                  <x-top.edit-input :id="21" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />

                  <div class="info-label" id="t-display19">{{ $pageTops[18]->note ?? '' }}</div>
                  <h3 id="t-display20">{{ $pageTops[19]->note ?? '' }}</h3>
                  <p id="t-display21">{{ $pageTops[20]->note ?? '' }}</p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="info-card">
                  <x-top.edit-input :id="22" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                  <x-top.edit-input :id="23" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                  <x-top.edit-input :id="24" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                  <div class="info-label" id="t-display22">{{ $pageTops[21]->note ?? '' }}</div>
                  <h3 id="t-display23">{{ $pageTops[22]->note ?? '' }}</h3>
                  <p id="t-display24">{{ $pageTops[23]->note ?? '' }}</p>
                </div>
            </div>
            <div class="col-md-12 mb-12">
                <div class="info-card">

                  <x-top.edit-input :id="25" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-50" />
                  <x-top.edit-input :id="26" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-50" />
                  <x-top.edit-textarea :id="27" :page-tops="$pageTops" :is-admin="$isAdmin" />

                  <div class="info-label" id="t-display25">{{ $pageTops[24]->note ?? '' }}</div>
                  <h3 id="t-display26">{{ $pageTops[25]->note ?? '' }}</h3>
                  <div id="t-display27">{!! $pageTops[26]->note ?? '' !!}</div>


                  <div class="row  align-items-center mt-2">
                      <div class="col-12 col-md-auto">
                        <x-top.edit-textarea :id="28" :page-tops="$pageTops" :is-admin="$isAdmin" editorClass="descriptionShort" />
                        <p class="h4  mb-0" id="t-display28" >{!! $pageTops[27]->note ?? '' !!}</p>
                      </div>
                  </div>
                  <table class="table table-bordered table-striped text-center w-100">
                      <thead class="thead-light">
                          <tr>
                              <th class="w-50"></th>
                              <th class="w-25">
                                <x-top.edit-input :id="29" :page-tops="$pageTops" :is-admin="$isAdmin" />
                                <span id="t-display29" >{{ $pageTops[28]->note ?? '' }}</span></th>
                              <th class="w-25">
                                <x-top.edit-input :id="30" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                                <span id="t-display30" >{{ $pageTops[29]->note ?? '' }}</span></th>
                              </th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                            <th>
                            <x-top.edit-input :id="31" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                            <span id="t-display31">{{ $pageTops[30]->note ?? '' }}</span></th>
                            <td>
                            <x-top.edit-input :id="32" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-50" />
                            <span id="t-display32">{{ $pageTops[31]->note ?? '' }}</span></td>
                            <td>
                            <x-top.edit-input :id="33" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-50" />
                            <span id="t-display33">{{ $pageTops[32]->note ?? '' }}</span></td>
                          </tr>
                          <tr>
                            <th>
                            <x-top.edit-input :id="34" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                            <span id="t-display34">{{ $pageTops[33]->note ?? '' }}</span></th>
                            <td>
                            <x-top.edit-input :id="35" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-50" />
                            <span id="t-display35">{{ $pageTops[34]->note ?? '' }}</span></td>
                            <td>
                            <x-top.edit-input :id="36" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-50" />
                            <span id="t-display36">{{ $pageTops[35]->note ?? '' }}</span></td>
                          </tr>
                          <tr>
                            <th>
                                <x-top.edit-input :id="37" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                                <span id="t-display37">{{ $pageTops[36]->note ?? '' }}</span>
                            </th>
                              <td>
                                <x-top.edit-input :id="38" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                                <span id="t-display38">{{ $pageTops[37]->note ?? '' }}</span></td>
                              <td>
                                <x-top.edit-input :id="39" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                                <span id="t-display39">{{ $pageTops[38]->note ?? '' }}</span></td>
                          </tr>
                          <tr>
                              <th>
                                <x-top.edit-input :id="40" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                              <span id="t-display40">{{ $pageTops[39]->note ?? '' }}</span></th>
                              <td>
                                <x-top.edit-input :id="41" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                                <span id="t-display41">{{ $pageTops[40]->note ?? '' }}</span></td>
                              <td>
                                <x-top.edit-input :id="42" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                                <span id="t-display42">{{ $pageTops[41]->note ?? '' }}</span></td>
                          </tr>
                      </tbody>
                  </table>
                  <div class="row  align-items-center">
                      <div class="col-12 col-md-auto">
                        <x-top.edit-textarea :id="43" :page-tops="$pageTops" :is-admin="$isAdmin" editorClass="descriptionShort" />
                          <p class="h4  mb-0" id="t-display43">{!! $pageTops[42]->note ?? '' !!}</p>
                      </div>
                  </div>
                  <table class="table table-bordered text-center w-100">
                      <tbody >
                          <tr>
                              <th class="table-secondary align-middle w-25">
                                <x-top.edit-input :id="44" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                                <span class=" mb-0" id="t-display44">{{ $pageTops[43]->note ?? '' }}</span>
                                </th>
                                <td class="align-middle" colspan=2>
                                <x-top.edit-input :id="45" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                                <span class=" mb-0" id="t-display45">{{ $pageTops[44]->note ?? '' }}</span>
                                </td>
                          </tr>
                          <tr>
                              <th class="table-secondary align-middle">
                              <x-top.edit-input :id="46" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                                <span class=" mb-0" id="t-display46">{{ $pageTops[45]->note ?? '' }}</span>
                                </th>
                              <td class="align-middle" colspan=2>
                                <x-top.edit-input :id="47" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                                <span class=" mb-0" id="t-display47">{{ $pageTops[46]->note ?? '' }}</span>
                                </td>
                          </tr>
                          <tr>
                            <th class="table-secondary align-middle">
                                <x-top.edit-input :id="48" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                                <span class=" mb-0" id="t-display48">{{ $pageTops[47]->note ?? '' }}</span>
                            </th>
                            <td class="table-secondary align-middle">
                            <x-top.edit-input :id="49" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                            <span class=" mb-0" id="t-display49">{{ $pageTops[48]->note ?? '' }}</span>
                            </td>
                            <td class="table-secondary align-middle">
                                <x-top.edit-input :id="50" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                                <span class=" mb-0" id="t-display50">{{ $pageTops[49]->note ?? '' }}</span>
                            </td>
                          </tr>
                          <tr>
                            <th class="table-secondary align-middle">
                                <x-top.edit-input :id="51" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                                <span class=" mb-0" id="t-display51">{{ $pageTops[50]->note ?? '' }}</span>
                            </th>
                              <td class="align-middle">
                                <x-top.edit-input :id="52" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                                <span class=" mb-0" id="t-display52">{{ $pageTops[51]->note ?? '' }}</span>
                                </td>
                              <td class="align-middle">
                                <x-top.edit-input :id="53" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                                <span class=" mb-0" id="t-display53">{{ $pageTops[52]->note ?? '' }}</span>
                              </td>
                          </tr>
                          <tr>
                              <th class="table-secondary align-middle">
                                <x-top.edit-input :id="54" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                                <span class=" mb-0" id="t-display54">{{ $pageTops[53]->note ?? '' }}</span>
                              </th>
                              <td class="align-middle">
                                <x-top.edit-input :id="55" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                                <span class=" mb-0" id="t-display55">{{ $pageTops[54]->note ?? '' }}</span>
                              </td>
                              <td class="align-middle">
                                <x-top.edit-input :id="56" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-75" />
                                <span class=" mb-0" id="t-display56">{{ $pageTops[55]->note ?? '' }}</span>
                              </td>
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
            <x-top.edit-input :id="57" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-50" />
            <x-top.edit-input :id="58" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-50" />
            <span id="t-display57">{{ $pageTops[56]->note ?? '' }}</span>
            <h2 id="t-display58">{{ $pageTops[57]->note ?? '' }}</h2>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="registration-card">
                    <x-top.edit-input :id="59" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-50" />
                    <x-top.edit-input :id="60" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-50" />
                    <x-top.edit-input :id="61" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-50" />
                    <h3 id="t-display59">{{ $pageTops[58]->note ?? '' }}</h3>
                    <p id="t-display60">{{ $pageTops[59]->note ?? '' }}</p>
                    <a href="#" class="btn btn-primary button" id="t-display61">
                        {{ $pageTops[60]->note ?? '' }}
                    </a>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="registration-card">
                    <x-top.edit-input :id="62" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-50" />
                    <x-top.edit-input :id="63" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-50" />
                    <x-top.edit-input :id="64" :page-tops="$pageTops" :is-admin="$isAdmin" width="w-50" />
                    <h3 id="t-display62">{{ $pageTops[61]->note ?? '' }}</h3>
                    <p id="t-display63">{{ $pageTops[62]->note ?? '' }}</p>
                    <a href="#" class="btn btn-primary button" id="t-display64">
                        {{ $pageTops[63]->note ?? '' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="conference-footer">
    <p>© 2026 〇〇学会 All Rights Reserved.</p>
</footer>
