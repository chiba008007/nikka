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
