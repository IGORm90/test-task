<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        $label = new LabelController;

        dump($label->store('site', 1, [
            'google',
            'meta'
        ]));

        dump($label->update('site', 1, [
            'google',
            'meta'
        ]));
        dump($label->delete('site', 1, [
            'meta'
        ]));
        dump($label->index('site', 1));
    }
}
