<x-app-layout>
    <x-slot name="header">
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-center mt-4 h2">New car</div>

                <div class="form-content flex justify-center p-6 bg-white border-b border-gray-200">
                    <table class="table table-bordered w-full flex justify-center p-6 color-black table-striped">
                        <tbody>
                            @foreach ($car->getAttributes() as $key => $value)
                            @if($value && $key != 'id' && $key != 'created_at' && $key != 'updated_at')
                            <tr>
                                <th class="pr-4">{{ ucfirst($key) }}</th>
                                <td>{{ $value }}</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-center mb-6">

                    @foreach ($images as $imageName)
                    <img src="{{ asset('images/' . $imageName) }}" alt="car image" class="mr-4 ml-4 mt-4" style="max-width: 30%; max-height: 300px;" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>