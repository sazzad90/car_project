<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Image;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class CarController extends Controller
{
    protected $records, $related;

    public function __construct()
    {
        $this->related = [
            'make',
            'model',
            'fuel_type',
            'drive',
            'cylinders',
            'transmission',
            'year',
            'min_city_mpg',
            'max_city_mpg',
            'min_hwy_mpg',
            'max_hwy_mpg',
            'min_comb_mpg',
            'max_comb_mpg',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $cars = Car::all();
        $response = Car::get();
        $cars = [];

        foreach ($response as $key => $record) {
            $cars[$key] = $record;
        }

        return view('dashboard', ['cars' => $cars]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'company_name' => 'required|string|max:50',
            'model_name' => 'required|string|max:50',
            'fuel_type' => 'nullable|in:gas,diesel,electricity',
            'driving_type' => 'nullable|in:fwd,rwd,awd,4wd',
            'cylinders' => 'nullable|integer',
            'transmission_type' => 'nullable|in:manual,automatic',
            'year' => 'nullable|integer',
            'min_city_mpg' => 'nullable|numeric',
            'max_city_mpg' => 'nullable|numeric',
            'min_hwy_mpg' => 'nullable|numeric',
            'max_hwy_mpg' => 'nullable|numeric',
            'min_comb_mpg' => 'nullable|numeric',
            'max_comb_mpg' => 'nullable|numeric',
        ]);

        $requestData = $request->all();


        $car = Car::create([
            'make' => $requestData['company_name'],
            'model' => $requestData['model_name'],
            'fuel_type' => $requestData['fuel_type'],
            'drive' => $requestData['driving_type'],
            'cylinders' => $requestData['cylinders'],
            'transmission' => $requestData['transmission_type'],
            'year' => $requestData['year'],
            'min_city_mpg' => $requestData['min_city_mpg'],
            'max_city_mpg' => $requestData['max_city_mpg'],
            'min_hwy_mpg' => $requestData['min_hwy_mpg'],
            'max_hwy_mpg' => $requestData['max_hwy_mpg'],
            'min_comb_mpg' => $requestData['min_comb_mpg'],
            'max_comb_mpg' => $requestData['max_comb_mpg'],
        ]);

        $this->storeImage($requestData['images'], $car->id);

        return redirect()->route('car.details', ['id' => $car->id]);
    }


    // $collection = collect($request->except('_token', 'company_name', 'model_name', 'driving_type', 'transmission_type'))->merge(['make' => $request->company_name, 'model' => $request->model_name, 'drive' => $request->driving_type, 'transmission' => $request->transmission_type]);
    // Car::create($collection->all());
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function storeImage(array $requestImages, $id)
    {
        foreach ($requestImages as $image) {
            $name = $image->getClientOriginalName();
            $imageName = $name; // . time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);


            $car = Image::create([
                'car_id' => $id,
                'name' =>  $imageName,
            ]);
        }
    }

    private function updateImage(array $requestImages, $id)
    {
        $filesToDelete = Image::where('car_id', $id)->get();

        if ($filesToDelete) {
            foreach ($filesToDelete as $file) {
                $name = $file->name;

                foreach ($requestImages as $image) {
                    if ($image->getClientOriginalName() != $name) {
                        $filePath = public_path('images/' . $name);
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                        $file->delete();
                    }
                }
            }

            Image::where('car_id', $id)->delete();
        }

        foreach ($requestImages as $image) {
            $name = $image->getClientOriginalName();
            $imageName = $name;
            $image->move(public_path('images'), $imageName);

            $car = Image::create([
                'car_id' => $id,
                'name' =>  $imageName,
            ]);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show($id, $status = null)
    {
        $car = Car::findOrFail($id);
        $carImages = $car->images;

        $imageNames = array();

        foreach ($carImages as $image) {
            $imageName = $image->getOriginal('name');
            $imageName = $image->name;
            array_push($imageNames, $imageName);
        }

        return $status ? view('cars.upgrade-car', ['car' => $car, 'images' => $imageNames]) : view('cars.newCar', ['car' => $car, 'images' => $imageNames]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCarRequest  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Find the car by ID
        $car = Car::findOrFail($id);

        // Validate the incoming request data
        $request->validate([
            'company_name' => 'required|string|max:50',
            'model_name' => 'required|string|max:50',
            'fuel_type' => 'nullable|in:gas,diesel,electricity',
            'driving_type' => 'nullable|in:fwd,rwd,awd,4wd',
            'cylinders' => 'nullable|integer',
            'transmission_type' => 'nullable|in:manual,automatic',
            'year' => 'nullable|integer',
            'min_city_mpg' => 'nullable|numeric',
            'max_city_mpg' => 'nullable|numeric',
            'min_hwy_mpg' => 'nullable|numeric',
            'max_hwy_mpg' => 'nullable|numeric',
            'min_comb_mpg' => 'nullable|numeric',
            'max_comb_mpg' => 'nullable|numeric',
        ]);

        $requestData = $request->all();

        // Update the car attributes with the validated data
        $car->update([
            'make' => $requestData['company_name'],
            'model' => $requestData['model_name'],
            'fuel_type' => $requestData['fuel_type'],
            'drive' => $requestData['driving_type'],
            'cylinders' => $requestData['cylinders'],
            'transmission' => $requestData['transmission_type'],
            'year' => $requestData['year'],
            'min_city_mpg' => $requestData['min_city_mpg'],
            'max_city_mpg' => $requestData['max_city_mpg'],
            'min_hwy_mpg' => $requestData['min_hwy_mpg'],
            'max_hwy_mpg' => $requestData['max_hwy_mpg'],
            'min_comb_mpg' => $requestData['min_comb_mpg'],
            'max_comb_mpg' => $requestData['max_comb_mpg'],
        ]);

        $this->updateImage($requestData['images'], $car->id);

        return redirect()->route('car.details', ['id' => $car->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Car::findOrFail($id);

        // delete images from local assets 
        $filesToDelete = Image::where('car_id', $id)->get();
        if ($filesToDelete) {
            foreach ($filesToDelete as $file) {
                $name = $file->name;

                $filePath = public_path('images/' . $name);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $file->delete();
            }
        }

        $car->delete();

        return redirect()->back();
    }
}
