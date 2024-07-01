<x-app-layout>
    

    <div class="py-12">

        <div class="mt-4 flex items-center justify-between">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <form method="POST" enctype="multipart/form-data" action="{{ route('posts.store') }}">
                    @csrf
                    <x-input-label for="text" :value="__('title')" />
                    <x-text-input id="title" class="block mt-1 w-full mb-6" type="title" name="title" :value="old('title')" />
                    <x-input-label for="text" :value="__('body')" />
                    <x-text-input id="body" class="block mt-1 w-full mb-6" type="body" name="body" :value="old('body')" />
                    <label for="image">Upload Image:</label>
                    <input type="file" id="image" name="image">
                    <br>
                
                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Craete post') }}
                    </button>
                </form>
            </div>
        </div>
    </div>    
</x-app-layout>
