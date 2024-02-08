<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="form-content p-6 bg-white border-b border-gray-200">
                    <h3 class="text-center">Upgrade your car</h3>
                    <form method="POST" action="{{ route('car.update', ['id' => $car->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-label for="company_name" :value="__('Company name')" />
                            <x-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="$car->make" required autofocus autocomplete="on" />
                        </div>

                        <div class="mt-4">
                            <x-label for="model_name" :value="__('Model name')" />
                            <x-input id="model_name" class="block mt-1 w-full" type="text" name="model_name" :value="$car->model" required />
                        </div>

                        <div class="mt-4">
                            <x-label for="fuel_type" :value="__('Fuel type')" />
                            <x-input id="fuel_type" class="block mt-1 w-full" type="text" name="fuel_type" :value="$car->fuel_type" />
                        </div>

                        <div class="mt-4">
                            <x-label for="driving_type" :value="__('Driving type')" />
                            <x-input id="driving_type" class="block mt-1 w-full" type="text" name="driving_type" :value="$car->drive" />
                        </div>

                        <div class="mt-4">
                            <x-label for="cylinders" :value="__('No. of cylinders')" />
                            <x-input id="cylinders" class="block mt-1 w-full" type="number" name="cylinders" :value="$car->cylinders" />
                        </div>

                        <div class="mt-4">
                            <x-label for="transmission_type" :value="__('Transmission type')" />
                            <x-input id="transmission_type" class="block mt-1 w-full" type="text" name="transmission_type" :value="$car->transmission" />
                        </div>

                        <div class="mt-4">
                            <x-label for="year" :value="__('Year')" />
                            <x-input id="year" class="block mt-1 w-full" type="number" name="year" :value="$car->year" />
                        </div>

                        <div class="mt-4">
                            <x-label for="min_city_mpg" :value="__('Min fuel consumption(city-mpg)')" />
                            <x-input id="min_city_mpg" class="block mt-1 w-full" type="number" step="0.01" name="min_city_mpg" :value="$car->min_city_mpg" />
                        </div>

                        <div class="mt-4">
                            <x-label for="max_city_mpg" :value="__('Max fuel consumption(city-mpg)')" />
                            <x-input id="max_city_mpg" class="block mt-1 w-full" type="number" step="0.01" name="max_city_mpg" :value="$car->max_city_mpg" />
                        </div>

                        <div class="mt-4">
                            <x-label for="min_hwy_mpg" :value="__('Min fuel consumption(highway-mpg)')" />
                            <x-input id="min_hwy_mpg" class="block mt-1 w-full" type="number" step="0.01" name="min_hwy_mpg" :value="$car->min_hwy_mpg" />
                        </div>

                        <div class="mt-4">
                            <x-label for="max_hwy_mpg" :value="__('Max fuel consumption(highway-mpg)')" />
                            <x-input id="max_hwy_mpg" class="block mt-1 w-full" type="number" step="0.01" name="max_hwy_mpg" :value="$car->max_hwy_mpg" />
                        </div>

                        <div class="mt-4">
                            <x-label for="min_comb_mpg" :value="__('Min combination(city and highway-mpg)')" />
                            <x-input id="min_comb_mpg" class="block mt-1 w-full" type="number" step="0.01" name="min_comb_mpg" :value="$car->min_comb_mpg" />
                        </div>

                        <div class="mt-4">
                            <x-label for="max_comb_mpg" :value="__('Max combination(city and highway-mpg)')" />
                            <x-input id="max_comb_mpg" class="block mt-1 w-full" type="number" step="0.01" name="max_comb_mpg" :value="$car->max_comb_mpg" />
                        </div>

                        <div class="mt-4">
                            <x-label for="images" :value="__('Images')" />
                            <x-input id="images" class="block mt-1 w-full" onchange="imagePreview(event)" type="file" name="images[]" multiple />
                        </div>

                        <!-- image preview  -->
                        <div class="mt-4 flex justify-content" id="images-container">
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-3" onclick="checkFileList()">
                                {{ __('Submit') }}
                            </x-button>
                        </div>
                        <!-- <img src="{{url('images/jaguar_f-type.jpg')}}" /> -->
                    </form>
                    <script>
                        function showMessage() {
                            alert(' Form submitted!');
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>


    @push('upgradeCar/script')
    <script>
        let imageFiles = document.getElementById('images').files;

        // db image load
        function loadDbImages() {
            let images = <?php echo json_encode($images); ?>;
            const container = document.getElementById('images-container');

            let dataTransfer = new DataTransfer();

            for (const file of images) {
                const imgElement = document.createElement('img');
                imgElement.src = "{{asset('/images')}}" + "/" + file
                console.log('image url: ', imgElement.src);

                imgElement.style.width = '360px';
                imgElement.style.height = '260px';

                // button element
                const crossBtn = document.createElement('button');
                crossBtn.id = file;
                // icon element
                const crossIcon = document.createElement('i');
                crossIcon.className = "fa fa-close";
                crossBtn.appendChild(crossIcon);

                crossBtn.addEventListener('click', function() {
                    console.log('nodeName: ', this.id);
                    const parentImage = this.parentNode;
                    const parentDiv = parentImage.parentNode;

                    const fileToRemoveIndex = Array.prototype.indexOf.call(parentDiv.children, parentImage);
                    console.log('index: ', fileToRemoveIndex);
                    console.log('itemToRemove: ', document.getElementById('images').files[fileToRemoveIndex]);

                    const filesArray = Array.from(imageFiles);
                    filesArray.splice(fileToRemoveIndex, 1);
                    const newDataTransfer = new DataTransfer();
                    filesArray.forEach(file => newDataTransfer.items.add(file));

                    imageFiles = newDataTransfer.files;
                    document.getElementById('images').files = imageFiles;
                    console.log('Updated files after clicking cross from db part:', document.getElementById('images').files);

                    this.parentNode.remove();
                });


                // creating image file 
                var parts = file.split('.');
                var extension = parts[1];

                var fileProperties = {
                    name: file,
                    type: "image/" + extension,
                };

                var blob = new Blob([], {
                    type: fileProperties.type
                });

                var newFile = new File([blob], fileProperties.name, {
                    type: fileProperties.type,
                });
                imageFiles.type = 'file';

                // adding image files into images input files
                dataTransfer.items.add(newFile);

                // image div
                const imageDiv = document.createElement('div');
                imageDiv.className = file;
                imageDiv.appendChild(imgElement);
                imageDiv.appendChild(crossBtn);
                container.appendChild(imageDiv);
            }
            imageFiles = dataTransfer.files;
            document.getElementById('images').files = imageFiles;
            console.log('db image files: ', document.getElementById('images').files);
            console.log('container after loading images from db: ', container);

        }

        loadDbImages();

        function imagePreview(event) {
            const container = document.getElementById('images-container');

            for (const file of event.target.files) {
                // image element
                const imgElement = document.createElement('img');
                imgElement.src = URL.createObjectURL(file);
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
                    console.log('nodeName: ', this.id);

                    // let imageFiles = document.getElementById('images');
                    const parentImage = this.parentNode;
                    const parentDiv = parentImage.parentNode;

                    const fileToRemoveIndex = Array.prototype.indexOf.call(parentDiv.children, parentImage);
                    console.log('index: ', fileToRemoveIndex);
                    console.log('itemToRemove: ', document.getElementById('images').files[fileToRemoveIndex]);

                    const filesArray = Array.from(imageFiles);
                    filesArray.splice(fileToRemoveIndex, 1);
                    const newDataTransfer = new DataTransfer();
                    filesArray.forEach(file => newDataTransfer.items.add(file));

                    imageFiles = newDataTransfer.files;
                    document.getElementById('images').files = imageFiles;
                    console.log('Updated files after clicking cross from selected part:', document.getElementById('images').files);

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


        function checkFileList() {
            console.log('final list to upload: ', imageFiles);
        }
    </script>
    @endpush
</x-app-layout>