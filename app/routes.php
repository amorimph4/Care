<?php

$route[] = ['/user/create', 'UserController@create'];
$route[] = ['/user/store', 'UserController@store'];
$route[] = ['/login', 'UserController@login'];
$route[] = ['/login/auth', 'UserController@auth'];
$route[] = ['/logout', 'UserController@logout'];

$route[] = ['/', 'HomeController@index'];

$route[] = ['/uploads', 'UploadController@index', 'auth'];
$route[] = ['/upload/{id}/show', 'UploadController@show', 'auth'];
$route[] = ['/upload/create', 'UploadController@create', 'auth'];
$route[] = ['/upload/store', 'UploadController@store', 'auth'];
$route[] = ['/upload/{id}/edit', 'UploadController@edit', 'auth'];
$route[] = ['/upload/{id}/update', 'UploadController@update', 'auth'];
$route[] = ['/upload/{id}/delete', 'UploadController@delete', 'auth'];


return $route;