<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
         {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mt-4">
                        <x-primary-button>
                            <a href="{{ route('posts.edit', ['post' => $post]) }}" class="bg-blue-500 hover:bg-blue-700 text-blue font-bold py-2 px-4 rounded">Edit Post</a>
                        </x-primary-button>
            </div>
            <div class="flex justify-end mt-4">
                <form method="POST" action="{{ route('posts.destroy', ['post' => $post]) }}">
                    @method('delete') 
                    @csrf
                        <x-primary-button>
                           {{ __('Delete Post') }}
                        </x-primary-button>
                </form>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4 mb-4">
                <div class="p-6 text-gray-900">
                {{ $post->body }}
                <img src="{{ asset('storage/'. $post->image) }}" alt="Post Image">
                <h2>Written by {{ $post->user->name}}</h2>
                {{ "Status : " .$post->status }}
                @if(!empty($post->note))
                <h2>Note: {{ $post->note }}</h2>
             @endif
                </div>
            </div>
            @if (Auth::user()->is_admin)
            <div class="flex justify mt-4">
                <form method="POST" action="{{ route('posts.reject', $post->id) }}"> 
                    @csrf
                    <x-primary-button>
                        {{ __('Reject Post') }}
                     </x-primary-button>
                    <x-input-label for="text" :value="__(' Rejection note')" />
                    <textarea id="note" name="note" rows="5" class="w-full"></textarea> 
                </form>
                <form method="POST" action="{{ route('posts.approve', $post->id)}}">
                   
                    @csrf
                        <x-primary-button>
                           {{ __('Approve Post') }}
                        </x-primary-button>
                </form>
            </div>
            @endif
            @if (Auth::user()->likesPost($post))
                <div class="flex justify mt-4">
                        <form method="POST" action="{{ route('posts.unlike', $post->id) }}">
                            @csrf
                                <x-primary-button type="submit" class="fw-light nav-link fs-6">
                                {{ __('unlike ') }}
                                </x-primary-button>
                                <span class="far fa-heart me-1">{{  $post->likes()->count()}}</span>
                                
                        </form>
                    </div>
            @else 
                <div class="flex justify mt-4">
                    <form method="POST" action="{{ route('posts.like', $post->id) }}">
                        @csrf
                            <x-primary-button type="submit" class="fw-light nav-link fs-6 ">
                            {{ __('like ') }}
                            </x-primary-button>
                            <span class="fas fa-heart me-1 ">{{$post->likes()->count()}}</span>
                            
                    </form>
                </div>
            @endif
            <div class="mt-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">{{ __("Comments") }}</h2>
                <form method="POST" action="{{ route('posts.comments.store', $post) }}">
                    @method('post') 
                    @csrf
                    <textarea id="body" name="body" rows="5" class="w-full"></textarea>
                        <x-primary-button type="submit">
                           {{ __('Add comment') }}
                        </x-primary-button>
                </form>
            </div>
            <div class="p-6 text-gray-900">
                <div>
                
                </div>
                @foreach($comments as $comment)
                <div>
                    <h2>{{ $comment->body }}</h2>
                  
                </div>
                <h2>Written by {{ $comment->user->name}}</h2>
               
                    <div class="flex justify mt-4">
                        <x-primary-button>
                            <a href="{{ route('posts.comments.edit', ['post'=>$post ,'comment' => $comment]) }}" class="bg-blue-500 hover:bg-blue-700 text-blue font-bold py-2 px-4 rounded">Edit comment</a>
                        </x-primary-button>
                    </div>
              
                @endforeach
            </div>
            {{ $comments->links()}}
        </div>
    </div>
    
</x-app-layout>