<?php

namespace App\Functions;

require_once __DIR__ . '/../../vendor/autoload.php';



use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class API_request
{
    private static $API_KEY = '9973533';

    public static function getDishes()
    {
        $client = new Client([
            'verify' => false,
        ]);

        try {
            $response = $client->request('GET', "https://www.themealdb.com/api/json/v2/" . self::$API_KEY . "/randomselection.php");

            $body = $response->getBody();
            $data = json_decode($body);
            dump($data);
            $array_of_data = [];
            foreach ($data->meals as $dish) {
                $dish_data = [];
                $dish_data['name'] = $dish->strMeal;
                $dish_data['image'] = $dish->strMealThumb;

                $array_of_data[] = $dish_data;
            }
            dd($array_of_data);
            return $array_of_data;
        } catch (RequestException $e) {
            // Gestione degli errori
            echo "Errore nella richiesta API: " . $e->getMessage();
            return [];
        }
    }

    public static function getAllCategories()
    {
        $client = new Client([
            'verify' => false,
        ]);

        try {
            $response = $client->request('GET', "https://www.themealdb.com/api/json/v1/1/categories.php");

            $body = $response->getBody();
            $data = json_decode($body);
            $array_of_data = [];
            foreach ($data->categories as $category) {
                $category_data = [];
                $category_data['name'] = $category->strCategory;
                $category_data['image'] = $category->strCategoryThumb;

                $array_of_data[] = $category_data;
            }
            dump($array_of_data);
            return $array_of_data;
        } catch (RequestException $e) {
            // Gestione degli errori
            echo "Errore nella richiesta API: " . $e->getMessage();
            return [];
        }
    }

    public static function getDishesByCategories($numberOfDishes, array $category, array $area = [])
    {
        $client = new Client([
            'verify' => false,
        ]);
        $full_list_of_dishes = [];

        while (count($full_list_of_dishes) < $numberOfDishes) {
            $response = $client->request('GET', "https://www.themealdb.com/api/json/v2/" . self::$API_KEY . "/randomselection.php");
            $body = $response->getBody();
            $data = json_decode($body);
            foreach ($data->meals as $dish) {
                if (in_array($dish->strCategory, $category) && ($area === [] || in_array($dish->strArea, $area))) {
                    $dish_data = [];
                    $dish_data['name'] = $dish->strMeal;
                    $dish_data['image'] = $dish->strMealThumb;
                    $full_list_of_dishes[] = $dish_data;
                }
            }
        }
        dd($full_list_of_dishes);
        return $full_list_of_dishes;
    }
}
