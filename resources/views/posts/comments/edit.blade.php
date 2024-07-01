
<x-app-layout>
    

    <div class="py-12">

        <div class="mt-4 flex items-center justify-between">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="flex justify-end mt-4">
                    <form method="POST" action="{{ route('posts.comments.update', ['post'=>$post ,'comment' => $comment]) }}">
    
                        @csrf
                        @method('PATCH') 
                        <x-input-label for="text" :value="__('Comment')" />
                        <x-text-input id="body" class="block mt-1 w-full mb-6" type="body" name="body" :value="old('body')" />
                        <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('update comment') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>    
</x-app-layout>