<?php

use App\ValueObjects\Metadata;

it('should test Metadata', function () {
    $metadataArray = Metadata::fromFaker(fake())->toArray();

    $metadata = new Metadata($metadataArray);

    expect($metadata)->toBeInstanceOf(Metadata::class);
    expect($metadata->__toString())->toBeJson();
});

it('should use defaults for Category and Audience', function () {
    $metadataArray = Metadata::fromFaker(fake())->toArray();
    unset($metadataArray['audience']);
    unset($metadataArray['category']);

    $metadata = new Metadata($metadataArray);
    expect($metadata)->toBeInstanceOf(Metadata::class);
});
