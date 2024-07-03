<?php

// use App\Functions\Helpers as Help; se vogliamo usare una funzione Help::'nomefunzione'


namespace App\Functions;

use Illuminate\Support\Str;

class Helpers
{

    public static function numberOfOrders()
    {
        return 60;
    }

    public static function getCsvData($path)
    {
        $file_stream = fopen($path, "r");
        if ($file_stream === false) {
            exit('Cannot open the file' . $path);
        }
        $data = [];
        while ($row = fgetcsv($file_stream)) {
            $data[] = $row;
        }
        fclose($file_stream);
        return $data;
    }

    public static function getStars($number)
    {
        $fullTemplate = '';
        for ($i = 0; $i < 5; $i++) {
            if ($i < $number) {
                $fullTemplate .= '<i class="fa-solid fa-star text-warning hype-text-shadow"></i>';
            } else {
                $fullTemplate .= '<i class="fa-regular fa-star"></i>';
            }
        }
        return $fullTemplate;
    }

    public static function generateSlug($name, $class)
    {
        $slug = Str::slug($name, '-');
        $count = 1;
        while ($class::where('slug', $slug)->first()) {
            $slug = Str::of($name)->slug('-') . "-{$count}";
            $count++;
        }
        return $slug;
    }


    public static function generateResponse($response)
    {
        if ($response) {

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'ok',
                    'results' => $response
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'error'
                ],
                400
            );
        }
    }
}
