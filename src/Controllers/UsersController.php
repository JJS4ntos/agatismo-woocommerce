<?php 
namespace App\Controllers;

use App\Controllers\Controller;

class UsersController extends Controller {

    public function my_account() {
        $user = wp_get_current_user();
        return $this->generateView('my-account', ['user' => $user]);
    }

}