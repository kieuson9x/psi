<?php

class About extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'About Us'
        ];

        $this->view('about', $data);
    }
}
