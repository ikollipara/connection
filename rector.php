<?php

use Rector\Config\RectorConfig;
use Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector;
use Rector\Php80\Rector\Class_\StringableForToStringRector;
use Rector\Php80\Rector\ClassConstFetch\ClassOnThisVariableObjectRector;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\DeclareStrictTypesRector;
use RectorLaravel\Rector\Class_\AddExtendsAnnotationToModelFactoriesRector;
use RectorLaravel\Rector\ClassMethod\MigrateToSimplifiedAttributeRector;
use RectorLaravel\Rector\Empty_\EmptyToBlankAndFilledFuncRector;
use RectorLaravel\Rector\MethodCall\AvoidNegatedCollectionFilterOrRejectRector;
use RectorLaravel\Rector\MethodCall\EloquentWhereRelationTypeHintingParameterRector;
use RectorLaravel\Rector\MethodCall\EloquentWhereTypeHintClosureParameterRector;
use RectorLaravel\Rector\MethodCall\RedirectRouteToToRouteHelperRector;
use RectorLaravel\Rector\MethodCall\ValidationRuleArrayStringValueToArrayRector;
use RectorLaravel\Set\LaravelLevelSetList;
use RectorLaravel\Set\LaravelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/database',
    ])
    ->withRules([
        DeclareStrictTypesRector::class,
        ClassOnThisVariableObjectRector::class,
        RemoveUnusedVariableInCatchRector::class,
        StringableForToStringRector::class,
        AvoidNegatedCollectionFilterOrRejectRector::class,
        AddExtendsAnnotationToModelFactoriesRector::class,
        EloquentWhereRelationTypeHintingParameterRector::class,
        EloquentWhereTypeHintClosureParameterRector::class,
        EmptyToBlankAndFilledFuncRector::class,
        MigrateToSimplifiedAttributeRector::class,
        RedirectRouteToToRouteHelperRector::class,
        ValidationRuleArrayStringValueToArrayRector::class,
    ])
    ->withSets([
        LaravelLevelSetList::UP_TO_LARAVEL_110,
        LaravelSetList::ARRAY_STR_FUNCTIONS_TO_STATIC_CALL,
    ]);
