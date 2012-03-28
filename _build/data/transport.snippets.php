<?php
$snips = array(
    'SnippetName' => 'Description for the snippet.',
);

$snippets = array();
$i = 0;

foreach($snips as $sn => $sdesc) {
    $i++;
    $sfilename = substr(strtolower($sn), 2);
    $snippets[$i]= $modx->newObject('modSnippet');
    $snippets[$i]->fromArray(array(
        'id' => $i,
        'name' => $sn,
        'description' => $sdesc,
        'snippet' => getSnippetContent($sources['snippets'] . 'snippet.' . $sfilename . '.php'),
    ), '', true, true);

    $properties = $sources['data'].'properties/properties.' . $sfilename . '.php';
    if(file_exists($properties)) {
        include $properties;
        $snippets[$i]->setProperties($properties);
    }
    unset($properties);
}

return $snippets;
