<?php

class PhotoController extends Controller {

    public function card() {
        echo $this->request()->params("id");
echo "<br />";
        echo $this->request()->get("ghg");
    }    
}
