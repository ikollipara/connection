<?php

use App\ValueObjects\Editor;

it('should test an editor instance', function () {
    $jsonRepresentation = '{"time":' . now()->valueOf() . ',"blocks":[],"version":"2.8.1"}';
    $editor = Editor::fromJson($jsonRepresentation);

    expect($editor->toJson())->toEqual($jsonRepresentation);
    expect($editor->toArray())->toHaveKeys(['time', 'blocks', 'version']);
    expect($editor->toJson(parse: true)->__toString())->toStartWith("JSON.parse");
});
