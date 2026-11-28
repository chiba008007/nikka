@extends('adminlte::page')

@section('title', 'バナー管理')

@section('content_header')
    <p class="h4">バナー管理</p>
@stop

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>表示順</th>
                <th>バナー画像</th>
                <th>リンク先URL</th>
                <th>公開状態</th>
                <th>更新日時</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($banners as $banner)
                <tr>
                    <td>{{ $banner->id }}</td>
                    <td>{{ $banner->sort }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $banner->image) }}"
                             style="max-width: 180px;">
                    </td>
                    <td>{{ $banner->url }}</td>
                    <td>
                        @if ($banner->status)
                            <span class="badge badge-success">公開</span>
                        @else
                            <span class="badge badge-secondary">非公開</span>
                        @endif
                    </td>
                    <td>{{ $banner->updated_at }}</td>
                    <td class="text-nowrap">
                        <a href="{{ route('edit.top.banner.edit', $banner->id) }}"
                          class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> 編集
                        </a>

                        <form action="{{ route('edit.top.banner.destroy', $banner->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('削除しますか？');">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> 削除
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">
                        バナーが登録されていません。
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@stop
