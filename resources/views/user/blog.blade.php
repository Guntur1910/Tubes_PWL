@extends('layouts.user')

@section('title', 'Blog - ' . config('app.name'))

@section('content')

{{-- ===== Blog Area ===== --}}
<div class="blog_area section-padding-80">
    <div class="container">
        <div class="row">
            @forelse($posts ?? [] as $post)
                <div class="col-12 col-lg-6">
                    <div class="single-blog-area mb-50">
                        <div class="blog-thumbnail">
                            <img src="{{ $post['image'] ?? asset('essence/img/blog-img/1.jpg') }}" alt="{{ $post['title'] ?? 'Blog Post' }}">
                        </div>
                        <div class="post-content">
                            <div class="post-meta">
                                <a href="#">{{ $post['date'] ?? 'Jan 10, 2020' }}</a>
                                <a href="#">{{ $post['author'] ?? 'Admin' }}</a>
                            </div>
                            <a href="#" class="post-title">{{ $post['title'] ?? 'Blog Post Title' }}</a>
                            <p>{{ $post['excerpt'] ?? 'Blog post excerpt...' }}</p>
                            <a href="#" class="read-more-btn">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p>No blog posts available.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection