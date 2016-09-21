<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/Cuisine.php";
    date_default_timezone_set('America/Los_Angeles');

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $app = new Silex\Application();

    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=restaurants';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        $cuisines = Cuisine::getAll();
        return $app['twig']->render('index.html.twig', array ('cuisines' => $cuisines));
    });

    $app->post("/", function() use ($app) {
        $new_cuisine = new Cuisine($id = null, $_POST['new_cuisine']);
        $new_cuisine->save();
        $cuisines = Cuisine::getAll();
        return $app['twig']->render('index.html.twig', array ('cuisines' => $cuisines));
    });

    $app->get("/cuisine/{id}", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine.html.twig', array ('cuisine' => $cuisine, 'restaurants' => $cuisine->findRestaurants()));
    });

    $app->post("/cuisine/{id}", function($id) use ($app) {
        $new_restaurant = new Restaurant($restaurant_id = null, $_POST['new_name'], $_POST['new_address'], $_POST['new_phone'], $_POST['cuisine_id'], $_POST['new_picture']);
        $new_restaurant->save();
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine.html.twig', array ('cuisine' => $cuisine, 'restaurants' => $cuisine->findRestaurants()));
    });

    $app->get("/restaurant/{id}", function($id) use ($app) {
        $restaurant = Restaurant::find($id);
        $cuisine = Cuisine::find($restaurant->getCuisineId());
        return $app['twig']->render('restaurant.html.twig', array ('restaurant' => $restaurant, 'cuisine' => $cuisine));
    });

    $app->get("/restaurant/{id}/edit", function($id) use ($app) {
        $restaurant = Restaurant::find($id);
        $cuisine = Cuisine::find($restaurant->getCuisineId());
        return $app['twig']->render('restaurant_edit.html.twig', array ('restaurant' => $restaurant, 'cuisine' => $cuisine));
    });

    $app->post("/restaurant/{id}", function($id) use ($app) {
        $restaurant = Restaurant::find($id);
        $restaurant->updateRestaurant($_POST['edit_name'], $_POST['edit_address'], $_POST['edit_phone'], $_POST['edit_cuisine_id']);
        $cuisine = Cuisine::find($restaurant->getCuisineId());
        return $app['twig']->render('restaurant.html.twig', array ('restaurant' => $restaurant, 'cuisine' => $cuisine));
    });

    $app->post("/restaurant/{id}/delete", function($id) use ($app) {
        $restaurant = Restaurant::find($id);
        $cuisine = Cuisine::find($restaurant->getCuisineId());
        $restaurant->deleteRestaurant();
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->findRestaurants()));
    });

    $app->get("/cuisine/{id}/edit", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        $error = '';
        return $app['twig']->render('cuisine_edit.html.twig', array('cuisine' => $cuisine, 'error' => $error));
    });

    $app->post("/cuisine/{id}/edit", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        $error = $cuisine->updateCuisine($_POST['edit_name']);
        if ($error == 'error') {
            return $app['twig']->render('cuisine_edit.html.twig', array('cuisine' => $cuisine, 'error' => $error));
        } else {
            return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->findRestaurants()));
        }
    });

    $app->post("/cuisine/{id}/delete", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        $cuisine->deleteCuisine();
        $cuisines = Cuisine::getAll();
        return $app['twig']->render('index.html.twig', array('cuisines' => $cuisines));
    });

    $app->post("/restaurant/{id}/update_rating", function($id) use ($app) {
        $restaurant = Restaurant::find($id);
        $cuisine = Cuisine::find($restaurant->getCuisineId());
        $restaurant->updateRating($_POST['user_rating']);
        return $app['twig']->render('restaurant.html.twig', array('restaurant' => $restaurant, 'cuisine' => $cuisine));
    });

    return $app;
?>
