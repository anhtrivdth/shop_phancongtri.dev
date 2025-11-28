<?php

class ContactController extends Controller
{
    private ContactLink $contactLink;

    public function __construct()
    {
        parent::__construct();
        $this->contactLink = new ContactLink();
    }

    public function index(): string
    {
        return $this->view('frontend/contact/index', [
            'title' => 'Liên hệ',
            'links' => $this->contactLink->enabled(),
        ]);
    }
}

