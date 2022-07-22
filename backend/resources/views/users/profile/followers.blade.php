@extends('layouts.app')

@section('title', 'Followers')

@section('content')
    @include('users.profile.header')

    <div style="margin-top: 100px">
        @if ($user->followers->isNotEmpty())
            <div class="row justify-content-center">
                <div class="col-4">
                    <h3 class="text-muted text-center">Followers</h3>

                    @foreach ($user->followers as $follower)
                        <div class="row align-items-center mt-3">
                            <div class="col-auto">
                                <a href="{{ route('profile.show', $follower->user->id) }}">
                                    @if ($follower->user->avatar)
                                        <img src="{{ asset('storage/avatars/' . $follower->user->avatar) }}" alt="{{ $follower->user->avatar }}" class="rounded-circle user-avatar">
                                    @else
                                        <i class="fa-solid fa-circle-user text-secondary user-icon"></i>
                                    @endif
                                </a>
                            </div>
                            <div class="col ps-0 text-truncate">
                                <a href="{{ route('profile.show', $follower->user->id) }}" class="text-decoration-none text-dark fw-bold small">{{ $follower->user->name }}</a>
                            </div>
                            <div class="col-auto text-end">
                                @if ($follower->user->id !== Auth::user()->id)
                                    @if ($follower->user->isFollowed())
                                        <form action="{{ route('follow.destroy', $follower->user->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="border-0 bg-transparent p-0 text-secondary btn-sm">Following</button>
                                        </form>
                                    @else
                                        <form action="{{ route('follow.store', $follower->user->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="border-0 bg-transparent p-0 text-primary btn-sm">Follow</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <h3 class="text-muted text-center">No followers yet.</h3>
        @endif
    </div>
@endsection