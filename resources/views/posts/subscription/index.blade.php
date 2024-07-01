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
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">{{ __("Your mebership is ". $userPlan )}}</h2>
                
                    @foreach($plans as $key => $plan)
                    @if ($key === 0)
                        @continue
                    @endif
                    <div>
                        <h2>{{ $plan->name }}</h2>
                        <h2>{{ $plan->price }}</h2>
                    </div>                     
                     <div class="flex justify mt-4">
                   
                        <form method="POST" action="{{ route('subscriptions.update',$key) }}">
                            @method('put') 
                            @csrf
                                <x-primary-button type="submit" class="fw-light nav-link fs-6 ">
                                {{ __('Subscripe ') }}
                                </x-primary-button>       
                        </form>
                    </div>
                    @endforeach
                    <div class="flex justify mt-4">
                        <form method="POST" action="{{ route('subscriptions.destroy', auth()->user()->subscription) }}">
                            @method('delete') 
                            @csrf
                                <x-primary-button type="submit" class="fw-light nav-link fs-6">
                                {{ __('Unsubscripe ') }}
                                </x-primary-button>
                                
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div>
    
        </div>
    </div>
</x-app-layout>
