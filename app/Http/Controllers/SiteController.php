<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\TextWidget;

class SiteController extends Controller
{
    public function about()
    {
        $widget = TextWidget::query()
            ->where('key', 'about-page')
            ->where('active',1)
            ->first();
        if(!$widget){
            throw new NotFoundHttpException();

        }
        return view('about')->with(compact('$widget'));
    }
}
