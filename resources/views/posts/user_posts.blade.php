<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">{{ __("All posts") }}</h2>
                    
                    </div>
                    @foreach($posts as $post)
                    <div class="flex justify mt-4">
                        <h2>{{ $post->title }}</h2>
                        <h2> {{" Status: ". $post->status }}</h2>
                    </div>
                    <a href="{{ route('posts.show', $post) }}">Read More</a>
                    @endforeach
                </div>
            </div>
        </div>
        
            {{ $posts->links()}}
        </div>
    
    </div>
</x-app-layout>
