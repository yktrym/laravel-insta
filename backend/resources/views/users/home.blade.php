@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="row gx-5">
    <div class="col-8">
        @forelse ($all_posts as $post)
            @if ($post->user->isFollowed() || Auth::user()->id === $post->user->id)
                <div class="card mb-4">
                    @include('users.posts.contents.title')
                    @include('users.posts.contents.body')
                </div>
            @endif
        @empty
            {{-- If the site doesn't have any posts yet. --}}
            <div class="text-center">
                <h2>Share Photos</h2>
                <p class="text-muted">When you share photos, they'll appear on your profile.</p>
                <a href="{{ route('post.create') }}" class="text-decoration-none">Share your first photo</a>
            </div>
        @endforelse
    </div>
    <div class="col-4">
        {{-- Profile Overview --}}
        <div class="row align-items-center mb-5 bg-white shadow-sm rounded-3 py-3">
            <div class="col-auto">
                <a href="{{ route('profile.show', Auth::user()->id) }}">
                @if (Auth::user()->avatar)
                    <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->avatar }}" class="rounded-circle overview-avatar">
                @else
                    <i class="fa-solid fa-circle-user text-secondary overview-icon"></i>
                @endif
                </a>
            </div>
            <div class="col ps-0">
                <a href="{{ route('profile.show', Auth::user()->id) }}" class="text-decoration-none text-dark fw-bold">{{ Auth::user()->name }}</a>
                <p class="text-muted">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <!-- Suggestions -->
        @if ($suggested_users)
            <div class="row">
                <div class="col-auto">
                    <p class="fw-bold text-secondary">Suggestions For You</p>
                </div>
                <div class="col text-end">
                    <a href="#" class="fw-bold text-dark text-decoration-none">See all</a>
                </div>
            </div>
            @foreach ($suggested_users as $user)
            <div class="row align-items-center mb-3">
                <div class="col-auto">
                    <a href="{{ route('profile.show', $user->id) }}" alt="{{ $user->avatar }}">
                    @if($user->avatar)
                        <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="{{ $user->avatar }}" class="rounded-circle user-avatar">
                    @else
                        <i class="fa-solid fa-circle-user text-secondary user-icon"></i>
                    @endif
                    </a>
                </div>
                <div class="col ps-0 text-truncate">
                    <a href="{{ route('profile.show' , $user->id) }}" class="text-decoration-none text-dark fw-bold small">{{ $user->name }}</a>
                </div>
                <div class="col-auto">
                    <form action="{{ route('follow.store' , $user->id) }}" method="post" class="d-inline">
                        @csrf
                        <button type="submit" class="border-0 bg-transparent p-0 text-primary btn-sm">Follow</button>
                    </form>
                </div>
            </div>
            @endforeach        
        @endif
    </div>
</div>
@endsection
