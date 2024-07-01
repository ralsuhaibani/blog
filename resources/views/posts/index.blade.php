<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">{{ __("All posts") }}</h2>
                    
                    </div>
                    @if (auth()->user()->subscription->ends_at->diffInDays(now()) <= 2)
                    <div>
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                            Your subscription will end in 

                            {{ now()->diffForHumans(auth()->user()->subscription->ends_at, ['parts' => 2]) }}
                        </h2>                    
                        you can subscribe <a href="{{ route('subscriptions.index') }}">here</a>
                       
                    </div> 
                    @endif
                    
                    <div class="flex justify-end mt-4">
                        <form method="GET" action="{{ route('posts.search') }}">
                           <div class="input-groub">
                            @csrf
                            <input class="input-control" name="search" placeholder="search..." value="{{ isset($search) ? $search : ' ' }}" />
                                <x-primary-button>
                                   {{ __('search') }}
                                </x-primary-button>
                           </div>
                        </form>
                    </div>
                    <div class="flex justify-end mt-4">
                        <form method="GET" action="{{ route('posts.sortByViews') }}">
                            @csrf
                            <x-primary-button>
                                {{ __('Sort by Most Viewed') }}
                            </x-primary-button>
                        </form>
                    </div>
                    @foreach($posts as $post)
                    <div>
                        <h2>{{ $post->title }}</h2>
                        <a href="{{ route('posts.show', $post) }}">Read More</a>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <form method="POST" action="{{ route('posts.create') }}">
            
                        <x-primary-button>
                            <a href="{{ route('posts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-blue font-bold py-2 px-4 rounded">Create Post</a>
                        </x-primary-button>
                </form>
            </div>
            <div class="flex justify-end mt-4">
                <form method="POST" action="{{ route('posts.user.posts') }}">
            
                        <x-primary-button>
                            <a href="{{ route('posts.user.posts') }}" class="bg-blue-500 hover:bg-blue-700 text-blue font-bold py-2 px-4 rounded">My posts</a>
                        </x-primary-button>
                </form>
            </div>
            @if (Auth::user()->is_admin)
            <div class="flex justify-end mt-4">

                            <x-primary-button>
                                <a href="{{ route('posts.pending') }}" class="bg-blue-500 hover:bg-blue-700 text-blue font-bold py-2 px-4 rounded">Pending Post</a>
                            </x-primary-button>
                </div>
            @endif
        </div>
        <div>
            {{ $posts->links()}}
        </div>
    </div>
</x-app-layout>
