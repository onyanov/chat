<?php

class RoomController extends Controller {
    
    public function list() {
    
    }
    
    public function add() {
      $name = input_filter(INPUT_POST, 'room_name', SANITIZE_STRING);
      $userId = $this->user()->id;
      $room = $this->model()->create($name, $userId);
      $this->render('created', $room);
    }
    
    public function remove() {
    
    }
}
