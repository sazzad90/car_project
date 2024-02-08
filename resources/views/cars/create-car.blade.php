<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="form-content p-6 bg-white border-b border-gray-200">
                    <h3 class="text-center">Create new car</h3>
                    <form method="POST" action="{{ route('car') }}" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <x-label for="company_name" :value="__('Company name')" />
                            <x-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-label for="model_name" :value="__('Model name')" />
                            <x-input id="model_name" class="block mt-1 w-full" type="text" name="model_name" :value="old('model_name')" required />
                        </div>

                        <div class="mt-4">
                            <x-label for="fuel_type" :value="__('Fuel type')" />
                            <x-input id="fuel_type" class="block mt-1 w-full" type="text" name="fuel_type" :value="old('fuel_type')" />
                        </div>

                        <div class="mt-4">
                            <x-label for="driving_type" :value="__('Driving type')" />
                            <x-input id="driving_type" class="block mt-1 w-full" type="text" name="driving_type" :value="old('driving_type')" />
                        </div>

                        <div class="mt-4">
                            <x-label for="cylinders" :value="__('No. of cylinders')" />
                            <x-input id="cylinders" class="block mt-1 w-full" type="number" name="cylinders" :value="old('cylinders')" />
                        </div>

                        <div class="mt-4">
                            <x-label for="transmission_type" :value="__('Transmission type')" />
                            <x-input id="transmission_type" class="block mt-1 w-full" type="text" name="transmission_type" :value="old('transmission_type')" />
                        </div>

                        <div class="mt-4">
                            <x-label for="year" :value="__('Year')" />
                            <x-input id="year" class="block mt-1 w-full" type="number" name="year" :value="old('year')" />
                        </div>

                        <div class="mt-4">
                            <x-label for="min_city_mpg" :value="__('Min fuel consumption(city-mpg)')" />
                            <x-input id="min_city_mpg" class="block mt-1 w-full" type="number" step="0.01" name="min_city_mpg" :value="old('min_city_mpg')" />
                        </div>

                        <div class="mt-4">
                            <x-label for="max_city_mpg" :value="__('Max fuel consumption(city-mpg)')" />
                            <x-input id="max_city_mpg" class="block mt-1 w-full" type="number" step="0.01" name="max_city_mpg" :value="old('max_city_mpg')" />
                        </div>

                        <div class="mt-4">
                            <x-label for="min_hwy_mpg" :value="__('Min fuel consumption(highway-mpg)')" />
                            <x-input id="min_hwy_mpg" class="block mt-1 w-full" type="number" step="0.01" name="min_hwy_mpg" :value="old('min_hwy_mpg')" />
                        </div>

                        <div class="mt-4">
                            <x-label for="max_hwy_mpg" :value="__('Max fuel consumption(highway-mpg)')" />
                            <x-input id="max_hwy_mpg" class="block mt-1 w-full" type="number" step="0.01" name="max_hwy_mpg" :value="old('max_hwy_mpg')" />
                        </div>

                        <div class="mt-4">
                            <x-label for="min_comb_mpg" :value="__('Min combination(city and highway-mpg)')" />
                            <x-input id="min_comb_mpg" class="block mt-1 w-full" type="number" step="0.01" name="min_comb_mpg" :value="old('min_comb_mpg')" />
                        </div>

                        <div class="mt-4">
                            <x-label for="max_comb_mpg" :value="__('Max combination(city and highway-mpg)')" />
                            <x-input id="max_comb_mpg" class="block mt-1 w-full" type="number" step="0.01" name="max_comb_mpg" :value="old('max_comb_mpg')" />
                        </div>

                        <div class="mt-4">
                            <x-label for="images" :value="__('Images')" />
                            <x-input id="images" class="block mt-1 w-full" onchange="imagePreview(event)" type="file" name="images[]" multiple />
                        </div>

                        <!-- image preview  -->
                        <div class="mt-4 flex justify-content" id="images-container">
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-3">
                                {{ __('Submit') }}
                            </x-button>
                        </div>
                    </form>
                    <script>
                        function showMessage() {
                            alert('Form submitted!');
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>

    @push('createCar/script')
    <script type="text/javascript">
        function imagePreview(event) {
            const container = document.getElementById('images-container');

            for (const file of event.target.files) {
                // image element
                const imgElement = document.createElement('img');
                imgElement.src = URL.createObjectURL(file);
                console.log('file: ', file);

                console.log('src: ', imgElement.src);
                imgElement.style.width = '360px';
                imgElement.style.height = '260px';

                // button element
                const crossBtn = document.createElement('button');
                crossBtn.id = file.name;

                // icon element
                const crossIcon = document.createElement('i');
                crossIcon.className = "fa fa-close";
                crossBtn.appendChild(crossIcon);

                crossBtn.addEventListener('click', function() {
                    let imageFiles = document.getElementById('images');
                    console.log('selected image files: ', imageFiles.files[0]); //////////////////
                    const parentImage = this.parentNode;
                    const parentDiv = parentImage.parentNode;

                    const fileToRemoveIndex = Array.prototype.indexOf.call(parentDiv.children, parentImage);
                    console.log('index: ', fileToRemoveIndex);
                    console.log('itemToRemove: ', document.getElementById('images').files[fileToRemoveIndex]);

                    const filesArray = Array.from(imageFiles.files);
                    filesArray.splice(fileToRemoveIndex, 1);
                    const newDataTransfer = new DataTransfer();
                    filesArray.forEach(file => newDataTransfer.items.add(file));

                    imageFiles.files = newDataTransfer.files;
                    document.getElementById('images').files = imageFiles.files;
                    console.log('Updated files:', document.getElementById('images').files);

                    this.parentNode.remove();
                });


                // image div
                const imageDiv = document.createElement('div');
                imageDiv.className = file.name;
                imageDiv.appendChild(imgElement);
                imageDiv.appendChild(crossBtn);

                container.appendChild(imageDiv);
            }
        }
    </script>
    @endpush
</x-app-layout>