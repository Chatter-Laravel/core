<?php

if (! function_exists('model')) {
    function model($class)
    {
        return get_class(app()->make($class));
    }
}

if (! function_exists('model_instance')) {
    function model_instance($class)
    {
        return app()->make($class);
    }
}
