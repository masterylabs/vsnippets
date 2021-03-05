<?php

// $app->get('sample', 'SampleController');

$app->get('embed/{video}', 'VideoController@embed');
$app->get('{video}', 'VideoController@web');