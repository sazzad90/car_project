<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="form-content p-6 bg-white border-b border-gray-200">
                    <h3 class="text-center mb-4" style="font-size: 30px;">Car list</h3>
                    <table class="table w-full m-4">
                        <tbody>
                            @foreach($cars as $key => $car)
                            @include('components.car', ['id' => $car->id, 'car' => $car, 'carName' => $car->make,'modelName' => $car->model])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('dashboard/script')
    <script type="text/javascript">

    </script>
    @endpush
</x-app-layout>