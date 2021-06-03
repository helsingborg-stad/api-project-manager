<?php

namespace ApiProjectManager;

class App
{
    public function __construct()
    {
        new Theme\Setup();
        new Theme\UI();
        new Theme\Enqueue();
        new PostTypes\Project();
        new PostTypes\Challenge();
        new PostTypes\Platform();
        new Roles\ProjectEditor();
        new Options();
        new Exporter();
    }
}
